<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToCompanywpuserShareholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('companywpuser_shareholders', function($table) {
            $table->string('beneficial');
            $table->string('shareholder');
            $table->unsignedInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('persons');
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
        Schema::table('companywpuser_shareholders', function($table) {              
            $table->dropColumn('beneficial');
            $table->dropColumn('shareholder');            
            $table->dropColumn('person_id');
        });        
    }
}
