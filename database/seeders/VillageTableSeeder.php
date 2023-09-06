<?php

namespace Database\Seeders;

use App\Models\Master\Geo\District;
use App\Models\Master\Geo\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VillageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/village.json');
        $json = File::get($path);
        $data = json_decode($json);

        $this->generate($data);
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $village        = Village::where('code', $val->code)
                ->first();
            if (!$village) {
                $village    = new Village;
                $district   = District::where('code', $val->parent_code)
                    ->first();
                if (!$district) {
                    continue;
                }
                $village->district_id  = $district->id;
            }
            $village->code         = $val->code;
            $village->name         = $val->name;
            $village->created_by   = 1;
            $village->created_at   = \Carbon\Carbon::now();
            $village->save();
        }
    }
}
