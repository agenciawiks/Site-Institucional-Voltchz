<?php
/**
 * VoltchZ Brasil - Conector de Banco de Dados PHP (Ponte JSON)
 * Serve os dados brutos e implementa a renderização dinâmica de SVGs no servidor para SEO.
 */

// Caminho absoluto para o arquivo JSON
$json_path = dirname(__DIR__) . '/static/data/db.json';

if (!file_exists($json_path)) {
    die("Erro crítico: Arquivo de banco de dados não localizado em: " . $json_path);
}

// Carrega os dados brutos do JSON
$db_data = json_decode(file_get_contents($json_path), true);

$GLOBALS['VOLTCHZ_MARCAS'] = $db_data['MARCAS'] ?? [];
$GLOBALS['VOLTCHZ_CATEGORIAS'] = $db_data['CATEGORIAS'] ?? [];
$GLOBALS['VOLTCHZ_PRODUTOS'] = $db_data['PRODUTOS'] ?? [];
$GLOBALS['VOLTCHZ_ARTIGOS'] = $db_data['ARTIGOS'] ?? [];

// --- FUNÇÕES UTILITÁRIAS ---

function get_marcas() {
    return $GLOBALS['VOLTCHZ_MARCAS'];
}

function get_categorias() {
    return $GLOBALS['VOLTCHZ_CATEGORIAS'];
}

function get_produtos() {
    return $GLOBALS['VOLTCHZ_PRODUTOS'];
}

function get_artigos() {
    return $GLOBALS['VOLTCHZ_ARTIGOS'];
}

function get_marca_by_id($id) {
    foreach (get_marcas() as $marca) {
        if ($marca['id'] === $id) {
            return $marca;
        }
    }
    return ['nome' => 'Institucional', 'descricao' => 'VoltchZ Brasil'];
}

function get_categoria_by_id($id) {
    foreach (get_categorias() as $cat) {
        if ($cat['id'] === $id) {
            return $cat;
        }
    }
    return ['nome' => 'Geral', 'descricao' => ''];
}

function get_produto_by_slug($slug) {
    foreach (get_produtos() as $prod) {
        if ($prod['slug'] === $slug) {
            return $prod;
        }
    }
    return null;
}

function get_artigo_by_slug($slug) {
    foreach (get_artigos() as $art) {
        if ($art['slug'] === $slug) {
            return $art;
        }
    }
    return null;
}

// Retorna a URL do WhatsApp para solicitação de orçamento
function get_budget_url($produto, $variacao = null) {
    $number = '5512981039845'; // WhatsApp padrão das configurações
    $brand = get_marca_by_id($produto['marcaId'])['nome'];
    
    $msg = "Olá! Gostaria de falar com a equipe técnica da VoltchZ Brasil.\n\n";
    $msg .= "Tenho interesse no produto: *" . $produto['nome'] . "*\n";
    $msg .= "Marca: *" . $brand . "*\n";
    
    if ($variacao) {
        $msg .= "Variação Selecionada: *" . $variacao['nome'] . "*\n";
        if (isset($variacao['sku'])) {
            $msg .= "Código SKU: *" . $variacao['sku'] . "*\n";
        }
    }
    
    $msg .= "\nGostaria de solicitar um orçamento formal e tirar algumas dúvidas técnicas sobre o dimensionamento do meu projeto.";
    
    return "https://wa.me/" . $number . "?text=" . urlencode($msg);
}

// --- GERADOR DE HARDWARE TECHNICAL VECTOR SVGs INLINE (VERSÃO PHP) ---
function generate_technical_svg($category, $name = '', $brand = '') {
    $accent = '#22c55e'; // Verde VoltchZ
    $bg = '#0f0f15';
    $grid = 'rgba(240, 240, 244, 0.03)';
    $border = 'rgba(255, 255, 255, 0.08)';
    
    $content = '';
    
    if ($category === 'protecao') {
        $content = "
            <!-- Fundo técnico/grid -->
            <rect width=\"400\" height=\"300\" fill=\"{$bg}\" rx=\"16\" />
            <g stroke=\"{$grid}\" stroke-width=\"1.5\">
                <line x1=\"0\" y1=\"50\" x2=\"400\" y2=\"50\" />
                <line x1=\"0\" y1=\"100\" x2=\"400\" y2=\"100\" />
                <line x1=\"0\" y1=\"150\" x2=\"400\" y2=\"150\" />
                <line x1=\"0\" y1=\"200\" x2=\"400\" y2=\"200\" />
                <line x1=\"0\" y1=\"250\" x2=\"400\" y2=\"250\" />
                <line x1=\"80\" y1=\"0\" x2=\"80\" y2=\"300\" />
                <line x1=\"160\" y1=\"0\" x2=\"160\" y2=\"300\" />
                <line x1=\"240\" y1=\"0\" x2=\"240\" y2=\"300\" />
                <line x1=\"320\" y1=\"0\" x2=\"320\" y2=\"300\" />
            </g>
            
            <!-- Chassi do Quadro -->
            <rect x=\"110\" y=\"40\" width=\"180\" height=\"220\" rx=\"12\" fill=\"#181822\" stroke=\"{$border}\" stroke-width=\"2\" />
            <!-- Tampa Acrílica Fumê -->
            <rect x=\"125\" y=\"55\" width=\"150\" height=\"120\" rx=\"6\" fill=\"rgba(10,10,15,0.75)\" stroke=\"rgba(255,255,255,0.15)\" stroke-width=\"1\" />
            
            <!-- Componentes (Disjuntores) -->
            <g transform=\"translate(135, 70)\">
                <!-- Disjuntor Principal -->
                <rect x=\"0\" y=\"0\" width=\"35\" height=\"75\" rx=\"3\" fill=\"#2d2d3a\" stroke=\"rgba(255,255,255,0.1)\" />
                <rect x=\"5\" y=\"10\" width=\"25\" height=\"20\" fill=\"#111\" />
                <rect x=\"12\" y=\"45\" width=\"11\" height=\"18\" rx=\"2\" fill=\"{$accent}\" />
                <text x=\"17\" y=\"23\" fill=\"#fff\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\">32A</text>
                
                <!-- DR Classe A -->
                <rect x=\"42\" y=\"0\" width=\"45\" height=\"75\" rx=\"3\" fill=\"#2d2d3a\" stroke=\"rgba(255,255,255,0.1)\" />
                <rect x=\"7\" y=\"10\" width=\"31\" height=\"20\" fill=\"#111\" />
                <rect x=\"20\" y=\"45\" width=\"11\" height=\"18\" rx=\"2\" fill=\"{$accent}\" />
                <circle cx=\"11\" cy=\"54\" r=\"3\" fill=\"#ef4444\" /> <!-- Botão Teste -->
                <text x=\"22\" y=\"23\" fill=\"#fff\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\">DR-A</text>
                
                <!-- DPS -->
                <rect x=\"94\" y=\"0\" width=\"35\" height=\"75\" rx=\"3\" fill=\"#2d2d3a\" stroke=\"rgba(255,255,255,0.1)\" />
                <rect x=\"5\" y=\"10\" width=\"25\" height=\"20\" fill=\"#111\" />
                <rect x=\"7\" y=\"45\" width=\"21\" height=\"18\" rx=\"1\" fill=\"#ea580c\" />
                <text x=\"17\" y=\"23\" fill=\"#fff\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\">DPS</text>
            </g>

            <!-- Fecho e Dobradiças -->
            <rect x=\"290\" y=\"130\" width=\"4\" height=\"20\" rx=\"1\" fill=\"#fff\" opacity=\"0.3\" />
            
            <!-- Detalhes de Texto Técnico -->
            <text x=\"200\" y=\"205\" fill=\"{$accent}\" font-size=\"10\" font-family=\"monospace\" text-anchor=\"middle\" font-weight=\"bold\">QDC VOLTCHZ</text>
            <text x=\"200\" y=\"220\" fill=\"rgba(240,240,244,0.4)\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\">CERTIFIED PROTECT IP65</text>
            <path d=\"M 200,230 L 210,240 L 202,240 L 204,248 L 195,238 L 201,238 Z\" fill=\"{$accent}\" />
        ";
    } elseif ($category === 'estacoes') {
        $content = "
            <rect width=\"400\" height=\"300\" fill=\"{$bg}\" rx=\"16\" />
            <g stroke=\"{$grid}\" stroke-width=\"1.5\">
                <line x1=\"0\" y1=\"50\" x2=\"400\" y2=\"50\" />
                <line x1=\"0\" y1=\"100\" x2=\"400\" y2=\"100\" />
                <line x1=\"0\" y1=\"150\" x2=\"400\" y2=\"150\" />
                <line x1=\"0\" y1=\"200\" x2=\"400\" y2=\"200\" />
                <line x1=\"0\" y1=\"250\" x2=\"400\" y2=\"250\" />
                <line x1=\"80\" y1=\"0\" x2=\"80\" y2=\"300\" />
                <line x1=\"160\" y1=\"0\" x2=\"160\" y2=\"300\" />
                <line x1=\"240\" y1=\"0\" x2=\"240\" y2=\"300\" />
                <line x1=\"320\" y1=\"0\" x2=\"320\" y2=\"300\" />
            </g>
            
            <!-- Eletroposto Base -->
            <rect x=\"145\" y=\"40\" width=\"110\" height=\"220\" rx=\"20\" fill=\"#1c1c28\" stroke=\"{$border}\" stroke-width=\"2\" />
            
            <!-- Moldura Central Black Piano -->
            <rect x=\"155\" y=\"55\" width=\"90\" height=\"190\" rx=\"14\" fill=\"#0b0b10\" />
            
            <!-- Tela LCD Glow -->
            <rect x=\"170\" y=\"75\" width=\"60\" height=\"40\" rx=\"4\" fill=\"#131824\" stroke=\"rgba(34,197,94,0.3)\" stroke-width=\"1.5\" />
            <text x=\"200\" y=\"93\" fill=\"{$accent}\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\" font-weight=\"bold\">READY</text>
            <text x=\"200\" y=\"105\" fill=\"#60a5fa\" font-size=\"7\" font-family=\"monospace\" text-anchor=\"middle\">22.0 kW / 32A</text>
            
            <!-- Status LED Ring -->
            <circle cx=\"200\" cy=\"165\" r=\"28\" fill=\"none\" stroke=\"rgba(34,197,94,0.06)\" stroke-width=\"8\" />
            <circle cx=\"200\" cy=\"165\" r=\"28\" fill=\"none\" stroke=\"{$accent}\" stroke-width=\"2.5\" stroke-dasharray=\"140, 30\" />
            
            <!-- Lightning Bolt Icon inside LED ring -->
            <path d=\"M 200,152 L 208,165 L 202,165 L 204,178 L 192,165 L 198,165 Z\" fill=\"{$accent}\" />
            
            <!-- Plug/Cabo -->
            <rect x=\"190\" y=\"248\" width=\"20\" height=\"30\" rx=\"4\" fill=\"#2d2d3a\" />
            <line x1=\"200\" y1=\"260\" x2=\"200\" y2=\"290\" stroke=\"#111\" stroke-width=\"6\" stroke-linecap=\"round\" />
        ";
    } elseif ($category === 'portateis') {
        $content = "
            <rect width=\"400\" height=\"300\" fill=\"{$bg}\" rx=\"16\" />
            <g stroke=\"{$grid}\" stroke-width=\"1.5\">
                <line x1=\"0\" y1=\"50\" x2=\"400\" y2=\"50\" />
                <line x1=\"0\" y1=\"100\" x2=\"400\" y2=\"100\" />
                <line x1=\"0\" y1=\"150\" x2=\"400\" y2=\"150\" />
                <line x1=\"200\" y1=\"0\" x2=\"200\" y2=\"300\" />
            </g>
            
            <!-- Unidade EVSE Central -->
            <rect x=\"130\" y=\"80\" width=\"140\" height=\"70\" rx=\"18\" fill=\"#1f1f2e\" stroke=\"{$border}\" stroke-width=\"2\" />
            <rect x=\"145\" y=\"92\" width=\"110\" height=\"46\" rx=\"10\" fill=\"#08080c\" />
            
            <!-- Display Digital -->
            <text x=\"200\" y=\"112\" fill=\"{$accent}\" font-size=\"10\" font-family=\"monospace\" text-anchor=\"middle\" font-weight=\"bold\">16A MONO</text>
            <text x=\"200\" y=\"127\" fill=\"rgba(240,240,244,0.5)\" font-size=\"8\" font-family=\"monospace\" text-anchor=\"middle\">220V · 3.5kW</text>
            
            <!-- Cabos enrolados (Círculos decorativos) -->
            <path d=\"M 90,115 C 60,60 340,60 310,115 C 290,150 110,150 90,115 Z\" fill=\"none\" stroke=\"#2d2d3c\" stroke-width=\"6\" opacity=\"0.4\" />
            <path d=\"M 80,125 C 50,70 350,70 320,125\" fill=\"none\" stroke=\"#111\" stroke-width=\"7\" stroke-linecap=\"round\" />
            
            <!-- Conector Tipo 2 -->
            <g transform=\"translate(300, 150) rotate(30)\">
                <rect x=\"0\" y=\"0\" width=\"18\" height=\"40\" rx=\"4\" fill=\"#2d2d3a\" />
                <rect x=\"-3\" y=\"10\" width=\"24\" height=\"15\" rx=\"2\" fill=\"#111\" />
                <line x1=\"9\" y1=\"40\" x2=\"9\" y2=\"60\" stroke=\"#111\" stroke-width=\"4\" />
            </g>
        ";
    } elseif ($category === 'suportes') {
        $content = "
            <rect width=\"400\" height=\"300\" fill=\"{$bg}\" rx=\"16\" />
            <g stroke=\"{$grid}\" stroke-width=\"1.5\">
                <line x1=\"0\" y1=\"50\" x2=\"400\" y2=\"50\" />
                <line x1=\"0\" y1=\"100\" x2=\"400\" y2=\"100\" />
                <line x1=\"0\" y1=\"150\" x2=\"400\" y2=\"150\" />
                <line x1=\"200\" y1=\"0\" x2=\"200\" y2=\"300\" />
            </g>
            
            <!-- Chão / Concreto -->
            <rect x=\"80\" y=\"250\" width=\"240\" height=\"20\" rx=\"4\" fill=\"#334155\" />
            <line x1=\"50\" y1=\"270\" x2=\"350\" y2=\"270\" stroke=\"rgba(255,255,255,0.1)\" stroke-width=\"2\" />
            
            <!-- Totem Metálico -->
            <rect x=\"185\" y=\"60\" width=\"30\" height=\"190\" fill=\"#1e293b\" stroke=\"{$border}\" stroke-width=\"1.5\" />
            <rect x=\"175\" y=\"240\" width=\"50\" height=\"10\" rx=\"2\" fill=\"#0f172a\" />
            
            <!-- Parafusos da Base -->
            <circle cx=\"180\" cy=\"245\" r=\"2.5\" fill=\"#94a3b8\" />
            <circle cx=\"220\" cy=\"245\" r=\"2.5\" fill=\"#94a3b8\" />
            
            <!-- Cobertura Superior (Policarbonato) -->
            <path d=\"M 130,50 L 270,35 L 280,43 L 130,60 Z\" fill=\"rgba(34,197,94,0.3)\" stroke=\"{$accent}\" stroke-width=\"2\" />
            <line x1=\"130\" y1=\"50\" x2=\"185\" y2=\"60\" stroke=\"#000\" stroke-width=\"3\" />
            <line x1=\"270\" y1=\"35\" x2=\"215\" y2=\"60\" stroke=\"#000\" stroke-width=\"3\" />
            
            <!-- Wallbox Integrada no Totem -->
            <rect x=\"180\" y=\"100\" width=\"40\" height=\"60\" rx=\"8\" fill=\"#0b0f19\" stroke=\"{$border}\" />
            <circle cx=\"200\" cy=\"130\" r=\"10\" fill=\"none\" stroke=\"{$accent}\" stroke-width=\"1.5\" />
        ";
    } else {
        $content = "
            <rect width=\"400\" height=\"300\" fill=\"{$bg}\" rx=\"16\" />
            <circle cx=\"200\" cy=\"150\" r=\"40\" fill=\"none\" stroke=\"{$accent}\" stroke-width=\"2\" stroke-dasharray=\"10 5\" />
            <text x=\"200\" y=\"154\" fill=\"{$accent}\" font-size=\"14\" font-family=\"sans-serif\" text-anchor=\"middle\" font-weight=\"bold\">VOLTCHZ</text>
        ";
    }

    $brandName = strtoupper($name ?: 'VOLTCHZ INJECTED');
    $labelBrand = strtoupper($brand ?: 'PRODUCT CATALOG');

    return "
    <svg viewBox=\"0 0 400 300\" class=\"w-full h-full object-cover transition-transform duration-500 hover:scale-105\" xmlns=\"http://www.w3.org/2000/svg\">
        {$content}
        <!-- Overlay Industrial de Canto -->
        <g transform=\"translate(20, 20)\">
            <rect x=\"0\" y=\"0\" width=\"120\" height=\"18\" rx=\"4\" fill=\"rgba(0,0,0,0.4)\" stroke=\"rgba(255,255,255,0.08)\" stroke-width=\"1\" />
            <circle cx=\"8\" cy=\"9\" r=\"3.5\" fill=\"{$accent}\" />
            <text x=\"18\" y=\"12\" fill=\"rgba(240,240,244,0.8)\" font-size=\"7.5\" font-family=\"monospace\" font-weight=\"bold\">{$labelBrand}</text>
        </g>
    </svg>
    ";
}
