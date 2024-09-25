<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create();
        $time = Carbon::now();

        // Loop untuk memasukkan 10 data acak
        for ($i = 0; $i < 10; $i++) {
            DB::table('akun_regis')->insert([
                'nama' => $faker->name,
                'nik' => $faker->username,
                'unit' => 'SMG',
                'no_hp' => '6285399014003',
                'sofdel' => '0',
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }
    }
}
