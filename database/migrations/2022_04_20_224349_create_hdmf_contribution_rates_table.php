<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHdmfContributionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hdmf_contribution_rates', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->float('ee_share')->comment('employee share');
            $table->float('er_share')->comment('employer share');
            $table->float('msc_min')->comment('msc-monthly salary credit');
            $table->float('msc_max')->comment('msc-monthly salary credit');
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
        Schema::dropIfExists('hdmf_contribution_rates');
    }
}
