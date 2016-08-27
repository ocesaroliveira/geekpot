<?php

namespace App\Service\User;

use App\User;

use Hash;

class Login
{

    public function execute($email, $password)
    {
        $user = User::where('email', '=', $email)
            ->first();

        if (is_null($user)) {
            return false;
        }

        if (!Hash::check($password, $user->password)) {
            return false;
        }

        return $user->id;
    }
}
