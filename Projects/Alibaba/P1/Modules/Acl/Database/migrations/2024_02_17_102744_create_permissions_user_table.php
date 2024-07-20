<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
            Schema::create('permission_user', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('permission_id')->constrained()->onDelete('cascade');
                $table->index("permission_id");
                $table->index("user_id");
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
            Schema::dropIfExists('permission_user');
    }
};
