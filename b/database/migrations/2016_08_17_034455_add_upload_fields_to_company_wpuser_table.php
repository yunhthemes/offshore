<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadFieldsToCompanyWpuserTable extends Migration
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
            $table->string('incorporation_certificate')->nullable();
            $table->string('incumbency_certificate')->nullable();
            $table->string('company_extract')->nullable();
            $table->string('last_financial_statements')->nullable();
            $table->string('other_documents_1')->nullable();
            $table->string('other_documents_2')->nullable();
            $table->string('other_documents_3')->nullable();
            $table->string('other_documents_4')->nullable();
            $table->string('other_documents_5')->nullable();
            $table->string('other_documents_6')->nullable();
            $table->string('other_documents_1_title')->nullable();
            $table->string('other_documents_2_title')->nullable();
            $table->string('other_documents_3_title')->nullable();
            $table->string('other_documents_4_title')->nullable();
            $table->string('other_documents_5_title')->nullable();
            $table->string('other_documents_6_title')->nullable();
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
            $table->dropColumn('incorporation_certificate');
            $table->dropColumn('incumbency_certificate');
            $table->dropColumn('company_extract');
            $table->dropColumn('last_financial_statements');
            $table->dropColumn('other_documents_1');
            $table->dropColumn('other_documents_2');
            $table->dropColumn('other_documents_3');
            $table->dropColumn('other_documents_4');
            $table->dropColumn('other_documents_5');
            $table->dropColumn('other_documents_6');
            $table->dropColumn('other_documents_1_title');
            $table->dropColumn('other_documents_2_title');
            $table->dropColumn('other_documents_3_title');
            $table->dropColumn('other_documents_4_title');
            $table->dropColumn('other_documents_5_title');
            $table->dropColumn('other_documents_6_title');
        });
    }
}
