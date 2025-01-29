<?php

namespace App\Policies;

use App\Models\Faculties;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FacultiesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Faculties $faculties): bool
    {
        return  $user->hasRole('User') || $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasRole('User') || $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Faculties $faculties): bool
    {
        return  $user->hasRole('User') || $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Faculties $faculties): bool
    {
        return  $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Faculties $faculties): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Faculties $faculties): bool
    {
        return false;
    }
}
