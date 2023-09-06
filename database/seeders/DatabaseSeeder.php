<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        // $this->call(VillageTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(MenuFlowSeeder::class);
        $this->call(StructSeeder::class);
        $this->call(UserSeeder::class);

        // Mobil
        $this->call(MerkMobilSeeder::class);
        $this->call(SeriMobilSeeder::class);
        $this->call(TahunMobilSeeder::class);
        $this->call(TipeMobilSeeder::class);
        $this->call(KodePlatSeeder::class);

        // Kendaraan
        $this->call(TipeKendaraanSeeder::class);
        $this->call(TipePemakaianSeeder::class);
        $this->call(KondisiKendaraanSeeder::class);
        $this->call(LuasPertanggunganSeeder::class);
    }
}
