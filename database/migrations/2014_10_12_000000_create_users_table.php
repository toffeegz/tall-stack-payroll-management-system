<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix_name')->nullable();

            $table->string('code')->unique();

            $table->string('phone_number')->nullable();

            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();

            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();

            $table->unsignedTinyInteger('gender')->default(0);
            $table->unsignedTinyInteger('marital_status');
            $table->char('nationality', 100)->nullable();
            $table->tinyInteger('number_dependent')->default(0);
            $table->text('address')->nullable();

            $table->unsignedTinyInteger('employment_status');
            $table->boolean('is_active')->default(true);

            $table->string('sss_number')->nullable();
            $table->string('phic_number')->nullable();
            $table->string('hdmf_number')->nullable();
            $table->string('tin_number')->nullable();

            $table->date('hired_date')->nullable();
            $table->date('leave_date')->comment('endo, resign, terminate date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->date('terminated_date')->nullable();
            $table->date('endo_date')->nullable();
            $table->date('inactive_date')->nullable();

            $table->boolean('is_paid_holidays')->default(false);
            $table->boolean('is_tax_exempted')->default(false);
            // $table->boolean('is_archive')->default(false);
            $table->boolean('system_access')->default(true);

            $table->unsignedTinyInteger('frequency_id')->default(1);
            
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
        Schema::dropIfExists('users');
    }
}
