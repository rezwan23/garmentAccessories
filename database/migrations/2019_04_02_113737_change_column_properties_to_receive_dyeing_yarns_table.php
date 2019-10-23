<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnPropertiesToReceiveDyeingYarnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_dyeing_yarns', function (Blueprint $table) {
            $table->unsignedBigInteger('dyeing_order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receive_dyeing_yarns', function (Blueprint $table) {
            $table->unsignedBigInteger('dyeing_order_id')->change();
        });
    }
}
