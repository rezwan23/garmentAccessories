<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitVoucherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_voucher_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('debit_voucher_id');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('debit_voucher_id')->references('id')->on('debit_vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debit_voucher_payments');
    }
}
