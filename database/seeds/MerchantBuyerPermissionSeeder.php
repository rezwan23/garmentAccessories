<?php

use Illuminate\Database\Seeder;

class MerchantBuyerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['Other Settings'] as $order){
            foreach(['dyeing-company-crud', 'buyer-crud', 'merchant-crud', 'garments-crud'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $order,
                    'permission'    =>  $permission,
                ]);
            }
        }
    }
}
