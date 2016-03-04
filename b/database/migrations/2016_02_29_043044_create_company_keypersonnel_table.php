<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyKeypersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_keypersonnel', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('keypersonnel_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('keypersonnel_id')->references('id')->on('keypersonnel');      
            $table->decimal('share_amount', 10, 2);                   
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
        Schema::drop('company_keypersonnel');
    }
}
