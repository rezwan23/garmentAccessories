<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGivenQuantityColumnToReceiveDyeingYarnMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_dyeing_yarn_materials', function (Blueprint $table) {
            $table->float('given_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receive_dyeing_yarn_materials', function (Blueprint $table) {
            $table->dropColumn('given_quantity');
        });
    }
}
