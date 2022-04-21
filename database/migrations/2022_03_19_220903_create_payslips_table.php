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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('payroll_period_id');
            $table->unsignedInteger('cutoff_order');
            $table->boolean('is_paid')->default(0);

            $table->decimal('basic_pay', $precision = 20, $scale = 3);
            $table->decimal('gross_pay', $precision = 20, $scale = 3);
            $table->decimal('net_pay', $precision = 20, $scale = 3);
            
            $table->decimal('tardiness', $precision = 20, $scale = 3);
            $table->decimal('deductions', $precision = 20, $scale = 3);

            $table->decimal('taxable', $precision = 20, $scale = 3)->nullable();
            $table->decimal('non_taxable', $precision = 20, $scale = 3)->nullable();

            $table->json('labels')->nullable();

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
        Schema::dropIfExists('payslips');
    }
};
