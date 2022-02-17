<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the material can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list materials');
    }

    /**
     * Determine whether the material can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function view(User $user, Material $model)
    {
        return $user->hasPermissionTo('view materials');
    }

    /**
     * Determine whether the material can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create materials');
    }

    /**
     * Determine whether the material can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function update(User $user, Material $model)
    {
        return $user->hasPermissionTo('update materials');
    }

    /**
     * Determine whether the material can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function delete(User $user, Material $model)
    {
        return $user->hasPermissionTo('delete materials');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete materials');
    }

    /**
     * Determine whether the material can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function restore(User $user, Material $model)
    {
        return false;
    }

    /**
     * Determine whether the material can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Material  $model
     * @return mixed
     */
    public function forceDelete(User $user, Material $model)
    {
        return false;
    }
}
