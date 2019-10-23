<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyIdsToSampleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sample_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('garment_id')->nullable();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->foreign('garment_id')->references('id')->on('garments');
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
        Schema::table('sample_orders', function (Blueprint $table) {
            $table->dropForeign(['garment_id']);
            $table->dropForeign(['merchant_id']);
            $table->dropForeign(['buyer_id']);
            $table->dropColumn('buyer_id');
            $table->dropColumn('merchant_id');
            $table->dropColumn('garment_id');
        });
    }
}
