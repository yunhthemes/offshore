<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanywpuserDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companywpuser_directors', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('companywpuser_id')->unsigned();            
            $table->string('type');
            $table->string('name');
            $table->string('address');            
            $table->string('address_2');
            $table->string('address_3')->nullable(); // state
            $table->string('address_4');
            $table->string('telephone');
            $table->string('passport')->nullable();
            $table->string('bill')->nullable();
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
        Schema::drop('companywpuser_directors');
    }
}
