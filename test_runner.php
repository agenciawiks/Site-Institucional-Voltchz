<?php
/**
 * VoltchZ Brasil - Testes Automatizados de Banco de Dados e Codificação
 * Este script valida a conexão, existência das tabelas estruturais, auto-migrações
 * e testa o fluxo de inserção/recuperação prevenindo duplo-encode de caracteres especiais.
 */

header('Content-Type: text/plain; charset=utf-8');

echo "========================================================\n";
echo "    VOLTCHZ BRASIL - RELATÓRIO DE TESTES AUTOMATIZADOS\n";
echo "========================================================\n\n";

$errors = 0;
$successes = 0;

function assert_test($description, $assertion) {
    global $errors, $successes;
    if ($assertion) {
        echo "[ OK ] - $description\n";
        $successes++;
    } else {
        echo "[FALHA] - $description\n";
        $errors++;
    }
}

// 1. Testar carregamento do db.php e Conexão
echo "--- 1. Conexão com o Banco de Dados ---\n";
try {
    if (!file_exists('includes/db.php')) {
        throw new Exception("Arquivo includes/db.php não encontrado.");
    }
    require_once 'includes/db.php';
    
    $pdo = get_db_connection();
    assert_test("Conexão estabelecida com sucesso via PDO.", $pdo instanceof PDO);
} catch (Exception $e) {
    assert_test("Erro ao carregar banco de dados: " . $e->getMessage(), false);
    echo "\nTestes abortados devido a falha na conexão principal.\n";
    exit(1);
}

// 2. Testar Existência das Tabelas
echo "\n--- 2. Verificação de Estrutura de Tabelas ---\n";
$required_tables = [
    'marcas',
    'categorias',
    'produtos',
    'produto_diferenciais',
    'produto_especificacoes',
    'produto_variacoes',
    'artigos',
    'artigo_conteudo',
    'usuarios',
    'leads',
    'configuracoes',
    'portfolio',
    'banners',
    'depoimentos',
    'faq'
];

foreach ($required_tables as $table) {
    try {
        $stmt = $pdo->query("SELECT 1 FROM `$table` LIMIT 1");
        assert_test("Tabela `$table` existe no banco.", $stmt !== false);
    } catch (Exception $e) {
        assert_test("Tabela `$table` NÃO encontrada. (" . $e->getMessage() . ")", false);
    }
}

// 3. Testar Automigrações
echo "\n--- 3. Verificação de Auto-Migrações ---\n";
try {
    // Verifica se a coluna 'imagem' existe na tabela artigos (feita no db.php)
    $stmt = $pdo->query("SHOW COLUMNS FROM `artigos` LIKE 'imagem'");
    $has_column = $stmt->fetch();
    assert_test("Auto-migração: Coluna 'imagem' está presente na tabela `artigos`.", !empty($has_column));
} catch (Exception $e) {
    assert_test("Falha ao verificar coluna na tabela artigos: " . $e->getMessage(), false);
}

// 4. Testar Fluxo de Inserção e Validação contra Duplo-Encode
echo "\n--- 4. Teste de Inserção de Produto e Validação de Codificação ---\n";
$test_slug = "produto-teste-automatizado-voltchz";
$test_nome = "Carregador VoltchZ O'Connor & \"Smarter\" <Teste>";
$test_resumo = "Resumo com caracteres especiais: Acentuação (áéíóúçãõ) e símbolos (&, \", ', <, >).";
$test_descricao = "Descrição detalhada do produto teste.";

try {
    // Remover se já existir para limpar estado
    $pdo->prepare("DELETE FROM produtos WHERE slug = ?")->execute([$test_slug]);

    // Inserir produto de teste
    $stmt = $pdo->prepare("INSERT INTO produtos (slug, nome, marca_id, categoria_id, potencia, tensao, aplicacao, tipo, resumo, descricao, imagem) VALUES (?, ?, 'voltchz', 'estacoes', '22 kW', '380V', 'Comercial', 'Wallbox', ?, ?, 'voltchz-smarter.png')");
    $inserted = $stmt->execute([$test_slug, $test_nome, $test_resumo, $test_descricao]);
    assert_test("Inserção do produto de teste no banco.", $inserted);

    // Recuperar produto
    $product = get_produto_by_slug($test_slug);
    assert_test("Recuperação do produto de teste usando get_produto_by_slug().", !empty($product));

    if ($product) {
        // Garantir que os caracteres especiais foram mantidos exatamente como inseridos
        // O banco deve retornar a string original sem conversões de entidades HTML duplicadas
        assert_test("Evitando Duplo-Encode no Nome: '" . htmlspecialchars($product['nome'], ENT_QUOTES, 'UTF-8') . "'", $product['nome'] === $test_nome);
        assert_test("Evitando Duplo-Encode no Resumo.", $product['resumo'] === $test_resumo);
    }

    // Limpar o banco de dados
    $pdo->prepare("DELETE FROM produtos WHERE slug = ?")->execute([$test_slug]);
    assert_test("Limpeza dos dados de teste concluída.", true);

} catch (Exception $e) {
    assert_test("Erro durante teste de inserção/codificação: " . $e->getMessage(), false);
}

echo "\n========================================================\n";
echo "    RESUMO DOS TESTES AUTOMATIZADOS\n";
echo "========================================================\n";
echo "Sucessos: $successes\n";
echo "Falhas: $errors\n";
if ($errors === 0) {
    echo "SITUAÇÃO GERAL: TODOS OS TESTES PASSARAM COM SUCESSO!\n";
} else {
    echo "SITUAÇÃO GERAL: ALGUNS TESTES FALHARAM. VERIFIQUE OS ERROS ACIMA.\n";
}
echo "========================================================\n";
