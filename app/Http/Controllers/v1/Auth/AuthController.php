<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignupRequest;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ResponseHandler;
use App\Exceptions\AuthException;

class AuthController extends Controller
{
    use ResponseHandler;
    public function __construct(User $model) {
        $this->model = $model;
    }

    public function login(UserLoginRequest $request)
    {
        $inputs = $request->all();
        if(Auth::attempt($inputs))
        {
            $user = Auth::user();
            $user['token'] = $user->createToken(env('APP_KEY'))->accessToken;

            return $this->buildSuccess(true, $user, 'User logged in successfully', Response::HTTP_OK);
        } else {
            throw new AuthException("Unable to authenticate user", Response::HTTP_UNAUTHORIZED);
        }
    }

    public function signup(UserSignupRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        $user = $this->model->createUser($inputs);
        \DB::commit();
        return $this->buildSuccess(true, $user, 'User account created successfully', Response::HTTP_OK);
    }
}
