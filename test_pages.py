#!/usr/bin/env python3
import subprocess
import sys
import time

# Give server a moment to start
time.sleep(2)

test_urls = [
    ('http://127.0.0.1:8000/login', 'Login'),
    ('http://127.0.0.1:8000/register', 'Register'),
]

print("Testing Blade Pages...\n")

for url, name in test_urls:
    try:
        result = subprocess.run(
            ['curl', '-s', '-I', url],
            capture_output=True,
            text=True,
            timeout=5
        )
        
        if '200' in result.stdout or '302' in result.stdout:
            print(f"✓ {name:20} - OK")
        else:
            print(f"✗ {name:20} - Status: {result.stdout.split(chr(13))[0]}")
    except Exception as e:
        print(f"✗ {name:20} - Error: {e}")

print("\nBlade pages test complete!")
