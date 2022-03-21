<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

class LoginIn extends IDto
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
