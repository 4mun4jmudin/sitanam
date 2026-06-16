import re
content = open('f:/semester 8/sistem/si_tanam/full rombak evaluasi.md', encoding='utf-8').read()
pres = re.findall(r'<pre class="cm-content[^>]*><code>(.*?)</code></pre>', content, re.DOTALL)
text_blocks = [re.sub(r'<br\s*/?>', '\n', p) for p in pres]

# Don't strip HTML tags! But we DO need to remove the <span class="..."> tags from CodeMirror.
# CodeMirror wraps syntax highlighting in spans like <span class="cm-tag">...</span>.
# We can strip spans specifically:
text_blocks = [re.sub(r'</?span[^>]*>', '', t) for t in text_blocks]

# Also unescape entities
text_blocks = [re.sub(r'&lt;', '<', t) for t in text_blocks]
text_blocks = [re.sub(r'&gt;', '>', t) for t in text_blocks]
text_blocks = [re.sub(r'&amp;', '&', t) for t in text_blocks]

open('f:/semester 8/sistem/si_tanam/real_blade.blade.php', 'w', encoding='utf-8').write(text_blocks[4])
print("Blade extracted, size:", len(text_blocks[4]))
