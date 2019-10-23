<?php

use Illuminate\Database\Seeder;

class SampleOrderPermissionSeeder extends Seeder
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
                'name'=>'Sample create',
                'group' =>  'Sample',
                'permission'    =>  'sample-order-create',
            ],
            [
                'name'=>'Sample edit',
                'group' =>  'Sample',
                'permission'    =>  'sample-order-edit',
            ],
            [
                'name'=>'Sample delete',
                'group' =>  'Sample',
                'permission'    =>  'sample-order-delete',
            ]
        ]);
    }
}
