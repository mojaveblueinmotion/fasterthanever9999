<?php

namespace Database\Seeders;

use App\Models\Master\AsuransiMobil\KondisiKendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KondisiKendaraanSeeder extends Seeder
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
                "name" => "Baru"
            ],
            [ 
                "name" => "Bekas"
            ],
        ];

        foreach ($data as $val) {
            $record          = KondisiKendaraan::firstOrNew(['name' => $val['name']]);
            $record->save();
        }
    }
}
