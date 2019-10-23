<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDyeingOrderIdToDyeingOrderRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dyeing_order_raw_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('dyeing_order_id');
            $table->foreign('dyeing_order_id')->references('id')->on('dyeing_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dyeing_order_raw_materials', function (Blueprint $table) {
            $table->dropForeign(['dyeing_order_id']);
            $table->dropColumn('dyeing_order_id');
        });
    }
}
