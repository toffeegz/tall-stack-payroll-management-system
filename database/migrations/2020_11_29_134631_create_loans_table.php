<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_type_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->float('amount')->default(0);
            $table->float('total_amount_to_pay')->default(0);
            $table->float('balance')->default(0);
            $table->float('pay_next')->default(0);
            $table->float('installment_amount')->default(0);
            $table->date('date_approved');
            $table->text('details')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('1-pending,2-approved,3-disapproved');
            $table->boolean('auto_deduct')->default(false);
            $table->tinyInteger('install_period')->default(0);
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
        Schema::dropIfExists('loans');
    }
}
