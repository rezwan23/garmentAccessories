<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableColumnsToPisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pis', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable()->change();
            $table->unsignedBigInteger('buyer_id')->nullable()->change();
            $table->unsignedBigInteger('item_id')->nullable()->change();
            $table->float('quantity')->nullable()->change();
            $table->float('unit_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pis', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->change();
            $table->unsignedBigInteger('buyer_id')->change();
            $table->unsignedBigInteger('item_id')->change();
            $table->float('quantity')->change();
            $table->float('unit_price')->change();
        });
    }
}
