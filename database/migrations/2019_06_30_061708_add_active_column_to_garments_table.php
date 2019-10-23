<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveColumnToGarmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garments', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('buyers', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('merchants', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('dyeing_companies', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('dyeing_companies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
