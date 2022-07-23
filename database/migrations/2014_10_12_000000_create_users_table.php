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
            $table->string('email');
            $table->string('department')->nullable();
            $table->string('blood_group');
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('institute')->nullable();
            $table->string('session')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');


            $table->string('lat_lng')->nullable();

            $table->boolean('available')->default(true);
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
