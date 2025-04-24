#  Aplikasi Konversi Mata Uang - Laravel + OpenExchangeRates API

Ini adalah aplikasi web sederhana untuk **mengonversi mata uang secara real-time** menggunakan **Laravel** dan **API dari OpenExchangeRates**.

##  Fitur Utama

- Konversi kurs mata uang secara langsung
- Real Time Convert
- Tampilan antarmuka responsif menggunakan Bootstrap

##  Teknologi yang Digunakan

- Laravel 10+
- OpenExchangeRates API

##  Tampilan UI

Halaman "Kurs Mata Uang" dengan dua kolom input:
- Input 1: Jumlah dan kode mata uang asal (contoh: USD)
- Input 2: Kode mata uang tujuan (contoh: IDR)
- Hasil konversi muncul secara langsung setelah mengisi

##  Cara Menjalankan

1. Clone repository ini:
    ```bash
    git clone https://github.com/pinnpalenn/UTS-KEPL-API.git
    cd UTS-KEPL-API
    ```

2. Install dependensi
   ```bash
   composer install
   ```

3. Salin file .env.example menjadi .env
   ```bash
   cp .env.example .env
   ```

4. Generate application key
   ```bash
   php artisan key:generate
   ```

5. Jalankan Laravel:
    ```bash
    php artisan serve
    ```

6. Tambahkan API key dari OpenExchangeRates ke file `.env`:
    ```env
    OPENEXCHANGE_APP_ID=masukkan_api_key_anda
    ```

7. Akses aplikasi di:
    ```
    http://127.0.0.1:8000/
    ```

##  API yang Digunakan

- [OpenExchangeRates](https://openexchangerates.org/) — untuk mendapatkan nilai tukar terbaru

> Daftar akun gratis di OpenExchangeRates, lalu tempelkan App ID kamu ke file `.env`.

##  Author

Alvin Avalen - 2311081003
