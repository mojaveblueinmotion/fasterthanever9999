<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\Merk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerkMobilSeeder extends Seeder
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
                "name" => "AUDI",
                "status" => "populer"
            ],
            [ 
                "name" => "BMW",
                "status" => "populer"
            ],
            [ 
                "name" => "CHERY",
                "status" => "non-populer"
            ],
            [ 
                "name" => "CHEVROLET",
                "status" => "populer"
            ],
            [ 
                "name" => "DAIHATSU",
                "status" => "non-populer"
            ]
        ];

        foreach ($data as $val) {
            $record          = Merk::firstOrNew(['name' => $val['name']]);
            $record->status = $val['status'];
            $record->save();
        }
    }
}
