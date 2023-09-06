<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\KodePlat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodePlatSeeder extends Seeder
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
                "name" => "DK",
                "daerah" => "Bali"
            ],
            [ 
                "name" => "P",
                "daerah" => "Banyuwangi"
            ],
            [ 
                "name" => "L",
                "daerah" => "Surabaya"
            ],
            
            [ 
                "name" => "B",
                "daerah" => "Jakarta"
            ],
            [ 
                "name" => "DR",
                "daerah" => "Lombok"
            ],
        ];

        foreach ($data as $val) {
            $record          = KodePlat::firstOrNew(['name' => $val['name']]);
            $record->daerah = $val['daerah'];
            $record->save();
        }
    }
}
