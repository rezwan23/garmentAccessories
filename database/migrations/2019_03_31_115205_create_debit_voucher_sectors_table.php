<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitVoucherSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_voucher_sectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('debit_voucher_id');
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('debit_voucher_id')->references('id')->on('debit_vouchers')->onDelete('cascade');
            $table->foreign('account_sector_id')->references('id')->on('account_sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debit_voucher_sectors');
    }
}
