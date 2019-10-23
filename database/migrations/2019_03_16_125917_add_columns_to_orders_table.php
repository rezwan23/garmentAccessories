<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('garments_id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('buyer_id');
            $table->date('order_date');
            $table->date('delivery_date');
            $table->float('total_amount');
            $table->foreign('garments_id')->references('id')->on('garments');
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->foreign('buyer_id')->references('id')->on('buyers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('garments_id');
            $table->dropColumn('merchant_id');
            $table->dropColumn('buyer_id');
            $table->dropColumn('order_date');
            $table->dropColumn('delivery_date');
            $table->dropColumn('total_amount');
        });
    }
}
