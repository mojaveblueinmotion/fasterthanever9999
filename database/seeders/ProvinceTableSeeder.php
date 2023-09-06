<?php

namespace Database\Seeders;

use App\Models\Master\Geo\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/province.json');
        $json = File::get($path);
        $data = json_decode($json);

        $this->generate($data);
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $prov = Province::where('code', $val->code)->first();
            if (!$prov) {
                $prov = new Province;
            }
            $prov->code         = $val->code;
            $prov->name         = $val->name;
            $prov->created_by   = 1;
            $prov->created_at   = \Carbon\Carbon::now();
            $prov->save();
        }
    }
}
