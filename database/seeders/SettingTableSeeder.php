<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'nama_perusahaan' => 'POS',
            'alamat' => 'Jl Menganti Babatan 3 Blok E, No 17',
            'telepon' => '083833331865',
            'tipe_nota' => '1', // kecil
            'diskon' => '5',
            'path_logo' => '/img/logo.png',
            'path_kartu_member' => '/img/member.png',
            // 'path_logo' => asset('/img/company-logo.png'),
            // 'path_kartu_member' => asset('/img/member.png'),
        ]);
    }
}
