<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Produto
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$product_id;

// Dados default do produto
$produto = [
    'nome' => '',
    'slug' => '',
    'marca_id' => '',
    'categoria_id' => '',
    'potencia' => '',
    'tensao' => '',
    'aplicacao' => '',
    'tipo' => '',
    'resumo' => '',
    'descricao' => '',
    'imagem' => '',
    'sort_order' => 0
];
$especificacoes = [];
$diferenciais = [];
$variacoes = [];

// Se for edição, carrega os dados atuais do banco
if ($is_edit) {
    try {
        $stmtProd = $db->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmtProd->execute([$product_id]);
        $loaded_prod = $stmtProd->fetch();
        
        if ($loaded_prod) {
            $produto = $loaded_prod;
            
            // Busca diferenciais
            $stmtDif = $db->prepare("SELECT diferencial FROM produto_diferenciais WHERE produto_id = ? ORDER BY ordem ASC");
            $stmtDif->execute([$product_id]);
            $diferenciais = $stmtDif->fetchAll(PDO::FETCH_COLUMN);
            
            // Busca especificações
            $stmtSpec = $db->prepare("SELECT chave, valor FROM produto_especificacoes WHERE produto_id = ? ORDER BY ordem ASC");
            $stmtSpec->execute([$product_id]);
            $especificacoes = $stmtSpec->fetchAll();
            
            // Busca variações (SKUs)
            $stmtVar = $db->prepare("SELECT sku, nome, adicional_desc AS adicionalDesc FROM produto_variacoes WHERE produto_id = ?");
            $stmtVar->execute([$product_id]);
            $variacoes = $stmtVar->fetchAll();
        } else {
            header('Location: produtos.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar produto: " . $e->getMessage();
    }
}

// Processa envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['slug'] ?? '')));
    $marca_id = $_POST['marca_id'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $potencia = filter_input(INPUT_POST, 'potencia', FILTER_SANITIZE_SPECIAL_CHARS);
    $tensao = filter_input(INPUT_POST, 'tensao', FILTER_SANITIZE_SPECIAL_CHARS);
    $aplicacao = filter_input(INPUT_POST, 'aplicacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS);
    $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

    // Arrays dinâmicos enviados
    $post_spec_chaves = $_POST['spec_chave'] ?? [];
    $post_spec_valores = $_POST['spec_valor'] ?? [];
    $post_diferenciais = $_POST['diferenciais'] ?? [];
    $post_var_skus = $_POST['var_sku'] ?? [];
    $post_var_nomes = $_POST['var_nome'] ?? [];
    $post_var_descs = $_POST['var_desc'] ?? [];

    if (empty($nome) || empty($slug) || empty($marca_id) || empty($categoria_id)) {
        $error_message = "Nome, identificador slug, marca e categoria são obrigatórios.";
    } else {
        try {
            $db->beginTransaction();

            // Verifica colisão de slug
            $stmtSlug = $db->prepare("SELECT COUNT(*) FROM produtos WHERE slug = ? AND id != ?");
            $stmtSlug->execute([$slug, $is_edit ? $product_id : 0]);
            if ($stmtSlug->fetchColumn() > 0) {
                throw new Exception("O identificador slug '{$slug}' já está sendo utilizado por outro produto.");
            }

            if ($is_edit) {
                // UPDATE do Produto
                $stmtUp = $db->prepare("UPDATE produtos SET slug = ?, nome = ?, marca_id = ?, categoria_id = ?, potencia = ?, tensao = ?, aplicacao = ?, tipo = ?, resumo = ?, descricao = ?, imagem = ?, sort_order = ? WHERE id = ?");
                $stmtUp->execute([$slug, $nome, $marca_id, $categoria_id, $potencia, $tensao, $aplicacao, $tipo, $resumo, $descricao, $imagem, $sort_order, $product_id]);
                $prodId = $product_id;
            } else {
                // INSERT do Produto
                $stmtIn = $db->prepare("INSERT INTO produtos (slug, nome, marca_id, categoria_id, potencia, tensao, aplicacao, tipo, resumo, descricao, imagem, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmtIn->execute([$slug, $nome, $marca_id, $categoria_id, $potencia, $tensao, $aplicacao, $tipo, $resumo, $descricao, $imagem, $sort_order]);
                $prodId = $db->lastInsertId();
            }

            // 1. Limpa e Reinsere Diferenciais
            $db->prepare("DELETE FROM produto_diferenciais WHERE produto_id = ?")->execute([$prodId]);
            $stmtInDif = $db->prepare("INSERT INTO produto_diferenciais (produto_id, diferencial, ordem) VALUES (?, ?, ?)");
            $ordem = 0;
            foreach ($post_diferenciais as $dif) {
                $dif = trim($dif);
                if (!empty($dif)) {
                    $stmtInDif->execute([$prodId, $dif, $ordem++]);
                }
            }

            // 2. Limpa e Reinsere Especificações
            $db->prepare("DELETE FROM produto_especificacoes WHERE produto_id = ?")->execute([$prodId]);
            $stmtInSpec = $db->prepare("INSERT INTO produto_especificacoes (produto_id, chave, valor, ordem) VALUES (?, ?, ?, ?)");
            $ordemSpec = 0;
            for ($i = 0; $i < count($post_spec_chaves); $i++) {
                $ch = trim($post_spec_chaves[$i]);
                $vl = trim($post_spec_valores[$i]);
                if (!empty($ch) && !empty($vl)) {
                    $stmtInSpec->execute([$prodId, $ch, $vl, $ordemSpec++]);
                }
            }

            // 3. Limpa e Reinsere Variações (SKUs)
            $db->prepare("DELETE FROM produto_variacoes WHERE produto_id = ?")->execute([$prodId]);
            $stmtInVar = $db->prepare("INSERT INTO produto_variacoes (sku, produto_id, nome, adicional_desc) VALUES (?, ?, ?, ?)");
            for ($i = 0; $i < count($post_var_skus); $i++) {
                $sku = trim($post_var_skus[$i]);
                $vNome = trim($post_var_nomes[$i]);
                $vDesc = trim($post_var_descs[$i]) ?: null;
                if (!empty($sku) && !empty($vNome)) {
                    $stmtInVar->execute([$sku, $prodId, $vNome, $vDesc]);
                }
            }

            $db->commit();
            
            // Redireciona de volta após salvar
            header("Location: produtos.php?saved=1");
            exit;

        } catch (Exception $e) {
            $db->rollBack();
            $error_message = "Erro ao salvar dados: " . $e->getMessage();
            
            // Recarrega os dados postados para não perder as alterações em tela
            $produto = [
                'nome' => $nome,
                'slug' => $slug,
                'marca_id' => $marca_id,
                'categoria_id' => $categoria_id,
                'potencia' => $potencia,
                'tensao' => $tensao,
                'aplicacao' => $aplicacao,
                'tipo' => $tipo,
                'resumo' => $resumo,
                'descricao' => $descricao,
                'imagem' => $imagem,
                'sort_order' => $sort_order
            ];
            
            // Reconstrói especificações
            $especificacoes = [];
            for ($i = 0; $i < count($post_spec_chaves); $i++) {
                if (!empty($post_spec_chaves[$i])) {
                    $especificacoes[] = ['chave' => $post_spec_chaves[$i], 'valor' => $post_spec_valores[$i]];
                }
            }
            // Reconstrói diferenciais
            $diferenciais = array_filter($post_diferenciais);
            // Reconstrói variações
            $variacoes = [];
            for ($i = 0; $i < count($post_var_skus); $i++) {
                if (!empty($post_var_skus[$i])) {
                    $variacoes[] = ['sku' => $post_var_skus[$i], 'nome' => $post_var_nomes[$i], 'adicionalDesc' => $post_var_descs[$i]];
                }
            }
        }
    }
}

// Marcas e Categorias para selects
$categorias = get_categorias();
$marcas = get_marcas();

admin_header($is_edit ? "Editar Produto" : "Cadastrar Novo Produto", "produtos");
?>

<?php if (!empty($error_message)): ?>
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<!-- FORMULÁRIO -->
<form method="POST" action="" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- COLUNA 1: DADOS BÁSICOS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-5">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Dados do Equipamento</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Nome Comercial</label>
                        <input type="text" id="prod-nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required placeholder="ex: VoltchZ Smart Wallbox"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Slug identificador (URL)</label>
                        <input type="text" id="prod-slug" name="slug" value="<?php echo htmlspecialchars($produto['slug']); ?>" required placeholder="ex: voltchz-smart-wallbox"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Categoria</label>
                        <select name="categoria_id" required class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $produto['categoria_id'] === $cat['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Marca</label>
                        <select name="marca_id" required class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            <option value="">Selecione...</option>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?php echo $marca['id']; ?>" <?php echo $produto['marca_id'] === $marca['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($marca['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Ordem de Exibição</label>
                        <input type="number" name="sort_order" value="<?php echo htmlspecialchars($produto['sort_order'] ?? 0); ?>" required min="0" placeholder="ex: 0"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Potência</label>
                        <input type="text" name="potencia" value="<?php echo htmlspecialchars($produto['potencia']); ?>" placeholder="ex: 22 kW / 7.4 kW"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Tensão</label>
                        <input type="text" name="tensao" value="<?php echo htmlspecialchars($produto['tensao']); ?>" placeholder="ex: 380V Trifásico"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Aplicação</label>
                        <input type="text" name="aplicacao" value="<?php echo htmlspecialchars($produto['aplicacao']); ?>" placeholder="ex: Corporativo, Frotas"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Tipo de Conexão</label>
                        <input type="text" name="tipo" value="<?php echo htmlspecialchars($produto['tipo']); ?>" placeholder="ex: Cabo Tipo 2 (5m)"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Resumo Comercial (Card)</label>
                    <input type="text" name="resumo" value="<?php echo htmlspecialchars($produto['resumo']); ?>" placeholder="Resumo simples que aparece na listagem do catálogo..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Descrição Completa</label>
                    <textarea name="descricao" rows="5" placeholder="Descrição completa com detalhes de montagem, conformidades, certificações..."
                              class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30 resize-y"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Imagem do Produto (Pasta `static/` ou URL)</label>
                    <div class="flex gap-2">
                        <input type="text" id="prod-imagem" name="imagem" value="<?php echo htmlspecialchars($produto['imagem']); ?>" placeholder="ex: static/produtos/carregador.png"
                               class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                        <input type="file" id="prod-file-input" class="hidden" accept="image/*">
                        <button type="button" onclick="triggerUpload('prod-file-input', 'prod-imagem', 'prod-preview')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 rounded-xl text-xs transition-all">
                            Fazer Upload
                        </button>
                    </div>
                    <div id="prod-preview-container" class="mt-3 p-2 bg-brand-bg3/25 border border-white/5 rounded-xl inline-block <?php echo empty($produto['imagem']) ? 'hidden' : ''; ?>">
                        <img id="prod-preview" src="<?php echo !empty($produto['imagem']) ? '../' . $produto['imagem'] : ''; ?>" class="max-h-24 rounded-lg object-contain">
                    </div>
                </div>
            </div>

            <!-- DIFERENCIAIS COMERCIAIS -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Diferenciais Comerciais</h3>
                    <button type="button" onclick="addDiferencial()" class="px-3 py-1 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                        + Adicionar
                    </button>
                </div>
                <div id="diferenciais-container" class="space-y-2">
                    <?php if (empty($diferenciais)): ?>
                        <!-- Primeiro input default se vazio -->
                        <div class="flex gap-2">
                            <input type="text" name="diferenciais[]" placeholder="ex: Controle de acesso inteligente via RFID"
                                   class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold px-2">&times;</button>
                        </div>
                    <?php else: ?>
                        <?php foreach ($diferenciais as $dif): ?>
                            <div class="flex gap-2">
                                <input type="text" name="diferenciais[]" value="<?php echo htmlspecialchars($dif); ?>"
                                       class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold px-2">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- COLUNA 2: ESPECIFICAÇÕES E SKUs/VARIAÇÕES -->
        <div class="space-y-6">
            
            <!-- ESPECIFICAÇÕES TÉCNICAS -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Especificações Técnicas</h3>
                    <button type="button" onclick="addEspecificacao()" class="px-3 py-1 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                        + Adicionar
                    </button>
                </div>
                
                <div id="especificacoes-container" class="space-y-3">
                    <?php if (empty($especificacoes)): ?>
                        <div class="flex gap-2 items-center">
                            <input type="text" name="spec_chave[]" placeholder="Parâmetro" class="w-1/3 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                            <input type="text" name="spec_valor[]" placeholder="Valor" class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold">&times;</button>
                        </div>
                    <?php else: ?>
                        <?php foreach ($especificacoes as $spec): ?>
                            <div class="flex gap-2 items-center">
                                <input type="text" name="spec_chave[]" value="<?php echo htmlspecialchars($spec['chave']); ?>" placeholder="Parâmetro" class="w-1/3 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                                <input type="text" name="spec_valor[]" value="<?php echo htmlspecialchars($spec['valor']); ?>" placeholder="Valor" class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- VARIAÇÕES / SKUS -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Modelos / SKUs</h3>
                    <button type="button" onclick="addVariacao()" class="px-3 py-1 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                        + Adicionar
                    </button>
                </div>
                
                <div id="variacoes-container" class="space-y-4">
                    <?php if (empty($variacoes)): ?>
                        <div class="bg-brand-bg3/20 border border-white/5 rounded-xl p-3.5 space-y-2 relative">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-500 font-bold">&times;</button>
                            <div>
                                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Código SKU único</label>
                                <input type="text" name="var_sku[]" placeholder="ex: AB-V22-TRI" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Nome do Modelo</label>
                                <input type="text" name="var_nome[]" placeholder="ex: 22 kW com leitor RFID" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Descrição / Cabo (opcional)</label>
                                <input type="text" name="var_desc[]" placeholder="ex: Trifásico 380V / Cabo Tipo 2 de 5m" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($variacoes as $var): ?>
                            <div class="bg-brand-bg3/20 border border-white/5 rounded-xl p-3.5 space-y-2 relative">
                                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-500 font-bold">&times;</button>
                                <div>
                                    <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Código SKU único</label>
                                    <input type="text" name="var_sku[]" value="<?php echo htmlspecialchars($var['sku']); ?>" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Nome do Modelo</label>
                                    <input type="text" name="var_nome[]" value="<?php echo htmlspecialchars($var['nome']); ?>" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Descrição / Cabo (opcional)</label>
                                    <input type="text" name="var_desc[]" value="<?php echo htmlspecialchars($var['adicionalDesc'] ?? ''); ?>" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SUBMIT BAR -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
                <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                    Salvar Produto
                </button>
                <a href="produtos.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
                    Cancelar e Voltar
                </a>
            </div>
        </div>

    </div>
</form>

<script>
    // Função de Upload AJAX
    function triggerUpload(fileInputId, textInputId, previewImgId) {
        const fileInput = document.getElementById(fileInputId);
        fileInput.click();
        
        fileInput.onchange = function() {
            if (fileInput.files.length === 0) return;
            
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('file', file);
            
            const btn = fileInput.nextElementSibling;
            const originalText = btn.textContent;
            btn.textContent = 'Enviando...';
            btn.disabled = true;
            
            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;
                
                if (data.success) {
                    document.getElementById(textInputId).value = data.path;
                    const previewImg = document.getElementById(previewImgId);
                    previewImg.src = '../' + data.path;
                    previewImg.parentElement.classList.remove('hidden');
                } else {
                    alert(data.message || 'Erro ao fazer upload.');
                }
            })
            .catch(err => {
                btn.textContent = originalText;
                btn.disabled = false;
                alert('Erro na comunicação com o servidor.');
            });
        };
    }

    // Gerar Slug Automaticamente
    const nomeInput = document.getElementById('prod-nome');
    const slugInput = document.getElementById('prod-slug');
    
    if (nomeInput && slugInput && <?php echo $is_edit ? 'false' : 'true'; ?>) {
        nomeInput.addEventListener('input', function() {
            const val = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // remove acentos
                .replace(/[^a-z0-9\s\-]/g, '') // remove caracteres especiais
                .replace(/\s+/g, '-') // converte espaço para hífen
                .replace(/-+/g, '-'); // remove hífens extras
            slugInput.value = val;
        });
    }

    // Gerenciador de Diferenciais
    function addDiferencial() {
        const container = document.getElementById('diferenciais-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="diferenciais[]" placeholder="ex: Controle de acesso inteligente via RFID"
                   class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold px-2">&times;</button>
        `;
        container.appendChild(div);
    }

    // Gerenciador de Especificações
    function addEspecificacao() {
        const container = document.getElementById('especificacoes-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center';
        div.innerHTML = `
            <input type="text" name="spec_chave[]" placeholder="Parâmetro" class="w-1/3 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
            <input type="text" name="spec_valor[]" placeholder="Valor" class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-500 font-bold">&times;</button>
        `;
        container.appendChild(div);
    }

    // Gerenciador de Variações
    function addVariacao() {
        const container = document.getElementById('variacoes-container');
        const div = document.createElement('div');
        div.className = 'bg-brand-bg3/20 border border-white/5 rounded-xl p-3.5 space-y-2 relative';
        div.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-500 font-bold">&times;</button>
            <div>
                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Código SKU único</label>
                <input type="text" name="var_sku[]" placeholder="ex: AB-V22-TRI" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>
            <div>
                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Nome do Modelo</label>
                <input type="text" name="var_nome[]" placeholder="ex: 22 kW com leitor RFID" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>
            <div>
                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Descrição / Cabo (opcional)</label>
                <input type="text" name="var_desc[]" placeholder="ex: Trifásico 380V / Cabo Tipo 2 de 5m" class="w-full bg-brand-bg3/50 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>
        `;
        container.appendChild(div);
    }
</script>

<?php 
admin_footer();
?>
