### Tourism Activity Booking System

**Scenario:**
You are to build a tourism activity booking system where users can browse and book various activities. The system must handle booking confirmations and notifications using Laravel's queue and event/listener system.

**Requirements:**

1. **Database Schema:**

   - **Activities:**
     - `id` (integer, primary key)
     - `name` (string)
     - `description` (text)
     - `location` (string)
     - `price` (decimal)
     - `available_slots` (integer)
     - `start_date` (timestamp)
     - `created_at` (timestamp)
     - `updated_at` (timestamp)
   
   - **Bookings:**
     - `id` (integer, primary key)
     - `activity_id` (integer, foreign key references activities.id)
     - `user_name` (string)
     - `user_email` (string)
     - `slots_booked` (integer)
     - `status` (enum: 'pending', 'confirmed', 'cancelled')
     - `created_at` (timestamp)
     - `updated_at` (timestamp)

2. **Features:**

   - **Activity Management:**
     - Create, read, update, and delete activities.
     - Upload images for activities.
   
   - **Booking Management:**
     - Users can book activities, specifying the number of slots.
     - Reduce available slots upon booking.
     - Send booking confirmation emails using a queue.
     - Update booking status to 'confirmed' after email is sent.
   
   - **Notifications:**
     - Send an email notification to the admin when a booking is made.
     - Send an email to users 24 hours before their booked activity starts.
   
   - **Search and Filtering:**
     - Search activities by name, location, and price.
     - Filter activities by availability.

3. **Additional Requirements:**

   - Use Eloquent relationships effectively.
   - Use resource controllers and routes.
   - Apply middleware to ensure only authorized actions can be performed.
   - Use form requests for validation.
   - Use API Resource classes for JSON responses.
   - Implement job queues for sending emails.
   - Implement event/listener system for booking-related notifications.

4. **Bonus Points:**

   - Implement a feature for users to cancel their bookings.

### Implementation Details:

1. **Models and Relationships:**
   - Define relationships: An activity can have many bookings. A booking belongs to an activity.

2. **Controllers:**
   - Create `ActivityController` and `BookingController` using `php artisan make:controller`.
   - Implement resourceful methods in controllers (`index`, `show`, `store`, `update`, `destroy`).

3. **Routes:**
   - Define resource routes for activities and bookings in `routes/api.php`.

4. **Validation:**
   - Use form requests to validate incoming data for creating and updating activities and bookings.

5. **Queues and Events/Listeners:**
   - Implement a queue system to handle sending emails. Use Laravel's built-in queue worker.
   - Create events and listeners for booking-related notifications.
     - Event: `BookingCreated`
     - Listeners: `SendBookingConfirmationEmail`, `NotifyAdminOfBooking`

6. **Task Scheduling:**
   - Use Laravel’s task scheduling to send reminder emails 24 hours before an activity starts.

This test should be completed within 3 hours. Your solution should demonstrate your ability to use Laravel's features effectively. 
