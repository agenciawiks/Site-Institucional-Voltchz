<?php
/**
 * VoltchZ Brasil - Conector de Banco de Dados PHP (PDO MySQL)
 * Serve os dados de forma estruturada a partir das tabelas relacionais do banco.
 */

// =====================================================================
// CONFIGURAÇÃO DO BANCO DE DADOS (Detecção Automática Local / Hostinger)
// =====================================================================
$is_local = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    if ($host === 'localhost' || $host === '127.0.0.1' || preg_match('/\.local$/', $host) || preg_match('/^192\.168\./', $host)) {
        $is_local = true;
    }
} else {
    $is_local = true; // Fallback para CLI local
}

if ($is_local) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'voltchz');
} else {
    // Tenta carregar as credenciais de produção de um arquivo separado.
    // Isso evita que suas credenciais sejam sobrescritas em cada upload de ZIP para a Hostinger.
    if (file_exists(__DIR__ . '/../db_config.php')) {
        require_once __DIR__ . '/../db_config.php';
    } elseif (file_exists(__DIR__ . '/db_config.php')) {
        require_once __DIR__ . '/db_config.php';
    } else {
        // Fallback de desenvolvimento (ajuste com os dados reais caso não utilize o db_config.php)
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'voltchz_db');
    }
}
define('DB_CHARSET', 'utf8mb4');


/**
 * Retorna uma instância do PDO conectada ao banco de dados.
 */
function get_db_connection() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        
        // Auto-migração da coluna imagem na tabela artigos se necessário
        try {
            $pdo->query("SELECT imagem FROM artigos LIMIT 1");
        } catch (Exception $e) {
            try {
                $pdo->exec("ALTER TABLE artigos ADD COLUMN imagem VARCHAR(255) NULL AFTER svg_metadata_subtitle");
            } catch (Exception $e2) {
                // Silencioso se der erro (ex: tabela ainda não criada)
            }
        }
        
        // Auto-migração da coluna tipo na tabela portfolio se necessário
        try {
            $pdo->query("SELECT tipo FROM portfolio LIMIT 1");
        } catch (Exception $e) {
            try {
                $pdo->exec("ALTER TABLE portfolio ADD COLUMN tipo VARCHAR(30) DEFAULT 'veiculo' AFTER id");
            } catch (Exception $e2) {
                // Silencioso se der erro (ex: tabela ainda não criada)
            }
        }

        // Auto-migração da coluna sort_order na tabela produtos se necessário
        try {
            $pdo->query("SELECT sort_order FROM produtos LIMIT 1");
        } catch (Exception $e) {
            try {
                $pdo->exec("ALTER TABLE produtos ADD COLUMN sort_order INT DEFAULT 0 AFTER imagem");
            } catch (Exception $e2) {
                // Silencioso se der erro (ex: tabela ainda não criada)
            }
        }
        
        // Inicializa as novas tabelas e dados padrão para o Admin
        try {
            init_voltchz_admin_tables($pdo);
        } catch (Exception $e) {
            // Silencioso se houver algum erro transitório
        }
    }
    return $pdo;
}

// --- FUNÇÕES UTILITÁRIAS ---

function get_marcas() {
    $db = get_db_connection();
    $stmt = $db->query("SELECT * FROM marcas");
    return $stmt->fetchAll();
}

function get_categorias() {
    $db = get_db_connection();
    $stmt = $db->query("SELECT * FROM categorias");
    return $stmt->fetchAll();
}

/**
 * Retorna todos os produtos formatados exatamente como o front-end espera.
 */
function get_produtos() {
    $db = get_db_connection();
    
    // Busca os produtos base
    $stmt = $db->query("SELECT id, slug, nome, marca_id AS marcaId, categoria_id AS categoriaId, potencia, tensao, aplicacao, tipo, resumo, descricao, imagem, sort_order FROM produtos ORDER BY sort_order ASC, id ASC");
    $produtos = $stmt->fetchAll();
    
    foreach ($produtos as &$prod) {
        $prodId = $prod['id'];
        
        // 1. Busca os diferenciais
        $stmtDif = $db->prepare("SELECT diferencial FROM produto_diferenciais WHERE produto_id = ? ORDER BY ordem ASC");
        $stmtDif->execute([$prodId]);
        $prod['diferenciais'] = $stmtDif->fetchAll(PDO::FETCH_COLUMN);
        
        // 2. Busca as especificações técnicas
        $stmtSpec = $db->prepare("SELECT chave, valor FROM produto_especificacoes WHERE produto_id = ? ORDER BY ordem ASC");
        $stmtSpec->execute([$prodId]);
        $specs = $stmtSpec->fetchAll();
        $prod['especificacoes'] = [];
        foreach ($specs as $s) {
            $prod['especificacoes'][$s['chave']] = $s['valor'];
        }
        
        // 3. Busca as variações (SKUs) - Desativado (produtos únicos)
        $prod['variacoes'] = [];
    }
    
    return $produtos;
}

/**
 * Retorna produtos filtrados por marca, categoria e termo de busca.
 */
function get_filtered_produtos($marca = 'todos', $categoria = 'todos', $busca = '') {
    $db = get_db_connection();
    $sql = "SELECT id, slug, nome, marca_id AS marcaId, categoria_id AS categoriaId, potencia, tensao, aplicacao, tipo, resumo, descricao, imagem, sort_order FROM produtos WHERE 1=1";
    $params = [];

    if ($marca !== 'todos') {
        $sql .= " AND marca_id = ?";
        $params[] = $marca;
    }

    if ($categoria !== 'todos') {
        $sql .= " AND categoria_id = ?";
        $params[] = $categoria;
    }

    if (!empty($busca)) {
        $sql .= " AND (nome LIKE ? OR resumo LIKE ? OR descricao LIKE ? OR potencia LIKE ?)";
        $searchVal = "%" . $busca . "%";
        $params[] = $searchVal;
        $params[] = $searchVal;
        $params[] = $searchVal;
        $params[] = $searchVal;
    }

    $sql .= " ORDER BY sort_order ASC, id ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll();

    foreach ($produtos as &$prod) {
        $prodId = $prod['id'];

        $stmtDif = $db->prepare("SELECT diferencial FROM produto_diferenciais WHERE produto_id = ? ORDER BY ordem ASC");
        $stmtDif->execute([$prodId]);
        $prod['diferenciais'] = $stmtDif->fetchAll(PDO::FETCH_COLUMN);

        $stmtSpec = $db->prepare("SELECT chave, valor FROM produto_especificacoes WHERE produto_id = ? ORDER BY ordem ASC");
        $stmtSpec->execute([$prodId]);
        $specs = $stmtSpec->fetchAll();
        $prod['especificacoes'] = [];
        foreach ($specs as $s) {
            $prod['especificacoes'][$s['chave']] = $s['valor'];
        }

        // Desativado (produtos únicos)
        $prod['variacoes'] = [];
    }

    return $produtos;
}

/**
 * Retorna artigos filtrados por categoria e termo de busca.
 */
function get_filtered_artigos($category = 'todos', $busca = '') {
    $db = get_db_connection();
    $sql = "SELECT id, slug, titulo, categoria, resumo, autor, cargo, data_publicacao AS data, tempo_leitura AS tempoLeitura, svg_metadata_category, svg_metadata_title, svg_metadata_subtitle, imagem FROM artigos WHERE 1=1";
    $params = [];

    if ($category !== 'todos') {
        $sql .= " AND categoria = ?";
        $params[] = $category;
    }

    if (!empty($busca)) {
        $sql .= " AND (titulo LIKE ? OR resumo LIKE ? OR autor LIKE ?)";
        $searchVal = "%" . $busca . "%";
        $params[] = $searchVal;
        $params[] = $searchVal;
        $params[] = $searchVal;
    }

    $sql .= " ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $artigos = $stmt->fetchAll();

    foreach ($artigos as &$art) {
        $artId = $art['id'];

        $art['svg_metadata'] = [
            'category' => $art['svg_metadata_category'],
            'title' => $art['svg_metadata_title'],
            'subtitle' => $art['svg_metadata_subtitle']
        ];
        unset($art['svg_metadata_category'], $art['svg_metadata_title'], $art['svg_metadata_subtitle']);

        $stmtCont = $db->prepare("SELECT id, tipo, texto, autor_citado FROM artigo_conteudo WHERE artigo_id = ? ORDER BY ordem ASC");
        $stmtCont->execute([$artId]);
        $blocos = $stmtCont->fetchAll();

        $art['conteudo'] = [];
        foreach ($blocos as $bloco) {
            $blocoData = ['type' => $bloco['tipo']];

            if ($bloco['tipo'] === 'blockquote') {
                $blocoData['text'] = $bloco['texto'];
                $blocoData['author'] = $bloco['autor_citado'];
            } elseif ($bloco['tipo'] === 'list') {
                $stmtList = $db->prepare("SELECT item FROM artigo_conteudo_list_items WHERE artigo_conteudo_id = ? ORDER BY ordem ASC");
                $stmtList->execute([$bloco['id']]);
                $blocoData['items'] = $stmtList->fetchAll(PDO::FETCH_COLUMN);
            } else {
                $blocoData['text'] = $bloco['texto'];
            }

            $art['conteudo'][] = $blocoData;
        }
    }

    return $artigos;
}


/**
 * Retorna todos os artigos formatados exatamente como o front-end espera.
 */
function get_artigos() {
    $db = get_db_connection();
    
    // Busca os artigos base
    $stmt = $db->query("SELECT id, slug, titulo, categoria, resumo, autor, cargo, data_publicacao AS data, tempo_leitura AS tempoLeitura, svg_metadata_category, svg_metadata_title, svg_metadata_subtitle, imagem FROM artigos ORDER BY id DESC");
    $artigos = $stmt->fetchAll();
    
    foreach ($artigos as &$art) {
        $artId = $art['id'];
        
        // Monta o svg_metadata esperado
        $art['svg_metadata'] = [
            'category' => $art['svg_metadata_category'],
            'title' => $art['svg_metadata_title'],
            'subtitle' => $art['svg_metadata_subtitle']
        ];
        unset($art['svg_metadata_category'], $art['svg_metadata_title'], $art['svg_metadata_subtitle']);
        
        // Busca os blocos de conteúdo do artigo
        $stmtCont = $db->prepare("SELECT id, tipo, texto, autor_citado FROM artigo_conteudo WHERE artigo_id = ? ORDER BY ordem ASC");
        $stmtCont->execute([$artId]);
        $blocos = $stmtCont->fetchAll();
        
        $art['conteudo'] = [];
        foreach ($blocos as $bloco) {
            $blocoData = [
                'type' => $bloco['tipo']
            ];
            
            if ($bloco['tipo'] === 'blockquote') {
                $blocoData['text'] = $bloco['texto'];
                $blocoData['author'] = $bloco['autor_citado'];
            } elseif ($bloco['tipo'] === 'list') {
                // Busca os itens da lista
                $stmtList = $db->prepare("SELECT item FROM artigo_conteudo_list_items WHERE artigo_conteudo_id = ? ORDER BY ordem ASC");
                $stmtList->execute([$bloco['id']]);
                $blocoData['items'] = $stmtList->fetchAll(PDO::FETCH_COLUMN);
            } else {
                $blocoData['text'] = $bloco['texto'];
            }
            
            $art['conteudo'][] = $blocoData;
        }
    }
    
    return $artigos;
}

function get_marca_by_id($id) {
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT * FROM marcas WHERE id = ?");
    $stmt->execute([$id]);
    $marca = $stmt->fetch();
    return $marca ? $marca : ['nome' => 'Institucional', 'descricao' => 'VoltchZ Brasil'];
}

function get_categoria_by_id($id) {
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT * FROM categorias WHERE id = ?");
    $stmt->execute([$id]);
    $cat = $stmt->fetch();
    return $cat ? $cat : ['nome' => 'Geral', 'descricao' => ''];
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

function get_artigo_imagem($slug) {
    $mapping = [
        'independencia-energetica-energia-solar-e-carregadores-evs' => 'solar panel electric car.webp',
        'economia-de-tempo-e-dinheiro-tco-dos-veiculos-eletricos' => 'electric car cost savings.webp',
        'conconveniencia-carregamento-residencial-comercial' => 'ev charging hotel parking.webp',
        'segundo-a-abve-numeros-indicam-transformacao-mercado-veiculos-eletrificados' => 'electric vehicle market.webp',
        'seguranca-e-controle-gestao-de-frotas-comerciais' => 'fleet electric vehicles.webp',
        'a-escolha-do-cabo-certo-na-instalacao-de-carregadores-para-veiculos-eletricos' => 'electrical cable installation.webp',
        'a-importancia-do-disjuntor-certo-na-protecao-de-instalacoes-eletricas' => 'circuit breaker panel.webp',
        'a-escolha-certa-carregador-tipo-a-ac-ou-b-para-carros-eletricos' => 'electrical safety protection.webp',
        'lei-18403-carregadores-veiculos-eletricos-condominios' => 'apartment parking charging.webp',

        // Slugs alternativos/antigos salvos no banco de dados
        'lei-no-18403-o-que-muda-na-instalacao-de-carregadores-de-veiculos-eletricos-em-condominios' => 'apartment parking charging.webp',
        'disjuntor-corretamente-dimensionado' => 'circuit breaker panel.webp',
        'escolha-do-cabo-certo-na-instalacao-de-carregadores-para-veiculos-eletricos' => 'electrical cable installation.webp',
        'seguranca-e-controle' => 'fleet electric vehicles.webp',
        'segundo-a-abve-os-numeros-de-2023-indicam-uma-transformacao-no-mercado-de-veiculos-eletrificados-no-brasil' => 'electric vehicle market.webp',
        'conveniencia' => 'ev charging hotel parking.webp',
        'httpswwwinstagramcompc23mx5ytteigsheg1wcwe2b2jzc2dn' => 'electric car cost savings.webp',
        'httpswwwinstagramcompc23nitktip6igshmwm5mwq5amvtzm9ndg' => 'solar panel electric car.webp',
    ];

    if (isset($mapping[$slug])) {
        return 'static/blogs/' . $mapping[$slug];
    }
    return 'static/logo.webp';
}

// Retorna a URL do WhatsApp para solicitação de orçamento
function get_budget_url($produto, $variacao = null) {
    $whatsapp_link = get_config('whatsapp_link', 'https://wa.me/5512981039845');
    $number = '5512981039845';
    if (!empty($whatsapp_link)) {
        if (preg_match('/(?:wa\.me|api\.whatsapp\.com\/send\?phone=)(\d+)/', $whatsapp_link, $matches)) {
            $number = $matches[1];
        } elseif (preg_match('/^\+?\d+$/', preg_replace('/[\s\-\(\)]/', '', $whatsapp_link))) {
            $number = preg_replace('/[^\d]/', '', $whatsapp_link);
        }
    }
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

// =====================================================================
// SISTEMA ADMINISTRATIVO - INICIALIZADOR E HELPERS DE CONTEÚDO DINÂMICO
// =====================================================================

/**
 * Inicializa a estrutura de tabelas do painel admin VoltchZ e popula com dados iniciais
 */
function init_voltchz_admin_tables($pdo) {
    // 1. Tabela configuracoes
    $pdo->exec("CREATE TABLE IF NOT EXISTS `configuracoes` (
        `chave` VARCHAR(100) PRIMARY KEY,
        `valor` TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed configuracoes se vazia
    $countConfig = $pdo->query("SELECT COUNT(*) FROM configuracoes")->fetchColumn();
    if ($countConfig == 0) {
        $configs = [
            'email_contato' => 'contato@voltchz.com.br',
            'telefone_comercial' => '(12) 98103-9845',
            'whatsapp_link' => 'https://wa.me/5512981039845',
            'telefone_0800' => '0800 444 1044',
            'whatsapp_suporte' => '(800) 444 1044',
            'horario_suporte' => 'Seg a Sex - 8h às 22h',
            'endereco' => 'Rua João Teixeira Netto, 72 - Jardim Aquarius, SJC - SP',
            'instagram' => 'https://www.instagram.com/voltchz',
            'linkedin' => 'https://www.linkedin.com/company/voltchz/'
        ];
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES (?, ?)");
        foreach ($configs as $k => $v) {
            $stmt->execute([$k, $v]);
        }
    }

    // 2. Tabela portfolio
    $pdo->exec("CREATE TABLE IF NOT EXISTS `portfolio` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `tipo` VARCHAR(30) DEFAULT 'veiculo',
        `brand` VARCHAR(50) NOT NULL,
        `model` VARCHAR(100) NOT NULL,
        `location` VARCHAR(150) NOT NULL,
        `description` TEXT NOT NULL,
        `image` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed portfolio se vazia
    $countPortfolio = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();
    if ($countPortfolio == 0) {
        $portfolio_items = [
            ['veiculo', 'byd', 'BYD Dolphin', 'Condomínio Alphaville, São José dos Campos', 'Instalação de Wallbox de 7.4 kW com Quadro de Proteção E-Wolf e infraestrutura dedicada.', 'static/clientes/cliente-5.webp'],
            ['veiculo', 'byd', 'BYD Song Plus', 'Residencial Jardim Aquarius, SJC', 'Recarga inteligente AC com balanceamento local de carga e proteção contra surtos.', 'static/clientes/cliente-12.webp'],
            ['veiculo', 'byd', 'BYD Seal', 'Condomínio Urbanova, SJC', 'Instalação de carregador de alta performance de 22 kW trifásico E-Wolf.', 'static/clientes/cliente-20.webp'],
            ['veiculo', 'gwm', 'GWM Ora 03', 'Condomínio Esplanada, SJC', 'Infraestrutura executada com cabeamento blindado de alta bitola e proteção DR Tipo A.', 'static/clientes/cliente-11.webp'],
            ['veiculo', 'gwm', 'GWM Haval H6', 'Taubaté, SP', 'Quadro de proteção E-Wolf 7.2 kW instalado integrado com Wallbox original GWM.', 'static/clientes/cliente-15.webp'],
            ['veiculo', 'volvo', 'Volvo XC40 Recharge', 'Condomínio Bosque Imperial, SJC', 'Recarga rápida e segura de 11 kW com dispositivo DR Tipo A de segurança e aterramento dedicado.', 'static/clientes/cliente-25.webp'],
            ['veiculo', 'volvo', 'Volvo EX30', 'Residencial Altos da Serra, SJC', 'Compacto e eficiente, carregador instalado em pedestal de alumínio VoltchZ.', 'static/clientes/cliente-32.webp'],
            ['veiculo', 'geely', 'Zeekr 001 (Geely Group)', 'Condomínio Quinta das Flores, SJC', 'Instalação homologada premium para o esportivo da Zeekr, utilizando quadro trifásico E-Wolf.', 'static/clientes/cliente-40.webp'],
            ['veiculo', 'geely', 'Volvo C40 (Geely Group)', 'Alphaville Industrial, Barueri', 'Instalação de carregamento integrado ao sistema de automação residencial e geração solar.', 'static/clientes/cliente-46.webp'],
            ['veiculo', 'geely', 'Zeekr X (Geely Group)', 'São Paulo, SP', 'Carregador Wallbox inteligente de 22 kW com leitor NFC e cabeamento embutido.', 'static/clientes/cliente-55.webp'],
            ['veiculo', 'porsche', 'Porsche Taycan', 'Condomínio Mônaco, Jacareí', 'Instalação trifásica premium de 22 kW com dupla proteção de aterramento e DPS classe II.', 'static/clientes/cliente-10.webp'],
            ['veiculo', 'tesla', 'Tesla Model Y', 'Jardim das Colinas, SJC', 'Carregador original Tesla Wall Connector integrado com proteção avançada E-Wolf.', 'static/clientes/cliente-2.webp'],
            ['veiculo', 'bmw', 'BMW iX', 'Valinhos, SP', 'Recarga trifásica de alta potência, com quadro de segurança tetrapolar e DR Tipo A.', 'static/clientes/cliente-18.webp'],
            ['veiculo', 'audi', 'Audi e-tron', 'Jardim Aquarius, SJC', 'Infraestrutura completa de recarga rápida instalada em vaga privativa de condomínio vertical.', 'static/clientes/cliente-30.webp'],
            ['condominio', 'condominio', 'Infraestrutura Coletiva', 'Condomínio Aquarius, SJC', 'Instalação de barramento blindado e quadros de medição individualizada para 20 vagas de garagem.', 'static/carregador-predio-estacionamento.webp'],
            ['condominio', 'condominio', 'Adequação Elétrica Coletiva', 'Edifício Esplanada, SJC', 'Projeto executivo e instalação de proteção contra incêndio e DPS tetrapolar para recarga coletiva.', 'static/carregador-predio-estacionamento2.webp']
        ];
        $stmt = $pdo->prepare("INSERT INTO portfolio (tipo, brand, model, location, description, image) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($portfolio_items as $item) {
            $stmt->execute($item);
        }
    }

    // 3. Tabela banners
    $pdo->exec("CREATE TABLE IF NOT EXISTS `banners` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `image` VARCHAR(255) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `subtitle` VARCHAR(255) NOT NULL,
        `button_text` VARCHAR(100) NOT NULL,
        `button_link` VARCHAR(255) NOT NULL,
        `sort_order` INT DEFAULT 0,
        `active` TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed banners se vazia
    $countBanners = $pdo->query("SELECT COUNT(*) FROM banners")->fetchColumn();
    if ($countBanners == 0) {
        $banners = [
            ['static/banner-rotativo-01webp.webp', 'Energia para o futuro, segurança no agora', 'A VoltchZ entrega a infraestrutura completa de carregamento elétrico com rigor técnico e suporte de engenharia.', 'Solicitar Orçamento', 'https://wa.me/5512981039845', 1, 1],
            ['static/banner-rotativo-02.webp', 'Infraestrutura para frotas e condomínios', 'Gestão balanceada de carga e telemetria para empreendimentos de grande porte.', 'Falar com Engenheiro', 'https://wa.me/5512981039845', 2, 1],
            ['static/banner-rotativo-03.webp', 'Projetos elétricos com engenharia, normas e segurança.', 'Nossas instalações seguem todas as normas técnicas (NBR 5410, 17019 e IEC 61851-1), para você carregar seu veículo com total confiança.', 'Solicitar Orçamento', 'https://wa.me/5512981039845', 3, 1],
            ['static/banner-rotativo-04.webp', 'Estruture seu negócio com recarga de alta performance', 'Projetamos infraestrutura rápida e escalável para redes comerciais, eletropostos e operações corporativas, com inteligência de carga, gestão contínua e experiência premium para seus clientes.', 'Planejar Estação Comercial', 'contato', 4, 1],
            ['static/banner-solar.webp', 'Energia Solar Inteligente', 'Integre geração própria de energia solar ao seu carregamento de veículo elétrico para máxima economia.', 'Simular Economia', 'https://wa.me/5512981039845', 5, 1],
            ['static/banner-intelbras.webp', 'Carregadores Intelbras Homologados', 'Linha completa de carregadores Intelbras instalada com a garantia técnica da VoltchZ.', 'Ver Modelos Intelbras', 'https://wa.me/5512981039845', 6, 1],
            ['static/banner-app.webp', 'Aplicativo VoltchZ App', 'Controle e gerencie suas recargas, consumo e telemetria na palma da mão.', 'Conhecer o App', 'https://wa.me/5512981039845', 7, 1],
            ['static/banner-spda.webp', 'Projeto e Inspeção de SPDA', 'Engenharia antes da instalação. Segurança durante toda a operação. A VoltchZ avalia SPDA, aterramento, capacidade elétrica, proteções e conformidade normativa antes da implantação da infraestrutura de recarga. Mais segurança para o condomínio, moradores e equipamentos.', 'Agendar Diagnóstico Técnico', 'https://wa.me/5512981039845', 8, 1]
        ];
        $stmt = $pdo->prepare("INSERT INTO banners (image, title, subtitle, button_text, button_link, sort_order, active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($banners as $b) {
            $stmt->execute($b);
        }
    } else {
        // Garantir que os novos banners sejam inseridos caso a tabela já tenha sido criada com os 4 antigos
        $novosBanners = [
            ['static/banner-solar.webp', 'Energia Solar Inteligente', 'Integre geração própria de energia solar ao seu carregamento de veículo elétrico para máxima economia.', 'Simular Economia', 'https://wa.me/5512981039845', 5, 1],
            ['static/banner-intelbras.webp', 'Carregadores Intelbras Homologados', 'Linha completa de carregadores Intelbras instalada com a garantia técnica da VoltchZ.', 'Ver Modelos Intelbras', 'https://wa.me/5512981039845', 6, 1],
            ['static/banner-app.webp', 'Aplicativo VoltchZ App', 'Controle e gerencie suas recargas, consumo e telemetria na palma da mão.', 'Conhecer o App', 'https://wa.me/5512981039845', 7, 1],
            ['static/banner-spda.webp', 'Projeto e Inspeção de SPDA', 'Engenharia antes da instalação. Segurança durante toda a operação. A VoltchZ avalia SPDA, aterramento, capacidade elétrica, proteções e conformidade normativa antes da implantação da infraestrutura de recarga. Mais segurança para o condomínio, moradores e equipamentos.', 'Agendar Diagnóstico Técnico', 'https://wa.me/5512981039845', 8, 1]
        ];
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM banners WHERE title = ?");
        $stmtInsert = $pdo->prepare("INSERT INTO banners (image, title, subtitle, button_text, button_link, sort_order, active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($novosBanners as $nb) {
            $stmtCheck->execute([$nb[1]]);
            if ($stmtCheck->fetchColumn() == 0) {
                $stmtInsert->execute($nb);
            }
        }
    }

    // 4. Tabela depoimentos
    $pdo->exec("CREATE TABLE IF NOT EXISTS `depoimentos` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(150) NOT NULL,
        `role_condo` VARCHAR(255) NOT NULL,
        `testimonial` TEXT NOT NULL,
        `image_avatar` VARCHAR(255) NULL,
        `active` TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed depoimentos se vazia
    $countDepoimentos = $pdo->query("SELECT COUNT(*) FROM depoimentos")->fetchColumn();
    if ($countDepoimentos == 0) {
        $depoimentos = [
            ['Thiago L.', 'Síndico do Condomínio Esplanada', 'A equipe da VoltchZ executou o projeto de infraestrutura de recarga do nosso condomínio de forma exemplar. Engenharia de ponta, documentação em dia e segurança total.', NULL, 1],
            ['Marcelo G.', 'CEO da LogiExpress', 'Instalamos 4 carregadores rápidos para a nossa frota corporativa. O sistema de balanceamento de carga superou as expectativas, otimizando nossos custos operacionais.', NULL, 1]
        ];
        $stmt = $pdo->prepare("INSERT INTO depoimentos (name, role_condo, testimonial, image_avatar, active) VALUES (?, ?, ?, ?, ?)");
        foreach ($depoimentos as $d) {
            $stmt->execute($d);
        }
    }

    // 5. Tabela faq
    $pdo->exec("CREATE TABLE IF NOT EXISTS `faq` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `question` VARCHAR(255) NOT NULL,
        `answer` TEXT NOT NULL,
        `sort_order` INT DEFAULT 0,
        `active` TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed faq se vazia
    $countFaq = $pdo->query("SELECT COUNT(*) FROM faq")->fetchColumn();
    if ($countFaq == 0) {
        $faqs = [
            ['1. Qual a potência ideal de carregador para uso residencial?', 'A maioria dos usuários utiliza carregadores a partir de 7 kW, que já oferecem boa velocidade. Em alguns casos, é possível usar 11 kW ou 22 kW, dependendo do veículo e da estrutura elétrica disponível.', 1, 1],
            ['2. Qual o impacto do carregador na conta de energia?', 'O impacto depende da potência do carregador e da frequência de uso. Em condomínios, é possível fazer medição individualizada para que cada usuário pague apenas o que consome de forma justa.', 2, 1],
            ['3. Posso usar a tomada comum da garagem para carregar?', 'Até é possível, mas não é recomendado. Tomadas comuns não suportam uso contínuo de alta carga, o que pode causar aquecimento e riscos. O ideal é um carregador dedicado (Wallbox).', 3, 1],
            ['4. Quais normas técnicas preciso atender na instalação?', 'As principais são: NBR 17019, NBR 5410, NBR IEC 61851-1 e normas de segurança contra incêndio do Corpo de Bombeiros. Segui-las garante uma instalação segura e adequada.', 4, 1],
            ['5. Qual a diferença entre carregador portátil e fixo?', 'O portátil é indicado para emergências ou uso ocasional, com menor potência. Já o Wallbox é fixo, mais seguro e oferece maior desempenho para o carregamento diário.', 5, 1],
            ['6. O que acontece se eu não seguir as normas técnicas?', 'Pode gerar riscos como choques elétricos, incêndios e até perda de garantia do veículo ou equipamento. Seguir as normas é essencial para a segurança e durabilidade.', 6, 1],
            ['7. Preciso de autorização para instalar no condomínio?', 'Sim. Normalmente é necessário comunicar o síndico e, em alguns casos, aprovação em assembleia, além de um estudo da capacidade elétrica do local.', 7, 1],
            ['8. Posso instalar um carregador rápido DC no condomínio?', 'Sim, mas exige infraestrutura elétrica robusta (geralmente 380V trifásico), além de um projeto técnico específico de engenharia.', 8, 1],
            ['9. O carregador pode ser compartilhado no condomínio?', 'Sim. É uma solução econômica, desde que haja controle de consumo e gestão adequada para garantir a divisão justa da energia entre os moradores.', 9, 1],
            ['10. Preciso contratar apenas empresas da montadora?', 'Não. O mais importante é que a instalação siga as normas técnicas. Isso garante segurança, independentemente da empresa ou marca do carregador.', 10, 1]
        ];
        $stmt = $pdo->prepare("INSERT INTO faq (question, answer, sort_order, active) VALUES (?, ?, ?, ?)");
        foreach ($faqs as $f) {
            $stmt->execute($f);
        }
    }
}

/**
 * Retorna todas as configurações como array associativo
 */
function get_configs() {
    static $cached_config = null;
    if ($cached_config !== null) {
        return $cached_config;
    }
    try {
        $db = get_db_connection();
        $stmt = $db->query("SELECT chave, valor FROM configuracoes");
        $rows = $stmt->fetchAll();
        $cached_config = [];
        foreach ($rows as $r) {
            $cached_config[$r['chave']] = $r['valor'];
        }
        return $cached_config;
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Puxa um valor específico de configuração
 */
function get_config($chave, $default = '') {
    $configs = get_configs();
    return isset($configs[$chave]) ? $configs[$chave] : $default;
}

/**
 * Salva ou atualiza uma configuração
 */
function save_config($chave, $valor) {
    try {
        $db = get_db_connection();
        $stmt = $db->prepare("INSERT INTO configuracoes (chave, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor = ?");
        return $stmt->execute([$chave, $valor, $valor]);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Puxa itens de portfólio dinâmico
 */
function get_portfolio_items() {
    try {
        $db = get_db_connection();
        $stmt = $db->query("SELECT * FROM portfolio ORDER BY id DESC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Puxa um item de portfólio específico
 */
function get_portfolio_item($id) {
    try {
        $db = get_db_connection();
        $stmt = $db->prepare("SELECT * FROM portfolio WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Retorna a lista de perguntas frequentes (FAQ)
 */
function get_faq($only_active = true) {
    try {
        $db = get_db_connection();
        $sql = "SELECT * FROM faq";
        if ($only_active) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        return $db->query($sql)->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Retorna os slides de banners ativos
 */
function get_banners($only_active = true) {
    try {
        $db = get_db_connection();
        $sql = "SELECT * FROM banners";
        if ($only_active) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        return $db->query($sql)->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Retorna os depoimentos de clientes
 */
function get_depoimentos($only_active = true) {
    try {
        $db = get_db_connection();
        $sql = "SELECT * FROM depoimentos";
        if ($only_active) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY id DESC";
        return $db->query($sql)->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

