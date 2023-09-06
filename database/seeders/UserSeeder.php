<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Master\Org\Position;
use App\Models\Master\Org\Struct;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
            ]
        );

        $ROLES = [
            [
                'name'  => 'Administrator',
            ],
            [
                'name'  => 'Agent',
            ],
            [
                'name'  => 'User Client',
            ],
        ];
        foreach ($ROLES as $value) {
            $record = Role::firstOrNew(['name'  => $value['name']]);
            $record->save();
        }

        $password = bcrypt('password');
        $user = User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@email.com',
                'password' => $password,
            ]
        );
        $user->assignRole($role);

        $USERS = [
            [
                'name'          => 'zacky',
                'username'      => 'zacky',
                'email'         => 'zacky@email.com',
                'password'      => $password,
                'position_id'   => '1',
                'status'        => 'active',
                'role_ids'      => [7],
            ],
            [
                'name'          => 'rusman',
                'username'      => 'rusman',
                'email'         => 'rusman@email.com',
                'password'      => $password,
                'position_id'   => '5',
                'status'        => 'active',
                'role_ids'      => [5],
            ],
            [
                'name'          => 'satrio',
                'username'      => 'satrio',
                'email'         => 'satrio@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'erhan',
                'username'      => 'erhan',
                'email'         => 'erhan@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'frendy',
                'username'      => 'frendy',
                'email'         => 'frendy@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'gita',
                'username'      => 'gita',
                'email'         => 'gita@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'kalam',
                'username'      => 'kalam',
                'email'         => 'kalam@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'ricky',
                'username'      => 'ricky',
                'email'         => 'ricky@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'yuni',
                'username'      => 'yuni',
                'email'         => 'yuni@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'rachel',
                'username'      => 'rachel',
                'email'         => 'rachel@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'jason',
                'username'      => 'jason',
                'email'         => 'jason@email.com',
                'password'      => $password,
                'position_id'   => '7',
                'status'        => 'active',
                'role_ids'      => [3],
            ],
            [
                'name'          => 'dadang',
                'username'      => 'dadang',
                'email'         => 'dadang@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'jujun',
                'username'      => 'jujun',
                'email'         => 'jujun@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'deni',
                'username'      => 'deni',
                'email'         => 'deni@email.com',
                'password'      => $password,
                'position_id'   => '8',
                'status'        => 'active',
                'role_ids'      => [2],
            ],
            [
                'name'          => 'iskandar',
                'username'      => 'iskandar',
                'email'         => 'iskandar@email.com',
                'password'      => $password,
                'position_id'   => 10,
                'status'        => 'active',
                'role_ids'      => [5],
            ],
            [
                'name'          => 'malik',
                'username'      => 'malik',
                'email'         => 'malik@email.com',
                'password'      => $password,
                'position_id'   => 9,
                'status'        => 'active',
                'role_ids'      => [5],
            ],
            [
                'name'          => 'hakam',
                'username'      => 'hakam',
                'email'         => 'hakam@email.com',
                'password'      => $password,
                'position_id'   => 2,
                'status'        => 'active',
                'role_ids'      => [5],
            ],
        ];

        foreach ($USERS as $key => $value) {
            $record = User::firstOrNew(['username' => $value['username']]);
            $record->name           = $value['name'];
            $record->username       = $value['username'];
            $record->email          = $value['email'];
            $record->name           = $value['name'];
            $record->password       = $value['password'];
            $record->position_id    = $value['position_id'];
            $record->status         = $value['status'];
            $record->save();
            $record->roles()->sync($value['role_ids']);
        }
    }
}
