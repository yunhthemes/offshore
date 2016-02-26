<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDirectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_director', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('director_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('director_id')->references('id')->on('directors');            
            $table->string('passport');
            $table->string('utility_bill');
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
        Schema::drop('company_director');
    }
}
