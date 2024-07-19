<?php

use App\Enums as Enums;
use Illuminate\Database\Migrations\Migration;

class CreateInitEnumsPgsqlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Enums\Tripe\Status::up();
        Enums\DeliveryReport\Status::up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Enums\Tripe\Status::down();
        Enums\DeliveryReport\Status::down();
    }
}
