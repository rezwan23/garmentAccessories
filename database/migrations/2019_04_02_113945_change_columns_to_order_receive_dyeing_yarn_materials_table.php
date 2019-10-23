<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsToOrderReceiveDyeingYarnMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_dyeing_yarn_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('dyeing_material_id')->nullable()->change();
            $table->unsignedBigInteger('given_quantity')->nullable()->change();
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
            $table->unsignedBigInteger('dyeing_material_id')->change();
            $table->unsignedBigInteger('given_quantity')->change();
        });
    }
}
