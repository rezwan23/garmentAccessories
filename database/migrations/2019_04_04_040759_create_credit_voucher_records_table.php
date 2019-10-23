<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditVoucherRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_voucher_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('credit_voucher_payment_id');
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('credit_voucher_payment_id')->references('id')->on('credit_voucher_payments')->onDelete('cascade');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });

        Schema::table('credit_voucher_payments', function (Blueprint $table){
            $table->dropForeign(['account_sector_id']);
            $table->dropColumn('account_sector_id', 'amount');
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_voucher_records');

        Schema::table('credit_voucher_payments', function (Blueprint $table){
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
}
