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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->string('bio')->nullable();
            $table->string('references')->nullable();
            $table->string('styleOfCooking')->nullable();
            $table->string('liquorServingCertification')->nullable();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('years')->nullable();
            $table->string('location')->nullable();
            $table->text('typeOfProfessional')->nullable();
            $table->integer('role')->nullable();
            $table->string('etc')->nullable();
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
