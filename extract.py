import re
import os

content = open('f:/semester 8/sistem/si_tanam/full rombak evaluasi.md', encoding='utf-8').read()
pres = re.findall(r'<pre class="cm-content[^>]*><code>(.*?)</code></pre>', content, re.DOTALL)
text_blocks = [re.sub(r'<br\s*/?>', '\n', p) for p in pres]
text_blocks = [re.sub(r'<[^>]+>', '', t) for t in text_blocks]
text_blocks = [re.sub(r'&lt;', '<', t) for t in text_blocks]
text_blocks = [re.sub(r'&gt;', '>', t) for t in text_blocks]
text_blocks = [re.sub(r'&amp;', '&', t) for t in text_blocks]

if len(text_blocks) > 0:
    open('f:/semester 8/sistem/si_tanam/eval_controller.php', 'w', encoding='utf-8').write(text_blocks[0])
if len(text_blocks) > 1:
    open('f:/semester 8/sistem/si_tanam/eval_service.php', 'w', encoding='utf-8').write(text_blocks[1])
if len(text_blocks) > 2:
    open('f:/semester 8/sistem/si_tanam/eval_view.blade.php', 'w', encoding='utf-8').write(text_blocks[2])
if len(text_blocks) > 3:
    open('f:/semester 8/sistem/si_tanam/eval_model.php', 'w', encoding='utf-8').write(text_blocks[3])
if len(text_blocks) > 4:
    open('f:/semester 8/sistem/si_tanam/eval_route.php', 'w', encoding='utf-8').write(text_blocks[4])

print('Extracted', len(text_blocks), 'blocks')
