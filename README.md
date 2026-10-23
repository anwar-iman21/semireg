# SemiReg — Seminar Registration SINATEK

SemiReg adalah aplikasi pendaftaran peserta **Seminar Nasional Teknologi (SINATEK)** berbasis Laravel. Aplikasi menggunakan MySQL dari XAMPP/phpMyAdmin, menyediakan tiket digital, panel panitia, ekspor CSV, serta halaman diagnostik untuk pengujian melalui Ngrok atau Cloudflare Tunnel. Paket ini berupa overlay: salin hanya file di dalam daftar berikut ke instalasi Laravel baru.

## 1. Isi paket overlay

```text
app/Http/Controllers/AdminController.php
app/Http/Controllers/RegistrationController.php
app/Http/Middleware/EnsureAdminAuthenticated.php
app/Models/Registration.php
app/Providers/AppServiceProvider.php                 (ditimpa)
config/seminar.php
 database/migrations/2026_01_01_000100_create_registrations_table.php
database/seeders/RegistrationSeeder.php
public/css/semireg.css
resources/views/admin/dashboard.blade.php
resources/views/admin/info.blade.php
resources/views/admin/login.blade.php
resources/views/layouts/app.blade.php
resources/views/registrations/home.blade.php
resources/views/registrations/lookup.blade.php
resources/views/registrations/success.blade.php
routes/web.php                                       (ditimpa)
README.md
```

> Abaikan spasi awal pada baris migration di atas saat menyalin path: path sebenarnya adalah `database/migrations/2026_01_01_000100_create_registrations_table.php`. File inti Laravel seperti `bootstrap/app.php` tidak perlu diubah. CSS ditulis di satu file, `public/css/semireg.css`; aplikasi tidak memerlukan npm atau proses build aset.

## 2. Prasyarat

- PHP 8.2 atau lebih baru, XAMPP (Apache + MySQL) sudah berjalan.
- Composer 2.x.
- Git opsional.

Cek versi dari terminal VS Code (Windows PowerShell), Linux, atau macOS:

```sh
php -v
composer --version
git --version
```

Jika `git` tidak tersedia, langkah instalasi tetap dapat dilanjutkan. Pastikan ekstensi `pdo_mysql` aktif dengan `php -m`.

Sebelum migrasi, buat database `semireg` terlebih dahulu lewat phpMyAdmin:
1. Buka `http://localhost/phpmyadmin`
2. Klik **New** di sidebar kiri
3. Isi nama database: `semireg`, pilih collation `utf8mb4_unicode_ci`, klik **Create**

## 3. Instalasi

Dari folder tempat Anda ingin menyimpan project:

```sh
composer create-project laravel/laravel semireg
cd semireg
```

Salin dan timpa isi paket overlay ke root folder `semireg`, dengan struktur folder dan nama file yang sama. Jangan menyalin folder `vendor` atau file database lokal dari paket. Kemudian jalankan:

```sh
php artisan optimize:clear
php artisan migrate
```

Database menggunakan MySQL/MariaDB dari XAMPP. Pastikan database `semireg` sudah dibuat di phpMyAdmin sebelum menjalankan migrasi.

Opsional, isi empat peserta contoh:

```sh
php artisan db:seed --class=RegistrationSeeder
```

Email contoh seeder hanya untuk data lokal. Jangan jalankan seeder pada database yang menyimpan peserta sungguhan.

## 4. Pengaturan `.env`

Buka `.env` di root project. Atur sekurangnya:

```dotenv
APP_ENV=local
APP_DEBUG=true
ADMIN_PASSWORD="ganti-dengan-password-panjang-dan-unik"
SEMINAR_KUOTA=150
```

`ADMIN_PASSWORD` default aplikasi adalah `ganti-password-ini`; wajib diganti sebelum aplikasi dapat diakses melalui internet. Nilai seperti nama acara, tema, waktu, lokasi dan kuota dapat diatur menggunakan `SEMINAR_NAMA`, `SEMINAR_TEMA`, `SEMINAR_TANGGAL`, `SEMINAR_WAKTU`, `SEMINAR_LOKASI`, dan `SEMINAR_KUOTA`. Nilai agenda contoh ada di `config/seminar.php`.

Untuk demo lokal, `APP_DEBUG=true` memudahkan melihat error. Sebelum dipublikasikan, atur `APP_ENV=production`, `APP_DEBUG=false`, gunakan password admin yang unik, dan jalankan `php artisan optimize:clear`. Jangan pernah mengunggah `.env` ke repositori atau membagikan isinya. Pastikan `APP_KEY` sudah terisi (Laravel membuatnya saat instalasi); bila kosong, jalankan `php artisan key:generate`.

## 5. Menjalankan secara lokal

```sh
php artisan serve --host=127.0.0.1 --port=8000
```

Buka alamat berikut di browser laptop:

- Halaman pendaftaran: `http://127.0.0.1:8000/`
- Panel panitia: `http://127.0.0.1:8000/admin`
- Diagnostik tunnel setelah login: `http://127.0.0.1:8000/admin/info`

Login panel menggunakan nilai `ADMIN_PASSWORD` dari `.env`. Server harus tetap berjalan saat tunnel digunakan. Form pendaftaran dibatasi 10 percobaan per menit, dan login dibatasi 5 percobaan per menit per alamat klien.

## 6. Ngrok

1. Buat akun di situs resmi Ngrok dan instal aplikasi Ngrok sesuai sistem operasi.
2. Salin authtoken dari dashboard akun, lalu pasang di terminal:

   ```sh
   ngrok config add-authtoken TOKEN_ANDA
   ```

3. Biarkan Laravel berjalan pada port 8000. Buka terminal kedua dan jalankan:

   ```sh
   ngrok http 8000
   ```

4. Buka URL HTTPS yang ditampilkan Ngrok dari perangkat lain. Paket gratis dapat menampilkan halaman peringatan sebelum membuka situs; perilaku dan batas layanan mengikuti kebijakan Ngrok. URL sementara biasanya berubah saat sesi tunnel dimulai ulang.

Jangan masukkan authtoken ke README, source code, atau percakapan publik. Periksa `/admin/info` untuk melihat skema, alamat klien, dan forwarded headers yang diterima.

## 7. Cloudflare Tunnel

### Quick Tunnel (tanpa akun)

Instal `cloudflared` dari dokumentasi resmi Cloudflare. Jalankan Laravel pada port 8000, lalu di terminal terpisah:

```sh
cloudflared tunnel --url http://localhost:8000
```

Buka URL `https://...trycloudflare.com` yang ditampilkan. Quick Tunnel ditujukan untuk uji coba; URL bersifat sementara dan dapat berubah saat proses tunnel dimulai ulang.

### Tunnel bernama dengan domain sendiri

Untuk alamat yang lebih stabil, gunakan domain yang dikelola Cloudflare:

1. Tambahkan domain ke Cloudflare dan pastikan nameserver domain diarahkan sesuai petunjuk Cloudflare.
2. Instal `cloudflared`, lalu autentikasi perangkat:

   ```sh
   cloudflared tunnel login
   ```

3. Buat tunnel bernama dan catat ID/nama tunnel:

   ```sh
   cloudflared tunnel create semireg
   ```

4. Buat DNS hostname yang mengarah ke tunnel:

   ```sh
   cloudflared tunnel route dns semireg daftar.domainanda.com
   ```

5. Buat konfigurasi `config.yml` cloudflared sesuai dokumentasi Cloudflare: definisikan tunnel, path kredensial JSON yang dibuat, ingress `hostname: daftar.domainanda.com`, `service: http://localhost:8000`, dan ingress terakhir `http_status:404`.
6. Jalankan tunnel bernama menggunakan file konfigurasi tersebut:

   ```sh
   cloudflared tunnel --config PATH_CONFIG/config.yml run semireg
   ```

Simpan file kredensial dan konfigurasi privat. Langkah ini memerlukan akun/domain dan nama parameter atau pilihan CLI dapat berubah; rujuk dokumentasi resmi Cloudflare saat mengatur tunnel bernama. Jangan membuka port MySQL atau membagikan kredensial tunnel.

## 8. Pengujian dari HP dan jaringan lain

Pastikan server Laravel dan tunnel tetap aktif. Salin URL HTTPS tunnel, lalu buka dari HP menggunakan data seluler (matikan Wi-Fi) atau minta penguji membuka URL dari jaringan yang berbeda. Uji halaman utama, registrasi menggunakan email baru, tiket sukses dan versi cetak. Login admin dan buka `/admin/info` untuk memeriksa header proxy. Catat hasil tanpa menyertakan password atau data pribadi peserta.

| URL publik (boleh disamarkan) | Alur akses yang diuji | Konfigurasi | Hasil / catatan |
|---|---|---|---|
| `https://contoh.trycloudflare.com` | HP, data seluler: beranda → daftar → tiket | Cloudflare Quick Tunnel, port 8000 | Isi hasil pengujian |
| `https://contoh.ngrok-free.app` | Jaringan lain: beranda → login admin → info | Ngrok, port 8000 | Isi hasil pengujian |

## 9. Perbandingan tunnel

| Aspek | Ngrok | Cloudflare Tunnel |
|---|---|---|
| Kemudahan konfigurasi | Cepat; instal, pasang authtoken, lalu `ngrok http 8000` | Quick Tunnel cepat; tunnel bernama memerlukan akun dan konfigurasi tambahan |
| Akun / autentikasi | Akun dan authtoken dibutuhkan untuk penggunaan normal | Quick Tunnel dapat dipakai tanpa akun; domain/tunnel bernama perlu akun Cloudflare |
| Kestabilan URL | URL gratis umumnya sementara dan dapat berubah; pilihan URL stabil bergantung paket/fitur | Quick Tunnel sementara; tunnel bernama pada domain sendiri memberi hostname yang lebih tetap |
| Cocok untuk | Demo kuliah singkat dan pengujian yang mudah | Demo cepat tanpa akun atau publikasi melalui domain yang dikelola Cloudflare |
| Kesimpulan | Pilihan praktis jika sudah memiliki akun Ngrok | Quick Tunnel mudah untuk uji coba; tunnel bernama lebih cocok bila butuh domain tetap |

Kebijakan fitur dan paket kedua layanan dapat berubah; gunakan dokumentasi resmi untuk detail terbaru.

## 10. Risiko keamanan dan pembatasan

Aplikasi pengembangan yang dibuka ke internet bisa membocorkan stack trace ketika `APP_DEBUG=true`, masih memakai password default, mengekspos data peserta, menerima percobaan brute force, membuka halaman diagnostik, atau tertinggal berjalan setelah demonstrasi. Batasi risiko dengan:

- Gunakan `APP_ENV=production`, `APP_DEBUG=false`, password admin panjang dan unik, serta `APP_KEY` yang terjaga.
- Rate limit login dan formulir sudah aktif; rate limit bukan pengganti autentikasi tambahan atau proteksi akses.
- Matikan proses tunnel setelah selesai menguji. Hentikan juga server Laravel.
- Pertimbangkan Cloudflare Access atau basic auth di depan aplikasi untuk membatasi pengunjung selama demo.
- Jangan expose port database, jangan tunnel seluruh jaringan, dan jangan mengirim file `.env` atau salinan database peserta kepada penguji.
- Halaman `/admin/info` berisi informasi koneksi. Gunakan hanya untuk uji, dan tutup tunnel atau batasi akses jika tidak diperlukan.
- Aplikasi tugas ini bukan sistem produksi: belum menyediakan akun panitia individual, audit log, backup, verifikasi email, atau kebijakan retensi data.

## 11. Troubleshooting

| Gejala | Solusi singkat |
|---|---|
| CSS tidak muncul | Pastikan file ada di `public/css/semireg.css`, URL langsung `/css/semireg.css` dapat dibuka, lalu hard refresh browser. Tidak perlu menjalankan npm/Vite. |
| Peserta ingin menemukan tiket lagi | Buka tautan **Cek tiket**, lalu masukkan email pendaftaran dan kode unik yang diberikan saat daftar. Keduanya diperlukan agar tiket orang lain tidak mudah dilihat. |
| Form menampilkan error 419 | Pastikan sesi/cookie browser aktif, jangan mengirim form dari tab yang terlalu lama terbuka, muat ulang halaman dan coba kembali. Pastikan `APP_KEY` terisi. |
| Tunnel tidak bisa tersambung | Pastikan `php artisan serve --port=8000` masih berjalan, lalu pastikan tunnel menunjuk ke port 8000 dan jaringan mengizinkan koneksi keluar. |
| Port bentrok | Gunakan `php artisan serve --port=8001`, lalu arahkan Ngrok dengan `ngrok http 8001` atau cloudflared ke `http://localhost:8001`. |
| Error 502 | Server Laravel berhenti atau port tunnel keliru. Jalankan ulang Laravel, verifikasi `http://127.0.0.1:8000` secara lokal, lalu restart tunnel. |
| Database / MySQL tidak tersambung | Pastikan service MySQL di XAMPP sudah berwarna hijau (running), database `semireg` sudah dibuat di phpMyAdmin, dan `DB_USERNAME=root` tanpa password di `.env`. |

---

**Catatan implementasi:** tautan dan action form menggunakan route/path relatif agar bekerja melalui HTTPS tunnel. Trusted proxy diatur dalam `AppServiceProvider`; middleware admin digunakan langsung sebagai class pada route tanpa alias di `bootstrap/app.php`.
