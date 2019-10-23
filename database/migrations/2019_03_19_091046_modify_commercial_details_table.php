<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCommercialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_details', function(Blueprint $table){
            $table->dropForeign(['order_item_requirement_id']);
            $table->dropColumn('order_item_requirement_id');
            $table->unsignedBigInteger('ordered_item_id');
            $table->foreign('ordered_item_id')->references('id')->on('ordered_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commercial_details',function(Blueprint $table){
            $table->unsignedBigInteger('order_item_requirement_id');
            $table->foreign('order_item_requirement_id')->references('id')->on('order_item_requirements');
            $table->dropForeign(['ordered_item_id']);
            $table->dropColumn('ordered_item_id');
        });
    }
}
