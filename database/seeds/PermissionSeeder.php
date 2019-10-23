<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['order'] as $order){
            foreach(['order-create', 'view-orders', 'raw-materials-assign', 'raw-materials-edit' , 'order-edit', 'order-delete', 'inactive-order'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $order,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['commercial'] as $commercial){
            foreach(['commercial-details-assign','commercial-edit', 'commercial-view','commercial-delete', 'add-pi', 'delete-pi', 'add-lc', 'delete-lc', 'lc-status-change'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $commercial,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['dyeing'] as $dyeing){
            foreach(['dyeing-assign', 'dyeing-view', 'dyeing-delete'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $dyeing,
                    'permission'    =>  $permission,
                ]);
            }
        }

        foreach(['factory'] as $factory){
            foreach(['view-production', 'delivery-record-delete', 'production-record-delete' , 'add-production-record', 'order-delivery', 'receive-dyeing-yarn', 'receive-dyeing-yarn-all'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $factory,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['purchase'] as $purchase){
            foreach(['purchase-view', 'purchase-delete', 'purchase'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $purchase,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['employee'] as $employee){
            foreach(['add-department', 'add-designation', 'add-employee'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $employee,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['account'] as $account){
            foreach(['debit', 'credit', 'debit-voucher-delete'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $account,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['account-configuration'] as $account){
            foreach(['sector-view','sector-edit', 'sector-delete', 'account-view', 'account-edit', 'account-delete', 'payment-method-edit', 'payment-method-delete', 'payment-method-view'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $account,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['salary-allowance'] as $sa){
            foreach(['allowance-&-deduction'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $sa,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['payroll'] as $payroll){
            foreach(['salary-setup'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $payroll,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['settings'] as $setting){
            foreach(['raw-materials-crud', 'materials-category-crud', 'items-crud', 'units-crud', 'colors-crud'] as $permission){
                \App\Models\Permission::create([
                    'name'  =>  ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $setting,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['reports'] as $report){
            foreach([
                'inventory-report',
                'yarn-inventory-report',
                'item-inventory-report',
                'income-expense',
                'party-report',
                'cash-report',
                'order-report',
                'delivery-report',
                'dyeing-yarn-report',
                'dyeing-yarn-company-report',
                'production-report',
                'purchase-report'
                    ] as $permission){
                \App\Models\Permission::create([
                    'name'  => ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $report,
                    'permission'    =>  $permission,
                ]);
            }
        }
        foreach(['user'] as $user){
            foreach(['user-create', 'user-edit', 'user-delete', 'set-permission', 'change-password'] as $permission){
                \App\Models\Permission::create([
                    'name'  => ucfirst(str_replace('-',' ',$permission)),
                    'group' =>  $user,
                    'permission'    =>  $permission,
                ]);
            }
        }
        \App\Models\Permission::create([
            'name'  =>  'Company User Crud',
            'group' =>  'Company',
            'permission'    =>  'company-user-crud',
        ]);
        \App\Models\Permission::create([
            'name'  =>  'Backup data',
            'group' =>  'Backup',
            'permission'    =>  'backup-data',
        ]);
    }
}
