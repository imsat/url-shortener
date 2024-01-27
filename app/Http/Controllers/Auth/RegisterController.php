<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid information!', 400, $validator->errors());
        }

        try {
            $user = $this->registerService->register($request->get('name'), $request->get('email'), $request->get('password'));

            return $this->response(true, 'Register successfully.', 200, $user);

        } catch (\Exception) {
            return $this->response(false, 'Something went wrong!!', 400);
        }

    }
}
