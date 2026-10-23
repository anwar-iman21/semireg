<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            ['nama' => 'Nadia Pratama', 'email' => 'nadia@example.com', 'no_hp' => '081234567890', 'kategori' => 'mahasiswa', 'nim' => '202401001', 'institusi' => 'Universitas Cakrawala'],
            ['nama' => 'Raka Wijaya', 'email' => 'raka@example.com', 'no_hp' => '082233445566', 'kategori' => 'umum', 'nim' => null, 'institusi' => 'Studio Langkah'],
            ['nama' => 'Siti Aulia', 'email' => 'siti@example.com', 'no_hp' => '083344556677', 'kategori' => 'mahasiswa', 'nim' => '202401032', 'institusi' => 'Institut Teknologi Nusantara'],
            ['nama' => 'Bima Adinata', 'email' => 'bima@example.com', 'no_hp' => '085566778899', 'kategori' => 'umum', 'nim' => null, 'institusi' => 'Mandiri'],
        ];

        foreach ($records as $record) {
            Registration::create($record + ['kode_tiket' => 'SMR-' . strtoupper(str()->random(6))]);
        }
    }
}
