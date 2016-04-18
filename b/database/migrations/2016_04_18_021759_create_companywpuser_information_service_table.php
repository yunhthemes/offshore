<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanywpuserInformationServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companywpuser_information_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companywpuser_id')->unsigned();
            $table->integer('information_service_id')->unsigned();        
            $table->foreign('companywpuser_id')->references('id')->on('company_wpusers');
            $table->foreign('information_service_id')->references('id')->on('information_services');
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
        Schema::drop('companywpuser_information_service');
    }
}
