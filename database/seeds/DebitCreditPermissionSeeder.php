<?php

use Illuminate\Database\Seeder;

class DebitCreditPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['account'] as $account){
            foreach(['debit-voucher','debit-payment', 'credit-voucher', 'credit-payment'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $account,
                    'permission'    =>  $permission,
                ]);
            }
        }
    }
}
