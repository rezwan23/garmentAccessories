<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommercialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_details', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('commercial_id');
            $table->foreign('commercial_id')->references('id')->on('commercials');
            $table->unsignedBigInteger('order_item_requirement_id');
            $table->foreign('order_item_requirement_id')->references('id')->on('order_item_requirements');
            $table->float('unit_price');
            $table->integer('quantity');
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
        Schema::dropIfExists('commercial_details');
    }
}
