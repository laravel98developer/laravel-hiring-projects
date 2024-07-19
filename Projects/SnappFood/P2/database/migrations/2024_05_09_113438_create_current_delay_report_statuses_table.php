<?php

use App\Enums\Tripe\Status;
use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $macroName = 'type'.Str::ucfirst(Str::camel(Status::$type));
        Grammar::macro($macroName, fn () => Status::$type);
        Schema::create('current_delay_report_statuses', function (Blueprint $table) {
            $table->ulid('delay_report_id')->primary();
            $table->string('delay_report_status_id', 26)->index();
            $table->addColumn('delayReportStates', 'status')->index();
            $table->string('description', 255)->nullable();
            $table->timestamps(6);

            $table->index('updated_at');
            $table->foreign('delay_report_id')->on('delay_reports')->references('id');
            $table->foreign('delay_report_status_id')->on('delay_report_statuses')->references('id');

        });
        DB::unprepared('
            CREATE OR REPLACE FUNCTION upsert_current_delay_report_statuses()
                RETURNS TRIGGER
                LANGUAGE PLPGSQL
            AS $$
            BEGIN
                INSERT INTO
                    current_delay_report_statuses (delay_report_id, delay_report_status_id, status, description, created_at, updated_at)
                VALUES (new.delay_report_id, new.id, new.status, new.description, new.created_at, new.created_at)
                ON CONFLICT (delay_report_id)
                DO
                   UPDATE SET delay_report_status_id = new.id,
                              status = new.status,
                              description = new.description,
                              updated_at = new.created_at;
                RETURN NULL;
            END;
            $$
        ');

        DB::unprepared('
            CREATE TRIGGER current_delay_report_statuses_trigger
                    AFTER INSERT
                    ON delay_report_statuses
                    FOR EACH ROW
                        EXECUTE PROCEDURE upsert_current_delay_report_statuses();
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_delay_report_statuses');
        DB::unprepared('
            DROP TRIGGER current_delay_report_statuses_trigger ON delay_report_statuses;
            DROP FUNCTION upsert_current_delay_report_statuses;
        ');
    }
};
