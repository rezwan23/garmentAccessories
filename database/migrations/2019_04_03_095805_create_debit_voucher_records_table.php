<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitVoucherRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_voucher_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('debit_voucher_payment_id');
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('debit_voucher_payment_id')->references('id')->on('debit_voucher_payments')->onDelete('cascade');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });

        Schema::table('debit_voucher_payments', function (Blueprint $table){
            $table->dropForeign(['account_sector_id']);
            $table->dropColumn('account_sector_id', 'amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debit_voucher_records');

        Schema::table('debit_voucher_payments', function (Blueprint $table){
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });
    }
}
