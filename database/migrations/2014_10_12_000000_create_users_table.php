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
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->string('bio')->nullable();
            $table->string('references')->nullable()->default("");
            $table->string('liquorServingCertification')->nullable()->default("");
            $table->string('company')->nullable()->default("");
            $table->string('title')->nullable()->default("");
            $table->string('years')->nullable()->default("");
            $table->string('location')->nullable()->default("");
            $table->string('postalCode')->nullable()->default("");
            $table->text('typeOfProfessional')->default("[]")->nullable();
            $table->text('styleOfCooking')->default("[]")->nullable();
            $table->integer('role')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->string('etc')->nullable()->default("");
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
