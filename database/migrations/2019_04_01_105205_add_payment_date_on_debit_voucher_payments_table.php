<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentDateOnDebitVoucherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_voucher_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cheque_no')->nullable();
            $table->date('payment_date');

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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
            $table->dropForeign(['account_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('account_id', 'payment_method_id', 'cheque_no', 'payment_date', 'user_id');
        });
    }
}
