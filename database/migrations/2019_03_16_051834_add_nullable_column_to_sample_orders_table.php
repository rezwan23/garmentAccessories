<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableColumnToSampleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sample_orders', function (Blueprint $table) {
            $table->date('delivery_date')->nullable()->change();
            $table->string('delivery_person')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_orders', function (Blueprint $table) {
            $table->date('delivery_date')->change();
            $table->string('delivery_person')->change();
        });
    }
}
