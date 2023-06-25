<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('scheduled_time_in')->nullable()->after('status');
            $table->time('scheduled_time_out')->nullable()->after('scheduled_time_in');
            $table->bigInteger('schedule_id')->nullable()->after('scheduled_time_out');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('scheduled_time_in')->nullable()->after('status');
            $table->time('scheduled_time_out')->nullable()->after('scheduled_time_in');
            $table->bigInteger('schedule_id')->nullable()->after('scheduled_time_out');
        });
    }
}
