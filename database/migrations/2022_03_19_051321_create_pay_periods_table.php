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
        Schema::create('pay_periods', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('frequency_id')->nullable()->unsigned();
            $table->string('cut_off')->nullable()->comment('ex(26-10,11-25)(4-3)(4-Thur, 3-wed)');
            $table->string('pay_day')->nullable()->comment('ex(15,30)(Sat = 6)');
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
        Schema::dropIfExists('pay_periods');
    }
};
