<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAmountColumnToLargeValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Credit Voucher
        DB::statement("ALTER TABLE credit_vouchers CHANGE total_amount total_amount FLOAT (14, 2) NOT NULL");
        DB::statement("ALTER TABLE credit_voucher_records CHANGE amount amount FLOAT (14, 2) NOT NULL");
        DB::statement("ALTER TABLE credit_voucher_sectors CHANGE amount amount FLOAT (14, 2) NOT NULL");
        // Transaction
        DB::statement("ALTER TABLE transactions CHANGE amount amount FLOAT (14, 2) NOT NULL");
        // Debit Voucher
        DB::statement("ALTER TABLE debit_vouchers CHANGE total_amount total_amount FLOAT (14, 2) NOT NULL");
        DB::statement("ALTER TABLE debit_voucher_records CHANGE amount amount FLOAT (14, 2) NOT NULL");
        DB::statement("ALTER TABLE debit_voucher_sectors CHANGE amount amount FLOAT (14, 2) NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Credit Voucher
        DB::statement("ALTER TABLE credit_vouchers CHANGE total_amount total_amount FLOAT (8, 2) NOT NULL");
        DB::statement("ALTER TABLE credit_voucher_records CHANGE amount amount FLOAT (8, 2) NOT NULL");
        DB::statement("ALTER TABLE credit_voucher_sectors CHANGE amount amount FLOAT (8, 2) NOT NULL");
        // Transaction
        DB::statement("ALTER TABLE transactions CHANGE amount amount FLOAT (8, 2) NOT NULL");
        // Debit Voucher
        DB::statement("ALTER TABLE debit_vouchers CHANGE total_amount total_amount FLOAT (8, 2) NOT NULL");
        DB::statement("ALTER TABLE debit_voucher_records CHANGE amount amount FLOAT (8, 2) NOT NULL");
        DB::statement("ALTER TABLE debit_voucher_sectors CHANGE amount amount FLOAT (8, 2) NOT NULL");
    }
}
