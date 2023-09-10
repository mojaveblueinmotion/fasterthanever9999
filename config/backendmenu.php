<?php

return [
    [
        'section'   => 'NAVIGASI',
        'name'      => 'navigasi',
        'perms'     => 'dashboard',
    ],
    // Dashboard
    [
        'name'  => 'dashboard',
        'perms' => 'dashboard',
        'title' => 'Dashboard',
        'icon'  => 'fa fa-th-large',
        'url'   => '/home',
    ],
    // Asuransi Mobil
    [
        'name' => 'asuransi',
        'title' => 'Asuransi',
        'icon' => 'fa fa-tags',
        'submenu' => [
                [
                    'name'  => 'asuransi.polis-mobil',
                    'perms' => 'master',
                    'title' => 'Asuransi Mobil',
                    'url'   => '/asuransi/polis-mobil',
                ],
        ],
    ],
    // Admin Console
    [
        'section' => 'ADMIN KONSOL',
        'name' => 'console.admin',
    ],
    [
        'name' => 'master',
        'perms' => 'master',
        'title' => 'Data Master',
        'icon' => 'fa fa-database',
        'submenu' => [
            [
                'name' => 'org',
                'title' => 'Struktur Organisasi',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'root',
                        'title' => 'Root',
                        'url' => '/master/org/root'
                    ],
                    // [
                    //     'name' => 'boc',
                    //     'title' => 'Pengawas',
                    //     'url' => '/master/org/boc',
                    // ],
                    [
                        'name' => 'bod',
                        'title' => 'Direksi',
                        'url' => '/master/org/bod',
                    ],
                    [
                        'name' => 'division',
                        'title' => 'Divisi',
                        'url' => '/master/org/division',
                    ],
                    [
                        'name' => 'department',
                        'title' => 'Departemen',
                        'url' => '/master/org/department',
                    ],
                    [
                        'name' => 'unit-bisnis',
                        'title' => 'Unit Bisnis',
                        'url' => '/master/org/unit-bisnis',
                    ],
                    [
                        'name' => 'position',
                        'title' => 'Jabatan',
                        'url' => '/master/org/position',
                    ],
                ]
            ],
            [
                'name' => 'geography',
                'title' => 'Geografis',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'province',
                        'title' => 'Provinsi',
                        'url' => '/master/geo/province'
                    ],
                    [
                        'name' => 'city',
                        'title' => 'Kota / Kabupaten',
                        'url' => '/master/geo/city'
                    ],
                    // [
                    //     'name' => 'district',
                    //     'title' => 'Kecamatan',
                    //     'url' => '/master/geo/district'
                    // ],
                    // [
                    //     'name' => 'village',
                    //     'title' => 'Desa',
                    //     'url' => '/master/geo/village'
                    // ],
                ]
            ],
            // [
            //     'name' => 'asset-type',
            //     'title' => 'Tipe Aset',
            //     'url' => '/master/asset-type'
            // ],
            // [
            //     'name' => 'asset',
            //     'title' => 'Aset TI',
            //     'url' => '/master/asset'
            // ],
            // [
            //     'name' => 'role-group',
            //     'title' => 'Grup',
            //     'url' => '/master/role-group'
            // ],
            // [
            //     'name' => 'priority',
            //     'title' => 'Prioritas',
            //     'url' => '/master/priority'
            // ],
            // [
            //     'name' => 'severity',
            //     'title' => 'Severity',
            //     'url' => '/master/severity'
            // ],
            [
                'name' => 'data-asuransi',
                'title' => 'Data Umum Asuransi',
                'submenu' => [
                    [
                        'name' => 'kategori-asuransi',
                        'title' => 'Kategori Asuransi',
                        'url' => '/master/data-asuransi/kategori-asuransi',
                    ],
                    [
                        'name' => 'perusahaan-asuransi',
                        'title' => 'Perusahaan Asuransi',
                        'url' => '/master/data-asuransi/perusahaan-asuransi',
                    ],
                    [
                        'name' => 'interval-pembayaran',
                        'title' => 'Interval Pembayaran',
                        'url' => '/master/data-asuransi/interval-pembayaran',
                    ],
                    [
                        'name' => 'fitur-asuransi',
                        'title' => 'Fitur Asuransi',
                        'url' => '/master/data-asuransi/fitur-asuransi',
                    ],
                ]
            ],
            [
                'name' => 'asuransi-properti',
                'title' => 'Asuransi Properti',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'okupasi',
                        'title' => 'Okupasi',
                        'url' => '/master/asuransi-properti/okupasi'
                    ],
                    [
                        'name' => 'asuransi-properti',
                        'title' => 'Asuransi Properti',
                        'url' => '/master/asuransi-properti/asuransi-properti'
                    ],
                ]
            ],
            [
                'name' => 'asuransi-mobil',
                'title' => 'Asuransi Mobil',
                'url' => '',
                'submenu' => [
                    // [
                    //     'name' => 'mobil',
                    //     'title' => 'Mobil',
                    //     'url' => '/master/asuransi-mobil/mobil'
                    // ],
                    // [
                    //     'name' => 'tipe-kendaraan',
                    //     'title' => 'Tipe Kendaraan',
                    //     'url' => '/master/asuransi-mobil/tipe-kendaraan'
                    // ],
                    [
                        'name' => 'tipe-pemakaian',
                        'title' => 'Tipe Pemakaian',
                        'url' => '/master/asuransi-mobil/tipe-pemakaian'
                    ],
                    [
                        'name' => 'luas-pertanggungan',
                        'title' => 'Luas Pertanggungan',
                        'url' => '/master/asuransi-mobil/luas-pertanggungan'
                    ],
                    [
                        'name' => 'kondisi-kendaraan',
                        'title' => 'Kondisi Kendaraan',
                        'url' => '/master/asuransi-mobil/kondisi-kendaraan'
                    ],
                    [
                        'name' => 'workshop',
                        'title' => 'Workshop',
                        'url' => '/master/asuransi-mobil/workshop'
                    ],
                    [
                        'name' => 'asuransi-mobil',
                        'title' => 'Asuransi Mobil',
                        'url' => '/master/asuransi-mobil/asuransi-mobil'
                    ],
                ]
            ],
            [
                'name' => 'database-mobil',
                'title' => 'Database Mobil',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'merk',
                        'title' => 'Merk Mobil',
                        'url' => '/master/database-mobil/merk'
                    ],
                    [
                        'name' => 'seri',
                        'title' => 'Seri Mobil',
                        'url' => '/master/database-mobil/seri'
                    ],
                    [
                        'name' => 'tahun',
                        'title' => 'Tahun Mobil',
                        'url' => '/master/database-mobil/tahun'
                    ],
                    [
                        'name' => 'tipe-mobil',
                        'title' => 'Tipe Mobil',
                        'url' => '/master/database-mobil/tipe-mobil'
                    ],
                    [
                        'name' => 'tipe-kendaraan',
                        'title' => 'Tipe Kendaraan',
                        'url' => '/master/database-mobil/tipe-kendaraan'
                    ],
                    [
                        'name' => 'kode-plat',
                        'title' => 'Kode Plat',
                        'url' => '/master/database-mobil/kode-plat'
                    ],
                ]
            ],
            [
                'name' => 'asuransi-motor',
                'title' => 'Asuransi Motor',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'asuransi-motor',
                        'title' => 'Asuransi Motor',
                        'url' => '/master/asuransi-motor/asuransi-motor'
                    ],
                    [
                        'name' => 'merk',
                        'title' => 'Merk Motor',
                        'url' => '/master/asuransi-motor/merk'
                    ],
                    [
                        'name' => 'seri',
                        'title' => 'Seri Motor',
                        'url' => '/master/asuransi-motor/seri'
                    ],
                    [
                        'name' => 'tahun',
                        'title' => 'Tahun Motor',
                        'url' => '/master/asuransi-motor/tahun'
                    ],
                    [
                        'name' => 'tipe-motor',
                        'title' => 'Tipe Motor',
                        'url' => '/master/asuransi-motor/tipe-motor'
                    ],
                ]
            ],
            [
                'name' => 'asuransi-perjalanan',
                'title' => 'Asuransi Perjalanan',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'jenis-perjalanan',
                        'title' => 'Jenis Perjalanan',
                        'url' => '/master/asuransi-perjalanan/jenis-perjalanan'
                    ],
                    [
                        'name' => 'tipe-perlindungan',
                        'title' => 'Tipe Perlindungan',
                        'url' => '/master/asuransi-perjalanan/tipe-perlindungan'
                    ],
                ]
            ],
            
        ]
    ],
    [
        'name' => 'setting',
        'perms' => 'setting',
        'title' => 'Pengaturan Umum',
        'icon' => 'fa fa-cogs',
        'submenu' => [
            [
                'name' => 'role',
                'title' => 'Hak Akses',
                'url' => '/setting/role',
            ],
            [
                'name' => 'flow',
                'title' => 'Sistem Approval',
                'url' => '/setting/flow',
            ],
            [
                'name' => 'user',
                'title' => 'Manajemen User',
                'url' => '/setting/user',
            ],
            [
                'name' => 'activity',
                'title' => 'History Aktivitas',
                'url' => '/setting/activity',
            ],
        ]
    ],
];
