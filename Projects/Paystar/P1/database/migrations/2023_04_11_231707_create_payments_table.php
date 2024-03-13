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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->float('amount',15,3)->comment('in tooman');
            $table->string('token')->collation('utf8_general_ci')->nullable();
            $table->string('ref_num')->collation('utf8_general_ci')->nullable();
            $table->string('tracking_code')->collation('utf8_general_ci')->nullable();
            $table->string('card_number')->collation('utf8_general_ci')->nullable();
            $table->string('transaction_id')->collation('utf8_general_ci')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('bank_first_data')->collation('utf8_general_ci')->nullable();
            $table->text('bank_second_data')->collation('utf8_general_ci')->nullable();
            $table->boolean('done')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
