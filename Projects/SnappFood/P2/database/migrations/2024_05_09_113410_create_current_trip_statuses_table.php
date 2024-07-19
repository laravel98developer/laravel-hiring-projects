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
        Schema::create('current_trip_statuses', function (Blueprint $table) {
            $table->ulid('trip_id')->primary();
            $table->string('trip_status_id', 26)->index();
            $table->addColumn('tripStates', 'status')->index();
            $table->string('description', 255)->nullable();
            $table->timestamps(6);

            $table->index('updated_at');
            $table->foreign('trip_id')->on('trips')->references('id');
            $table->foreign('trip_status_id')->on('trip_statuses')->references('id');
        });
        DB::unprepared('
            CREATE OR REPLACE FUNCTION upsert_current_trip_statuses()
                RETURNS TRIGGER
                LANGUAGE PLPGSQL
            AS $$
            BEGIN
                INSERT INTO
                    current_trip_statuses (trip_id, trip_status_id, status, description, created_at, updated_at)
                VALUES (new.trip_id, new.id, new.status, new.description, new.created_at, new.created_at)
                ON CONFLICT (trip_id)
                DO
                   UPDATE SET trip_status_id = new.id,
                              status = new.status,
                              description = new.description,
                              updated_at = new.created_at;
                RETURN NULL;
            END;
            $$
        ');

        DB::unprepared('
            CREATE TRIGGER current_trip_statuses_trigger
                    AFTER INSERT
                    ON trip_statuses
                    FOR EACH ROW
                        EXECUTE PROCEDURE upsert_current_trip_statuses();
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_trip_statuses');
        DB::unprepared('
            DROP TRIGGER current_trip_statuses_trigger ON trip_statuses;
            DROP FUNCTION upsert_current_trip_statuses;
        ');
    }
};
