<?php

namespace App\Services\Identity\Models;

use App\Services\Base\Models\IDto;

class loginIn extends IDto
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;
}

class loginOut extends IDto
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $name;
    /**
     * @var object
     */
    public $role;

    // ---
    /**
     * @var string
     */
    public $token;

    /**
     * @var integer
     */
    public $ttl;

    // ---
    /**
     * @var string
     */
    public $refreshToken;

    /**
     * @var integer
     */
    public $refreshTtl;

    //----------------------------

    /**
     * @var object
     */
    public $user;
}
