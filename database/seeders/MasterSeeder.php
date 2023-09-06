<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Master\Asset;
use App\Models\Master\AssetDetail;
use App\Models\Master\AssetType;
use App\Models\Master\JenisIuran;
use App\Models\Master\JenisPengeluaran;
use App\Models\Master\Org\Position;
use App\Models\Master\Priority;
use App\Models\Master\RoleGroup;
use App\Models\Master\Severity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            if (env('APP_ENV') == 'rusman') {
                $password = '$2y$10$LzcbokN3QIpE5iImQddazuKHnzx4AFCl9awqzX03XYjJ4NcvIu.L2'; // password
                $position_helpdesk  = Position::where('code', 1001)->first();
                $position_teknisi   = Position::where('code', 1002)->first();
                $role_helpdesk = Role::firstOrNew(
                    ['id' => 2],
                    [
                        'name' => 'Helpdesk',
                    ]
                );
                $role_helpdesk->save();
                $role_teknisi = Role::firstOrNew(
                    ['id' => 3],
                    [
                        'name' => 'Teknisi',
                    ]
                );
                $role_teknisi->save();

                $user_helpdesk1 = User::firstOrNew(
                    [
                        'position_id'   => $position_helpdesk->id,
                        'name'          => 'Helpdesk 1',
                        'username'      => 'helpdesk1',
                        'email'         => 'helpdesk1@email.com',
                        'password'      => $password,
                    ]
                );
                $user_helpdesk1->save();
                $user_helpdesk1->assignRole($role_helpdesk);
                $user_helpdesk2 = User::firstOrNew(
                    [
                        'position_id'   => $position_helpdesk->id,
                        'name'          => 'Helpdesk 2',
                        'username'      => 'helpdesk2',
                        'email'         => 'helpdesk2@email.com',
                        'password'      => $password,
                    ]
                );
                $user_helpdesk2->save();
                $user_helpdesk2->assignRole($role_helpdesk);
                $user_helpdesk3 = User::firstOrNew(
                    [
                        'position_id'   => $position_helpdesk->id,
                        'name'          => 'Helpdesk 3',
                        'username'      => 'helpdesk3',
                        'email'         => 'helpdesk3@email.com',
                        'password'      => $password,
                    ]
                );
                $user_helpdesk3->save();
                $user_helpdesk3->assignRole($role_helpdesk);

                $user_teknisi1 = User::firstOrNew(
                    [
                        'position_id'   => $position_teknisi->id,
                        'name'          => 'Teknisi 1',
                        'username'      => 'teknisi1',
                        'email'         => 'teknisi1@email.com',
                        'password'      => $password,
                    ]
                );
                $user_teknisi1->save();
                $user_teknisi1->assignRole($role_teknisi);
                $user_teknisi2 = User::firstOrNew(
                    [
                        'position_id'   => $position_teknisi->id,
                        'name'          => 'Teknisi 2',
                        'username'      => 'teknisi2',
                        'email'         => 'teknisi2@email.com',
                        'password'      => $password,
                    ]
                );
                $user_teknisi2->save();
                $user_teknisi2->assignRole($role_teknisi);
                $user_teknisi3 = User::firstOrNew(
                    [
                        'position_id'   => $position_teknisi->id,
                        'name'          => 'Teknisi 3',
                        'username'      => 'teknisi3',
                        'email'         => 'teknisi3@email.com',
                        'password'      => $password,
                    ]
                );
                $user_teknisi3->save();
                $user_teknisi3->assignRole($role_teknisi);
            }

            $ASSET_DETAILS__IAO = [
                [
                    'name'  => 'Dashboard',
                ],
                [
                    'name'  => 'Monitoring',
                ],
                [
                    'name'  => 'PKAT/Operasional',
                ],
                [
                    'name'  => 'PKAT/Khusus',
                ],
                [
                    'name'  => 'PKAT/Audit TI',
                ],
                [
                    'name'  => 'Persiapan Audit/Surat Penugasan',
                ],
                [
                    'name'  => 'Persiapan Audit/Program Audit',
                ],
                [
                    'name'  => 'Persiapan Audit/Biaya Penugasan',
                ],
                [
                    'name'  => 'Persiapan Audit/Biaya Penugasan Auditor',
                ],
                [
                    'name'  => 'Pelaporan Audit/LHA',
                ],
                [
                    'name'  => 'Tindak Lanjut Audit/Monitoring',
                ],
                [
                    'name'  => 'Investigasi/Surat Tugas Investigasi',
                ],
                [
                    'name'  => 'Investigasi/Surat Pemanggilan',
                ],
                [
                    'name'  => 'Investigasi/Pemeriksaan',
                ],
                [
                    'name'  => 'Audit Eksternal/Register',
                ],
                [
                    'name'  => 'Audit Eksternal/Tindak Lanjut',
                ],
                [
                    'name'  => 'Data Master',
                ],
                [
                    'name'  => 'Pengaturan Umum',
                ],
            ];
            $ASSET_TYPES = [
                [
                    'name' => 'Hardware',
                ],
                [
                    'name' => 'Network',
                ],
                [
                    'name' => 'Software',
                    'ASSETS'    => [
                        [
                            'name'          => 'IAO BCAMF',
                            'serial_number' => '001',
                            'merk'          => 'IAO',
                            'regist_date'   => now()->format('d/m/Y'),
                            'DETAILS'       => $ASSET_DETAILS__IAO,
                        ],
                        [
                            'name'          => 'IAO BPD-DIY',
                            'serial_number' => '002',
                            'merk'          => 'IAO',
                            'regist_date'   => now()->format('d/m/Y'),
                            'DETAILS'       => $ASSET_DETAILS__IAO,
                        ],
                        [
                            'name'          => 'IAO Galeri24',
                            'serial_number' => '003',
                            'merk'          => 'IAO',
                            'regist_date'   => now()->format('d/m/Y'),
                            'DETAILS'       => $ASSET_DETAILS__IAO,
                        ],

                        [
                            'name'          => 'KMS Waskita',
                            'serial_number' => '004',
                            'merk'          => 'KMS',
                            'regist_date'   => now()->format('d/m/Y'),
                            'DETAILS'       => [],
                        ],
                    ],
                    // 'ROLE_GROUPS'   => [
                    //     [
                    //         'name'          => 'Grup Helpdesk 1 Software',
                    //         'role_id'       => $role_helpdesk->id,
                    //         'member_ids'    => [$user_helpdesk1->id]
                    //     ],
                    //     [
                    //         'name'          => 'Grup Helpdesk 2 Software',
                    //         'role_id'       => $role_helpdesk->id,
                    //         'member_ids'    => [$user_helpdesk2->id]
                    //     ],
                    //     [
                    //         'name'          => 'Grup Helpdesk 3 Software',
                    //         'role_id'       => $role_helpdesk->id,
                    //         'member_ids'    => [$user_helpdesk3->id]
                    //     ],

                    //     [
                    //         'name'          => 'Grup Teknisi 1 Software',
                    //         'role_id'       => $role_teknisi->id,
                    //         'member_ids'    => [$user_teknisi1->id]
                    //     ],
                    //     [
                    //         'name'          => 'Grup Teknisi 2 Software',
                    //         'role_id'       => $role_teknisi->id,
                    //         'member_ids'    => [$user_teknisi2->id]
                    //     ],
                    //     [
                    //         'name'          => 'Grup Teknisi 3 Software',
                    //         'role_id'       => $role_teknisi->id,
                    //         'member_ids'    => [$user_teknisi3->id]
                    //     ],
                    // ],
                ],
                [
                    'name' => 'SOP',
                ],
            ];
            foreach ($ASSET_TYPES as $key => $value) {
                $record = AssetType::firstOrNew(
                    [
                        'name'  => $value['name']
                    ]
                );
                $record->save();
                foreach (($value['ASSETS'] ?? []) as $key => $item) {
                    $asset = Asset::firstOrNew(
                        [
                            'serial_number' => $item['serial_number']
                        ]
                    );
                    $asset->asset_type_id   = $record->id;
                    $asset->name            = $item['name'];
                    $asset->merk            = $item['merk'];
                    $asset->regist_date     = $item['regist_date'];
                    $asset->save();

                    foreach (($item['DETAILS'] ?? []) as $key => $item) {
                        $asset_detail = AssetDetail::firstOrNew(
                            [
                                'asset_id'  => $asset->id,
                                'name'      => $item['name'],
                            ]
                        );
                        $asset_detail->save();
                    }
                }

                if (env('APP_ENV') == 'rusman' && $record->name == 'Software') {
                    $ROLE_GROUPS = [
                        [
                            'name'          => 'Grup Helpdesk 1 Software',
                            'role_id'       => $role_helpdesk->id,
                            'member_ids'    => [$user_helpdesk1->id]
                        ],
                        [
                            'name'          => 'Grup Helpdesk 2 Software',
                            'role_id'       => $role_helpdesk->id,
                            'member_ids'    => [$user_helpdesk2->id]
                        ],
                        [
                            'name'          => 'Grup Helpdesk 3 Software',
                            'role_id'       => $role_helpdesk->id,
                            'member_ids'    => [$user_helpdesk3->id]
                        ],

                        [
                            'name'          => 'Grup Teknisi 1 Software',
                            'role_id'       => $role_teknisi->id,
                            'member_ids'    => [$user_teknisi1->id]
                        ],
                        [
                            'name'          => 'Grup Teknisi 2 Software',
                            'role_id'       => $role_teknisi->id,
                            'member_ids'    => [$user_teknisi2->id]
                        ],
                        [
                            'name'          => 'Grup Teknisi 3 Software',
                            'role_id'       => $role_teknisi->id,
                            'member_ids'    => [$user_teknisi3->id]
                        ],
                    ];
                    foreach ($ROLE_GROUPS as $key => $item) {
                        $role_group = RoleGroup::firstOrNew(
                            [
                                'name' => $item['name']
                            ]
                        );
                        $role_group->role_id         = $item['role_id'];
                        $role_group->save();
                        $role_group->members()->sync($item['member_ids']);
                        $role_group->types()->sync([$record->id]);
                    }
                }
            }

            $PRIORITIES = [
                [
                    'name'  => 'Priority 1',
                ],
                [
                    'name'  => 'Priority 2',
                ],
                [
                    'name'  => 'Priority 3',
                ],
            ];
            foreach ($PRIORITIES as $key => $item) {
                $record = Priority::firstOrNew(
                    [
                        'name' => $item['name']
                    ]
                );
                $record->save();
            }

            $SEVERITIES = [
                [
                    'name'  => 'Severity 1',
                ],
                [
                    'name'  => 'Severity 2',
                ],
                [
                    'name'  => 'Severity 3',
                ],
            ];
            foreach ($SEVERITIES as $key => $item) {
                $record = Severity::firstOrNew(
                    [
                        'name' => $item['name']
                    ]
                );
                $record->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
