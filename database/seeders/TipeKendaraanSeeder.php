<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\TipeKendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeKendaraanSeeder extends Seeder
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
                "type" => "Diesel"
            ],
            [ 
                "type" => "Bensin"
            ],
            [ 
                "type" => "Electric Vehicle (EV)"
            ],
        ];

        foreach ($data as $val) {
            $record          = TipeKendaraan::firstOrNew(['type' => $val['type']]);
            $record->save();
        }
    }
}
