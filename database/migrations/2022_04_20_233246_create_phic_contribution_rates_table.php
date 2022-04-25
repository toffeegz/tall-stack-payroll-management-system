<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhicContributionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phic_contribution_rates', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->float('premium_rate');
            $table->float('mbs_min');  
            $table->float('mbs_max');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phic_contribution_rates');
    }
}
