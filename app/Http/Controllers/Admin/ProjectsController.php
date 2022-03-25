<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Projects\IndexProjectRequest;
use App\Http\Requests\Web\Projects\CreateProjectRequest;
use App\Http\Requests\Web\Projects\MassDestroyProjectRequest;
use App\Http\Requests\Web\Projects\StoreProjectRequest;
use App\Http\Requests\Web\Projects\UpdateProjectRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\LanguageRepository;

class ProjectsController extends Controller
{
    private $_projectRepository;
    private $_userRepository;
    private $_languageRepository;

    public function __construct(ProjectRepository $projectRepository, UserRepository $userRepository , LanguageRepository $languageRepository)
    {
        $this->_projectRepository = $projectRepository;
        $this->_userRepository = $userRepository;
        $this->_languageRepository = $languageRepository;
    }

    public function index(IndexProjectRequest $request)
    {
        $projects = $this->_projectRepository->getAllData();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(CreateProjectRequest $request)
    {
        $authors = $this->_userRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id');

        return view('admin.projects.create', compact('authors', 'languages'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->_projectRepository->store($request);

        return redirect()->route('admin.projects.index');
    }

    public function edit(Project $project)
    {
        $authors = $this->_userRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id');

        $project->load('author');

        return view('admin.projects.edit', compact('authors', 'languages', 'project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->_projectRepository->update($project->id, $request);

        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project)
    {
        $project = $this->_projectRepository->view($project->id);

        $project->load('languages','categories');

        return view('admin.projects.show', compact('project'));
    }

    public function destroy(MassDestroyProjectRequest $request, Project $project)
    {
        $project = $this->_projectRepository->delete($project->id);

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        $projects = $this->_projectRepository->deleteAll($request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
