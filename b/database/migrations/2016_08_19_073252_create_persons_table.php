<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('person_code')->unique();
            $table->string('person_type');
            $table->string('third_party_company_name');       
            $table->string('third_party_company_jurisdiction');
            $table->string('third_party_company_reg_no');
            $table->string('title');
            $table->string('first_name');
            $table->string('surname');
            $table->string('nationality');
            $table->string('passport_no');
            $table->string('passport_expiry');
            $table->string('tax_residence');
            $table->string('tax_number');
            $table->string('email');
            $table->string('mobile_telephone');
            $table->string('work_telephone');
            $table->string('home_telephone');
            $table->string('home_address');
            $table->string('home_address_2');
            $table->string('home_address_3');
            $table->string('home_address_5');
            $table->string('home_address_6');
            $table->string('postal_address');
            $table->string('postal_address_2');
            $table->string('postal_address_3');
            $table->string('postal_address_5');
            $table->string('postal_address_6');
            $table->string('perferred_currency');
            $table->string('account_registered');
            $table->string('login_ip');
            $table->string('relationship_commenced');
            $table->string('relationship_ended');
            $table->string('passport_copy');
            $table->string('proof_of_address');
            $table->string('bank_reference');
            $table->string('professional_reference');
            $table->string('notes');                        
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');        
        Schema::drop('persons');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
