<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // id (integer, primary key)
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // activity_id (foreign key references activities.id)
            $table->string('user_name'); // user_name (string)
            $table->string('user_email'); // user_email (string)
            $table->integer('slots_booked'); // slots_booked (integer)
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // status (enum: 'pending', 'confirmed', 'cancelled')
            $table->timestamps(); // created_at and updated_at (timestamps)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
