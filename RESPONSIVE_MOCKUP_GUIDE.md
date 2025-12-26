# Responsive Layout Mockup - SchoolPay Admin & Siswa

## DESKTOP VIEW (1024px+)

### Admin/Operator Dashboard Layout
```
┌─────────────────────────────────────────────────────────────────┐
│ 🎓 SchoolPay     [Page Title]     🔔 (notifications)    👤 User ▼ │  ← Top Navbar (h-20)
├────────────┬───────────────────────────────────────────────────────┤
│ Menu Utama │                                                       │
│ ├─ 📊 Dashboard                                                   │
│ │                                                                 │
│ Manajemen Data                                                    │
│ ├─ 👥 Data Siswa                                                 │  ← Sidebar (w-64)
│ ├─ 📋 Kategori Bayar                                             │  ← Fixed, visible
│ │                                                                 │
│ Transaksi                                                         │
│ ├─ 💰 Pembayaran  [5]                                            │
│ ├─ 📄 Tagihan                                                    │  Main Content Area
│ │                                                                 │  ├─ Stats Cards
│ Laporan                                                           │  ├─ Tables
│ ├─ 📊 Laporan                                                    │  ├─ Forms
│ ├─ 📤 Import/Export                                              │  └─ Etc.
│ │                                                                 │
│ Pengaturan                                                        │
│ └─ ⚙️ Pengaturan Profil                                          │
└────────────┴───────────────────────────────────────────────────────┘
```

### Siswa Dashboard Layout
```
┌─────────────────────────────────────────────────────────────────┐
│ 🎓 SchoolPay     📊 Dashboard    📄 Tagihan    📜 Riwayat      │  ← Navbar (h-20)
│                  [User dropdown with notifications]              │
├───────────────────────────────────────────────────────────────────┤
│                                                                   │
│  Welcome Card                   Stats Cards (4-column grid)      │  Main Content
│                                                                   │
│  Tagihan List                   Quick Actions                    │
│  [Table with data]                                               │
│                                                                   │
│  Recent Transactions                                             │
│  [Table with data]                                               │
│                                                                   │
└───────────────────────────────────────────────────────────────────┘
```

---

## TABLET VIEW (640px - 1023px)

### Admin/Operator Layout
```
┌─────────────────────────────────────────────────┐
│ 🎓 SchoolPay    [Page Title]    🔔  👤 User   │  ← Navbar (h-16)
├─────────────────────────────────────────────────┤
│                                                 │
│  Content Area                                   │
│                                                 │  ← Sidebar Hidden (toggle via ☰)
│  - Sidebar visible on toggle                    │
│  - Full width content                           │
│  - Responsive grid (md:grid-cols-2)             │
│                                                 │
│                                                 │
└─────────────────────────────────────────────────┘
```

### Siswa Layout
```
┌─────────────────────────────────────────────────┐
│ 🎓 SchoolPay    📊 Dashboard  🔔  👤 User ▼  │  ← Navbar (h-16)
├─────────────────────────────────────────────────┤
│  📊 Dashboard  │ 📄 Tagihan  │ 📜 Riwayat  ☰   │  ← Nav links visible, hidden on mobile
├─────────────────────────────────────────────────┤
│                                                 │
│  Content Area                                   │
│  - 2-column grid layout                         │
│  - Responsive forms                             │
│  - Mobile-friendly tables                       │
│                                                 │
└─────────────────────────────────────────────────┘
```

---

## MOBILE VIEW (<640px)

### Admin/Operator Layout
```
┌────────────────────────────┐
│ ☰ 🎓  🔔  👤 User        │  ← Navbar (h-14)
├────────────────────────────┤
│ Sidebar (overlay)          │
│ ┌────────────────────────┐ │
│ │ ☰ SchoolPay         ✕  │ │
│ ├────────────────────────┤ │
│ │ 📊 Dashboard           │ │
│ │ 👥 Data Siswa          │ │
│ │ 📋 Kategori Bayar      │ │
│ │ 💰 Pembayaran        5 │ │
│ │ 📄 Tagihan             │ │
│ │ 📊 Laporan             │ │
│ │ 📤 Import/Export       │ │
│ │ ⚙️  Pengaturan Profil  │ │
│ └────────────────────────┘ │
├────────────────────────────┤
│  Content Area              │  ← Scrollable
│  (below sidebar)           │
│  - Single column layout    │
│  - Full width             │
│                           │
└────────────────────────────┘
  ↑
  Backdrop (semi-transparent black)
```

### Siswa Layout
```
┌────────────────────────────┐
│ ☰ 🎓  🔔  👤 User        │  ← Navbar (h-14)
├────────────────────────────┤
│ Mobile Menu (hidden)       │  ← Toggled by ☰
│ ┌────────────────────────┐ │
│ │ 📊 Dashboard           │ │
│ │ 📄 Tagihan             │ │
│ │ 📜 Riwayat             │ │
│ └────────────────────────┘ │
├────────────────────────────┤
│  Content Area              │  ← Scrollable
│  (below navbar)            │  ← Single column
│  - Stats cards stacked     │  ← Full width buttons
│  - Tables scrollable       │
│  - Forms in single column  │
│                           │
│                           │
└────────────────────────────┘
```

---

## RESPONSIVE BEHAVIOR

### Navbar Height Transitions
```
Mobile   (320px): h-14   → height: 56px
Tablet   (640px): sm:h-16 → height: 64px
Desktop (1024px): lg:h-20 → height: 80px
```

### Sidebar Visibility
```
Mobile   (<640px):  Hidden (fixed, -translate-x-full)
Tablet (640-1023): Hidden (fixed, -translate-x-full) [with toggle]
Desktop (≥1024px): Visible (static, translate-x-0)
```

### Content Padding
```
Mobile   (<640px):  px-3   → 12px padding each side
Tablet (640-1023): px-4   → 16px padding each side  
Desktop (≥1024px): px-6   → 24px padding each side
```

### Navigation Links (Siswa)
```
Mobile (<640px):   Hidden (in hamburger menu)
Tablet (640-768):  Hidden (in hamburger menu)
Desktop (≥768px):  Visible (in navbar center)
```

---

## INTERACTION PATTERNS

### Hamburger Menu (Mobile)
```
User clicks ☰
  ↓
toggleMobileMenu() called
  ↓
Sidebar/Mobile Menu slides in from left
Backdrop appears (semi-transparent)
  ↓
User can click on menu item or backdrop to close
```

### Notification Dropdown
```
User clicks 🔔
  ↓
toggleNotifications() called
  ↓
Dropdown appears below bell icon
User menu auto-closes
  ↓
Shows pending counts & empty state
```

### User Menu Dropdown
```
User clicks 👤 User
  ↓
toggleUserMenu() called
  ↓
Dropdown appears below user avatar
Notification menu auto-closes
  ↓
Shows profile, settings, logout options
Mobile: Also shows nav links
```

### Close Behavior
```
Click outside dropdown
  ↓
document.addEventListener('click') triggers
  ↓
event.target.closest() checks if inside dropdown
  ↓
If outside: dropdown.classList.add('hidden')
```

---

## COLOR CODING

### Navbar & Sidebar
```
Background:  bg-white        (Light background)
Border:      border-gray-200 (Subtle border)
Text:        text-gray-900   (Dark text)
Icons:       text-gray-600   (Medium gray)
```

### Active States
```
Background:  bg-blue-50               (Light blue)
Border:      border-l-4 border-blue-600 (Left border)
Text:        text-blue-700            (Dark blue)
Icon:        text-blue-600            (Blue)
```

### Hover States
```
Background:  hover:bg-gray-100 (Light gray)
Text:        hover:text-gray-900 (Dark)
Icon:        group-hover:text-gray-600 (Gray)
```

### Badges & Alerts
```
Pending:     bg-red-100 text-red-700 (Red)
Success:     bg-green-100 text-green-700 (Green)
Warning:     bg-yellow-100 text-yellow-700 (Yellow)
Info:        bg-blue-100 text-blue-700 (Blue)
```

---

## TOUCH & ACCESSIBILITY

### Touch Targets
- All buttons: min 44×44px (recommended)
- Our buttons: p-2 (8px) = 32px (slightly small, acceptable)
- Link padding: py-2.5 = 40px (good for mobile)
- Avatar: min w-8 h-8 (32px)

### Keyboard Navigation
- Tab through navbar items
- Enter to activate
- Click outside to close dropdowns
- Future: ESC key to close dropdowns

### Font Sizes
```
Mobile:   text-xs (12px) to text-sm (14px)
Tablet:   text-sm (14px) to text-base (16px)
Desktop:  text-base (16px) to text-lg (18px)
```

---

## FILE STRUCTURE REFERENCE

```
resources/views/layouts/
├── app.blade.php              ← Main container
├── top-navbar.blade.php       ← Admin/Operator navbar
├── admin-sidebar.blade.php    ← Admin/Operator sidebar
├── siswa-navbar.blade.php     ← Siswa navbar
├── footer.blade.php
├── guest.blade.php
└── auth/
    └── [auth templates]
```

---

## RESPONSIVE BREAKPOINTS REFERENCE

| Breakpoint | Width | Usage |
|-----------|-------|-------|
| default (mobile) | <640px | Base styles, mobile-first |
| `sm` | ≥640px | Small screens (phones landscape) |
| `md` | ≥768px | Tablets |
| `lg` | ≥1024px | Desktops |
| `xl` | ≥1280px | Large desktops |
| `2xl` | ≥1536px | Extra large |

**Tailwind Classes Format**: `[breakpoint]:[property]`
Example: `sm:px-6 md:px-8 lg:px-12`

---

**Created**: Phase 6 - Layout Responsiveness Refactor
**Status**: Complete and Production-Ready
**Browser Support**: All modern browsers (Chrome, Firefox, Safari, Edge)
**Mobile Tested**: iOS Safari, Android Chrome
