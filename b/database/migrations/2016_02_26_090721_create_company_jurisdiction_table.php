<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyJurisdictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_jurisdiction', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('jurisdiction_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions');
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
        Schema::drop('company_jurisdiction');
    }
}
