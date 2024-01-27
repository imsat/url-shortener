<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterService extends Service
{
    public function register($name, $email, $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        if ($user) {
            $data['token'] = $user->createToken('fms')->plainTextToken;
            $data['user'] = $user;

            return $data;
        }
        return false;
    }
}
