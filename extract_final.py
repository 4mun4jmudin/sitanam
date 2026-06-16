import json
import bs4

content = open('f:/semester 8/sistem/si_tanam/full rombak evaluasi.md', encoding='utf-8').read()
soup = bs4.BeautifulSoup(content, 'html.parser')
pres = soup.find_all('pre', class_=lambda c: c and 'cm-content' in c)

# We want the text content of the code block. 
# CodeMirror uses nested spans. We just want the raw text inside `pre > code`.
# `get_text()` returns all text inside the element, which correctly reconstructs the code
# if there are no line breaks missing. However, CodeMirror uses `<br>` or `<br/>` for newlines!
# So we just need to replace `<br>` with `\n`, then call `get_text()`.

text_blocks = []
for pre in pres:
    code = pre.find('code')
    if code:
        # replace <br> with newline in the BeautifulSoup tree
        for br in code.find_all('br'):
            br.replace_with('\n')
        
        # now get the text, which will unescape &lt; and &gt; automatically by BeautifulSoup!
        text = code.get_text(separator=' ')
        text_blocks.append(text)

print("Found blocks:", len(text_blocks))
if len(text_blocks) > 0:
    open('f:/semester 8/sistem/si_tanam/eval_final_controller.php', 'w', encoding='utf-8').write(text_blocks[0])
if len(text_blocks) > 1:
    open('f:/semester 8/sistem/si_tanam/eval_final_service.php', 'w', encoding='utf-8').write(text_blocks[1])
if len(text_blocks) > 2:
    open('f:/semester 8/sistem/si_tanam/eval_final_view.blade.php', 'w', encoding='utf-8').write(text_blocks[2])
if len(text_blocks) > 3:
    open('f:/semester 8/sistem/si_tanam/eval_final_model.php', 'w', encoding='utf-8').write(text_blocks[3])
if len(text_blocks) > 4:
    open('f:/semester 8/sistem/si_tanam/eval_final_route.php', 'w', encoding='utf-8').write(text_blocks[4])
