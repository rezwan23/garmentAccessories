<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDyeingCompanyIdToDyeingOrderRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dyeing_order_raw_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('dyeing_company_id')->nullable();
            $table->foreign('dyeing_company_id')->references('id')->on('dyeing_companies');
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
            $table->dropForeign(['dyeing_company_id']);
            $table->dropColumn('dyeing_company_id');
        });
    }
}
