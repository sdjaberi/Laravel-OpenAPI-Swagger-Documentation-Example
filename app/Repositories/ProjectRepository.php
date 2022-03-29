<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface IProjectRepository
{
    public function getAllWithAuthor(): Collection;
}

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    /**
    * ProjectRepository constructor.
    *
    * @param Project $model
    */
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    /**
    *
    * @return Collection
    */
    public function getAllWithAuthor(): Collection
    {
        return
            parent::asyncExecution(function() {
                return Project::with('author')->get();
            });
    }
}
