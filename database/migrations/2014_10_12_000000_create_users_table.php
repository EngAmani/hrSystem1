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
            $table->string('amana_id')->unique()->nullable();
            $table->string('company_id')->unique()->nullable();
            $table->string('name');
            $table->string('Administration');
            $table->string('email')->unique();
            $table->integer('role')->nullable()->default(0);
            $table->integer('leaveBalance')->nullable()->default(30);
            $table->integer('emergencyLesve')->nullable()->default(5);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
