<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyWpuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_wpusers', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('company_id')->unsigned();
            $table->bigInteger('wpuser_id')->unsigned();        
            $table->date('renewal_date')->nullable();
            $table->boolean('nominee_director')->default(false);
            $table->boolean('nominee_shareholder')->default(false);
            $table->boolean('nominee_secretary')->default(false);
            $table->string('reg_no')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('vat_reg_no')->nullable();
            $table->string('reg_office')->nullable();            
            $table->boolean('status')->default(false);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('wpuser_id')->references('ID')->on('wp_users');
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
        Schema::drop('company_wpusers');
    }
}
