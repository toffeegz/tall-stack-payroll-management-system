<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('type_id')->comment('1-full_day, 2-half_day, 3-above_day')->default(1);
            $table->unsignedSmallInteger('leave_type_id')->comment('leave_types');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('hours_duration')->comment('hours');
            $table->longText('reason');
            $table->boolean('approved')->default(false);
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists('leaves');
    }
}
