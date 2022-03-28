<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Http\Exceptions\ApiNotFoundException;
use Spatie\Async\Pool;

interface IBaseRepository
{
    /**
    * @return Collection
    */
   public function getAllAsync(): Collection;

    /**
    * @param array $attributes
    * @return Model
    */
   public function storeAsync(array $attributes): Model;

    /**
    * @param $id
    * @param array $attributes
    * @return bool
    */
    public function updateAsync($id = null, array $attributes): ?bool;

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
    * @return Collection
    */
    public function getAllAsync(): Collection
    {
        return
            $this->asyncExecution(function() {
                return $this->model::latest()->get();
            });
    }

    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function storeAsync(array $attributes): Model
    {
        return
            $this->asyncExecution(function() use($attributes) {
                return $this->model->create($attributes);
            });
    }

    /**
    * @param array $attributes
    * @param string $id
    *
    * @return bool
    */
    public function updateAsync($id = null, array $attributes): ?bool
    {
        return
            $this->asyncExecution(function() use($id, $attributes) {

                $this->model = $this->model->find($id);

                if(!$this->model)
                    throw new ApiNotFoundException();

                return $this->model->update($attributes);
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

    function asyncExecution(callable $fn)
    {
        $pool = Pool::create();
        $pool[] = async(function () use($fn){
            return $fn();
        })->then(function ($output) {
            $this->result = $output;
        });
        await($pool);

        return $this->result;
    }
}
