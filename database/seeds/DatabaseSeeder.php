<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PermissionSeeder::class);
         $this->call(SuperAdminSeed::class);
         $this->call(SampleOrderPermissionSeeder::class);
         $this->call(SamplePermissionSeederExtended::class);
         $this->call(MerchantBuyerPermissionSeeder::class);
         $this->call(DebitCreditPermissionSeeder::class);
    }
}
