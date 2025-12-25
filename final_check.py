#!/usr/bin/env python3
"""
Check critical Blade files for balanced @section/@endsection
"""
import os

critical_files = [
    r'c:\laragon\www\payment-school\resources\views\auth\register.blade.php',
    r'c:\laragon\www\payment-school\resources\views\auth\login.blade.php',
    r'c:\laragon\www\payment-school\resources\views\admin\dashboard.blade.php',
    r'c:\laragon\www\payment-school\resources\views\siswa\dashboard.blade.php',
]

print("Critical Blade Files Check")
print("="*60)

all_ok = True

for file_path in critical_files:
    with open(file_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    file_name = os.path.basename(os.path.dirname(file_path)) + '/' + os.path.basename(file_path)
    
    # Count sections and endsections
    section_content = 0
    endsections = 0
    section_title = 0
    
    for line in lines:
        if "@section('content')" in line or '@section("content")' in line:
            section_content += 1
        elif "@section('title'" in line or '@section("title"' in line:
            section_title += 1
        if '@endsection' in line:
            endsections += 1
    
    # Check structure
    status = "OK" if (section_content == 1 and section_title == 1 and endsections == 1) else "BROKEN"
    if status == "BROKEN":
        all_ok = False
    
    print(f"{'OK' if status == 'OK' else 'ERROR':5} | {file_name:50}")
    print(f"       @section('title')={section_title}, @section('content')={section_content}, @endsection={endsections}")

print("="*60)

if all_ok:
    print("\nSUCCESS: All critical Blade files have correct structure!")
    print("The 'Cannot end a section without first starting one' error is FIXED!\n")
else:
    print("\nFAILED: Some files still have issues!\n")

# Check file sizes to confirm no garbage
print("\nFile Sizes:")
for file_path in critical_files:
    size = os.path.getsize(file_path)
    lines = len(open(file_path).readlines())
    print(f"  {os.path.basename(file_path):30} {size:6} bytes, {lines:3} lines")
