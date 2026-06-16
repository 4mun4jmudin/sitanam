import json
import os

log_path = r'C:\Users\User\.gemini\antigravity-ide\brain\d3cebc60-ab99-434c-954e-0e175631240e\.system_generated\logs\transcript.jsonl'
lines = open(log_path, encoding='utf-8').readlines()
msgs = [json.loads(l) for l in lines]
for m in msgs:
    if m.get('type') == 'USER_INPUT' and 'sesuaikan saja' in m.get('content', ''):
        content = m['content']
        # The content has some user text at the beginning, then `<x-app-layout>...`
        # Let's extract the actual code
        start_idx = content.find('<x-app-layout>')
        if start_idx != -1:
            code = content[start_idx:]
            open('f:/semester 8/sistem/si_tanam/extracted_view.blade.php', 'w', encoding='utf-8').write(code)
            print("Extracted blade view length:", len(code))
            break
