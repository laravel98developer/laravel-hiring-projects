<?php

use AliSalehi\Task\Models\TableName;
use AliSalehi\Task\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(TableName::Task, function (Blueprint $table) {
            $table->id();
            $table->foreignId(Task::USER_ID)->constrained(config('user.table'))->cascadeOnDelete();
            $table->string(Task::TITLE);
            $table->text(Task::DESCRIPTION)->nullable();
            $table->string(Task::ATTACHMENT)->nullable();
            $table->date(Task::DUE_DATE);
            $table->boolean(Task::IS_COMPLETED)->default(Task::$IS_COMPLETED['false']);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists(TableName::Task);
    }
};
