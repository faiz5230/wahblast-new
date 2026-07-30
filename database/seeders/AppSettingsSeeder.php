<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_settings')->insert([
            ['key' => 'app_name', 'value' => 'Nama Aplikasi'],
            ['key' => 'app_title', 'value' => 'Judul Aplikasi'],
            ['key' => 'app_footer', 'value' => 'Footer Aplikasi'],
            ['key' => 'app_logo', 'value' => null],
            ['key' => 'app_icon', 'value' => null],
            ['key' => 'app_logo_full', 'value' => null],
        ]);
    }
}
