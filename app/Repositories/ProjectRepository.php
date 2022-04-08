<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Base\BaseRepository;
use App\Services\Project\Models\ProjectPageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

interface IProjectRepository
{
    public function getAllWithAuthor(): Collection;
    public function getAllUserProjectsAsync($filter, $include = []): Builder;
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


    /**
    *
    * @return Builder
    */
    public function getAllUserProjectsAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include)->withCount('languages', 'categories');

                $result = self::filter($result, $filter);

                $user = Auth::user();

                if($user)
                {
                    $result = $result
                        ->whereIn('id', $user->categories->map(
                            function ($category) {
                                return $category->project_id;
                            }
                        )
                    );
                }

                return $result;
            });
    }

    /**
    * @param Builder $query
    * @param ProjectPageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $query = null, ProjectPageableFilter $filter = null)
    {
        if(isset($filter->project))
        {
            $query = $query
                ->where('name', '=', $filter->project);
        }

        if(isset($filter->q))
        {
            $query = $query
                ->where('name', 'like', '%' .$filter->q. '%');
        }

        return $query;
    }
}
