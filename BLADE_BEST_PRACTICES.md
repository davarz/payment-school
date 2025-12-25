# Blade Template Best Practices & Troubleshooting

## Blade Section/Layout System

### Basic Structure
Laravel Blade uses a parent-child inheritance model via `@extends` and `@section`.

```blade
<!-- Parent Layout (layouts/app.blade.php) -->
<html>
<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
</head>
<body>
    @yield('content')
</body>
</html>

<!-- Child Page (pages/dashboard.blade.php) -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard Content</h1>
@endsection
```

### Key Rules

1. **Single-line Sections** (do NOT need @endsection):
   ```blade
   @section('title', 'Page Title')
   ```

2. **Multi-line Sections** (DO need @endsection):
   ```blade
   @section('content')
       <div>Content here</div>
   @endsection
   ```

3. **Correct Structure for app.blade.php extending pages**:
   ```blade
   @extends('layouts.app')
   
   @section('title', 'Your Page Title')  ← Single line, no endsection needed
   
   @section('content')                   ← Multi-line block
       ... your HTML content ...
   @endsection                          ← Closes 'content' section
   ```

## Common Error: "Cannot end a section without first starting one"

### Cause
```blade
@endsection  ← Error: trying to close when no @section('...') is open
```

### Solutions

1. **Check for balanced sections**
   ```bash
   # Count @section and @endsection
   grep -c "@section(" file.blade.php
   grep -c "@endsection" file.blade.php
   ```

2. **Verify order** - @endsection must close an open @section('content') block
   ```blade
   ✗ WRONG:
   @endsection
   @section('content')
   
   ✓ CORRECT:
   @section('content')
   @endsection
   ```

3. **Check for duplicate code** - Remove any garbage after first @endsection:
   ```bash
   # View file structure
   head -210 file.blade.php > temp.blade.php
   # Keep only first 210 lines + @endsection
   ```

## Blade Component Patterns

### Components (do NOT extend layouts)
Components are reusable UI fragments:
```blade
<!-- resources/views/components/card.blade.php -->
<div class="card">
    {{ $slot }}
</div>

<!-- Usage in pages -->
<x-card>
    Content goes here
</x-card>
```

### Layout/Page Files (DO extend layouts)
Pages extend layouts and use @section:
```blade
<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
    <x-card>
        Admin content
    </x-card>
@endsection
```

## File Organization

### Layouts (`resources/views/layouts/`)
- `app.blade.php` - Main authenticated layout
- `guest.blade.php` - Unauthenticated layout (login/register)

### Pages (`resources/views/*/`)
- Always use: `@extends('layouts.app')` or `@extends('layouts.guest')`
- Always define: `@section('title', '...')` and `@section('content')...@endsection`

### Components (`resources/views/components/`)
- Reusable fragments
- Use: `{{ $slot }}` for content injection
- Usage: `<x-component-name>content</x-component-name>`

## Verification Script
```python
# Python script to verify Blade syntax
critical_files = [
    'auth/register.blade.php',
    'auth/login.blade.php', 
    'admin/dashboard.blade.php',
    'siswa/dashboard.blade.php',
]

for file in critical_files:
    sections = count('@section(')
    endsections = count('@endsection')
    assert sections == 2 and endsections == 1, f"{file} broken"
```

## Debugging Tips

1. **Clear Blade cache before testing**:
   ```bash
   php artisan view:clear
   ```

2. **Check Laravel log for exact line**:
   ```bash
   tail storage/logs/laravel.log | grep "@endsection"
   ```

3. **Use `php artisan tinker` to test views**:
   ```php
   view('admin.dashboard')->render();
   ```

4. **Inspect compiled view cache**:
   ```bash
   ls storage/framework/views/
   # Find compiled PHP files
   cat storage/framework/views/[hash].php | head -20
   ```

## Reference Files (Payment School Project)

- `resources/views/layouts/app.blade.php` - Main layout
- `resources/views/layouts/guest.blade.php` - Auth layout  
- `resources/views/auth/register.blade.php` - Registration page
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/admin/dashboard.blade.php` - Admin dashboard
- `resources/views/siswa/dashboard.blade.php` - Student dashboard

All verified clean as of 2025-12-25.
