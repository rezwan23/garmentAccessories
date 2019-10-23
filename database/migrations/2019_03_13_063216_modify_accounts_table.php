<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function(Blueprint $table){
            $table->string('branch_name')->nullable()->change();
            $table->string('swift_code')->nullable()->change();
            $table->string('routing_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function(Blueprint $table){
            $table->string('branch_name')->change();
            $table->string('swift_code')->change();
            $table->string('routing_number')->change();
        });
    }
}
