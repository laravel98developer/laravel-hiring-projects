<?php

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table->double('from_destination_latitude');
            $table->double('from_destination_longitude');
            $table->double('to_destination_latitude');
            $table->double('to_destination_longitude');
            $table->text('address');
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_name');
            $table->string('supplier_phone', 11);
            $table->string('receiver_name');
            $table->string('receiver_phone', 11);
            $table->unsignedTinyInteger('status')->default(OrderStatusEnum::WAITING->value);
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
