<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanywpuserNomineeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companywpuser_nominees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companywpuser_id')->unsigned();
            $table->string('name');
            $table->string('address');       
            $table->string('telephone');
            $table->string('person_type');
            $table->foreign('companywpuser_id')->references('id')->on('company_wpusers');            
            $table->timestamps('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('companywpuser_nominees');
    }
}
