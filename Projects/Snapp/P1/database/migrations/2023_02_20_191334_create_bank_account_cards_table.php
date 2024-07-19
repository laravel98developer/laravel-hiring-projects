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
        Schema::create('bank_account_cards', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique_id');
            $table->foreignId('bank_account_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('card_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account_cards');
    }
};
