<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Base\BaseRepository;

interface IRoleRepository
{
}

class RoleRepository extends BaseRepository implements IRoleRepository
{
    /**
    * RoleRepository constructor.
    *
    * @param Role $model
    */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
