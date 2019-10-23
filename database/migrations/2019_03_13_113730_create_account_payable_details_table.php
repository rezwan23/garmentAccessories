<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountPayableDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payable_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_payable_id');
            $table->foreign('account_payable_id')->references('id')->on('account_payables');
            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('account_sectors');
            $table->text('description');
            $table->float('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_payable_details');
    }
}
