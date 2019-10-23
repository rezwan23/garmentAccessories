<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalAllowancesColumnToPrepareSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prepare_salaries', function (Blueprint $table) {
            $table->float('total_allowance')->default(0);
            $table->float('total_deduction')->default(0);
            $table->float('paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prepare_salaries', function (Blueprint $table) {
            $table->dropColumn('total_allowance');
            $table->dropColumn('total_deduction');
            $table->dropColumn('paid');
        });
    }
}
