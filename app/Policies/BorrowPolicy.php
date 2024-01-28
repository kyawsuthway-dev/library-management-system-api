<?php

namespace App\Policies;

use App\Models\User;

class BorrowPolicy
{
    public function viewAny(User $user)
    {
        return $user->userType->value === 'super_admin' || $user->userType->value === 'librarian' || $user->userType->value === 'staff';
    }

    public function create(User $user)
    {
        return $user->userType->value === 'librarian' || $user->userType->value === 'staff';
    }

    public function returnBook(User $user)
    {
        return $user->userType->value === 'librarian' || $user->userType->value === 'staff';
    }
}
