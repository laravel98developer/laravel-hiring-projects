<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\DeliveryRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryRequestPolicy
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
        return $user->tokenCan(Permission::DELIVERY_REQUEST_LIST->value);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DeliveryRequest $deliveryRequest)
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
        return $user->tokenCan(Permission::DELIVERY_REQUEST_INSERT->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function cancel(User $user, DeliveryRequest $deliveryRequest)
    {
        return $user->tokenCan(Permission::DELIVERY_REQUEST_CANCEL->value) && $user->id === $deliveryRequest->collection_user_id;
    }

    /**
     * Determine whether the user can accept models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function accept(User $user)
    {
        return $user->tokenCan(Permission::DELIVERY_REQUEST_ACCEPT->value);
    }

    
    /**
     * Determine whether the user can receive models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function receive(User $user, DeliveryRequest $deliveryRequest)
    {
        return $user->tokenCan(Permission::DELIVERY_REQUEST_FULL_DELIVERY_OP->value) && $user->id === $deliveryRequest->deliverer_user_id;
    }

    /**
     * Determine whether the user can deliver models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deliver(User $user, DeliveryRequest $deliveryRequest)
    {
        return $user->tokenCan(Permission::DELIVERY_REQUEST_FULL_DELIVERY_OP->value) && $user->id === $deliveryRequest->deliverer_user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DeliveryRequest $deliveryRequest)
    {
        //
    }
}
