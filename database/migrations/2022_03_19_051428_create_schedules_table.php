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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('lunch_time')->nullable();
            $table->tinyInteger('department_id')->nullable();

            $table->json('working_days');

            // $table->boolean('sunday')->comment('working_day')->default(false);
            // $table->boolean('monday')->comment('working_day')->default(true);
            // $table->boolean('tuesday')->comment('working_day')->default(true);
            // $table->boolean('wednesday')->comment('working_day')->default(true);
            // $table->boolean('thursday')->comment('working_day')->default(true);
            // $table->boolean('friday')->comment('working_day')->default(true);
            // $table->boolean('saturday')->comment('working_day')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
