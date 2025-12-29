# Fitur Real-Time Email Validation

## Overview
Fitur real-time email validation memungkinkan user untuk langsung mengetahui apakah email yang mereka masukkan sudah terdaftar di sistem atau belum, tanpa harus submit form terlebih dahulu.

## Implementasi

### 1. Backend - Controller Method
**File:** `app/Http/Controllers/Admin/SiswaController.php`

```php
public function checkEmail(Request $request)
{
    $email = $request->query('email');
    $currentId = $request->query('current_id'); // untuk update

    if (!$email) {
        return response()->json(['available' => true]);
    }

    $query = User::where('email', $email);

    if ($currentId) {
        $query->where('id', '!=', $currentId);
    }

    $exists = $query->exists();

    return response()->json([
        'available' => !$exists,
        'email' => $email,
    ]);
}
```

### 2. Routes
**File:** `routes/web.php`

```php
// Public route (untuk registration)
Route::get('/check-email', [AdminSiswaController::class, 'checkEmail'])->name('check-email');

// Protected route (untuk admin siswa management)
Route::get('/check-email', [AdminSiswaController::class, 'checkEmail'])->name('siswa.check-email');
```

### 3. Frontend - Siswa Create Form
**File:** `resources/views/admin/siswa/create.blade.php`

Fitur yang ditambahkan:
- Loader spinner saat sedang checking
- Icon check circle hijau jika email tersedia
- Border hijau pada input jika email tersedia
- Error message merah jika email sudah terdaftar
- Border merah pada input jika email sudah terdaftar
- Debounce 500ms untuk mengurangi request yang tidak perlu

### 4. Frontend - Register Form
**File:** `resources/views/auth/register.blade.php`

Implementasi yang sama dengan form Tambah Siswa Admin.

## Fitur Detail

### Validasi Status

#### ✅ Email Tersedia
- Input border berubah hijau (`border-green-500`)
- Tampilkan checkmark icon (`fa-check-circle text-green-500`)
- Error message disembunyikan
- User bisa lanjut submit form

#### ❌ Email Sudah Dipakai
- Input border berubah merah (`border-red-500`)
- Tampilkan error message: "Email sudah terdaftar di sistem"
- Icon check disembunyikan
- User akan mendapat validasi error jika tetap submit

### Performance
- **Debounce:** 500ms untuk mengurangi request
- **Endpoint:** `/check-email` dengan query parameter `?email=xxx`
- **Response:** JSON dengan property `available` (boolean)

## User Experience

### Saat Mengetik Email

1. **Instant Check:** Setelah user berhenti mengetik 500ms
2. **Loading State:** Loader spinner menunjukkan sedang proses
3. **Instant Feedback:** 
   - ✅ Hijau jika tersedia
   - ❌ Merah jika sudah dipakai
4. **Clear Message:** Error message yang jelas dan membantu

## Testing

### Test Email Tersedia
```bash
curl "http://localhost/check-email?email=newuser@example.com"
# Response: {"available": true, "email": "newuser@example.com"}
```

### Test Email Sudah Dipakai
```bash
curl "http://localhost/check-email?email=existing@example.com"
# Response: {"available": false, "email": "existing@example.com"}
```

## Integrasi dengan Edit Form

Untuk implementasi di edit form, tambahkan `current_id` query parameter:

```html
<input 
    type="email" 
    id="email-input" 
    name="email"
    data-current-id="{{ $user->id }}"
>
```

Kemudian di JavaScript:
```javascript
const currentId = emailInput.dataset.currentId;
const url = currentId 
    ? `/check-email?email=${encodeURIComponent(email)}&current_id=${currentId}`
    : `/check-email?email=${encodeURIComponent(email)}`;
```

## Browser Compatibility
✅ Modern browsers yang support:
- Fetch API
- ES6 classes
- DOM manipulation

## Troubleshooting

### Email check tidak berfungsi
1. Pastikan endpoint `/check-email` sudah terdaftar di route
2. Cek browser console untuk error message
3. Verify CSRF token tidak ada masalah (endpoint adalah GET)

### Loading spinner tidak hilang
1. Check network tab di browser untuk response
2. Pastikan response format JSON valid
3. Check server logs untuk error

### Border color tidak berubah
1. Pastikan Tailwind CSS sudah di-compile
2. Check class names sesuai dengan Tailwind version yang digunakan
3. Verify tidak ada CSS override lain
