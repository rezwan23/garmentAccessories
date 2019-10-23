<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditVoucherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_voucher_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('credit_voucher_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cheque_no')->nullable();
            $table->date('payment_date');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->foreign('credit_voucher_id')->references('id')->on('credit_vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_voucher_payments');
    }
}
