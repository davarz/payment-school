#!/usr/bin/env python3
import os

# Target file from command line or default
import sys
file_path = sys.argv[1] if len(sys.argv) > 1 else r'c:\laragon\www\payment-school\resources\views\admin\siswa\create.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Find FIRST @endsection only
endsection_found = False
for i in range(len(lines)):
    if '@endsection' in lines[i] and not endsection_found:
        new_lines = lines[:i+1]
        endsection_found = True
        break

if endsection_found:
    with open(file_path, 'w', encoding='utf-8') as f:
        f.writelines(new_lines)
    print(f"File cleaned: {len(new_lines)} lines")
else:
    print("No @endsection found")
