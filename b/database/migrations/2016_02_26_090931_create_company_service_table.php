<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_service', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('service_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('country');
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
        //
        Schema::drop('company_service');
    }
}
