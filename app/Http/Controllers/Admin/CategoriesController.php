<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Categories\IndexCategoryRequest;
use App\Http\Requests\Web\Categories\StoreCategoryRequest;
use App\Http\Requests\Web\Categories\UpdateCategoryRequest;
use App\Http\Requests\Web\Categories\ShowCategoryRequest;
use App\Http\Requests\Web\Categories\DeleteCategoryRequest;
use App\Http\Requests\Web\Categories\MassDestroyCategoryRequest;
use App\Http\Requests\Web\Categories\CategoryTranslationRequest;
use App\Http\Requests\Web\Categories\CategoryImportRequest;
use App\Http\Requests\Web\Categories\CategoryExportRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\PhraseRepository;
use App\Repositories\PhraseCategoryRepository;
use App\Repositories\TranslationRepository;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Phrase;
use App\Models\PhraseCategory;
use App\Models\Translation;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use DOMDocument;
use DOMImplementation;
use Illuminate\Contracts\Filesystem\FileNotFoundException as FilesystemFileNotFoundException;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use stdClass;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use ZipArchive;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    private $_categoryRepository;
    private $_projectRepository;
    private $_languageRepository;
    private $_phraseRepository;
    private $_phraseCategoryRepository;
    private $_translationRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProjectRepository $projectRepository,
        LanguageRepository $languageRepository,
        PhraseRepository $phraseRepository,
        PhraseCategoryRepository $phraseCategoryRepository,
        TranslationRepository $translationRepository
        )
    {
        $this->_categoryRepository = $categoryRepository;
        $this->_projectRepository = $projectRepository;
        $this->_languageRepository = $languageRepository;
        $this->_phraseRepository = $phraseRepository;
        $this->_phraseCategoryRepository = $phraseCategoryRepository;
        $this->_translationRepository = $translationRepository;
    }

    public function index(IndexCategoryRequest $request)
    {
        $categories = $this->_categoryRepository->getAllAsync()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $projects = $this->_projectRepository->getAllAsync()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.categories.create', compact('projects'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->_categoryRepository->storeAsync($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        $projects = $this->_projectRepository->getAllAsync()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $category->load('project');

        return view('admin.categories.edit', compact('category', 'projects'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->_categoryRepository->updateAsync($category->name, $request->all());

        return redirect()->route('admin.categories.index');
    }

    public function show(ShowCategoryRequest $request,Category $category)
    {
        $category = $this->_categoryRepository->viewAsync($category->name);

        //$category->load('phrases');
        //$category->load('users');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(DeleteCategoryRequest $request, Category $category)
    {
        $result = $this->_categoryRepository->deleteAsync($category->name);

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        $result = $this->_categoryRepository->deleteAllAsync($request->names);

        return response(null, Response::HTTP_NO_CONTENT);
    }


    ///--------------------------------------------- translate actions -----------------------------------////
    public function translate($name, $to = "German", CategoryTranslationRequest $categoryTranslationRequest)
    {
        /*  Validate requested data */
        $categoryTranslationRequest->validated();

        $category = $this->_categoryRepository->viewAsync($name);

        $category->load('phrases');
        $category->project->load('languages');

        $phrases = $category->phrases;

        $languageFrom = $this->_languageRepository->getPrimaryAsync();

        $languagesTo = $category->project->languages
            ->where('id', '!=', $languageFrom->id);

        $languageTo = $this->_languageRepository->getAllNotPrimaryAsync()
            ->where("title", $to)->first();

        $translations = $this->_translationRepository->findTranslations($category->name, $languageTo ? $languageTo->id : null)->get();

        return view('admin.categories.translate')
            ->with('category', $category)
            ->with('phrases',  $phrases)
            ->with('from', $languageFrom)
            ->with('to',   $languageTo)
            ->with('languagesTo',  $languagesTo)
            ->with('translations', $translations)
            ->with('user',   Auth::user());
    }

    ///--------------------------------------------- import actions -----------------------------------////
    public function import($name, CategoryImportRequest $categoryImportRequest)
    {
        $method = $categoryImportRequest->method();

        if($method == 'GET'){
            return $this->importGet($name, $categoryImportRequest);
        }

        if($method == 'POST'){
            return $this->importPost($name, $categoryImportRequest);

        }
    }

    public function importGet($name, CategoryImportRequest $categoryImportRequest)
    {
        /*  Validate requested data */
        $categoryImportRequest->validated();

        $category = $this->_categoryRepository->viewAsync($name);

        $category->project->load('languages');

        $languageFrom = $this->_languageRepository->getPrimaryAsync();

        $categories = $this->_categoryRepository->getAllAsync()->pluck('name', 'name');

        return view('admin.categories.import')
            ->with('categories', $categories)
            ->with('category', $category)
            ->with('from', $languageFrom);
    }

    public function importPost($name, CategoryImportRequest $categoryImportRequest)
    {

        /* Validate requested data */
        $categoryImportRequest->validated();

        $categoryName = $name;
        $file = $categoryImportRequest->myfile;
        $fileName = date("m-d-Y H:i:s.u") . '_' . $file->getClientOriginalName();

        /* Save file on storage */
        try
        {
            Storage::disk('public')->putFileAs('qt', new File($file), $fileName);
        }
        catch (FileException $exception)
        {
            return response()->json(["status" => "Error"], JsonResponse::HTTP_BAD_REQUEST);
        }

        /* Read file from storage */
        try
        {
            $file = Storage::disk('public')->get('/qt/' . $fileName);
        }
        catch (FilesystemFileNotFoundException $exception)
        {
            return response()->json(["status" => "Error"], JsonResponse::HTTP_BAD_REQUEST);
        }

        $xmlFile = new \SimpleXMLElement($file);

        $items = (array)$xmlFile->xpath('context');

        foreach ($items as $context) {

            $messages = (array)$context->xpath('message');

            foreach ($messages as $message) {

                $phraseCategoryName = $context->name;
                $phrase = $message->source;

                $phraseEntity = $this->_phraseRepository->findAsync($phrase, $categoryName, $phraseCategoryName);

                if(!$phraseEntity) {

                    $phraseDto = new stdClass();
                    $phraseDto->phrase = $phrase;
                    $phraseDto->category_name = $categoryName;

                    $phraseCategoryEntity = $this->_phraseCategoryRepository->getByNameAsync($phraseCategoryName);

                    if(!$phraseCategoryEntity)
                    {
                        $phraseCategoryDto = new stdClass();
                        $phraseCategoryDto->name = $phraseCategoryName;

                        $locationsArray = array();
                        foreach ($context->message as $message)
                            array_push($locationsArray, $message->location);

                        $phraseCategoryDto->filename = json_encode($locationsArray);

                        $phraseCategoryEntity = $this->_phraseCategoryRepository->storeAsync((array) $phraseCategoryDto);
                    }

                    $phraseDto->phrase_category_id = $phraseCategoryEntity->id;

                    $phraseEntity = $this->_phraseRepository->storeAsync((array) $phraseDto);
                }
            }
        }

        return redirect()->route('admin.categories.translate',['name' => $name]);
    }

    ///--------------------------------------------- export actions -----------------------------------////
    public function export($name, $to = null, CategoryExportRequest $categoryExportRequest)
    {
        /*  Validate requested data */
        $method = $categoryExportRequest->method();

        if($method == 'GET')
            return $this->exportGet($name, $to, $categoryExportRequest);

        if($method == 'POST')
            return $this->exportPost($name, $to, $categoryExportRequest);
    }

    public function exportGet($name, $to, CategoryExportRequest $categoryExportRequest)
    {
        /*  Validate requested data */
        $categoryExportRequest->validated();

        $category = $this->_categoryRepository->viewAsync($name);

        $category->project->load('languages');

        $languageFrom = $this->_languageRepository->getPrimaryAsync();

        $languagesTo = $category->project->languages
            ->where('id', '!=', $languageFrom->id);

        $languageTo = new Language();
        if(isset($to))
            $languageTo = $this->_languageRepository->getAllNotPrimaryAsync()
                ->where("title", $to)->first();

        $categories = $this->_categoryRepository->getAllAsync()->pluck('name', 'name');

        $phrasesCount = $category->phrases->count();

        $phrasesCategoriesCount = $this->
            _phraseRepository
            ->phrasesHasPhraseCategoryAsync($category->name)
            ->select('phrase_category_id')
            ->groupBy('phrase_category_id')
            ->get()
            ->count();

        $translations = $this->_translationRepository->
            findTranslationsCount(
                $category->name,
                isset($to) ? $languageTo->id : null
            );

        $translationsCount = $translations->count();

        return view('admin.categories.export')
            ->with('categories', $categories)
            ->with('category', $category)
            ->with('from', $languageFrom)
            ->with('to', $languageTo)
            ->with('phrasesCategoriesCount', $phrasesCategoriesCount)
            ->with('translationsCount', $translationsCount)
            ->with('phrasesCount', $phrasesCount)
            ->with('languagesTo', $languagesTo);
    }

    public function exportPost($name, $to, CategoryExportRequest $categoryExportRequest)
    {
        // Validate requested data
        $categoryExportRequest->validated();

        $category = $this->_categoryRepository->viewAsync($name);
        $languageTo = $this->_languageRepository
            ->getAllNotPrimaryAsync()
            ->where("title", $to)
            ->first();

        $folderName = uniqid();

        if(isset($to) && !empty($to))
            $this->exportXML($category, $languageTo, $folderName);
        else
        {
            ini_set('memory_limit', '1024M');

            $category->project->load('languages');
            $languages = $category->project->languages->whereNotIn('is_primary', 1);

            foreach ($languages as $language)
                $this->exportXML($category, $language, $folderName);
        }

        $zip_file = "QtTranslations.zip";
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('./app/public/qt/'.$folderName);

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        //dd(iterator_count($files));

        if(iterator_count($files) < 1)
            return true;

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                $relativePath = 'translations/' . substr($filePath, strlen($path) - 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        return response()->download($zip_file);
    }

    public function exportXML($category, $to, $folderName, $prefix = 'sw', $file_extension_name = 'ts')
    {
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        $implementation = new DOMImplementation();

        $xml->appendChild($implementation->createDocumentType('TS'));
        $doctype = $xml->createElement('TS');
        $doctype->setAttribute('version', '2.1');
        $doctype->setAttribute('language', $to->title);

        $phrases = Phrase::where('category_name', $category->name)->with('phraseCategory')->get();
        $phraseIds = $phrases->pluck('id')->toArray();
        $phraseCategoryIds = $phrases->pluck('phrase_category_id')->toArray();

        $phraseCategories = PhraseCategory::with('phrases')->whereIn('id', $phraseCategoryIds)->get();

        $translations = Translation::with('phrase')->whereIn('phrase_id', $phraseIds)->where('language_id', $to->id)->get();

        foreach ($phraseCategories as $phrase_category) {
            $context = $xml->createElement('context');
            $nameXML = $xml->createElement('name', $phrase_category->name);
            $context->appendChild($nameXML);
            $filtered = collect($phrases);
            $filtered->where('phrase_category_id', $phrase_category->id);

            foreach ($filtered->where('phrase_category_id', $phrase_category->id) as $phrase) {
                $message = $xml->createElement('message');

                $source = $xml->createElement('source', $phrase->phrase);
                $context->appendChild($message);
                $message->appendChild($source);

                $translate = $translations->where('phrase_id', $phrase->id)->first();

                if($translate == null) {
                    $translation = $xml->createElement('translation');
                    $translation->setAttribute('type', 'unfinished');
                    $translation->appendChild($xml->createTextNode(''));
                } else {
                    $translation = $xml->createElement('translation', $translate->translation);
                }

                $message->appendChild($translation);
                $doctype->appendChild($context);
            }
        }

        $xml->appendChild($doctype);

        $xml->saveXML();

        $path = storage_path('./app/public/qt/' . $folderName . '/');
        if (!is_dir($path))
            mkdir($path);

        $xml->save($path . $prefix . "." . $to->iso_code . '.' . $file_extension_name);
    }
}
