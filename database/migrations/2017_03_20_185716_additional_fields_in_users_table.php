<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalFieldsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //  
            $table->string('company_name')->nullable();
            $table->string('hash');
            $table->string('mobile_number')->nullable();
            $table->enum('status', ['ACTIVE', 'DEACTIVE'])->default('ACTIVE');
            $table->integer('image')->unsigned()->nullable();
            $table->foreign('image')->references('id')->on('images');
            $table->enum('type', ['MAKER', 'CONSUMER'])->default('CONSUMER');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->dropColumn('company_name');
            $table->dropColumn('hash');
            $table->dropColumn('mobile_number');
            $table->dropColumn('status');
            $table->dropForeign(['image']);
            $table->dropColumn('image');
            $table->dropColumn('type');
        });
    }
}
