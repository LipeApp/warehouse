<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the warehouse can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list warehouses');
    }

    /**
     * Determine whether the warehouse can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function view(User $user, Warehouse $model)
    {
        return $user->hasPermissionTo('view warehouses');
    }

    /**
     * Determine whether the warehouse can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create warehouses');
    }

    /**
     * Determine whether the warehouse can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function update(User $user, Warehouse $model)
    {
        return $user->hasPermissionTo('update warehouses');
    }

    /**
     * Determine whether the warehouse can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function delete(User $user, Warehouse $model)
    {
        return $user->hasPermissionTo('delete warehouses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete warehouses');
    }

    /**
     * Determine whether the warehouse can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function restore(User $user, Warehouse $model)
    {
        return false;
    }

    /**
     * Determine whether the warehouse can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Warehouse  $model
     * @return mixed
     */
    public function forceDelete(User $user, Warehouse $model)
    {
        return false;
    }
}
