<?php

namespace Database\Seeders;

use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/city.json');
        $json = File::get($path);
        $data = json_decode($json);

        $this->generate($data);
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $city = City::where('code', $val->code)
                ->first();
            if (!$city) {
                $city = new City;
                $province   = Province::where('code', $val->parent_code)
                    ->first();
                if (!$province) {
                    continue;
                }
                $city->province_id  = $province->id;
            }
            $city->code         = $val->code;
            $city->name         = $val->name;
            $city->created_by   = 1;
            $city->created_at   = \Carbon\Carbon::now();
            $city->save();
        }
    }
}
