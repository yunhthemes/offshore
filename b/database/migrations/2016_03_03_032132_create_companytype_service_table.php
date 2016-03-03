<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanytypeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companytype_service', function (Blueprint $table) {
            $table->integer('company_type_id')->unsigned();            
            $table->integer('service_id')->unsigned();        
            $table->foreign('company_type_id')->references('id')->on('company_types');
            $table->foreign('service_id')->references('id')->on('services');
            $table->decimal('price', 10, 2);
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
        Schema::drop('companytype_service');
    }
}
