<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Route;

class UserPolicy
{
    /**
     * Super admins and librarians can view any user
     */
    public function viewAny(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }

    public function view(User $user)
    {
        return $user->id === Route::current('user')->user->id || $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }

    public function create(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }

    public function update(User $user)
    {
        return $user->id === Route::current('user')->user->id || $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }

    /**
     * Only super admins and librarians can delete user accounts
     */
    public function delete(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }
}
