<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

class RegisterIn extends IDto
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;
}
