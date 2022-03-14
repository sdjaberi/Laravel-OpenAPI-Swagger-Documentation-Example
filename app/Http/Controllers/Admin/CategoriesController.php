<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\IndexCategoryRequest;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\MassDestroyCategoryRequest;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TranslationRepository;
use App\Repositories\LanguageRepository;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Phrase;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    private $_categoryRepository;
    private $_projectRepository;
    private $_translationRepository;
    private $_languageRepository;

    public function __construct(CategoryRepository $categoryRepository, ProjectRepository $projectRepository, TranslationRepository $translationRepository, LanguageRepository $languageRepository)
    {
        $this->_categoryRepository = $categoryRepository;
        $this->_projectRepository = $projectRepository;
        $this->_translationRepository = $translationRepository;
        $this->_languageRepository = $languageRepository;
    }

    public function index(IndexCategoryRequest $request)
    {
        $categories = $this->_categoryRepository->getAllData();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(CreateCategoryRequest $request)
    {
        $projects = $this->_projectRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.categories.create', compact('projects'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->_categoryRepository->store($request);

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        $projects = $this->_projectRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $category->load('project');

        //dd($category);

        return view('admin.categories.edit', compact('category', 'projects'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->_categoryRepository->update($category->name, $request);

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        $category = $this->_categoryRepository->view($category->name);

        $category->load('phrases');
        $category->load('users');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        $category = $this->_categoryRepository->delete($category->name);

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        $categories = $this->_categoryRepository->deleteAll($request('names'));

        return response(null, Response::HTTP_NO_CONTENT);
    }



    ///--------- Custom Actions -----------////

    public function translate($name, $to = "German")
    {
        //dd($name);

        $category = $this->_categoryRepository->view($name);

        $category->load('phrases');
        $category->project->load('languages');

        $phrases = $category->phrases;

        $languageFrom = $this->_languageRepository->getPrimaryLanguage();
        $languagesTo = $category->project->languages->where('id', '!=', $languageFrom->id);
        $languageTo = $this->_languageRepository->getAllData()->where("title", $to)->first();


        $translations = collect();
        foreach ($phrases as $phrase) {
            $translation =
                $this->
                    _translationRepository->
                        getAllData()
                        ->where('language_id', $languageTo->id)
                        ->where('phrase_id', $phrase->id)
                        ->first();

            $translations->push($translation);
        }

        //$phrases->_translationRepository->getAllData();


        //$translations = $this->_translationRepository->getAllData();

        //$projects = $this->_projectRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //return view('admin.categories.edit', compact('category', 'projects'));

        //return new CategoryResource($category);


        return view('admin.categories.translate')
            ->with('category', $category)
            ->with('phrases',  $phrases)
            ->with('from', $languageFrom)
            ->with('to',   $languageTo)
            ->with('languagesTo',  $languagesTo)
            ->with('translations', $translations)
            ->with('user',   Auth::user());

    }

}
