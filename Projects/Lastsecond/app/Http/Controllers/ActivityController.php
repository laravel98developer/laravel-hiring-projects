<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    /**
     * Retrieves a list of activities based on optional filters.
     *
     * @param Request $request The HTTP request object containing filter parameters.
     * @return \Illuminate\Http\JsonResponse The list of activities as JSON.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Activity::class);

        // Initialize a query to retrieve activities
        $query = Activity::query();

        // Filter activities by name
        if ($request->has('name')) {
            // Add a WHERE clause to the query to match the name parameter
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter activities by location
        if ($request->has('location')) {
            // Add a WHERE clause to the query to match the location parameter
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        // Filter activities by price
        if ($request->has('max_price')) {
            // Add a WHERE clause to the query to filter activities with a price less than or equal to the max_price parameter
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->has('min_price')) {
            // Add a WHERE clause to the query to filter activities with a price greater than or equal to the min_price parameter
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Filter activities by availability
        if ($request->has('is_available')) {
            // Add a WHERE clause to the query to filter activities with available slots greater than or equal to 0
            $query->where('available_slots', '>=', 0);
        }

        // Execute the query and retrieve the activities
        $activities = $query->get();

        // Return the activities as JSON
        return response()->json($activities);
    }

    /**
     * Store a newly created activity in storage
     *
     * This function creates a new activity in the database using the
     * data provided in the request. The activity object is then
     * returned as a JSON response with a status code of 201 (Created).
     *
     * @param \App\Http\Requests\CreateActivityRequest $request The request object containing the activity data
     * @return \Illuminate\Http\Response The created activity object as JSON, with a status code of 201 (Created)
     */
    public function store(CreateActivityRequest $request)
    {
        Gate::authorize('create', Activity::class);

        // Create a new activity using the data from the request
        $activity = Activity::create($request->all());

        // Return the created activity as a JSON response with a status code of 201 (Created)
        return response()->json($activity, 201);
    }

    /**
     * Display the specified activity
     *
     * This endpoint is used to display the details of an activity.
     * It accepts an activity ID as a parameter and returns the
     * corresponding activity object.
     *
     * @param Activity $activity The activity object to be displayed
     * @return \Illuminate\Http\Response The activity object, with a status code of 200 (OK)
     */
    public function show(Activity $activity)
    {
        Gate::authorize('view', $activity);

        return response()->json($activity);
    }

    /**
     * Update the specified activity in storage
     *
     * This endpoint is used to update an existing activity in the database. It
     * accepts an activity ID as a parameter and a JSON payload with optional
     * fields to update. The payload may contain the following fields:
     *
     * - name: The name of the activity (optional, string, max 255 characters)
     * - description: A description of the activity (optional, string)
     * - location: The location of the activity (optional, string, max 255 characters)
     * - price: The price of the activity (optional, numeric, non-negative)
     * - available_slots: The number of available slots for the activity (optional, integer, positive)
     * - start_date: The start date and time of the activity (optional, date, after the current date)
     *
     * @param \App\Http\Requests\UpdateActivityRequest $request The HTTP request object containing the activity data to update
     * @param \App\Models\Activity $activity The activity object to be updated
     * @return \Illuminate\Http\Response The updated activity, with a status code of 200 (OK)
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        Gate::authorize('update', $activity);

        // Validate and update the activity
        // Retrieve the validated data from the request
        $validatedData = $request->validated();

        // Update the activity with the validated data
        $activity->update($validatedData);

        // Return the updated activity with a status code of 200 (OK)
        return response()->json($activity);
    }

    /**
     * Remove the specified activity from storage
     *
     * This endpoint is used to delete an existing activity from the database.
     *
     * @param Activity $activity The activity object to be deleted.
     * @return \Illuminate\Http\Response
     *     A response with no content, indicating that the activity has been
     *     successfully deleted. The response status code is 204 (No Content).
     */
    public function destroy(Activity $activity)
    {
        Gate::authorize('delete', $activity);

        // Delete the activity from the database
        $activity->delete();

        // Return a 204 (No Content) response
        return response()->json(null, 204);
    }
}
