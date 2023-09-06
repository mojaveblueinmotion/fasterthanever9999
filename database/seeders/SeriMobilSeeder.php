<?php

namespace Database\Seeders;

use App\Models\Master\DatabaseMobil\Seri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeriMobilSeeder extends Seeder
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
                "merk_id" => 1,
                "code" => "AUDAUD79",
                "model" => "A3 SPORTBACK 1.2 TFSI"
            ],
            [ 
                "merk_id" => 1,
                "code" => "AUDAUD033",
                "model" => "A4 1.8 TFSI"
            ],
            [ 
                "merk_id" => 2,
                "code" => "BMW116001",
                "model" => "116 I A/T"
            ],
            [ 
                "merk_id" => 2,
                "code" => "BMW118001",
                "model" => "218 I ACTIVE TOURER SPORT"
            ],
            [ 
                "merk_id" => 3,
                "code" => "CHERTI004",
                "model" => "TIGGO 7 Pro 1.5L Turbo Premium"
            ],
            [ 
                "merk_id" => 3,
                "code" => "CHERTI006",
                "model" => "TIGGO 8 Pro Premium"
            ]
        ];

        foreach ($data as $val) {
            $record          = Seri::firstOrNew(['code' => $val['code']]);
            $record->merk_id = $val['merk_id'];
            $record->model = $val['model'];
            $record->save();
        }
    }
}
