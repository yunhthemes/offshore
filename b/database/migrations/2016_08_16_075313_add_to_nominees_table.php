<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('companywpuser_nominees', function($table) {
            $table->string('address_2');
            $table->string('address_3')->nullable(); // state     
            $table->string('address_4');
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
        Schema::table('companywpuser_nominees', function($table) {
            $table->dropColumn('address_2');
            $table->dropColumn('address_3');
            $table->dropColumn('address_4');
        });
    }
}
