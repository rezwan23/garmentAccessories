<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountIdOnDebitVoucherPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_voucher_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('account_sector_id');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });

        Schema::table('credit_voucher_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('account_sector_id');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('opening_balance');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropColumn('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debit_voucher_payments', function (Blueprint $table) {
            $table->dropForeign(['account_sector_id']);
            $table->dropColumn('account_sector_id');
        });

        Schema::table('credit_voucher_payments', function (Blueprint $table) {
            $table->dropForeign(['account_sector_id']);
            $table->dropColumn('account_sector_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->float('opening_balance');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }
}
