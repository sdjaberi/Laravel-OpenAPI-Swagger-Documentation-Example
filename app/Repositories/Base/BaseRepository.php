<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Http\Exceptions\ApiNotFoundException;
use App\Services\Base\IPageableFilter;
use Doctrine\DBAL\Query\QueryBuilder;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Async\Pool;

interface IBaseRepository
{
    /**
    * @return Builder
    */
   public function getAllAsync(IPageableFilter $filter, array $include): Builder;

    /**
    * @param array $attributes
    * @return Model
    */
   public function storeAsync(array $attributes, array $relations = []): Model;

    /**
    * @param $id
    * @param array $attributes
    * @return bool
    */
    public function updateAsync($id = null, array $attributes, array $relations = []): ?Model;

    /**
    * @param array $attributes
    * @return bool
    */
    public function upsertAsync(array $attributes): ?bool;

   /**
    * @param $id
    * @return Model
    */
   public function viewAsync($id): ?Model;

   /**
    * @param $id
    * @return bool
    */
    public function deleteAsync($id): ?bool;

   /**
    * @param $ids
    * @return bool
    */
   public function deleteAllAsync($ids): ?bool;
}

class BaseRepository implements IBaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
    *
    * @return Builder
    */
    public function getAllAsync(IPageableFilter $filter, array $include): Builder
    {
        return
            $this->asyncExecution(function() use($filter, $include) {

                $query = $this->model;

                $query = $query->orderBy( !isset($filter->sort) ? "id" : $filter->sort);
                $query = $query->take( !isset($filter->limit) ? 50 : $filter->limit);
                $query = $query->skip( !isset($filter->skip) ? 0 : $filter->skip);

                $query = $query->with($include);

                return $query;
            });
    }

    /**
    * @param array $attributes
    * @param array $relations
    *
    * @return Model
    */
    public function storeAsync(array $attributes, array $relations = []): Model
    {
        return
            $this->asyncExecution(function() use($attributes, $relations) {

                $model = $this->model->create($attributes);

                if(isset($relations)){
                    foreach ($relations as $relation)
                        $model->$relation()->sync($attributes[$relation]);
                }

                return $model;
            });
    }

    /**
    * @param array $attributes
    * @param array $relations
    * @param string $id
    *
    * @return bool
    */
    public function updateAsync($id = null, array $attributes, array $relations = []): ?Model
    {
        return
            $this->asyncExecution(function() use($id, $attributes, $relations) {

                $model = $this->model->with($relations)->find($id);

                if(!$model)
                    throw new ApiNotFoundException();

                if(isset($relations)){
                    foreach ($relations as $relation)
                        $model->$relation()->sync($attributes[$relation]);
                }

                $model->update($attributes);

                return $model;
            });
    }

    /**
    * @param array $attributes
    *
    * @return bool
    */
    public function upsertAsync(array $attributes): ?bool
    {
        return
            $this->asyncExecution(function() use($attributes) {
                return $this->model->upsert($attributes);
            });
    }

    /**
    * @param $id
    * @return Model
    */
    public function viewAsync($id): ?Model
    {
        return
            $this->asyncExecution(function() use($id) {
                return $this->model->find($id);
            });
    }

    /**
    * @param $id
    * @return bool
    */
    public function deleteAsync($id): ?bool
    {
        return
            $this->asyncExecution(function() use($id) {
                return $this->model->find($id)->delete();
            });
    }

    /**
    * @param $ids
    * @return bool
    */
    public function deleteAllAsync($ids) : ?bool
    {
        return
            $this->asyncExecution(function() use($ids) {
                return $this->model->whereIn($this->model->getKeyName(), $ids)->delete();
            });
    }

    public function asyncExecution(callable $fn)
    {
        $pool = Pool::create();

        $pool[] = async(function () use($fn){
            return $fn();
        })->then(function ($output) {
            $this->result = $output;
        })
        ->catch(function ($exception) {
            // Handle the thrown exception for this child process.
            throw $exception;
        });

        await($pool);

        return $this->result;
    }
}
