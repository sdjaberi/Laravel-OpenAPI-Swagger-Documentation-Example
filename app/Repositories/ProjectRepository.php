<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface IProjectRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
}

class ProjectRepository implements IProjectRepository
{
    public function getAllData()
    {
        return Project::with('author')->get();
    }

    public function store($data)
    {
        $project = new Project();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->author_id = $data['author_id'];
        $project->save();

        $project->languages()->sync($data['languages']);

        return $project;
    }

    public function update($id = null, $data)
    {
        $project = Project::find($id);

        if(!$project)
            throw new ApiNotFoundException();

        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->author_id = $data['author_id'];
        $project->save();

        $project->languages()->sync($data['languages']);

        return $project;
    }

    public function view($id)
    {
        $project = Project::find($id);

        if(!$project)
            throw new ApiNotFoundException();

        return $project->load('author');
    }

    public function delete($id)
    {
        $project = Project::find($id);

        if(!$project)
            throw new ApiNotFoundException();

        return $project->delete();
    }

    public function deleteAll($ids)
    {
        return Project::whereIn('id', $ids)->delete();
    }

}
