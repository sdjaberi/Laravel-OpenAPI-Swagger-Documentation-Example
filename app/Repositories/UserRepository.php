<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;
use Laravel\Passport\PersonalAccessTokenResult;

interface IUserRepository
{
    public function viewByEmailAsync($id): User;
    public function storeTokenAsync($data): PersonalAccessTokenResult;
}

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
    * UserRepository constructor.
    *
    * @param User $model
    */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
    * @param string $email
    *
    * @return User
    */
    public function viewByEmailAsync($email):User
    {
        return
            parent::asyncExecution(function() use($email) {
                return parent::getAllAsync()->first('email', $email);
            });
    }

    /**
    * @param User $user
    *
    * @return PersonalAccessTokenResult
    */
    public function storeTokenAsync($user): PersonalAccessTokenResult
    {
        return
            parent::asyncExecution(function() use($user) {
                $tokenResult = $user->createToken('Personal Access Token');

                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);

                $token->save();

                return $tokenResult;
            });
    }

}
