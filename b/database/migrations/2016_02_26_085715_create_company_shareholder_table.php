<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyShareholderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_shareholder', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('shareholder_id')->unsigned();        
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('shareholder_id')->references('id')->on('shareholders');
            $table->decimal('share_amount', 10, 2);
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
        Schema::drop('company_shareholder');
    }
}
