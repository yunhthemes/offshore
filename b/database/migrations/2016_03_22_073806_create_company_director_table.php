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
        Schema::create('company_directors', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('company_id')->unsigned();            
            $table->string('name');
            $table->string('address');            
            $table->string('address_2');
            $table->string('address_3');
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
        Schema::drop('company_directors');
    }
}
