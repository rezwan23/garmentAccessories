<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveDyeingYarnMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_dyeing_yarn_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('receive_dyeing_yarn_id');
            $table->foreign('receive_dyeing_yarn_id')->references('id')->on('receive_dyeing_yarns');
            $table->unsignedBigInteger('dyeing_material_id');
            $table->foreign('dyeing_material_id')->references('id')->on('dyeing_order_raw_materials');
            $table->unsignedBigInteger('accessory_id');
            $table->foreign('accessory_id')->references('id')->on('accessories');
            $table->float('received_quantity');
            $table->float('due_quantity');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('receive_dyeing_yarn_materials');
    }
}
