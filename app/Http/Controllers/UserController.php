<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\StoreUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with(['userType:id,value,description'])->get();

            return $this->apiResponseSuccess('Users retrieved successfully', UserResource::collection($users), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $user = User::create($validated_request->toArray());

            return $this->apiResponseSuccess('User created successfully', new UserResource($user), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function show(User $user)
    {
        return $this->apiResponseSuccess('User retrieved successfully', new UserResource($user), 200);
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $user->update($validated_request->toArray());

            return $this->apiResponseSuccess('User updated successfully', new UserResource($user), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return $this->apiResponseSuccess('User removed!', null, 204);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
