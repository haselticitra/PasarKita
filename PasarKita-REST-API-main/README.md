# PasarKita — Marketplace PHP Native

## Deskripsi
PasarKita merupakan aplikasi marketplace sederhana berbasis web yang dibangun menggunakan PHP Native, MySQLi, dan Bootstrap 5. Aplikasi ini dikembangkan untuk memenuhi tugas pengembangan Web Service / REST API Marketplace.

## Teknologi
- PHP Native
- MySQL
- MySQLi
- Bootstrap 5
- REST API
- JSON
- XAMPP

## Fitur Aplikasi
- Registrasi dan login pengguna
- Menampilkan daftar produk
- Pencarian dan kategori produk
- Detail produk
- Keranjang belanja
- Checkout dan pemesanan
- Riwayat pesanan pengguna
- Dashboard administrator
- CRUD produk dan kategori
- Pengelolaan status pesanan

## REST API

| No. | Endpoint | Method | Keterangan |
|---|---|---|---|
| 1 | `/api/produk.php` | GET | Mengambil seluruh produk |
| 2 | `/api/produk.php?id=1` | GET | Mengambil detail produk |
| 3 | `/api/kategori.php` | GET | Mengambil seluruh kategori |
| 4 | `/api/pesanan.php` | POST | Membuat pesanan baru |

### Contoh URL Pengujian

- `http://localhost/PasarKita/api/produk.php`
- `http://localhost/PasarKita/api/produk.php?id=1`
- `http://localhost/PasarKita/api/produk.php?id=99999`
- `http://localhost/PasarKita/api/kategori.php`

### Contoh JSON POST Pesanan

```json
{
  "user_id": 1,
  "address": "Jl. Melati No. 10, Bengkulu",
  "phone": "081234567890",
  "notes": "Mohon pilih produk segar",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

## Cara Instalasi

1. Instal dan jalankan XAMPP.
2. Aktifkan Apache dan MySQL.
3. Salin folder PasarKita ke `C:/xampp/htdocs/`.
4. Buka phpMyAdmin.
5. Buat database dengan nama `pasarkita`.
6. Import file database SQL.
7. Sesuaikan konfigurasi database pada `config.php`.
8. Buka `http://localhost/PasarKita/` melalui browser.

## Pengujian API

Pengujian dilakukan menggunakan browser dan Postman.

Respons API menggunakan format JSON. Endpoint POST digunakan untuk membuat pesanan dan menyimpan data ke database.

**Catatan:** Pengujian POST perlu dilengkapi dengan bukti respons berhasil setelah pengujian ulang menggunakan Postman Desktop Agent.

## Pengembang
Nama: [Isi Nama Mahasiswa]

Mata Kuliah: [Isi Nama Mata Kuliah]

Proyek: Pengembangan Web Service / REST API Marketplace