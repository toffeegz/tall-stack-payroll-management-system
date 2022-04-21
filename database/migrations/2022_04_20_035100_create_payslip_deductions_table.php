<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslip_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payslip_id');
            $table->float('tax_sss');
            $table->float('tax_hdmf');
            $table->float('tax_phic');
            $table->float('hdmf_loan');
            $table->float('sss_loan');
            $table->float('withholding_tax');
            $table->float('loan');
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
        Schema::dropIfExists('payslip_deductions');
    }
}
