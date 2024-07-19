<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repository\TripRepository;
use App\Contracts\Repository\TripStatusRepository;
use App\Exceptions\OrderHasTrip;
use App\Exceptions\TripNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripStoreRequest;
use App\Http\Requests\Admin\TripUpdateRequest;
use App\Http\Resources\Admin\TripCollection;
use App\Http\Resources\Admin\TripResource;

class TripController extends Controller
{
    public function __construct(
        private readonly TripRepository $tripRepository,
        private readonly TripStatusRepository $tripStatusRepository
    )
    {
    }

    public function store(TripStoreRequest $request): TripResource
    {
        $has = $this->tripRepository->orderHasTrip($request->get('order_id'));
        throw_if($has, OrderHasTrip::class);

        $trip = $this->tripRepository->create(
            $request->only('order_id')
        );

        $this->tripStatusRepository->create([
            'status' => $request->validated('status'),
            'trip_id' => $trip->id,
        ]);

        return TripResource::make($trip);
    }

    public function update(string $id, TripUpdateRequest $request): TripResource
    {
        $trip = $this->tripRepository->find($id);
        throw_if(empty($trip), TripNotFound::class);

        $this->tripStatusRepository->create([
            'status' => $request->validated('status'),
            'trip_id' => $trip->id,
        ]);

        return TripResource::make($trip);
    }

    public function index(): TripCollection
    {
        return TripCollection::make(
            $this->tripRepository->all(
                with: [
                    'tripStatus',
                ]
            )
        );
    }
}
