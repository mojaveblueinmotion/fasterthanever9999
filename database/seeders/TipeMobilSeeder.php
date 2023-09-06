<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\TipeMobil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeMobilSeeder extends Seeder
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
                "name" => "Minibus"
            ],
            [ 
                "name" => "Sedan"
            ],
        ];

        foreach ($data as $val) {
            $record          = TipeMobil::firstOrNew(['name' => $val['name']]);
            $record->save();
        }
    }
}
