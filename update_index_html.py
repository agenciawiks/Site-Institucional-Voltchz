import re

with open('viabilidade.html', 'r', encoding='utf-8') as f:
    v_html = f.read()

# Extract the new chart block from viabilidade.html
match = re.search(r'(          <!-- Load Curve Chart \(SVG\) -->\n          <div class=\"relative p-6 sm:p-8 bg-\[\#0a0a0f\].*?</div>\n            </div>\n          </div>)', v_html, re.DOTALL)
if match:
    new_chart_block = match.group(1)
    lines = new_chart_block.split('\n')
    new_chart_block = '\n'.join([line[2:] if line.startswith('  ') else line for line in lines])
    
    with open('index.html', 'r', encoding='utf-8') as f:
        i_html = f.read()
        
    i_html_replaced = re.sub(r'        <!-- Left: Chart preview -->\n        <div class=\"relative p-5 sm:p-6.*?(?=        <!-- Right: Text content -->)', '        <!-- Left: Chart preview -->\n' + new_chart_block + '\n\n', i_html, flags=re.DOTALL)
    
    with open('index.html', 'w', encoding='utf-8') as f:
        f.write(i_html_replaced)
    print('Updated index.html successfully.')
else:
    print('Could not find the chart block in viabilidade.html')
