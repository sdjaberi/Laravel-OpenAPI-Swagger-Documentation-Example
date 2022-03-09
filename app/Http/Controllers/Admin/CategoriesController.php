<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\IndexCategoryRequest;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\MassDestroyCategoryRequest;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;

class CategoriesController extends Controller
{
    private $_categoryRepository;
    private $_projectRepository;

    public function __construct(CategoryRepository $categoryRepository, ProjectRepository $projectRepository)
    {
        //$this->middleware('auth')->except(['index', 'show']);

        $this->_categoryRepository = $categoryRepository;
        $this->_projectRepository = $projectRepository;
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

        //dd($category);


        //$category->load('phrases');

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
}
