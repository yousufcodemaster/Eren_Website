<?php

namespace App\Policies;

use App\Models\ResellerClient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResellerClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_reseller;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ResellerClient $resellerClient): bool
    {
        return $user->is_reseller && $resellerClient->reseller_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_reseller && $user->canAddMoreClients();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResellerClient $resellerClient): bool
    {
        return $user->is_reseller && $resellerClient->reseller_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResellerClient $resellerClient): bool
    {
        return $user->is_reseller && $resellerClient->reseller_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ResellerClient $resellerClient): bool
    {
        return $user->is_reseller && $resellerClient->reseller_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ResellerClient $resellerClient): bool
    {
        return $user->is_reseller && $resellerClient->reseller_id === $user->id;
    }
}
