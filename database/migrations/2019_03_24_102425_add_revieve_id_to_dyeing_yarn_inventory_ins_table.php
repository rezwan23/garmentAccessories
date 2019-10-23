<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRevieveIdToDyeingYarnInventoryInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dyeing_yarn_inventory_ins', function (Blueprint $table) {
            $table->unsignedBigInteger('receive_id');
            $table->foreign('receive_id')->references('id')->on('receive_dyeing_yarns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dyeing_yarn_inventory_ins', function (Blueprint $table) {
            $table->dropForeign(['receive_id']);
            $table->dropColumn('receive_id');
        });
    }
}
