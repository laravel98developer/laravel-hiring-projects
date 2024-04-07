<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->double('origin_latitude')->default(0);
            $table->double('origin_longitude')->default(0);
            $table->string('origin_firstname', 25);
            $table->string('origin_lastname', 25);
            $table->string('origin_address', 255);
            $table->string('origin_phone', 12)->index();
            $table->double('destination_latitude')->default(0);
            $table->double('destination_longitude')->default(0);
            $table->string('destination_firstname', 25);
            $table->string('destination_lastname', 25);
            $table->string('destination_address', 255);
            $table->string('destination_phone', 12)->index();
            $table->unsignedBigInteger('collection_user_id')->index();
            $table->unsignedBigInteger('deliverer_user_id')->nullable()->index();
            $table->timestamp('accepted_at')->nullable()->index();
            $table->timestamp('received_at')->nullable()->index();
            $table->timestamp('delivered_at')->nullable()->index();
            $table->timestamp('canceled_at')->nullable()->index();
            $table->timestamps();
            $table->foreign('collection_user_id')->references('id')->on('users');
            $table->foreign('deliverer_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_requests');
    }
};
