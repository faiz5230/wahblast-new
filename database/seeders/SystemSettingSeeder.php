<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->insert([
            ['key' => 'setting_webhook', 'value' => '', 'type' => 'string'],
            ['key' => 'setting_number_of_message', 'value' => '', 'type' => 'string'],
            ['key' => 'setting_delay_message', 'value' => '', 'type' => 'string'],
            ['key' => 'setting_template_message', 'value' => '', 'type' => 'string']
        ]);

        // $smtpSettings = [
        //     'host' => 'smtp.example.com',
        //     'port' => 587,
        //     'username' => 'user@example.com',
        //     'password' => 'secret',
        //     'encryption' => 'tls'
        // ];
        
        // DB::table('system_settings')->insert([
        //     'key' => 'smtp_settings',
        //     'value' => json_encode($smtpSettings), // Mengubah array menjadi string JSON
        // ]);
    }
}
