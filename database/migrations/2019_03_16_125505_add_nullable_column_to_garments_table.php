<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableColumnToGarmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garments', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('address')->nullable()->change();
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
            $table->string('email')->change();
            $table->string('phone_number')->change();
            $table->string('address')->change();
        });
    }
}
