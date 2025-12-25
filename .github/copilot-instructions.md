# Copilot Instructions for Payment School

**Purpose:** School Payment Management System - tracks student payment obligations, processes payment records, and manages payment verification workflows.

## Architecture Overview

### Three-Layer Domain Model
- **Users** (`app/Models/User.php`): Base authentication with `role` enum (admin/operator/siswa)
- **Siswa** (`app/Models/Siswa.php`): Student profile linking to User via `user_id`; uses soft deletes
- **KategoriPembayaran**: Payment categories (e.g., tuition, facility fees) with `auto_generate` toggle and `frekuensi` (frequency) for auto-generating invoices
- **Tagihan** (Invoices): Generated from KategoriPembayaran; represents payment obligations with `jumlah_tagihan`, `tanggal_jatuh_tempo`, and `status` (unpaid/paid)
- **Pembayaran** (Payments): Individual payment records with `kode_transaksi`, verification workflow (`verified_by`, `verified_at`), and `metode_bayar` enum (tunai/transfer/qris)

**Critical relationship:** Tagihan → Pembayaran (one-to-one ideally, but modeled as one-to-many). Observer pattern in `PembayaranObserver` syncs payment status back to tagihan.

### Observer-Driven State Management
Model observers in [AppServiceProvider.php](app/Providers/AppServiceProvider.php#L41) auto-register:
- **PembayaranObserver**: Auto-generates `kode_transaksi` on create, updates related Tagihan on payment status changes, clears dashboard cache
- **KategoriPembayaranObserver**: Logs amount changes, manages cache invalidation
- **SiswaObserver** / **TagihanObserver** / **UserObserver**: Track mutations with extensive logging via `Log::info()` and `Log::warning()`

Use observers for side effects; query fresh state from observers' `updated()` methods only after confirms status transitions.

### Role-Based Access Control (RBAC)
Routes grouped by role via middleware `CheckRole` (app/Http/Middleware/CheckRole.php):
- **Admin** (`/admin/*`): Full dashboard, user/siswa/pembayaran/tagihan CRUD, bulk operations, reports
- **Operator** (`/operator/*`): Dashboard, pembayaran verification/update, import/export, limited reports
- **Siswa** (`/siswa/*`): View own tagihan, submit pembayaran, profile, protected by `siswa.status` middleware (requires active status)

User methods (`isAdmin()`, `isOperator()`, `isSiswa()`) in [User model](app/Models/User.php) for blade checks.

## Critical Workflows

### Payment Verification Flow
1. Siswa submits payment (Pembayaran created with `status: 'pending'`, `bukti_bayar` file)
2. `PembayaranObserver::creating()` generates unique transaction code
3. Operator/Admin verifies: marks `status: 'paid'`, observer sets `verified_by` and `verified_at`
4. Observer's `updated()` hook calls `updateRelatedTagihan()`, cascading status to Tagihan
5. Cache cleared for user: `Cache::forget('user_pembayaran_' . user_id)`

### Invoice Auto-Generation
If KategoriPembayaran has `auto_generate: true` and `frekuensi: 'bulanan'`:
- Typically triggered during seeding or via artisan command (check Console/Commands)
- Creates Tagihan for each active Siswa per category; use Siswa scopes like `->where('status_siswa', 'aktif')`

### Password Reset with Rate Limiting
[PasswordResetService](app/Services/PasswordResetService.php):
- IP limit: 5 attempts/hour (cache key: `pwd_reset_ip:IP`)
- Email limit: 3 attempts/hour (cache key: `password_reset_attempts:email`)
- Custom rule `ResetPasswordLimit` validates against email attempts
- Siswa cannot reset if not active (status check in service)

## Development Patterns

### Testing & Build
- **Test suite**: `phpunit` (config: [phpunit.xml](phpunit.xml)); separates Unit/ and Feature/ tests
- **Frontend**: Vite with Laravel plugin (app.css, app.js); Tailwind + AlpineJS in stack
- **Commands**: `php artisan` for migrations, seeding, tinker
- **Auth routes**: [routes/auth.php](routes/auth.php) uses Laravel Breeze scaffolding

### Naming & Localization
- Table/column names are Indonesian (e.g., `siswa`, `pembayaran`, `tagihan`, `jumlah_bayar`)
- Model class names English, but reflect domain terms
- Cache keys prefix with domain (e.g., `dashboard_stats`, `kategori_pembayaran_active`)
- Log messages often bilingual; use consistent key patterns

### Database Cascades
- Pembayaran/Tagihan/Siswa soft-delete (has `deleted_at`); Users hard-delete on cascade
- Foreign keys: `constrained()` with `onDelete('cascade')` (e.g., kategori_pembayaran_id in pembayaran)
- Use `->where('status_siswa', 'aktif')` and `->whereNull('deleted_at')` in queries for active records

### View Sharing & Blade
AppServiceProvider's `shareViewData()` injects into all views:
- `$currentUser`, `$currentSiswa`, `$siswaData`
- `$pendingPembayaranCount`, `$pendingTagihanCount`
- `$appName`, `$semesterAktif`

Use these in blade without re-querying; check role in templates with `$currentUser->isAdmin()`.

## Integration Points

### Spatie Laravel-Permission
Installed but not heavily visible in routes (roles hardcoded in middleware). If expanding permissions, register `Permission` model and update `CheckRole` middleware to use Spatie's `hasPermissionTo()`.

### File Storage
Pembayaran `bukti_bayar` stored via Laravel's `Storage` facade. Default disk: `local` (check [config/filesystems.php](config/filesystems.php)).

### Notifications
Custom notification classes in [app/Notifications/](app/Notifications/): AdminTriggeredPasswordReset, CustomResetPasswordNotification. Queued if `QUEUE_CONNECTION` not `sync` (test config uses `sync`).

### Email Verification
Routes in auth.php include email verification (`verify-email`), uses signed URLs and rate throttle.

## Common Pitfalls & Best Practices

1. **Observer Loops**: PembayaranObserver's `updated()` calls `updateRelatedTagihan()` which modifies Tagihan. Don't trigger further pembayaran updates in Tagihan observer (would loop).
2. **Soft Deletes**: Always use `->where('deleted_at', null)` or `->whereNull('deleted_at')` explicitly if not using `SoftDelete::query()`; Siswa query omits deleted.
3. **Role Checks**: Prefer middleware `role:admin` in routes over runtime checks. Fallback to `$user->isAdmin()` in conditionals.
4. **Cache Invalidation**: Manually call `Cache::forget()` after mutations (e.g., in observers). Don't rely on cache without expiration.
5. **Decimal Fields**: `jumlah_bayar`, `jumlah_tagihan` are `decimal(15,2)`. Cast to `'decimal:2'` in models.

## Key File References

- Models: `app/Models/` (User, Siswa, Pembayaran, Tagihan, KategoriPembayaran)
- Observers: `app/Observers/` (side effects & logging)
- Routes: `routes/web.php` (role-based groups), `routes/auth.php`
- Controllers: `app/Http/Controllers/Admin/`, `app/Http/Controllers/Siswa/`
- Service: [PasswordResetService.php](app/Services/PasswordResetService.php) (auth logic)
- Provider: [AppServiceProvider.php](app/Providers/AppServiceProvider.php) (observers, view sharing)
- Middleware: [CheckRole.php](app/Http/Middleware/CheckRole.php), [CheckSiswaStatus.php](app/Http/Middleware/CheckSiswaStatus.php)
