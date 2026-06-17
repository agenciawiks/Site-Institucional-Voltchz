<?php
/**
 * VoltchZ Brasil - Script de Migração de Banco de Dados
 * Divide o "Quadro de Proteção E-Wolf 7.2 kW" (ID 1) em 4 produtos distintos:
 * - ID 1: Monofásico/Bifásico, Sem tomada industrial
 * - ID 39: Monofásico/Bifásico, Com tomada industrial
 * - ID 40: Trifásico, Sem tomada industrial
 * - ID 41: Trifásico, Com tomada industrial
 */

require_once __DIR__ . '/../includes/db.php';

try {
    $db = get_db_connection();
    $db->beginTransaction();

    // 1. Limpar registros antigos associados ao ID 1
    $db->prepare("DELETE FROM produto_variacoes WHERE produto_id = 1")->execute();
    $db->prepare("DELETE FROM produto_especificacoes WHERE produto_id = 1")->execute();
    $db->prepare("DELETE FROM produto_diferenciais WHERE produto_id = 1")->execute();
    $db->prepare("DELETE FROM produtos WHERE id = 1")->execute();
    
    // Garantir que os novos IDs também não conflitem (limpando-os se já existirem)
    $db->prepare("DELETE FROM produto_variacoes WHERE produto_id IN (39, 40, 41)")->execute();
    $db->prepare("DELETE FROM produto_especificacoes WHERE produto_id IN (39, 40, 41)")->execute();
    $db->prepare("DELETE FROM produto_diferenciais WHERE produto_id IN (39, 40, 41)")->execute();
    $db->prepare("DELETE FROM produtos WHERE id IN (39, 40, 41)")->execute();

    // 2. Inserir os 4 produtos na tabela 'produtos'
    $produtos = [
        [
            1, 
            'quadro-protecao-ewolf-7-2kw-mono-bif-sem-tomada', 
            'Quadro de Proteção E-Wolf 7.2 kW (Monofásico/Bifásico - Sem Tomada)', 
            'ewolf', 'protecao', '7,2 kW (32A)', '220VAC (Monofásico / Bifásico)', 
            'Residencial e Comercial Leve', 'Quadro de Segurança Bipolar', 
            'Proteção de segurança essencial para o carregamento do seu carro em residências. Equipado com DR Classe A e DPS de alta performance.', 
            'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco.', 
            'static/produtos/ewolf-quadro-protecao-7kw.webp'
        ],
        [
            39, 
            'quadro-protecao-ewolf-7-2kw-mono-bif-com-tomada', 
            'Quadro de Proteção E-Wolf 7.2 kW (Monofásico/Bifásico - Com Tomada)', 
            'ewolf', 'protecao', '7,2 kW (32A)', '220VAC (Monofásico / Bifásico)', 
            'Residencial e Comercial Leve', 'Quadro de Segurança Bipolar (com Tomada)', 
            'Proteção de segurança essencial equipada com tomada industrial azul de 32A 2P+T acoplada de alta performance.', 
            'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco. Apresenta saída com tomada industrial padrão NBR IEC 60309.', 
            'static/produtos/ewolf-quadro-protecao-7kw.webp'
        ],
        [
            40, 
            'quadro-protecao-ewolf-7-2kw-trifasico-sem-tomada', 
            'Quadro de Proteção E-Wolf 7.2 kW (Trifásico - Sem Tomada)', 
            'ewolf', 'protecao', '7,2 kW (Trifásico)', '380VAC (Trifásico com Neutro)', 
            'Residencial e Comercial Leve', 'Quadro de Segurança Tetrapolar', 
            'Proteção trifásica inteligente e compacta de alta performance, equipada com DR Classe A e DPS de alta performance.', 
            'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW (Trifásico) atua como um escudo entre a rede elétrica trifásica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco.', 
            'static/produtos/ewolf-quadro-protecao-7kw.webp'
        ],
        [
            41, 
            'quadro-protecao-ewolf-7-2kw-trifasico-com-tomada', 
            'Quadro de Proteção E-Wolf 7.2 kW (Trifásico - Com Tomada)', 
            'ewolf', 'protecao', '7,2 kW (Trifásico)', '380VAC (Trifásico com Neutro)', 
            'Residencial e Comercial Leve', 'Quadro de Segurança Tetrapolar (com Tomada)', 
            'Proteção trifásica inteligente de alta performance equipada com tomada industrial vermelha de alta potência acoplada.', 
            'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW (Trifásico) atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco. Apresenta tomada vermelha trifásica padrão IEC 60309.', 
            'static/produtos/ewolf-quadro-protecao-7kw.webp'
        ]
    ];

    $stmtProd = $db->prepare("INSERT INTO produtos (id, slug, nome, marca_id, categoria_id, potencia, tensao, aplicacao, tipo, resumo, descricao, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($produtos as $p) {
        $stmtProd->execute($p);
        echo "Produto criado: {$p[2]}\n";
    }

    // 3. Inserir Diferenciais (os mesmos para todos os 4 modelos)
    $diferenciais = [
        'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)',
        'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d\'água',
        'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados',
        'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento'
    ];

    $stmtDif = $db->prepare("INSERT INTO produto_diferenciais (produto_id, diferencial, ordem) VALUES (?, ?, ?)");
    foreach ([1, 39, 40, 41] as $prod_id) {
        foreach ($diferenciais as $ordem => $dif) {
            $stmtDif->execute([$prod_id, $dif, $ordem]);
        }
    }
    echo "Diferenciais inseridos.\n";

    // 4. Inserir Especificações Técnicas individualizadas
    $stmtSpec = $db->prepare("INSERT INTO produto_especificacoes (produto_id, chave, valor, ordem) VALUES (?, ?, ?, ?)");
    
    // ID 1: Monofásico/Bifásico Sem Tomada
    $specs1 = [
        ['Potência Nominal', '7,2 kW (32A)', 0],
        ['Tensão Operacional', '220VAC (Monofásico F+N ou Bifásico F+F)', 1],
        ['Disjuntor', 'Bipolar 32A Curva C (6kA)', 2],
        ['Interruptor DR', 'Bipolar 40A / 30mA Classe A', 3],
        ['DPS Surto', 'Bipolar 20/40kA 275V Classe II', 4],
        ['Grau de Vedação', 'IP65 (Instalação interna ou externa)', 5],
        ['Saída de Energia', 'Prensa-cabo direto nos bornes internos', 6]
    ];
    foreach ($specs1 as $ordem => $spec) {
        $stmtSpec->execute([1, $spec[0], $spec[1], $ordem]);
    }

    // ID 39: Monofásico/Bifásico Com Tomada
    $specs39 = [
        ['Potência Nominal', '7,2 kW (32A)', 0],
        ['Tensão Operacional', '220VAC (Monofásico F+N ou Bifásico F+F)', 1],
        ['Disjuntor', 'Bipolar 32A Curva C (6kA)', 2],
        ['Interruptor DR', 'Bipolar 40A / 30mA Classe A', 3],
        ['DPS Surto', 'Bipolar 20/40kA 275V Classe II', 4],
        ['Grau de Vedação', 'IP65 (Gabinete) / IP44 (Tomada acoplada)', 5],
        ['Saída de Energia', 'Tomada Industrial Azul 32A 2P+T padrão IEC 60309', 6]
    ];
    foreach ($specs39 as $ordem => $spec) {
        $stmtSpec->execute([39, $spec[0], $spec[1], $ordem]);
    }

    // ID 40: Trifásico Sem Tomada
    $specs40 = [
        ['Potência Nominal', '7,2 kW / 22 kW Trifásico', 0],
        ['Tensão Operacional', '380VAC Trifásico (L1+L2+L3+N+Terra)', 1],
        ['Disjuntor', 'Tetrapolar 40A Curva C (6kA)', 2],
        ['Interruptor DR', 'Tetrapolar 40A / 30mA Classe A', 3],
        ['DPS Surto', 'Tetrapolar 20/40kA 275V Classe II', 4],
        ['Grau de Vedação', 'IP65 (Instalação interna ou externa)', 5],
        ['Saída de Energia', 'Prensa-cabo direto nos bornes internos', 6]
    ];
    foreach ($specs40 as $ordem => $spec) {
        $stmtSpec->execute([40, $spec[0], $spec[1], $ordem]);
    }

    // ID 41: Trifásico Com Tomada
    $specs41 = [
        ['Potência Nominal', '7,2 kW / 22 kW Trifásico', 0],
        ['Tensão Operacional', '380VAC Trifásico (L1+L2+L3+N+Terra)', 1],
        ['Disjuntor', 'Tetrapolar 40A Curva C (6kA)', 2],
        ['Interruptor DR', 'Tetrapolar 40A / 30mA Classe A', 3],
        ['DPS Surto', 'Tetrapolar 20/40kA 275V Classe II', 4],
        ['Grau de Vedação', 'IP65 (Gabinete) / IP44 (Tomada acoplada)', 5],
        ['Saída de Energia', 'Tomada Industrial Vermelha 32A 3P+N+T padrão IEC 60309', 6]
    ];
    foreach ($specs41 as $ordem => $spec) {
        $stmtSpec->execute([41, $spec[0], $spec[1], $ordem]);
    }
    echo "Especificações inseridas.\n";

    $db->commit();
    echo "=== Migração de banco de dados concluída com sucesso! ===\n";
} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    echo "Erro na migração: " . $e->getMessage() . "\n";
}
