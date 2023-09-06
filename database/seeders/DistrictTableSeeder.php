<?php

namespace Database\Seeders;

use App\Models\Master\Geo\City;
use App\Models\Master\Geo\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/district.json');
        $json = File::get($path);
        $data = json_decode($json);

        $this->generate($data);
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $district = District::where('code', $val->code)
                ->first();
            if (!$district) {
                $district   = new District;
                $city       = City::where('code', $val->parent_code)
                    ->first();
                if (!$city) {
                    continue;
                }
                $district->city_id  = $city->id;
            }
            $district->code         = $val->code;
            $district->name         = $val->name;
            $district->created_by   = 1;
            $district->created_at   = \Carbon\Carbon::now();
            $district->save();
        }
    }
}
