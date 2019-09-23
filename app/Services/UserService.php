<?php

namespace App\Services;

use App\User;

class UserService
{
    public function getUserByEmail($email)
    {
        return User::where(['email' => $email])->first();
    }

    public function createUser($email, $name)
    {
        return User::create([
            'name'  => $name,
            'email' => $email
        ]);

    }
}
