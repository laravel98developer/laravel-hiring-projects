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
        Schema::create('delay_report_statuses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('delay_report_id')->constrained()->cascadeOnDelete();
            $table->addColumn('delayReportStates', 'status');
            $table->string('description', 255)->nullable();
            $table->timestamp('created_at', 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_report_statuses');
    }
};
