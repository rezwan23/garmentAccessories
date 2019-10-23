<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPurchaseAccessoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_accessory_items', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_accessory_id');
            $table->foreign('purchase_accessory_id')->references('id')->on('purchase_accessories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_accessory_items', function (Blueprint $table) {
            $table->dropColumn('purchase_accessory_id');
        });
    }
}
