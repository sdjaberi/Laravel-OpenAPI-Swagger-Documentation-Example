<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Base\BaseRepository;

interface IPermissionRepository
{
}

class PermissionRepository extends BaseRepository implements IPermissionRepository
{
    /**
    * PermissionRepository constructor.
    *
    * @param Permission $model
    */
   public function __construct(Permission $model)
   {
       parent::__construct($model);
   }
}
