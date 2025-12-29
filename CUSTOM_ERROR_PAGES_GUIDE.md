# CUSTOM ERROR PAGES GUIDE

## Cara Mengganti Debug Error dengan Custom Error Pages

### ✅ Yang Sudah Dilakukan

1. **APP_DEBUG = false** di `.env` - Matikan debug mode di production
2. **Custom Error Pages** di `resources/views/errors/`:
   - `404.blade.php` - Halaman Tidak Ditemukan
   - `403.blade.php` - Akses Ditolak
   - `419.blade.php` - Session Kadaluarsa
   - `500.blade.php` - Server Error

### 🔧 Cara Kerja

Laravel otomatis mencari error pages di folder `resources/views/errors/` berdasarkan HTTP status code:
- Jika ada error 404, Laravel akan menampilkan `404.blade.php`
- Jika ada error 500, Laravel akan menampilkan `500.blade.php`
- Dan seterusnya...

### 📋 Mengubah APP_DEBUG

**Development Mode (Local):**
```env
APP_DEBUG=true
```
- Menampilkan detailed error dengan debug info (HANYA untuk development)
- Jangan gunakan di production!

**Production Mode:**
```env
APP_DEBUG=false
```
- Menampilkan custom error pages yang user-friendly
- Ini yang Anda gunakan sekarang

### 🎯 Error Pages yang Tersedia

| Status Code | File | Deskripsi |
|------------|------|-----------|
| 404 | `errors/404.blade.php` | Halaman Tidak Ditemukan |
| 403 | `errors/403.blade.php` | Akses Ditolak |
| 419 | `errors/419.blade.php` | Session Kadaluarsa |
| 500 | `errors/500.blade.php` | Server Error / Internal Server Error |

### 📝 Menambah Error Page Baru

Jika ingin custom error page untuk status lain, buat file baru di `resources/views/errors/`:

**Contoh: Error 429 (Too Many Requests)**
```bash
# Buat file: resources/views/errors/429.blade.php
```

Setelah membuat file, Laravel akan otomatis menggunakannya.

### 🔐 Customization Options

#### 1. Ubah Email Support
Edit file error pages (404.blade.php, 500.blade.php, dll):
```html
<!-- Cari baris ini -->
<a href="mailto:support@example.com" class="text-blue-600 hover:underline">support</a>

<!-- Ubah dengan email Anda -->
<a href="mailto:admin@sekolah.com" class="text-blue-600 hover:underline">admin@sekolah.com</a>
```

#### 2. Ubah App Name
Edit di `.env`:
```env
APP_NAME=SMPMaknaBakti
```
atau di file error pages gunakan:
```blade
{{ config('app.name', 'Payment School') }}
```

#### 3. Ubah Warna/Design
Edit class Tailwind di error pages:
```html
<!-- Gradien Header -->
<div class="bg-gradient-to-r from-red-500 to-orange-600">
```

### 🚀 Testing Error Pages

**Test 404 Error:**
```
Buka URL: http://localhost/halaman-yang-tidak-ada
```

**Test 500 Error (Force):**
Edit `routes/web.php`:
```php
Route::get('/test-500', function () {
    abort(500, 'Server Error untuk Testing');
});
```

Kemudian buka: `http://localhost/test-500`

### 🎨 Design Notes

Semua custom error pages sudah:
- ✅ Menggunakan Tailwind CSS
- ✅ Konsisten dengan dashboard theme
- ✅ Responsive (mobile-friendly)
- ✅ Gradient header yang menarik
- ✅ Info card yang jelas
- ✅ Action buttons yang helpful
- ✅ Indonesian language
- ✅ Support section

### 📌 Important Notes

1. **APP_DEBUG harus FALSE di production**
   ```env
   APP_DEBUG=false  # ← SELALU gunakan ini
   ```

2. **Custom error pages hanya muncul ketika APP_DEBUG=false**
   - Jika APP_DEBUG=true, akan tetap menampilkan debug info
   - Ubah ke false untuk melihat custom error pages

3. **File naming harus sesuai HTTP status code**
   - `404.blade.php` untuk 404 error
   - `500.blade.php` untuk 500 error
   - dll

4. **Bisa juga di customize di Handler**
   Edit `app/Exceptions/Handler.php` untuk custom logic:
   ```php
   public function render($request, Throwable $exception)
   {
       // Custom logic di sini
       return parent::render($request, $exception);
   }
   ```

## Summary

Sekarang ketika terjadi error:
- ❌ TIDAK akan menampilkan debug error yang tidak profesional
- ✅ AKAN menampilkan halaman error yang profesional dan user-friendly
- ✅ User akan tahu apa yang terjadi dan apa yang harus dilakukan
- ✅ Support contact tersedia jika mereka butuh bantuan
