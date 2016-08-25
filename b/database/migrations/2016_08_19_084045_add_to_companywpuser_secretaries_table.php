<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToCompanywpuserSecretariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('companywpuser_secretaries', function($table) {            
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
        Schema::table('companywpuser_secretaries', function($table) {             
            $table->dropForeign('companywpuser_secretaries_person_id_foreign');
            $table->dropColumn('person_id');
        });
    }
}
