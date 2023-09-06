<?php

namespace Database\Seeders;

use App\Models\Master\AsuransiMobil\LuasPertanggungan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LuasPertanggunganSeeder extends Seeder
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
                "name" => "Komprehensif"
            ],
            [ 
                "name" => "Kehilangan"
            ],
        ];

        foreach ($data as $val) {
            $record          = LuasPertanggungan::firstOrNew(['name' => $val['name']]);
            $record->save();
        }
    }
}
