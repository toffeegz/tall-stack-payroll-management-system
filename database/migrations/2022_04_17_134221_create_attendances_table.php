<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('time_in');
            $table->time('time_out');
            $table->integer('regular')->nullable();
            $table->integer('late')->nullable();
            $table->integer('undertime')->nullable();
            $table->integer('overtime')->nullable();
            $table->integer('night_differential')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedTinyInteger('status')->default('4')->comment('1-present, 2-late, 3-nosched, 4-pending, 5-inc');
            $table->string('task')->nullable();
            $table->unsignedInteger('category')->nullable();
            $table->unsignedInteger('sub_category')->nullable();
            $table->unsignedInteger('created_by')->nullable()->comment('NULL = generated');
            $table->dateTime('date_approved')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
