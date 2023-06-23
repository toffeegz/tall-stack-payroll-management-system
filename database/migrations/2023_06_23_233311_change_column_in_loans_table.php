<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('details');
            $table->string('reference_no')->nullable()->after('date_approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('details');
            $table->dropColumn('reference_no');
        });
    }
}
