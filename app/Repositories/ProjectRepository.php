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
    public function getAllAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function viewAsync($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);
}

class ProjectRepository implements IProjectRepository
{
    public function getAllAsync()
    {
        return Project::with('author')->get();
    }

    public function storeAsync($data)
    {
        $project = new Project();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->author_id = $data['author_id'];
        $project->save();

        $project->languages()->sync($data['languages']);

        return $project;
    }

    public function updateAsync($id = null, $data)
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

    public function viewAsync($id)
    {
        $project = Project::find($id);

        if(!$project)
            throw new ApiNotFoundException();

        return $project->load('author');
    }

    public function deleteAsync($id)
    {
        $project = Project::find($id);

        if(!$project)
            throw new ApiNotFoundException();

        return $project->deleteAsync();
    }

    public function deleteAllAsync($ids)
    {
        return Project::whereIn('id', $ids)->deleteAsync();
    }

}
