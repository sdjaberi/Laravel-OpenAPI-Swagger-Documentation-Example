<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\MassDestroyProjectRequest;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepository;
//use UserRepository;

use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;

class ProjectsController extends Controller
{
    private $_projectRepository;
    private $_userRepository;

    public function __construct(ProjectRepository $projectRepository) //, UserRepository $userRepository)
    {
        $this->_projectRepository = $projectRepository;
        //$this->_userRepository = $userRepository;
    }

    public function index()
    {
        $projects = $this->_projectRepository->getAllData();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        if(!Gate::allows('project_create'))
            throw new ApiPermissionException;

        $authors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.projects.create', compact('authors'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->_projectRepository->storeOrUpdate(null, $request);

        return redirect()->route('admin.projects.index');
    }

    public function edit(Project $project)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $authors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project->load('author');

        return view('admin.projects.edit', compact('authors', 'project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->_projectRepository->storeOrUpdate($request['id'], $project);

        return redirect()->route('admin.projects.index');

        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project)
    {
        $project = $this->_projectRepository->view($project->id);

        return view('admin.projects.show', compact('project'));
    }

    public function destroy(Project $project)
    {
        $project = $this->_projectRepository->delete($project->id);

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        Project::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
