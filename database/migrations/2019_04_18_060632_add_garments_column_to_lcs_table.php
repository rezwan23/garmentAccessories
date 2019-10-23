<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGarmentsColumnToLcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lcs', function (Blueprint $table) {
            $table->unsignedBigInteger('garment_id')->nullable();
            $table->foreign('garment_id')->references('id')->on('garments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lcs', function (Blueprint $table) {
            $table->dropForeign(['garment_id']);
            $table->dropColumn('garment_id');
        });
    }
}
