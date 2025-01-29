<?php

namespace App\Policies;

use App\Models\AcademicSessions;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AcademicSessionsPolicy
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
    public function view(User $user, AcademicSessions $academicSessions): bool
    {
        return  $user->hasRole('User') || $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AcademicSessions $academicSessions): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AcademicSessions $academicSessions): bool
    {
        return  $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AcademicSessions $academicSessions): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AcademicSessions $academicSessions): bool
    {
        return $user->hasRole('Super_admin') || $user->hasRole('Admin');
    }
}
