<?php

use Illuminate\Database\Seeder;

class SamplePermissionSeederExtended extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->insert([
           [
               'name'=>'Sample Delivery',
               'group' =>  'Sample',
               'permission'    =>  'sample-order-delivery',
           ],
            [
                'name'=>'Sample edit remarks',
                'group' =>  'Sample',
                'permission'    =>  'sample-edit-remarks',
            ]
        ]);
    }
}
