# ReviewFilm

## Tentang Proyek

ReviewFilm adalah sebuah aplikasi berbasis web yang dibuat menggunakan Laravel 11 untuk memberikan ulasan dan informasi tentang berbagai film.

## Spesifikasi Minimum

Sebelum menginstal proyek ini, pastikan perangkat Anda memiliki spesifikasi berikut:

-   **PHP**: Versi 8.2 atau lebih baru
-   **Laravel**: Versi 11
-   **Database**: MySQL 8.3 atau PostgreSQL
-   **Composer**: Terinstal di sistem
-   **Node.js & npm**: Untuk pengelolaan aset frontend (opsional)

## Cara Install dan Clone

### 1. Clone Repository

```sh
git clone https://github.com/maul3107/ReviewFilm.git
cd ReviewFilm
```

### 2. Instal Dependensi

Jalankan perintah berikut untuk menginstal dependensi PHP menggunakan Composer:

```sh
composer install
```

### 3. Konfigurasi Lingkungan

Duplikasi file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.

```sh
cp .env.example .env
```

Kemudian ubah konfigurasi database sesuai kebutuhan:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviewfilm
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key Aplikasi

```sh
php artisan key:generate
```

### 5. Migrasi dan Seeder Database

```sh
php artisan migrate --seed
```

### 6. Jalankan Server

```sh
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## Opsi Tambahan (Frontend)

Proyek menggunakan Tailwind CSS dan Alpine.js, jalankan:

```sh
npm install && npm run dev
```

## Kontribusi

Jika ingin berkontribusi, silakan buat pull request atau ajukan issue di repository.

## Lisensi

Proyek ini dilisensikan di bawah[ ](https://opensource.org/licenses/MIT)[MIT License](https://opensource.org/licenses/MIT).
