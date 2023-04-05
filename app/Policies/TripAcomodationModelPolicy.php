<?php

namespace App\Policies;

use App\Models\Trip_AcomodationModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripAcomodationModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip_AcomodationModel  $tripAcomodationModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trip_AcomodationModel $tripAcomodationModel)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip_AcomodationModel  $tripAcomodationModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trip_AcomodationModel $tripAcomodationModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip_AcomodationModel  $tripAcomodationModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trip_AcomodationModel $tripAcomodationModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip_AcomodationModel  $tripAcomodationModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trip_AcomodationModel $tripAcomodationModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip_AcomodationModel  $tripAcomodationModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trip_AcomodationModel $tripAcomodationModel)
    {
        //
    }
}
