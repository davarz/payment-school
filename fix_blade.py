#!/usr/bin/env python3
import os

# Find all blade files
blade_dir = r'c:\laragon\www\payment-school\resources\views'

def get_all_blade_files(directory):
    blade_files = []
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php'):
                blade_files.append(os.path.join(root, file))
    return blade_files

blade_files = get_all_blade_files(blade_dir)

for file_path in blade_files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    lines = content.split('\n')
    
    # Find @section lines that are NOT @section('title') style (one-liners)
    # Should be @section('content')
    content_section_line = -1
    for i, line in enumerate(lines):
        if "@section('content')" in line or '@section("content")' in line:
            content_section_line = i
            break
    
    if content_section_line == -1:
        continue
    
    # Count @endsection after content section
    endsection_count = 0
    first_endsection_after = -1
    
    for i in range(content_section_line, len(lines)):
        if '@endsection' in lines[i]:
            endsection_count += 1
            if first_endsection_after == -1:
                first_endsection_after = i
    
    # Should only have 1 @endsection after @section('content')
    if endsection_count > 1:
        print(f"{file_path}")
        print(f"  Found {endsection_count} @endsection(s) after @section('content')")
        print(f"  First @endsection at line {first_endsection_after + 1}")
        
        # Keep only up to first endsection
        new_lines = lines[:first_endsection_after + 1]
        new_content = '\n'.join(new_lines)
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"  FIXED! Removed {len(lines) - len(new_lines)} lines\n")

print("Scan complete!")

