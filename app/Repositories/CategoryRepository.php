<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Base\BaseRepository;

interface ICategoryRepository
{
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
}
