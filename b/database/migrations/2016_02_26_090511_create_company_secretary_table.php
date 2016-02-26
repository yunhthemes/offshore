<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySecretaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_secretary', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('secretary_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('secretary_id')->references('id')->on('secretaries');
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
        Schema::drop('company_secretary');
    }
}
