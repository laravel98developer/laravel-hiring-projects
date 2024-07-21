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
        Schema::create('articles', function (Blueprint $table) {
            //required fields in project description
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('author_name');
            $table->text('content');

            //extra fields
            $table->string('file');
            $table->boolean('is_published');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
