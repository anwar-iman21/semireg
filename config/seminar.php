<?php

return [
    'name' => env('SEMINAR_NAMA', 'Seminar Nasional Teknologi (SINATEK)'),
    'theme' => env('SEMINAR_TEMA', 'Merancang Masa Depan Digital: Inovasi, Etika, dan Dampak Teknologi'),
    'date' => env('SEMINAR_TANGGAL', 'Sabtu, 21 November 2026'),
    'time' => env('SEMINAR_WAKTU', '08.00–17.00 WIB'),
    'location' => env('SEMINAR_LOKASI', 'Politeknik Negeri Lampung'),
    'quota' => (int) env('SEMINAR_KUOTA', 150),
    'admin_password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
    'trust_proxies' => env('TRUST_PROXIES', '*'),
    'agenda' => [
        ['time' => '08.00', 'title' => 'Registrasi & Pembukaan Acara', 'description' => 'Check-in tiket SemiReg, pengambilan seminar kit, dan sambutan pembuka.'],
        ['time' => '09.00', 'title' => 'Keynote: AI & Peluang Karir Teknologi', 'description' => 'Tren kecerdasan buatan, lanskap industri tech Indonesia, dan skill masa depan.'],
        ['time' => '10.30', 'title' => 'Sesi I: Web Development Modern', 'description' => 'Arsitektur web terkini, ekosistem framework, REST API, dan standar keamanan.'],
        ['time' => '13.00', 'title' => 'Sesi II: Keamanan Siber untuk Pemula', 'description' => 'Pengenalan ethical hacking, celah keamanan umum web, dan proteksi sistem.'],
        ['time' => '14.30', 'title' => 'Workshop: Build & Deploy App', 'description' => 'Praktik langsung pembuatan aplikasi web dan publikasi lewat secure tunnel.'],
        ['time' => '16.00', 'title' => 'Panel: Dosen × Praktisi Industri', 'description' => 'Sesi tanya jawab terbuka, tips tugas akhir/skripsi, dan karir di industri tech.'],
    ],
];
