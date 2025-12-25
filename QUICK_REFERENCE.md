# 🎯 Quick Reference - SchoolPay Refactor

## File Changes Summary

### 📄 Modified Files (8)
```
✏️ resources/views/layouts/app.blade.php
✏️ resources/views/layouts/guest.blade.php
✏️ resources/views/layouts/admin-sidebar.blade.php
✏️ resources/views/layouts/siswa-navbar.blade.php
✏️ resources/views/admin/dashboard.blade.php
✏️ resources/views/siswa/dashboard.blade.php
✏️ resources/views/auth/login.blade.php
✏️ resources/views/auth/register.blade.php
```

### 🆕 New Files Created (11)
```
✨ resources/views/layouts/top-navbar.blade.php
✨ resources/views/layouts/footer.blade.php
✨ resources/views/components/card.blade.php
✨ resources/views/components/stats-card.blade.php
✨ resources/views/components/button.blade.php
✨ resources/views/components/badge.blade.php
✨ resources/views/components/alert.blade.php
✨ resources/views/components/form-group.blade.php
✨ resources/views/components/form-input.blade.php
✨ resources/views/components/page-header.blade.php
✨ resources/views/components/table.blade.php
```

### 📋 Documentation Files (2)
```
📚 REFACTOR_SUMMARY.md
📚 UI_DESIGN_GUIDE.md
```

---

## 🎨 Component Quick Reference

### Stats Card
```blade
<x-stats-card 
    label="Label" 
    value="Value"
    subtitle="Subtitle"
    color="blue|green|orange|red|purple"
    icon="fa-icon"
/>
```

### Badge
```blade
<x-badge type="success|warning|danger|info|primary|secondary">
    Text
</x-badge>
```

### Alert
```blade
<x-alert type="success|warning|danger|info" 
         title="Title"
         closable>
    Message
</x-alert>
```

### Card
```blade
<x-card class="additional-classes">
    <div class="card-header">Header</div>
    <div class="card-body">Content</div>
</x-card>
```

### Form Group
```blade
<x-form-group label="Label" 
              name="field_name" 
              required
              hint="Helper text">
    <x-form-input type="email" name="field_name" />
</x-form-group>
```

### Page Header
```blade
<x-page-header 
    title="Page Title"
    subtitle="Optional subtitle"
    icon="fa-icon"
/>
```

---

## 🎯 Responsive Classes Quick Guide

| Purpose | Mobile | Tablet | Desktop |
|---------|--------|--------|---------|
| Hide/Show | `hidden` | `sm:block` | `md:hidden` |
| Padding | `px-4` | `sm:px-6` | `lg:px-8` |
| Grid Cols | `grid-cols-1` | `sm:grid-cols-2` | `lg:grid-cols-4` |
| Text Size | `text-sm` | `sm:text-base` | `lg:text-lg` |
| Width | `w-full` | `sm:w-auto` | `md:w-1/2` |

---

## 🎨 Color System

### Primary Colors
- `blue-50` to `blue-900` - Primary brand color
- `bg-blue-600` - Primary button
- `hover:bg-blue-700` - Hover state

### Status Colors
- `green-*` - Success, Paid, Active
- `orange-*` - Warning, Pending, Unpaid
- `red-*` - Danger, Failed, Overdue
- `blue-*` - Info, Default

### Gray Palette
- `gray-50` - Light background
- `gray-100` - Card background
- `gray-700` - Body text
- `gray-900` - Dark text

---

## 📐 Spacing System

```
px-2  = 8px   (small)
px-3  = 12px  (small)
px-4  = 16px  (default)
px-6  = 24px  (large)
px-8  = 32px  (extra large)
```

Same applies for `py-`, `m-`, `mb-`, `mt-`, `gap-`, etc.

---

## 🔤 Typography Classes

```
text-xs    = 12px (small text)
text-sm    = 14px (labels, hints)
text-base  = 16px (body text)
text-lg    = 18px (headings)
text-2xl   = 24px (major headings)
text-3xl   = 30px (page titles)

font-normal   = 400 (body)
font-medium   = 500 (labels, highlights)
font-semibold = 600 (subheadings)
font-bold     = 700 (headings)
```

---

## 🎯 Border Radius

```
rounded      = 4px
rounded-lg   = 8px (default for cards)
rounded-2xl  = 16px (large cards)
rounded-full = 50% (circles)
```

---

## 🚀 Common Patterns

### Responsive Grid
```blade
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-stats-card ... />
    <x-stats-card ... />
    <x-stats-card ... />
    <x-stats-card ... />
</div>
```

### Form Section
```blade
<x-card>
    <div class="card-header">
        <h2>Form Title</h2>
    </div>
    <div class="card-body space-y-5">
        <x-form-group label="Field 1" name="field1" required>
            <x-form-input ... />
        </x-form-group>
        <x-form-group label="Field 2" name="field2">
            <x-form-input ... />
        </x-form-group>
    </div>
</x-card>
```

### Alert Section
```blade
@if($errors->any())
    <x-alert type="danger" title="Error" closable>
        Please check the form for errors
    </x-alert>
@endif

@if(session('success'))
    <x-alert type="success" closable>
        {{ session('success') }}
    </x-alert>
@endif
```

### Table with Status
```blade
<x-card>
    <div class="card-header">Recent Items</div>
    <div class="card-body overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th>Column 1</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        <x-badge type="success">
                            {{ $item->status }}
                        </x-badge>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
```

---

## 🎨 Utility Classes Cheat Sheet

### Display & Visibility
```
hidden         - display: none
block          - display: block
flex           - display: flex
grid           - display: grid
inline-block   - display: inline-block
```

### Flexbox
```
flex-row       - row direction
flex-col       - column direction
items-center   - align items center
justify-center - justify content center
space-x-4      - gap between items
```

### Grid
```
grid-cols-1    - 1 column
grid-cols-2    - 2 columns
grid-cols-4    - 4 columns
gap-4          - gap between items
```

### Sizing
```
w-full         - width 100%
w-1/2          - width 50%
h-full         - height 100%
min-h-screen   - minimum height 100vh
```

### Effects
```
shadow         - small shadow
shadow-lg      - large shadow
rounded        - border radius
border         - 1px border
transition     - smooth transition
hover:bg-*     - background on hover
```

---

## 📱 Mobile-First Checklist

When creating a new view:
- [ ] Mobile layout works (< 640px)
- [ ] Tablet layout works (640px - 1024px)
- [ ] Desktop layout works (> 1024px)
- [ ] Touch targets are at least 44x44px
- [ ] Forms are easy to fill on mobile
- [ ] Images are responsive
- [ ] Text is readable
- [ ] No horizontal scroll
- [ ] Navigation is accessible
- [ ] Loading states are shown

---

## 🔍 Debugging Tips

### Check Responsive
1. Open DevTools (F12)
2. Click device toggle (Ctrl+Shift+M)
3. Test at different breakpoints

### Test Accessibility
1. Use keyboard navigation (Tab, Enter)
2. Check color contrast
3. Test with screen reader
4. Verify focus states

### Verify Components
1. Check component props are passed
2. Verify error classes render
3. Test with/without content
4. Check mobile vs desktop

---

## ⚡ Performance Tips

- Use `@once` directive for shared imports
- Lazy load images with `loading="lazy"`
- Minimize inline styles
- Use CSS classes instead of inline styles
- Cache components with `@cache`
- Use `route()` helper instead of hardcoding URLs

---

## 🎓 Learning Resources

### Official Docs
- [Tailwind CSS](https://tailwindcss.com)
- [Laravel Blade](https://laravel.com/docs/11.x/blade)
- [Font Awesome](https://fontawesome.com)

### Component Patterns
- See `resources/views/components/` for implementations
- Check dashboards for real-world usage
- Review auth pages for form patterns

---

## 📞 Common Issues & Solutions

### Components not rendering?
→ Check if component file exists in `resources/views/components/`

### Styling not applied?
→ Verify Tailwind CDN is loaded in layout
→ Check `tailwind.config.js` for class purging

### Mobile looks weird?
→ Add responsive classes (sm:, md:, lg:)
→ Test with DevTools device emulation

### Form validation not showing?
→ Check `@error($fieldname)` in form-group
→ Verify error bag is passed from controller

---

## 🎉 You're All Set!

Everything is ready for development. Start using the components and patterns above to build beautiful, responsive views for your SchoolPay application!

---

**Last Updated**: December 25, 2025
**Status**: Production Ready ✅
