<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrepareSalaryIdToSalarySheetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_sheet_details', function (Blueprint $table) {
            $table->unsignedBigInteger('prepare_salary_id')->nullable();
            $table->foreign('prepare_salary_id')->references('id')->on('prepare_salaries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_sheet_details', function (Blueprint $table) {
            $table->dropForeign(['prepare_salary_id']);
            $table->dropColumn('prepare_salary_id');
        });
    }
}
