<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToCompanyWpuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('company_wpusers', function($table) {
            $table->date('date_of_next_accounts');
            $table->date('accounts_completion_deadline');
            $table->date('date_of_last_vat_return');
            $table->date('date_of_next_vat_return');
            $table->date('vat_return_deadline');
            $table->date('next_agm_due_by');
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
        Schema::table('company_wpusers', function($table) {
            $table->dropColumn('date_of_next_accounts');
            $table->dropColumn('accounts_completion_deadline');
            $table->dropColumn('date_of_last_vat_return');
            $table->dropColumn('date_of_next_vat_return');
            $table->dropColumn('vat_return_deadline');
            $table->dropColumn('next_agm_due_by');
        });
    }
}
