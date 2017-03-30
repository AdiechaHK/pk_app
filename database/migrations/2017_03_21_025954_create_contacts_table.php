<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();// (fk - User)
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_name')->nullable(); // (string)
            $table->string('firstname')->nullable(); // (string)
            $table->string('lastname')->nullable(); // (string
            $table->string('email')->nullable(); // (string)
            $table->string('mobile_number')->nullable(); // (string)
            $table->string('street')->nullable(); // (string)
            $table->string('area')->nullable(); // (string)
            $table->string('city')->nullable(); // (string)
            $table->string('state')->nullable(); // (string)
            $table->string('country')->nullable(); // (string)
            $table->integer('image')->nullable()->unsigned(); // (int fk - Image)
            $table->foreign('image')->references('id')->on('images');
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
        Schema::dropIfExists('contacts');
    }
}
