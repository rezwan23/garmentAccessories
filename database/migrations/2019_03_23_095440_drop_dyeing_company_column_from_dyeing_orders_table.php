<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDyeingCompanyColumnFromDyeingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dyeing_orders', function (Blueprint $table) {
            $table->dropColumn('dyeing_company');
            $table->unsignedBigInteger('dyeing_company_id');
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
        Schema::table('dyeing_orders', function (Blueprint $table) {
            $table->dropForeign(['dyeing_company_id']);
            $table->dropColumn('dyeing_company_id');
        });
    }
}
