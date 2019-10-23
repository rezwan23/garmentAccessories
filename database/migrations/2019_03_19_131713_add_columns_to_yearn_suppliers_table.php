<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToYearnSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yearn_suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('updated_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yearn_suppliers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn('company_id');
            $table->dropColumn('updated_by');
        });
    }
}
