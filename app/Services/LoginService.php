<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LoginService extends Service
{
    public function authenticate($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $data['token'] = $user->createToken('fms')->plainTextToken;
            $data['user'] = $user;
            return $data;
        }
        return false;
    }
}
