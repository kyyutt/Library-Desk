# LibraryDesk

**LibraryDesk** adalah sistem perpustakaan berbasis web yang dibangun menggunakan framework CodeIgniter 4. Sistem ini dirancang untuk mempermudah pengelolaan data buku, anggota, peminjaman, pengembalian, dan reservasi dalam perpustakaan. Aplikasi ini memiliki antarmuka admin yang memungkinkan pengelolaan perpustakaan dengan mudah.

## Fitur Utama

- **Manajemen Buku**: Tambah, edit, dan hapus data buku.
- **Manajemen Anggota**: Tambah, edit, dan hapus data anggota.
- **Sirkulasi**:
  - **Reservasi**: Pengelolaan reservasi buku oleh anggota, otomatis berubah statusnya ketika dipinjam.
  - **Peminjaman**: Catat dan kelola peminjaman buku.
  - **Pengembalian**: Kelola pengembalian buku dan perbarui status.
- **Manajemen Denda**: Kelola denda keterlambatan pengembalian.
- **Laporan**: Akses laporan aktivitas perpustakaan secara menyeluruh.

## Struktur Proyek

LibraryDesk terdiri dari modul-modul utama untuk manajemen buku, anggota, dan sirkulasi buku, serta laporan. Antarmuka admin menggunakan template CSS yang disesuaikan dengan struktur database.

### Struktur Database

- **books**: Menyimpan informasi buku (judul, pengarang, kategori, dll).
- **members**: Menyimpan data anggota perpustakaan.
- **reservations**: Menyimpan data reservasi buku.
- **loans**: Menyimpan data peminjaman buku.
- **returns**: Menyimpan data pengembalian buku.
- **fines**: Menyimpan data denda keterlambatan pengembalian.

## Instalasi

1. **Clone** repository ini:

   ```bash
   git clone https://github.com/username/librarydesk.git
   cd librarydesk
   ```

2. Install dependencies menggunakan **Composer**:

   ```bash
   composer install
   ```

3. **Copy** file konfigurasi `.env`:

   ```bash
   cp env.example .env
   ```

4. Atur **koneksi database** pada file `.env`:

   ```env
   database.default.hostname = localhost
   database.default.database = nama_database
   database.default.username = user_database
   database.default.password = password_database
   database.default.DBDriver = MySQLi
   ```

5. Jalankan **migrasi database**:

   ```bash
   php spark migrate
   ```

6. Jalankan server CodeIgniter:

   ```bash
   php spark serve
   ```

## Penggunaan

Akses aplikasi di `http://localhost:8080` setelah server berjalan. Masuk sebagai admin untuk mulai mengelola perpustakaan.

## Teknologi yang Digunakan

- **Backend**: CodeIgniter 4
- **Frontend**: HTML, CSS, Bootstrap
- **Database**: MySQL

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Kontribusi

Kontribusi terbuka untuk siapa saja. Silakan lakukan *fork* dan ajukan *pull request* untuk perubahan atau penambahan yang diusulkan.

---

Dibuat dengan ❤️ oleh **Iky**
```
