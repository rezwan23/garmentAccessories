<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name');
            $table->string('garments_name');
            $table->string('merchant_name');
            $table->string('buyer_name');
            $table->string('order_number');
            $table->date('receive_date');
            $table->date('delivery_date');
            $table->string('status');
            $table->string('delivery_person');
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
        Schema::dropIfExists('sample_orders');
    }
}
