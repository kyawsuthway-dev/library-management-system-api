<?php

namespace App\Policies;

use App\Models\User;

class PublisherPolicy
{
    public function create(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian' || $user->userType->value === 'staff';
    }

    public function update(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian' || $user->userType->value === 'staff';
    }
    
    public function delete(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian';
    }
}
