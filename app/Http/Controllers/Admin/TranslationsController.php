<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Translations\IndexTranslationRequest;
use App\Http\Requests\Web\Translations\CreateTranslationRequest;
use App\Http\Requests\Web\Translations\MassDestroyTranslationRequest;
use App\Http\Requests\Web\Translations\StoreTranslationRequest;
use App\Http\Requests\Web\Translations\UpdateTranslationRequest;
use App\Http\Requests\Web\Translations\UpdateTranslationAjaxRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Translation;
use App\Repositories\TranslationRepository;
use App\Repositories\UserRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\PhraseRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Rule\Parameters;

class TranslationsController extends Controller
{
    private $_translationRepository;
    private $_userRepository;
    private $_languageRepository;
    private $_phraseRepository;

    public function __construct(TranslationRepository $translationRepository, UserRepository $userRepository, LanguageRepository $languageRepository, PhraseRepository $phraseRepository)
    {
        $this->_translationRepository = $translationRepository;
        $this->_userRepository = $userRepository;
        $this->_languageRepository = $languageRepository;
        $this->_phraseRepository = $phraseRepository;
    }

    public function index(IndexTranslationRequest $request)
    {
        //$translations = $this->_translationRepository->getAllAsync();

        return view('admin.translations.index'); //, compact('translations'));
    }

    public function create(CreateTranslationRequest $request)
    {
        $authors = $this->_userRepository->getAllAsync()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllNotPrimaryAsync()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $phrases = $this->_phraseRepository->getAllAsync()->pluck('phrase', 'id')->prepend(trans('global.pleaseSelect'), '');
        $primaryLanguage = $this->_languageRepository->getPrimaryAsync()->take(1)->pluck('title', 'id');

        return view('admin.translations.create', compact('authors', 'languages', 'phrases', 'primaryLanguage'));
    }

    public function store(StoreTranslationRequest $request)
    {
        //dd($request->all());

        $translation = $this->_translationRepository->storeAsync($request);

        return redirect()->route('admin.translations.index');
    }

    public function edit(Translation $translation)
    {
        $authors = $this->_userRepository->getAllAsync()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllNotPrimaryAsync()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $phrases = $this->_phraseRepository->getAllAsync()->pluck('phrase', 'id')->prepend(trans('global.pleaseSelect'), '');
        $primaryLanguage = $this->_languageRepository->getPrimaryAsync()->take(1)->pluck('title', 'id');

        $translation->load('author', 'language', 'phrase');

        return view('admin.translations.edit', compact('authors', 'languages', 'phrases', 'translation', 'primaryLanguage'));
    }

    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        /*  Validate requested data */
        //$request->validated();

        $translation = $this->_translationRepository->updateAsync($translation->id, $request);

        return redirect()->route('admin.translations.index');
    }

    public function show(Translation $translation)
    {
        $translation = $this->_translationRepository->viewAsync($translation->id);

        return view('admin.translations.show', compact('translation'));
    }

    public function destroy(Translation $translation)
    {
        $translation = $this->_translationRepository->deleteAsync($translation->id);

        return back();
    }

    public function massDestroy(MassDestroyTranslationRequest $request)
    {
        $translations = $this->_translationRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }


    //------------------------------------- Custom Actions ----------------------------------//

    /* Index ajax request */
   public function getTranslations(Request $request)
   {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        //dd($request->all());

        $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : null; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        //dd($columnIndex,$columnName ,$columnSortOrder, $searchValue);

        // Total records
        $totalRecords = Translation::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Translation::

            where('translation', 'like', '%' .$searchValue . '%')

            ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
            ->select('phrases.*', 'phrase_translations.*')
            ->orWhere('phrases.phrase', 'like', '%' .$searchValue . '%')

            ->join('languages', 'phrase_translations.language_id', '=', 'languages.id')
            ->select('languages.*', 'phrase_translations.*')
            ->orWhere('languages.title', 'like', '%' .$searchValue . '%')

            ->leftJoin('users', 'phrase_translations.user_id', '=', 'users.id')
            ->select('users.*', 'phrase_translations.*')
            ->orWhere('users.name', 'like', '%' .$searchValue . '%')

            ->count();

        //dd($totalRecords,$totalRecordswithFilter);

        //dd($columnName, $columnSortOrder);

        // Fetch records
        $records = Translation::orderBy($columnName, $columnSortOrder)
            ->where('translation', 'like', '%' .$searchValue . '%')

            ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
            ->orWhere('phrases.phrase', 'like', '%' .$searchValue . '%')

            ->join('languages', 'phrase_translations.language_id', '=', 'languages.id')
            ->orWhere('languages.title', 'like', '%' .$searchValue . '%')

            ->leftJoin('users', 'phrase_translations.user_id', '=', 'users.id')
            ->orWhere('users.name', 'like', '%' .$searchValue . '%')

            ->select(
                'phrases.phrase as phrase',
                'phrases.base_id as base_id',
                'phrases.id as phrase_id',
                'languages.title as language',
                'languages.id as language_id',
                'users.name as author',
                'users.id as user_id',
                'phrase_translations.*',
                )

            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            //dd($record);
            $id = $record->id;
            $base_id = $record->base_id;
            $translation = $record->translation;
            $phrase = $record->phrase;
            $language = $record->language;
            $author = $record->author;

            $data_arr[] = array(
                "id" => $id,
                "base_id" => $base_id,
                "translation" => $translation,
                "phrase" => $phrase,
                "language" => $language,
                "author" => $author,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
            );

        echo json_encode($response);
        exit;
    }

    /**
     * @param Request $request
     * @param TranslationStoreRequest $storeAsyncRequest
     * @return object
     */
    public function ajaxStore(Request $request, StoreTranslationRequest $storeAsyncRequest): object
    {
        /*  Validate requested data */
        $storeAsyncRequest->validated();

        /* Store data */
        $translation = $this->_translationRepository->storeAsync($request);

        return response()->json(["data" => $translation], 200);
    }

    /**
     * @param Request $request
     * @param TranslationUpdateRequest $updateRequest
     * @param $id
     * @return object
     */
    public function ajaxUpdate(Request $request, UpdateTranslationAjaxRequest $updateRequest, $id): object
    {
        /*  Validate requested data */
        $updateRequest->validated();

        $translation = $this->_translationRepository->updateAsync($id, $request);

        return response()->json(["data" => $translation], 200);
    }
}
