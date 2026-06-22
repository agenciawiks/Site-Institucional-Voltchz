<?php
/**
 * VoltchZ Brasil - Script Utilitário Temporário de Atualização dos Slugs e Títulos do Blog + Imagens de Quadros
 * IMPORTANTE: Após executar este arquivo no servidor, delete-o por segurança.
 */

// Define as credenciais do banco usando a conexão oficial do site
require_once __DIR__ . '/../includes/db.php';

try {
    $db = get_db_connection();
    
    // Array de mapeamento de IDs para novos Slugs e Títulos do Blog
    $updates = [
        1 => [
            'slug' => 'lei-no-18403-o-que-muda-na-instalacao-de-carregadores-de-veiculos-eletricos-em-condominios',
            'titulo' => 'Lei nº 18.403: o que muda na instalação de carregadores de veículos elétricos em condomínios'
        ],
        2 => [
            'slug' => 'carregador-tipo-a-ac-ou-b-para-carros-eletricos',
            'titulo' => 'Carregador Tipo A, AC ou B para Carros Elétricos'
        ],
        3 => [
            'slug' => 'disjuntor-corretamente-dimensionado',
            'titulo' => 'Disjuntor Corretamente Dimensionado'
        ],
        4 => [
            'slug' => 'escolha-do-cabo-certo-na-instalacao-de-carregadores-para-veiculos-eletricos',
            'titulo' => 'Escolha do Cabo Certo na Instalação de Carregadores para Veículos Elétricos'
        ],
        5 => [
            'slug' => 'seguranca-e-controle',
            'titulo' => 'Segurança e Controle'
        ],
        6 => [
            'slug' => 'segundo-a-abve-os-numeros-de-2023-indicam-uma-transformacao-no-mercado-de-veiculos-eletrificados-no-brasil',
            'titulo' => 'Segundo a ABVE, os números de 2023 indicam uma transformação no mercado de veículos eletrificados no Brasil'
        ],
        7 => [
            'slug' => 'conveniencia',
            'titulo' => 'Conveniência'
        ],
        8 => [
            'slug' => 'httpswwwinstagramcompc23mx5ytteigsheg1wcwe2b2jzc2dn',
            'titulo' => 'Economia de Tempo e Dinheiro | VoltchZ Brasil'
        ],
        9 => [
            'slug' => 'httpswwwinstagramcompc23nitktip6igshmwm5mwq5amvtzm9ndg',
            'titulo' => 'Independência Energética | VoltchZ Brasil'
        ],
    ];

    echo "<html><head><title>Atualização do Banco VoltchZ</title></head><body style='font-family: sans-serif; padding: 20px; line-height: 1.6;'>";
    echo "<h2>1. Atualizando Slugs e Títulos do Blog no Banco de Dados...</h2><hr>";
    
    foreach ($updates as $id => $data) {
        $stmt = $db->prepare("UPDATE artigos SET slug = ?, titulo = ? WHERE id = ?");
        $stmt->execute([$data['slug'], $data['titulo'], $id]);
        echo "Artigo ID <b>{$id}</b> atualizado:<br>";
        echo " - Título: <b>{$data['titulo']}</b><br>";
        echo " - Slug: <code>{$data['slug']}</code><br><br>";
    }
    
    echo "<h2>2. Atualizando Imagens dos Quadros de Proteção (Com Tomada)...</h2><hr>";
    
    // Atualizar quadros que usam tomada industrial para as novas fotos exclusivas
    $quadros_updates = [
        39 => 'static/produtos/ewolf-quadro-protecao-7kw-com-tomada.webp', // Mono/Bif Com Tomada
        41 => 'static/produtos/ewolf-quadro-protecao-7kw-com-tomada.webp', // Trifásico Com Tomada
    ];
    
    foreach ($quadros_updates as $id => $img_path) {
        $stmt = $db->prepare("UPDATE produtos SET imagem = ? WHERE id = ?");
        $stmt->execute([$img_path, $id]);
        echo "Produto ID <b>{$id}</b> imagem atualizada para: <code>{$img_path}</code><br>";
    }
    
    echo "<hr><h3 style='color: green;'>[OK] Todas as atualizações foram aplicadas com sucesso no banco de dados!</h3>";
    echo "<p style='color: red;'><b>ATENÇÃO: Delete este arquivo da sua pasta 'scratch' agora por segurança!</b></p>";
    echo "</body></html>";
    
} catch (Exception $e) {
    echo "<b style='color:red;'>Erro ao atualizar banco de dados: " . $e->getMessage() . "</b>";
}
