<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $valid_request = $request->safe();

            $valid_request['user_type_id'] = 4;

            $user = User::create($valid_request->toArray());

            $token = $user->createToken('access_token');

            return $this->apiResponseSuccess('Registered successfully!', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'status' => $user->status,
                'user_type' => [
                    'id' => $user->userType->id,
                    'value' => $user->userType->value,
                    'description' => $user->userType->description,
                ],
                'token' => $token->plainTextToken
            ], 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->safe()->only(['email', 'password']);

            $user = User::with('userType')->where('email', $credentials['email'])->first();

            if(!auth()->attempt($credentials)){
                return $this->apiResponseError('Incorrect credentials!');
            }

            $token = $user->createToken('access_token');

            return $this->apiResponseSuccess('Registered successfully!', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'status' => $user->status,
                'user_type' => [
                    'id' => $user->userType->id,
                    'value' => $user->userType->value,
                    'description' => $user->userType->description,
                ],
                'token' => $token->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function authUser()
    {
        try {
            $user = Auth::user();

            return $this->apiResponseSuccess('Your information', new UserResource($user), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->apiResponseSuccess('Logout success!', null, 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
