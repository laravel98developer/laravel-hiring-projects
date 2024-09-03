<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // id (integer, primary key)
            $table->string('name'); // name (string)
            $table->text('description'); // description (text)
            $table->string('location'); // location (string)
            $table->decimal('price', 8, 2); // price (decimal)
            $table->integer('available_slots'); // available_slots (integer)
            $table->timestamp('start_date'); // start_date (timestamp)
            $table->timestamps(); // created_at and updated_at (timestamps)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
