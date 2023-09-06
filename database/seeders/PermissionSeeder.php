<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            /** DASHBOARD **/
            [
                'name'          => 'dashboard',
                'action'        => ['view'],
            ],

            // ASURANSI MOBIL
            [
                'name'          => 'asuransi.polis-mobil',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],

            /** ADMIN CONSOLE **/
            [
                'name'          => 'master',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'setting',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
        ];

        $this->generate($permissions);

        $ROLES = [
            [
                'name'  => 'Administrator',
                'PERMISSIONS'   => [
                    'dashboard'                 => ['view'],
                    'master'                    => ['view', 'create', 'edit', 'delete'],
                    'setting'                   => ['view', 'create', 'edit', 'delete'],
                ],
            ],
            [
                'name'  => 'Agent',
                'PERMISSIONS'   => [
                ],
            ],
            [
                'name'  => 'User Client',
                'PERMISSIONS'   => [
                ],
            ],
            // [
            //     'name'  => 'Auditee',
            //     'PERMISSIONS'   => [
            //     ],
            // ],
            // [
            //     'name'  => 'Kadiv Internal Audit',
            //     'PERMISSIONS'   => [
            //     ],
            // ],
            
            // [
            //     'name'  => 'Direktur Utama',
            //     'PERMISSIONS'   => [
            //     ],
            // ],
            // [
            //     'name'  => 'Direksi',
            //     'PERMISSIONS'   => [
            //     ],
            // ],
        ];
        foreach ($ROLES as $role) {
            $record = Role::firstOrNew(['name' => $role['name']]);
            $record->name = $role['name'];
            $record->save();
            $perms = [];
            foreach ($role['PERMISSIONS'] as $module => $actions) {
                foreach ($actions as $action) {
                    $perms[] = $module . '.' . $action;
                }
            }
            $perm_ids = Permission::whereIn('name', $perms)->pluck('id');
            // dd($perm_ids);
            $record->syncPermissions($perm_ids);
        }
    }

    public function generate($permissions)
    {
        // Role
        $admin = Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
            ]
        );

        $perms_ids = [];
        foreach ($permissions as $row) {
            foreach ($row['action'] as $key => $val) {
                $name = $row['name'] . '.' . trim($val);
                $perms = Permission::firstOrCreate(compact('name'));
                $perms_ids[] = $perms->id;
                if (!$admin->hasPermissionTo($perms->name)) {
                    if ($name == 'monitoring.view') continue;
                    $admin->givePermissionTo($perms);
                }
            }
        }
        Permission::whereNotIn('id', $perms_ids)->delete();

        // Clear Perms Cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function countActions($data)
    {
        $count = 0;
        foreach ($data as $row) {
            $count += count($row['action']);
        }

        return $count;
    }
}
