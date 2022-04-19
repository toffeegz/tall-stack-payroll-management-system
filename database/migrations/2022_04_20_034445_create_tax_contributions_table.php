<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_contributions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->date('date');
            $table->unsignedSmallInteger('payroll_period');
            $table->unsignedSmallInteger('tax_type');
            $table->double('employee_share');
            $table->double('employer_share');
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
        Schema::dropIfExists('tax_contributions');
    }
}
