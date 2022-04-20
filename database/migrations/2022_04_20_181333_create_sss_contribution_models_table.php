<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSssContributionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_contribution_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sss_contribution_rate_id');
            $table->float('compensation_minimum');
            $table->float('compensation_maximum');
            $table->float('monthly_salary_credit')->comment('monthly salary credit');
            $table->float('ec_contribution');
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
        Schema::dropIfExists('sss_contribution_models');
    }
}
