<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;

interface IProjectRepository
{
    public function getAllData();
    public function storeOrUpdate($id = null,$data);
    public function view($id);
    public function delete($id);
}

class ProjectRepository implements IProjectRepository
{
    public function getAllData()
    {
        if(Gate::allows('project_access'))
            throw new ApiPermissionException;

        try {
            return Project::latest()->get();
        } catch (\Exception $ex) {
            throw new ApiNotFoundException;
        }
    }

    public function storeOrUpdate($id = null,$data)
    {
        if(is_null($id)){
            if(Gate::allows('project_create'))
                throw new ApiPermissionException;


            $project = new Project();
            $project->name = $data['name'];
            $project->author_id = $data['roll'];
            $project->save();

            return $project;
        }
        else
        {
            if(Gate::allows('project_edit'))
                throw new ApiPermissionException;

            $project = Project::find($id);
            $project->name = $data['name'];
            $project->roll = $data['roll'];
            $project->save();

            return $project;
        }
    }

    public function view($id)
    {
        if(Gate::allows('project_show'))
            throw new ApiPermissionException;

        return Project::find($id)->load('author');
    }

    public function delete($id)
    {
        if(Gate::allows('project_delete'))
            throw new ApiPermissionException;

        return Project::find($id)->delete();
    }
}
