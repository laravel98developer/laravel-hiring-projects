<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index()->unique();
            $table->integer('provider_id')->unsigned();
            $table->string('name');
            $table->integer('quantity');
            $table->boolean('status')->default(true);
            $table->boolean('comment_status')->default(true);
            $table->boolean('comment_status_after_buy')->default(false);
            $table->boolean('vote_status')->default(true);
            $table->boolean('vote_status_after_buy')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
