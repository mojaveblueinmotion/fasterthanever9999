<?php

namespace Database\Seeders;

use App\Models\Master\AsuransiMobil\TipePemakaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipePemakaianSeeder extends Seeder
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
                "name" => "Umum"
            ],
            [ 
                "name" => "Dinas"
            ],
        ];

        foreach ($data as $val) {
            $record          = TipePemakaian::firstOrNew(['name' => $val['name']]);
            $record->save();
        }
    }
}
