<?php

namespace App\Repositories;

use App\Models\Project;

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
        return Project::latest()->get();
    }

    public function storeOrUpdate($id = null,$data)
    {
        if(is_null($id)){
            $project = new Project();
            $project->name = $data['name'];
            $project->author_id = $data['roll'];
            return $project->save();
        }else{
            $project = Project::find($id);
            $project->name = $data['name'];
            $project->roll = $data['roll'];
            return $project->save();
        }
    }

    public function view($id)
    {
        return Project::find($id);
    }

    public function delete($id)
    {
        return Project::find($id)->delete();
    }
}
