<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanywpuserServiceCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companywpuser_service_country', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companywpuser_id')->unsigned();
            $table->integer('service_country_id')->unsigned();        
            $table->foreign('companywpuser_id')->references('id')->on('company_wpusers');
            $table->foreign('service_country_id')->references('id')->on('service_country');
            $table->integer('credit_card_count');
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
        Schema::drop('companywpuser_service_country');
    }
}
