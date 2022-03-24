<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

class LoginOut extends IDto
{
    /**
     * @var integer
     */
    public $id;

    // ---
    /**
     * @var string
     */
    public $token;

    /**
     * @var integer
     */
    public $expires_at;

    // ---
    /**
     * @var string
     */
    public $refreshToken;

    // ---
    /**
     * @var string
     */
    public $token_type;


    //----------------------------

    /**
     * @var object
     */
    public $user;


    /**
     * @var object
     */
    public $role;
}
