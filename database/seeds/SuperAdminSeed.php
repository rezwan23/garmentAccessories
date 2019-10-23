<?php

use Illuminate\Database\Seeder;

class SuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = \App\Models\Role::create(['name'=>'Super Super Admin']);
        $permissions = \App\Models\Permission::query()->pluck('id');
        $adminRole->permissions()->attach($permissions);
        $com_id = \App\Models\Company::create([
            'name'  =>  'Smart Software',
            'website'   =>  '#',
            'address'   =>  '#',
            'emails'    =>  'abc@abc.com',
            'phones'    =>  '01234',
            'logo'  =>  'smart.jpg',
        ])->id;
        \App\User::create([
            'name'=>'Smart Software',
            'email' =>  'ceo@smartsoft.com',
            'password'  =>  \Illuminate\Support\Facades\Hash::make('12345678'),
            'company_id'    =>  $com_id,
            'role_id'   =>  $adminRole->id,
        ]);
    }
}
