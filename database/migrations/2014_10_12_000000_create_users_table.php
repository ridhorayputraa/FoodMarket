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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->foreignIds('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            // Field yang tidak ada

            $table->text('address')->nullable();
            $table->string('houseNumber')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('city')->nullable();

            $table->string('roles')->default('USER');

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
};
