<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transaction_log', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('Merchant_User_Id')->unique();
            $table->string('Merchant_ref_number');
            $table->string('Lpsid');       
            $table->string('Lpspwd');       
            $table->string('Transactionid');
            $table->string('Requestid');
            $table->string('bill_firstname');
            $table->string('bill_lastname');
            $table->string('Purchase_summary');
            $table->string('currencydesc');
            $table->string('amount');
            $table->string('CardBin');
            $table->string('CardLast4');
            $table->string('CardType');
            $table->string('merchant_ipaddress');
            $table->string('CVN_Result');
            $table->string('AVS_Result');
            $table->string('Status');
            $table->string('CardToken');
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
        Schema::drop('transaction_log');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
