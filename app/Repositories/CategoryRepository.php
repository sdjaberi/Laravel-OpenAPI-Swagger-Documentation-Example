<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Base\BaseRepository;
use App\Services\Category\Models\CategoryPageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

interface ICategoryRepository
{
    public function getAllUserCategoriesAsync($filter, $include = []): Builder;
    public function count($filter = null): int;
}

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    /**
    * CategoryRepository constructor.
    *
    * @param Category $model
    */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
    *
    * @return Builder
    */
    public function getAllUserCategoriesAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include);

                $result = self::filter($result, $filter)->withCount('phrases');

                return $result;
            });
    }

    /**
    *
    * @return integer
    */
    public function count($filter = null): int
    {
        return
            parent::asyncExecution(function() use($filter) {

                $result = parent::getCount();

                $result = self::filter($result, $filter);

                return $result->count();
            });
    }

    /**
    * @param Builder $query
    * @param CategoryPageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $result, CategoryPageableFilter $filter)
    {
        if(isset($filter->category))
        {
            $result = $result
                ->where('name', '=', $filter->category);
        }

        if(isset($filter->project))
        {
            $result = $result
                ->join('projects', 'categories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'categories.*')
                ->where('projects.name' , '=', $filter->project);
        }

        if(isset($filter->q))
        {
            $result = $result
                ->where('categories.name', 'like', '%' .$filter->q. '%')

                ->join('projects', 'categories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'categories.*')
                ->orWhere('projects.name' , 'like', '%' .$filter->q. '%');;
        }

        $user = Auth::user();

        if($user)
        {
            $result = $result
                ->whereIn('name', $user->categories->map(
                    function ($item) {
                        return $item->name;
                    }
                )
            );
        }

        return $result;
    }

}
