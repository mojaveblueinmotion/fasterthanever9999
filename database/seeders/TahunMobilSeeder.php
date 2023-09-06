<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\Tahun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunMobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
             
            [ 
                "seri_id" => 2,
                "tahun" => "2020",
                "harga" => "100"
            ],
            [ 
                "seri_id" => 1,
                "tahun" => "2020",
                "harga" => "1,111"
            ],
            [ 
                "seri_id" => 3,
                "tahun" => "2023",
                "harga" => "111"
            ],
            [ 
                "seri_id" => 4,
                "tahun" => "2023",
                "harga" => "111"
            ],
            [ 
                "seri_id" => 5,
                "tahun" => "2023",
                "harga" => "1,111"
            ],
            [ 
                "seri_id" => 6,
                "tahun" => "2023",
                "harga" => "111"
            ]
        ];

        foreach ($data as $val) {
            $record          = Tahun::firstOrNew(
                [
                    'seri_id' => $val['seri_id'],
                    'tahun' => $val['tahun'],
                    'harga' => $val['harga'],
                ]
            );
            $record->save();
        }
    }
}
