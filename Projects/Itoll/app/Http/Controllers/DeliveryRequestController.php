<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest\StoreDeliveryRequestRequest;
use App\Http\Resources\ApiResource;
use App\Http\Resources\DeliveryRequestCollection;
use App\Models\DeliveryRequest;
use App\Models\User;
use App\Notifications\DelivererChangeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeliveryRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->can('viewAny', DeliveryRequest::class)) {
            $status = Response::HTTP_OK;
            $data = (new DeliveryRequestCollection(DeliveryRequest::whereNull('deliverer_user_id')->paginate(50)))->response()->getData(true);
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * Display list of delivery requests of a specified deliverer.
     */
    public function deliverers_list(Request $request)
    {
        if($request->user()->can('viewAny', DeliveryRequest::class)) {
            $status = Response::HTTP_OK;
            $data = (new DeliveryRequestCollection(DeliveryRequest::where('deliverer_user_id', "=", $request->user()->id)->paginate(50)))->response()->getData(true);
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * Display list of all delivery requests plus delivery requests of a specified deliverer.
     */
    public function all_deliverers_list(Request $request)
    {
        if($request->user()->can('viewAny', DeliveryRequest::class)) {
            $status = Response::HTTP_OK;
            $data = (new DeliveryRequestCollection(DeliveryRequest::whereNull('deliverer_user_id')->orWhere('deliverer_user_id', "=", $request->user()->id)->paginate(50)))->response()->getData(true);
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        // return new ApiResource($status, $data ?? "");
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreDeliveryRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryRequestRequest $request)
    {
        if($request->user()->can('create', DeliveryRequest::class)) {
            $deliveryRequest = new DeliveryRequest();
            $deliveryRequest->origin_latitude = $request->o_latitude;
            $deliveryRequest->origin_longitude = $request->o_longitude;
            $deliveryRequest->origin_firstname = $request->o_firstname;
            $deliveryRequest->origin_lastname = $request->o_lastname;
            $deliveryRequest->origin_address = $request->o_address;
            $deliveryRequest->origin_phone = $request->o_phone;
            $deliveryRequest->destination_latitude = $request->d_latitude;
            $deliveryRequest->destination_longitude = $request->d_longitude;
            $deliveryRequest->destination_firstname = $request->d_firstname;
            $deliveryRequest->destination_lastname = $request->d_lastname;
            $deliveryRequest->destination_address = $request->d_address;
            $deliveryRequest->destination_phone = $request->d_phone;
            $deliveryRequest->collection_user_id = $request->user()->id;
            if($deliveryRequest->save()) {
                $status = Response::HTTP_CREATED;
                $data = $deliveryRequest->id;
                $request->user()->notify(new DelivererChangeStatus($data, __('notification.delivery_request_insert', ['id' => $data])));
            } else {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Cancel a model
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, int $id)
    {
        $deliveryRequest = DeliveryRequest::findOrFail($id);
        if($request->user()->can('cancel', $deliveryRequest)) {
            if(is_null($deliveryRequest->accepted_at)) {
                $deliveryRequest->canceled_at = now();
                $deliveryRequest->save();
                if($deliveryRequest->save()) {
                    $status = Response::HTTP_OK;
                    $data = __('api.canceled_successfully');
                    $request->user()->notify(new DelivererChangeStatus($id, __('notification.delivery_request_cancel', ['id' => $id])));
                } else {
                    $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                }
            } else {
                $status = Response::HTTP_NOT_ACCEPTABLE;
                $data = __('api.cannot_cancel');
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Accept a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, int $id)
    {
        if($request->user()->can('accept', DeliveryRequest::class)) {
            try {
                DB::beginTransaction();
                $deliveryRequest = DeliveryRequest::lockForUpdate()->whereNull('deliverer_user_id')->find($id); // we used lock to prevent Race Condition
                if(!is_null($deliveryRequest)) {
                    $deliveryRequest->accepted_at = now();
                    $deliveryRequest->deliverer_user_id = $request->user()->id;
                    if($deliveryRequest->save()) {
                        $status = Response::HTTP_OK;
                        $data = __('api.accepted_successfully');
                        $user = User::find($deliveryRequest->collection_user_id);
                        $user->notify(new DelivererChangeStatus($id, __('notification.delivery_request_accepted', ['id' => $id])));
                    } else {
                        $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                    }
                } else {
                    $status = Response::HTTP_NOT_ACCEPTABLE;
                    $data = __('api.cannot_accept');
                }
                DB::commit();
            } catch (\Exception | \Throwable $e) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                DB::rollBack();
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Receive a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function received(Request $request, int $id)
    {
        $deliveryRequest = DeliveryRequest::findOrFail($id);
        if($request->user()->can('receive', $deliveryRequest)) {
            if(!is_null($deliveryRequest->accepted_at) && is_null($deliveryRequest->received_at)) {
                $deliveryRequest->received_at = now();
                $deliveryRequest->save();
                $status = Response::HTTP_OK;
                $user = User::find($deliveryRequest->collection_user_id);
                $user->notify(new DelivererChangeStatus($id,__('notification.delivery_request_received', ['id' => $id])));
            } else if (!is_null($deliveryRequest->received_at)) {
                $status = Response::HTTP_CONFLICT;
                $data = __('api.cannot_receive_again');
            } else if (is_null($deliveryRequest->received_at)) {
                $status = Response::HTTP_NOT_ACCEPTABLE;
                $data = __('api.not_accepted_yet');
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Receive a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function delivered(Request $request, int $id)
    {
        $deliveryRequest = DeliveryRequest::findOrFail($id);
        if($request->user()->can('deliver', $deliveryRequest)) {
            if(!is_null($deliveryRequest->received_at) && is_null($deliveryRequest->delivered_at)) {
                $deliveryRequest->delivered_at = now();
                $deliveryRequest->save();
                $status = Response::HTTP_OK;
                $user = User::find($deliveryRequest->collection_user_id);
                $user->notify(new DelivererChangeStatus($id,__('notification.delivery_request_delivered', ['id' => $id])));
            } else if (!is_null($deliveryRequest->delivered_at)) {
                $status = Response::HTTP_CONFLICT;
                $data = __('api.cannot_deliver_again');
            } else if (is_null($deliveryRequest->received_at)) {
                $status = Response::HTTP_NOT_ACCEPTABLE;
                $data = __('api.not_received_yet');
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryRequest $deliveryRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryRequest  $deliveryRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryRequest $deliveryRequest)
    {
        //
    }
}
