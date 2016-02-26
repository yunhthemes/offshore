<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');
            $table->string('incoporation_date');
            $table->decimal('price', 10, 2);
            $table->boolean('shelf');
            $table->integer('company_type_id')->unsigned();
            $table->foreign('company_type_id')->references('id')->on('company_types');
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
        Schema::drop('companies');
    }
}
