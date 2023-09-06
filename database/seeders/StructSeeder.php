<?php

namespace Database\Seeders;

use App\Models\Master\Org\Position;
use App\Models\Master\Org\Struct;
use Illuminate\Database\Seeder;

class StructSeeder extends Seeder
{
    public function run()
    {
        $structs = [
            // type => 1:presdir, 2:direktur, 3:ia division, 4:it division
            // Level Root
            [
                'level'         => 'root',
                'name'          => config('base.company.name'),
                'phone'         => config('base.company.phone'),
                'email'         => config('base.company.email'),
                'website'       => config('base.company.website'),
                'address'       => config('base.company.address'),
                'city_id'       => config('base.company.city_id'),
                'code'          => 1001,
                'type'          => null,
            ],
            // Level BOD
            [
                'level'         => 'bod',
                'name'          => 'Direktur Utama',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1001,
                'code'          => 2001,
                'type'          => 'presdir',
                'POSITIONS'     =>
                [
                    [
                        'name'      => 'Direktur Utama',
                        'code'      => 1006,
                    ],
                ],
            ],[
                'level'         => 'bod',
                'name'          => 'Direktur Keuangan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2001,
                'code'          => 3002,
                'type'          => 'it',
                'code'          => 2002,
                'type'          => 'presdir',
                'POSITIONS'     =>
                [
                    [
                        'name'      => 'IT Helpdesk',
                        'code'      => 1001,
                    ],
                    [
                        'name'      => 'IT Teknisi',
                        'code'      => 1002,
                        'name'      => 'Direktur Keuangan',
                        'code'      => 1004,
                    ],
                ],
            ],
            [
                'level'         => 'bod',
                'name'          => 'Direktur Operasional',
                'parent_code'   => 3002,
                'code'          => 4003,
                'type'          => 'it',
                'parent_code'   => 2001,
                'code'          => 2003,
                'type'          => 'presdir',
                'POSITIONS'     =>
                [
                    [
                        'name'      => 'Direktur Operasional',
                        'code'      => 1005,
                    ],
                ],
            ],
            [
                'level'         => 'division',
                'name'          => 'Divisi Teknologi Informasi',
                'parent_code'   => 2001,
                'code'          => 3002,
                'type'          => 'it',
                'POSITIONS'     =>
                [
                    [
                        'name'      => 'Kepala Divisi Teknologi Informasi',
                        'code'      => 1007,
                    ],
                ],
            ],
            [
                'level'         => 'division',
                'name'          => 'Divisi Sumber Daya Manusia',
                'parent_code'   => 2001,
                'code'          => 3003,
                'type'          => 'it',
                'POSITIONS'     =>
                [
                    [
                        'name'      => 'Kepala Divisi Sumber Daya Manusia',
                        'code'      => 1008,
                    ],
                    ]

                ],
                [
                    'level'         => 'department',
                    'name'          => 'IT Software Development',
                    'parent_code'   => 3002,
                    'code'          => 4001,
                    'type'          => 'it',
                ],
                [
                    'level'         => 'department',
                    'name'          => 'IT Support',
                    'parent_code'   => 3002,
                    'code'          => 4002,
                    'type'          => 'it',
                ],
                [
                    'level'         => 'department',
                    'name'          => 'IT Operasional',
                    'parent_code'   => 3002,
                    'code'          => 4003,
                    'type'          => 'it',
                    'POSITIONS'     =>
                    [
                        [
                            'name'      => 'IT Engineer',
                            'code'      => 1009,
                        ],
                        [
                            'name'      => 'Officer Service Desk',
                            'code'      => 1010,
                        ],
                    ],

                ],
                [
                    'level'         => 'department',
                    'name'          => 'IT Planning',
                    'phone'         => config('base.company.phone'),
                    'address'       => config('base.company.address'),
                    'parent_code'   => 3002,
                    'code'          => 4004,
                    'type'          => 'it',
                ],
                [
                    'level'         => 'unit-bisnis',
                    'name'          => 'Unit Bisnis Jawa Barat',
                    'phone'         => config('base.company.phone'),
                    'address'       => config('base.company.address'),
                    'parent_code'   => 2003,
                    'code'          => 5001,
                    'type'          => 0,
                    'POSITIONS'     =>
                    [
                        [
                            'name'      => 'Kepala Unit Bisnis Jawa Barat',
                            'code'      => 1002,
                        ],
                    ],
                ],
                [
                    'level'         => 'unit-bisnis',
                    'name'          => 'Unit Bisnis Jakarta',
                    'phone'         => config('base.company.phone'),
                    'address'       => config('base.company.address'),
                    'parent_code'   => 2003,
                    'code'          => 5002,
                    'type'          => 0,
                    'POSITIONS'     =>
                    [
                        [
                            'name'      => 'Kepala Unit Bisnis Jakarta',
                            'code'      => 1003,
                        ],
                    ],
                ],
                [
                    'level'         => 'unit-bisnis',
                    'name'          => 'Unit Bisnis Jawa Timur',
                    'phone'         => config('base.company.phone'),
                    'address'       => config('base.company.address'),
                    'parent_code'   => 2003,
                    'code'          => 5003,
                    'type'          => 0,
                    'POSITIONS'     =>
                    [
                        [
                            'name'      => 'Kepala Unit Bisnis Jawa Timur',
                            'code'      => 1001,
                        ],
                    ],
                ],
            ];

            $this->generate($structs);
        }

        public function generate($structs)
        {
            ini_set("memory_limit", -1);

            foreach ($structs as $val) {
                $struct = Struct::firstOrNew(['code' => $val['code']]);
                $struct->level   = $val['level'];
                $struct->name    = $val['name'];
                $struct->type    = $val['type'] ?? null;
                $struct->email   = $val['email'] ?? null;
                $struct->website = $val['website'] ?? null;
                $struct->phone   = $val['phone'] ?? null;
                $struct->address = $val['address'] ?? null;
                $struct->city_id = $val['city_id'] ?? null;
                if (!empty($val['parent_code'])) {
                    if ($parent = Struct::where('code', $val['parent_code'])->first()) {
                        $struct->parent_id = $parent->id;
                    }
                }
                $struct->save();
                if (isset($val['POSITIONS'])) {
                    foreach ($val['POSITIONS'] as $key => $value) {
                        $position = Position::firstOrNew(
                            [
                                'code' => $value['code']
                                ]
                            );
                            $position->location_id = $struct->id;
                            $position->name = $value['name'];
                            $position->save();
                            // dd(json_decode($position));
                        }
                    }
                }
            }
        }
