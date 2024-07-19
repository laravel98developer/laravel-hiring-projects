<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_statuses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('trip_id')->constrained()->cascadeOnDelete();
            $table->addColumn('tripStates', 'status');
            $table->string('description', 255)->nullable();
            $table->timestamp('created_at', 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_statuses');
    }
};
