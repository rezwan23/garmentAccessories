<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditVoucherSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_voucher_sectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('credit_voucher_id');
            $table->unsignedBigInteger('account_sector_id');
            $table->float('amount');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('credit_voucher_id')->references('id')->on('credit_vouchers')->onDelete('cascade');
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
        Schema::dropIfExists('credit_voucher_sectors');
    }
}
