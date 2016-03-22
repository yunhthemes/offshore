<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpuserCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wpuser_company', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('wpuser_id')->unsigned();        
            $table->integer('company_id')->unsigned();            
            $table->foreign('wpuser_id')->references('ID')->on('wp_users');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::drop('wpuser_company');
    }
}
