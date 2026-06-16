import bs4

content = open('f:/semester 8/sistem/si_tanam/full rombak evaluasi.md', encoding='utf-8').read()
soup = bs4.BeautifulSoup(content, 'html.parser')
pres = soup.find_all('pre', class_=lambda c: c and 'cm-content' in c)

text_blocks = []
for pre in pres:
    code = pre.find('code')
    if code:
        # Get all text nodes and replace <br> with \n
        text = ''
        for child in code.children:
            if child.name == 'br':
                text += '\n'
            elif isinstance(child, bs4.NavigableString):
                text += str(child)
            else:
                text += child.get_text()
        text_blocks.append(text)

print(len(text_blocks))

if len(text_blocks) > 0: open('f:/semester 8/sistem/si_tanam/eval_controller2.php', 'w', encoding='utf-8').write(text_blocks[0])
if len(text_blocks) > 1: open('f:/semester 8/sistem/si_tanam/eval_service2.php', 'w', encoding='utf-8').write(text_blocks[1])
if len(text_blocks) > 2: open('f:/semester 8/sistem/si_tanam/eval_view2.blade.php', 'w', encoding='utf-8').write(text_blocks[2])
if len(text_blocks) > 3: open('f:/semester 8/sistem/si_tanam/eval_model2.php', 'w', encoding='utf-8').write(text_blocks[3])
if len(text_blocks) > 4: open('f:/semester 8/sistem/si_tanam/eval_route2.php', 'w', encoding='utf-8').write(text_blocks[4])
