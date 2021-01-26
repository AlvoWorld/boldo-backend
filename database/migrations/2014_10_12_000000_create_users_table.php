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
            $table->string('lname')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('references')->nullable()->default("");
            $table->string('liquorServingCertification')->nullable()->default("");
            $table->string('company')->nullable()->default("");
            $table->string('title')->nullable()->default("");
            $table->string('years')->nullable()->default("");
            $table->string('location')->nullable()->default("");
            $table->string('geolocation')->nullable()->default("");
            $table->string('postalCode')->nullable()->default("");
            $table->text('typeOfProfessional')->nullable();
            $table->text('styleOfCooking')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('role')->nullable(); //0:customer 1:pro 2: admin
            $table->boolean('active')->nullable()->default(true);
            $table->string('etc')->nullable()->default("");
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
