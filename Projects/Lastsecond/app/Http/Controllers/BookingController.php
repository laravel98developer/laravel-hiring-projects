<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatusEnum;
use App\Models\Activity;
use App\Models\Booking;
use App\Events\BookingCreated;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     *
     * This function retrieves all bookings and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing the list of bookings.
     */
    public function index()
    {
        // Check if the user is authorized to view any booking
        Gate::authorize('viewAny', Booking::class);

        // Retrieve all bookings, including their related activities
        $bookings = Booking::with('activity')->get();

        // Return the bookings as a JSON response
        return response()->json($bookings);
    }

    /**
     * Store a newly created booking in storage
     *
     * This function creates a new booking in the database using the
     * data provided in the request. The booking object is then
     * returned as a JSON response with a status code of 201 (Created).
     *
     * @param \App\Http\Requests\CreateBookingRequest $request The request object containing the booking data
     * @return \Illuminate\Http\Response The created booking object as JSON, with a status code of 201 (Created)
     */
    public function store(CreateBookingRequest $request)
    {
        // Check if the user is authorized to create a new booking
        Gate::authorize('create', Booking::class);

        // Find the activity being booked
        $activity = Activity::findOrFail($request->activity_id);

        // Check if enough slots are available
        if ($activity->available_slots < $request->slots_booked) {
            // Return an error response if not enough slots are available
            return response()->json(['error' => 'Not enough slots available'], 400);
        }

        // Create the booking
        $booking = Booking::create($request);

        // Reduce the available slots in the activity
        $activity->decrement('available_slots', $request->slots_booked);

        // Fire the event to handle email notifications
        event(new BookingCreated($booking));

        // Return the booking as a JSON response
        return response()->json($booking, 201);
    }

    /**
     * Display the specified booking
     *
     * This endpoint is used to display the details of a booking.
     * It accepts a booking ID as a parameter and returns the
     * corresponding booking object.
     *
     * @param Booking $booking The booking object to be displayed
     * @return \Illuminate\Http\Response The booking object, with a status code of 200 (OK)
     */
    public function show(Booking $booking)
    {
        // Check if the user is authorized to view the booking
        Gate::authorize('view', $booking);

        // Return the booking object as a JSON response
        return response()->json($booking);
    }

    /**
     * Update the specified booking in storage
     *
     * This endpoint is used to update an existing booking in the database.
     * It accepts a booking ID as a parameter and a JSON payload with optional
     * fields to update. The payload may contain the following fields:
     *
     * - status: The status of the booking (optional, string, must be one of the BookingStatusEnum values)
     *
     * @param \App\Http\Requests\UpdateBookingRequest $request The HTTP request object containing the booking data to update
     * @param \App\Models\Booking $booking The booking object to be updated
     * @return \Illuminate\Http\Response The updated booking object, with a status code of 200 (OK)
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        // Check if the user is authorized to update the booking
        Gate::authorize('update', $booking);

        // If the booking status is being changed to cancelled, increment the available slots in the activity
        if ($booking->status !== BookingStatusEnum::Cancelled && $request->status === BookingStatusEnum::Cancelled->value) {
            $booking->activity->increment('available_slots', $booking->slots_booked);
        }
        // If the booking status is being changed from cancelled to any other status, decrement the available slots in the activity
        if ($booking->status === BookingStatusEnum::Cancelled && $request->status !== BookingStatusEnum::Cancelled->value) {
            $booking->activity->decrement('available_slots', $booking->slots_booked);
        }

        // Update the booking with the validated data
        $booking->update([...$request->all(), 'status' => BookingStatusEnum::tryFrom($request->status)]);

        // Return the updated booking object as a JSON response
        return response()->json($booking);
    }

    /**
     * Remove the specified booking from storage
     *
     * @param Booking $booking The booking object to be deleted
     * @return \Illuminate\Http\Response The response object with a status code of 204 (No Content)
     */
    public function destroy(Booking $booking)
    {
        // Check if the user is authorized to delete the booking
        Gate::authorize('delete', $booking);

        // Reduce the available slots in the activity
        // We only do this if the booking status is not 'cancelled'
        // since we don't want to reduce the available slots twice
        if ($booking->status !== BookingStatusEnum::Cancelled) {
            $booking->activity->increment('available_slots', $booking->slots_booked);
        }

        // Delete the booking from the database
        $booking->delete();

        // Return a 204 (No Content) response
        return response()->json(null, 204);
    }
}
