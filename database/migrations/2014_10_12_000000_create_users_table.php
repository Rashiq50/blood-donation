<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('blood_group');
            $table->string('phone');

            $table->string('area')->nullable();
            $table->string('city')->nullable();

            $table->string('lat_lng')->nullable();

            $table->boolean('available')->default(false);
            $table->timestamp('last_donated')->nullable();
            $table->integer('total_donation')->default(0);
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
