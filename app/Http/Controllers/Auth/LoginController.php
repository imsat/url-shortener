<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * User login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid information!', 400, $validator->errors());
        }

        try {
            $user = $this->loginService->authenticate($request->get('email'), $request->get('password'));

            if($user){
                return $this->response(true, 'Login successfully.', 200, $user);
            }else{
                return $this->response(false, 'Unauthenticated', 400);
            }

        } catch (\Exception) {
            return $this->response(false, 'Something went wrong!!', 400);
        }

    }

    /**
     * User logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->response(true, 'Logout successfully.');
        } catch (\Exception) {
            return $this->response(false, 'Something went wrong!!', 400);
        }

    }
}
