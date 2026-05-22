import re

lines = open('temp_path.txt', 'r', encoding='utf-8').read().splitlines()
path_d = lines[0]
fill_d = lines[1]

with open('viabilidade.html', 'r', encoding='utf-8') as f:
    html = f.read()

html = re.sub(r'<path d=\"M 60\.0,286\.7[^\"]*Z\" fill=\"url\(#greenFillNew\)\"/>', f'<path d=\"{fill_d}\" fill=\"url(#greenFillNew)\"/>', html)
html = re.sub(r'<path d=\"M 60\.0,286\.7[^\"]*299\.2\" fill=\"none\" stroke=\"#22c55e\" stroke-width=\"2\" stroke-linejoin=\"round\"/>', f'<path d=\"{path_d}\" fill=\"none\" stroke=\"#22c55e\" stroke-width=\"1.5\" stroke-linejoin=\"round\"/>', html)

html = html.replace('<!-- Peak is at x=365.8, y=249.2 -->', '<!-- Peak is at x=378.9, y=249.2 -->')
html = html.replace('<line x1=\"365.8\" y1=\"249.2\" x2=\"365.8\" y2=\"200\" stroke=\"#22c55e\" stroke-width=\"1\"/>', '<line x1=\"378.9\" y1=\"249.2\" x2=\"378.9\" y2=\"200\" stroke=\"#22c55e\" stroke-width=\"1\"/>')
html = html.replace('<rect x=\"290\" y=\"140\" width=\"150\" height=\"60\" rx=\"8\" fill=\"#0a0a0f\" stroke=\"#22c55e\" stroke-width=\"1\"/>', '<rect x=\"303.9\" y=\"140\" width=\"150\" height=\"60\" rx=\"8\" fill=\"#0a0a0f\" stroke=\"#22c55e\" stroke-width=\"1\"/>')
html = html.replace('<text x=\"365\" y=\"165\" text-anchor=\"middle\" font-size=\"16\" font-weight=\"bold\" fill=\"#22c55e\">53,74 kVA</text>', '<text x=\"378.9\" y=\"165\" text-anchor=\"middle\" font-size=\"16\" font-weight=\"bold\" fill=\"#22c55e\">53,74 kVA</text>')
html = html.replace('<text x=\"365\" y=\"185\" text-anchor=\"middle\" font-size=\"11\" fill=\"#e4e4e7\">Maior potência atingida</text>', '<text x=\"378.9\" y=\"185\" text-anchor=\"middle\" font-size=\"11\" fill=\"#e4e4e7\">Maior potência atingida</text>')

with open('viabilidade.html', 'w', encoding='utf-8') as f:
    f.write(html)

print('Done.')
