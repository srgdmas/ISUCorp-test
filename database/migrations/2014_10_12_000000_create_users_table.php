<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_name')->nullable();
            $table->boolean('notifications')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_time_passwors_change')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('roles_id')->constrained();
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
