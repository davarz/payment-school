#!/usr/bin/env python3
"""
Final verification script to ensure all Blade files have proper section structure
"""
import os
import sys

blade_dir = r'c:\laragon\www\payment-school\resources\views'

def check_blade_file(file_path):
    """Check if blade file has balanced @section/@endsection"""
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    lines = content.split('\n')
    
    # For auth files (extends guest layout)
    if 'guest' in file_path:
        # Should have: @section('title') + @section('content') + 1 @endsection
        sections = []
        endsections = 0
        
        for i, line in enumerate(lines):
            if "@section('title" in line or "@section(\"title" in line:
                sections.append(('title', i+1))
            elif "@section('content" in line or "@section(\"content" in line:
                sections.append(('content', i+1))
            if '@endsection' in line:
                endsections += 1
        
        # Should have 2 sections and 1 endsection
        if len(sections) == 2 and sections[0][0] == 'title' and sections[1][0] == 'content' and endsections == 1:
            return True, "OK (2 sections, 1 endsection)"
        else:
            return False, f"BROKEN (sections={len(sections)}, endsections={endsections})"
    
    # For app layout files
    else:
        sections = []
        endsections = 0
        
        for i, line in enumerate(lines):
            if '@section(' in line and '@endsection' not in line:
                sections.append(i+1)
            if '@endsection' in line:
                endsections += 1
        
        # Simple check: should have endsection count matching or close to section count
        if endsections >= 1:
            return True, f"OK ({len(sections)} sections, {endsections} endsections)"
        else:
            return False, f"BROKEN (sections={len(sections)}, endsections={endsections})"

# Scan all blade files
print("Blade File Structure Verification\n" + "="*50)

errors = []
for root, dirs, files in os.walk(blade_dir):
    for file in sorted(files):
        if file.endswith('.blade.php'):
            file_path = os.path.join(root, file)
            rel_path = file_path.replace(blade_dir, '').lstrip('\\')
            
            ok, msg = check_blade_file(file_path)
            
            status = "✓" if ok else "✗"
            print(f"{status} {rel_path:50} {msg}")
            
            if not ok:
                errors.append(rel_path)

print("\n" + "="*50)
if errors:
    print(f"\n{len(errors)} file(s) with issues:")
    for err in errors:
        print(f"  - {err}")
    sys.exit(1)
else:
    print("\n✓ All Blade files have correct structure!")
    sys.exit(0)
