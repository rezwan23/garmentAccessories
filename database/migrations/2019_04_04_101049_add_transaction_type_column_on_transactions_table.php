<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionTypeColumnOnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('transaction_type', ['credit', 'debit'])->default('credit');
            $table->unsignedBigInteger('party_id')->nullable();
        });

        Schema::table('credit_vouchers', function (Blueprint $table) {
            $table->boolean('is_paid')->default(0);
        });

        Schema::table('debit_vouchers', function (Blueprint $table) {
            $table->boolean('is_paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_type', 'party_id');
        });
        Schema::table('credit_vouchers', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });

        Schema::table('debit_vouchers', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
    }
}
