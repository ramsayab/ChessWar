# Chess War

## Identitas

| Nama           | NIM         |
| -------------- | ----------- |
| Ramsay Abelson | 20240801042 |

<div>
  <p style="margin-top:12px">
    <a href="docs/LAPORAN-AWAL-PROJECT-AKHIR.pdf" style="display:inline-block; background:#1f6feb; color:#fff; padding:10px 16px; border-radius:8px; text-decoration:none; font-weight:600">Laporan UTS — Klik di sini</a>
  </p>
</div>

<div style="height:28px"></div>

## Deskripsi Project

Chess War adalah aplikasi web permainan catur berbasis Laravel. Project ini memiliki halaman landing page, autentikasi pengguna, dashboard pemain, halaman permainan catur melawan engine, serta panel admin berbasis Filament.

Konsep utama yang ditampilkan pada aplikasi adalah variasi catur dengan sistem power draft, yaitu pemain mendapatkan pilihan power/kartu yang dapat mengubah cara bermain. Pada implementasi game saat ini, halaman permainan menggunakan board catur interaktif dan engine WukongJS sebagai lawan komputer.

## Teknologi yang Digunakan

### Backend

- PHP 8.2
- Laravel 12
- Laravel Blade
- Laravel Authentication manual melalui `AuthController`
- Filament 3 untuk admin panel
- Spatie Laravel Permission untuk role dan permission
- MariaDB 10.11 sebagai database

### Frontend

- HTML, CSS, dan JavaScript
- Blade Template
- Vite
- Tailwind CSS
- Bootstrap 4 pada halaman game
- jQuery
- Chessboardjs untuk tampilan papan catur
- Chessjs tersedia sebagai library aturan catur
- WukongJS sebagai chess engine

### Development & Deployment

- Docker Compose
- Nginx
- PHP-FPM
- Composer
- NPM
- Pest untuk testing
- Laravel Pint untuk code style

## Fitur Aplikasi

### 1. Landing Page

Halaman utama berada di route `/`. Fitur yang ditampilkan:

- Branding aplikasi Chess War.
- Penjelasan konsep Random Power Draft Chess.
- Tombol menuju register dan informasi power.
- Daftar power yang menjadi konsep permainan:
  - Blink Knight
  - Super Rook
  - Undying King
  - Confused Pawn
  - Omni Queen
  - Grey Bishop
- Penjelasan alur match:
  - Shuffle kartu power
  - Pick one
  - Power active

### 2. Register

Halaman register berada di route `/register`.

Fungsi:

- Membuat akun baru.
- Validasi nama, username, email, password, dan konfirmasi password.
- Password disimpan dalam bentuk hash.
- Setelah berhasil register, pengguna diarahkan ke halaman login.

### 3. Login

Halaman login berada di route `/login`.

Fungsi:

- Login menggunakan email dan password.
- Validasi credential pengguna.
- Jika berhasil, pengguna diarahkan ke dashboard.
- Jika gagal, aplikasi menampilkan error email atau password salah.

### 4. Logout

Fungsi logout tersedia melalui route `/logout`.

Fungsi:

- Mengeluarkan pengguna dari session.
- Menghapus session aktif.
- Regenerate CSRF token.
- Mengarahkan pengguna kembali ke halaman login.

### 5. Dashboard Pengguna

Dashboard berada di route `/dashboard` dan hanya dapat diakses setelah login.

Fungsi:

- Menampilkan nama atau username pengguna.
- Menampilkan tombol Play Now menuju halaman game.
- Menampilkan kartu Quick Match dan Continue Playing sebagai menu permainan.

### 6. Game Catur

Halaman game berada di route `/game` dan hanya dapat diakses setelah login.

Fungsi:

- Menampilkan papan catur interaktif.
- Pemain dapat drag and drop bidak.
- Validasi langkah menggunakan engine.
- Pemain dapat bermain melawan engine WukongJS.
- Engine melakukan pencarian langkah terbaik selama sekitar 1 detik.
- Tombol kontrol game:
  - New untuk mulai ulang permainan.
  - Move untuk memaksa engine bergerak.
  - Undo untuk membatalkan langkah.
  - Flip untuk membalik orientasi papan.
- Mendukung update posisi board dari FEN yang dihasilkan engine.

### 7. Admin Panel

Panel admin berada di route `/admin`.

Fungsi:

- Login admin melalui Filament.
- Dashboard admin.
- Manajemen user melalui `UserResource`.
- Edit profil admin/user.
- Role dan permission menggunakan Filament Shield.
- Activity logging menggunakan Filament Logger.
- Theme dan tampilan admin menggunakan plugin Filament tambahan.

### 8. Role dan Seeder

Project memiliki seeder untuk role dan user awal.

Role:

- `super_admin`
- `user`

User bawaan:

| Role        | Email           | Password |
| ----------- | --------------- | -------- |
| super_admin | admin@admin.com | password |
| user        | user@admin.com  | password |

### 9. Database Match

Project memiliki migration tabel `matches`.

Kolom utama:

- `user_id`
- `is_win`
- `total_time`
- `power_type`
- `created_at`
- `updated_at`

Tabel ini disiapkan untuk menyimpan riwayat pertandingan, status menang/kalah, durasi permainan, dan jenis power yang digunakan.

## Struktur Folder Penting

```text
chess_war/
├── docker-compose.yml
├── nginx/
├── php/
├── db/
└── src/
    ├── app/
    │   ├── Filament/
    │   ├── Http/Controllers/
    │   └── Models/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    ├── public/
    │   ├── css/
    │   ├── js/
    │   └── vendor/
    ├── resources/views/
    └── routes/
```

## Route Utama

| Method | Route        | Fungsi               |
| ------ | ------------ | -------------------- |
| GET    | `/`          | Landing page         |
| GET    | `/login`     | Halaman login        |
| POST   | `/login`     | Proses login         |
| GET    | `/register`  | Halaman register     |
| POST   | `/register`  | Proses register      |
| POST   | `/logout`    | Logout               |
| GET    | `/dashboard` | Dashboard pengguna   |
| GET    | `/game`      | Halaman game catur   |
| GET    | `/admin`     | Panel admin Filament |

## Cara Menjalankan Project

### 1. Jalankan Docker

Dari root project:

```bash
docker compose up -d --build
```

### 2. Masuk ke Container PHP

```bash
docker compose exec php bash
```

### 3. Install Dependency Backend

```bash
composer install
```

### 4. Install Dependency Frontend

```bash
npm install
```

### 5. Siapkan Environment

Jika file `.env` belum tersedia di folder `src`, salin dari `.env.example`:

```bash
cp .env.example .env
php artisan key:generate
```

### 6. Jalankan Migration dan Seeder

Project menyediakan command khusus:

```bash
php artisan project:init
```

Command tersebut menjalankan:

- `migrate:fresh`
- generate permission Filament Shield
- database seeder
- clear cache Laravel dan Filament

### 7. Build Asset Frontend

Untuk development:

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 8. Akses Aplikasi

Jika menggunakan konfigurasi Docker dan Nginx bawaan:

```text
https://chess_war.test
```

Pastikan domain `chess_war.test` sudah diarahkan ke `127.0.0.1` pada file hosts lokal.

## Testing

Project menggunakan Pest. Test dapat dijalankan dari folder `src`:

```bash
php artisan test
```

## Catatan Implementasi

- Konsep power draft sudah ditampilkan pada landing page.
- Halaman game saat ini menjalankan permainan catur standar melawan engine WukongJS.
- Tabel `matches` sudah disiapkan untuk penyimpanan data pertandingan, tetapi integrasi riwayat match ke UI/game masih dapat dikembangkan lebih lanjut.
- `UserChessResource` pada Filament sudah dibuat, namun kolom form dan tabelnya masih kosong.
