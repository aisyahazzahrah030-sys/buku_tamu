# Buku Tamu e-Government - Diskominfo Kota Padang

Sistem buku tamu digital untuk Dinas Komunikasi dan Informatika Kota Padang dengan fitur lengkap untuk dokumentasi kunjungan e-Government.

## Fitur Utama

### 📝 Form Buku Tamu Lengkap
- Identitas tamu (nama, nomor HP, email, instansi)
- Kategori tamu (OPD, Pemerintah Daerah Lain, Mahasiswa, dll)
- Informasi kunjungan e-Government (jenis layanan, keperluan, dll)
- Dokumentasi foto (upload/kamera)
- Persetujuan penggunaan data
- Auto-generate tanggal dan jam kunjungan

### 👨‍💼 Dashboard Admin
- Login admin dengan keamanan berlapis
- Dashboard statistik (total tamu, hari ini, minggu ini, bulan ini)
- Filter data lengkap (nama, kategori, layanan, tanggal)
- Tabel data dengan pagination
- View detail tamu
- Delete data
- Export Excel dan PDF

### 🔐 Keamanan
- Session management
- SQL injection protection
- File upload security
- Input validation & sanitization
- Password hashing dengan bcrypt

## Struktur Direktori

```
buku_tamu/
├── config/
│   └── database.php          # Konfigurasi dan koneksi database
├── admin/
│   ├── login.php             # Halaman login admin
│   ├── dashboard.php         # Dashboard admin
│   ├── logout.php            # Logout admin
│   ├── get_detail.php        # AJAX detail tamu
│   ├── delete.php            # AJAX delete data
│   ├── export_excel.php      # Export Excel
│   └── export_pdf.php        # Export PDF
├── assets/
│   └── css/
│       └── style.css         # Stylesheet lengkap
├── uploads/
│   └── foto_tamu/            # Folder upload foto tamu
├── index.php                 # Form buku tamu utama
├── database.sql              # SQL database schema
└── README.md                 # Documentation
```

## Instalasi

### 1. Requirements
- PHP 7.4+ atau PHP 8.x
- MySQL 5.7+ atau MariaDB 10.3+
- Web Server (Apache/Nginx)
- Ekstensi PHP: mysqli, gd, fileinfo

### 2. Database Setup
Import file `database.sql` ke MySQL:

```sql
mysql -u username -p database_name < database.sql
```

### 3. Konfigurasi Database
Edit file `config/database.php`:

```php
define('DB_HOST', 'localhost');        // Host database
define('DB_USER', 'root');             // Username database
define('DB_PASS', '');                 // Password database
define('DB_NAME', 'buku_tamu_diskominfo'); // Nama database
```

### 4. Folder Permissions
Buat folder untuk upload dan set permissions:

```bash
mkdir uploads/foto_tamu
chmod 755 uploads/foto_tamu
```

### 5. Akses Aplikasi
- Form Buku Tamu: `http://localhost/buku_tamu/`
- Login Admin: `http://localhost/buku_tamu/admin/login.php`

**Login Default:**
- Username: `admin`
- Password: `admin123`

## Penggunaan

### Form Buku Tamu
1. Isi identitas tamu lengkap
2. Pilih kategori tamu
3. Pilih jenis layanan e-Government
4. Jelaskan keperluan kunjungan
5. Upload foto (opsional)
6. Centang persetujuan penggunaan data
7. Klik "Kirim Buku Tamu"

### Dashboard Admin
1. Login dengan credentials admin
2. View statistik kunjungan
3. Filter data sesuai kebutuhan
4. View detail tamu
5. Export data ke Excel/PDF
6. Delete data tidak perlu

## Kustomisasi

### Mengubah Logo/Branding
Edit CSS di `assets/css/style.css` atau gambar logo di header.

### Menambah Field Baru
1. Tambah kolom di database (`ALTER TABLE buku_tamu ADD ...`)
2. Update form di `index.php`
3. Update PHP processing di form submission
4. Update admin dashboard columns

### Mengubah Email/Password Admin
Update di database atau via PHPMyAdmin:
```sql
UPDATE admin SET username='new_admin', password='$2y$10$...' WHERE id=1;
```

## Security Features

✅ **SQL Injection Protection** - Menggunakan prepared statements
✅ **XSS Protection** - HTML entities escaping
✅ **CSRF Protection** - Session-based authentication
✅ **File Upload Security** - File type & size validation
✅ **Password Security** - Bcrypt hashing
✅ **Input Validation** - Server-side validation

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## Troubleshooting

### Upload Foto Tidak Berfungsi
1. Cek folder permissions `uploads/foto_tamu/`
2. Pastikan ekstensi PHP `fileinfo` aktif
3. Cek php.ini untuk `upload_max_filesize`

### Database Connection Error
1. Verifikasi credentials di `config/database.php`
2. Pastikan MySQL service berjalan
3. Cek nama database dan tabel

### Session Login Tidak Berfungsi
1. Pastikan PHP session save path writable
2. Cek session.cookie_secure di php.ini jika HTTPS
3. Clear browser cookies

## Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

MIT License - dapat digunakan dan dimodifikasi sesuai kebutuhan.

## Support

Untuk bantuan teknis atau pertanyaan, silakan hubungi:
- Email: support@diskominfo.padang.go.id
- Telpon: (0751) XXXXXX

---

**Dinas Komunikasi dan Informatika Kota Padang**  
e-Government Development Team