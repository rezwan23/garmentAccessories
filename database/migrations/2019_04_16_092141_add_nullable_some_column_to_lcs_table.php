<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableSomeColumnToLcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        'created_by', 'updated_by', 'company_id', 'seller_bank'
//        , 'seller_bank_branch','buyer_bank','buyer_bank_branch',
//        'lc_number',
//        'payment_terms',
//        'party_date',
//        'bank_date',
//        'accept_date',
//        'adjust_remarks',
//        'total_value'
        Schema::table('lcs', function (Blueprint $table) {
            $table->string('seller_bank')->nullable()->change();
            $table->string('seller_bank_branch')->nullable()->change();
            $table->string('buyer_bank')->nullable()->change();
            $table->string('buyer_bank_branch')->nullable()->change();
            $table->string('buyer_bank_branch')->nullable()->change();
            $table->string('lc_number')->nullable()->change();
            $table->date('party_date')->nullable()->change();
            $table->date('bank_date')->nullable()->change();
            $table->date('accept_date')->nullable()->change();
            $table->string('payment_terms')->nullable()->change();
            $table->string('adjust_remarks')->nullable()->change();
            $table->float('total_value', 10,4)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lcs', function (Blueprint $table) {
            $table->string('seller_bank')->change();
            $table->string('seller_bank_branch')->change();
            $table->string('buyer_bank')->change();
            $table->string('buyer_bank_branch')->change();
            $table->string('buyer_bank_branch')->change();
            $table->string('lc_number')->change();
            $table->date('party_date')->change();
            $table->date('bank_date')->change();
            $table->date('accept_date')->change();
            $table->string('payment_terms')->change();
            $table->string('adjust_remarks')->change();
            $table->float('total_value', 10,4)->change();
        });
    }
}
