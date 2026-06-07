<?php
/**
 * VoltchZ Brasil - Gerenciador de Categorias e Marcas
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// AÇÕES DE CRUDS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // --- CATEGORIAS ---
    if ($action === 'save_categoria') {
        $id = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['id'] ?? '')));
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS) ?: null;
        $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] === '1';
        
        if (empty($id) || empty($nome)) {
            $error_message = "Código identificador (slug/ID) e Nome da Categoria são obrigatórios.";
        } else {
            try {
                if ($is_edit) {
                    $stmt = $db->prepare("UPDATE categorias SET nome = ?, descricao = ?, imagem = ? WHERE id = ?");
                    $stmt->execute([$nome, $descricao, $imagem, $id]);
                    $success_message = "Categoria '{$nome}' atualizada com sucesso.";
                } else {
                    // Verifica duplicidade
                    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM categorias WHERE id = ?");
                    $stmtCheck->execute([$id]);
                    if ($stmtCheck->fetchColumn() > 0) {
                        $error_message = "Uma categoria com o código '{$id}' já existe.";
                    } else {
                        $stmt = $db->prepare("INSERT INTO categorias (id, nome, descricao, imagem) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$id, $nome, $descricao, $imagem]);
                        $success_message = "Categoria '{$nome}' cadastrada com sucesso.";
                    }
                }
            } catch (Exception $e) {
                $error_message = "Erro ao salvar categoria: " . $e->getMessage();
            }
        }
    }
    
    elseif ($action === 'delete_categoria') {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            try {
                // Checa se há produtos vinculados
                $stmtCheck = $db->prepare("SELECT COUNT(*) FROM produtos WHERE categoria_id = ?");
                $stmtCheck->execute([$id]);
                if ($stmtCheck->fetchColumn() > 0) {
                    $error_message = "Não é possível excluir esta categoria porque existem produtos vinculados a ela.";
                } else {
                    $stmt = $db->prepare("DELETE FROM categorias WHERE id = ?");
                    $stmt->execute([$id]);
                    $success_message = "Categoria excluída com sucesso.";
                }
            } catch (Exception $e) {
                $error_message = "Erro ao excluir categoria: " . $e->getMessage();
            }
        }
    }
    
    // --- MARCAS ---
    elseif ($action === 'save_marca') {
        $id = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['id'] ?? '')));
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS) ?: null;
        $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] === '1';
        
        if (empty($id) || empty($nome)) {
            $error_message = "Código identificador (slug/ID) e Nome da Marca são obrigatórios.";
        } else {
            try {
                if ($is_edit) {
                    $stmt = $db->prepare("UPDATE marcas SET nome = ?, descricao = ?, imagem = ? WHERE id = ?");
                    $stmt->execute([$nome, $descricao, $imagem, $id]);
                    $success_message = "Marca '{$nome}' atualizada com sucesso.";
                } else {
                    // Verifica duplicidade
                    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM marcas WHERE id = ?");
                    $stmtCheck->execute([$id]);
                    if ($stmtCheck->fetchColumn() > 0) {
                        $error_message = "Uma marca com o código '{$id}' já existe.";
                    } else {
                        $stmt = $db->prepare("INSERT INTO marcas (id, nome, descricao, imagem) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$id, $nome, $descricao, $imagem]);
                        $success_message = "Marca '{$nome}' cadastrada com sucesso.";
                    }
                }
            } catch (Exception $e) {
                $error_message = "Erro ao salvar marca: " . $e->getMessage();
            }
        }
    }
    
    elseif ($action === 'delete_marca') {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            try {
                // Checa se há produtos vinculados
                $stmtCheck = $db->prepare("SELECT COUNT(*) FROM produtos WHERE marca_id = ?");
                $stmtCheck->execute([$id]);
                if ($stmtCheck->fetchColumn() > 0) {
                    $error_message = "Não é possível excluir esta marca porque existem produtos vinculados a ela.";
                } else {
                    $stmt = $db->prepare("DELETE FROM marcas WHERE id = ?");
                    $stmt->execute([$id]);
                    $success_message = "Marca excluída com sucesso.";
                }
            } catch (Exception $e) {
                $error_message = "Erro ao excluir marca: " . $e->getMessage();
            }
        }
    }
}

// Buscar dados
$categorias = get_categorias();
$marcas = get_marcas();

admin_header("Categorias & Marcas", "categorias");
?>

<!-- Alertas -->
<?php if (!empty($success_message)): ?>
    <div class="bg-brand-green/10 border border-brand-green/20 text-brand-green p-4 rounded-xl text-sm mb-6">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>
<?php if (!empty($error_message)): ?>
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<!-- Split View: Categorias de um lado, Marcas do outro -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- CATEGORIAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-1">Categorias</h3>
            <p class="text-xs text-brand-muted mb-6">Organização dos chips do catálogo de produtos.</p>
            
            <!-- Formulário de Categoria (Add / Edit) -->
            <form method="POST" action="" class="bg-brand-bg3/40 border border-white/5 rounded-xl p-4 mb-6 space-y-4">
                <input type="hidden" name="action" value="save_categoria">
                <input type="hidden" id="cat-is-edit" name="is_edit" value="0">
                
                <h4 id="cat-form-title" class="text-xs font-bold uppercase tracking-wider text-brand-green">Nova Categoria</h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Código (ID / Slug)</label>
                        <input type="text" id="cat-id" name="id" placeholder="ex: estacoes" required
                               class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Nome Exibido</label>
                        <input type="text" id="cat-nome" name="nome" placeholder="ex: Estações de Recarga" required
                               class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Descrição Curta</label>
                    <input type="text" id="cat-desc" name="descricao" placeholder="Breve resumo da categoria..."
                           class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Imagem / Ícone (Caminho ou URL opcional)</label>
                    <input type="text" id="cat-img" name="imagem" placeholder="static/icon-categoria.svg"
                           class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div class="flex gap-2 justify-end">
                    <button type="button" onclick="resetCatForm()" id="cat-cancel-btn" class="hidden text-xs text-brand-muted hover:text-white px-3 py-2">Cancelar</button>
                    <button type="submit" class="bg-brand-green text-brand-bg font-bold px-4 py-2 rounded-lg text-xs hover:brightness-110 active:scale-95 transition-all">Salvar Categoria</button>
                </div>
            </form>

            <!-- Tabela de Categorias -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-white/5 text-white/50 uppercase tracking-wider font-bold">
                            <th class="py-2 px-1">Código</th>
                            <th class="py-2 px-1">Nome</th>
                            <th class="py-2 px-1">Descrição</th>
                            <th class="py-2 px-1 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($categorias as $cat): ?>
                            <tr class="hover:bg-white/[0.01]">
                                <td class="py-2.5 px-1 font-mono text-[11px] text-brand-green"><?php echo htmlspecialchars($cat['id']); ?></td>
                                <td class="py-2.5 px-1 text-white font-semibold"><?php echo htmlspecialchars($cat['nome']); ?></td>
                                <td class="py-2.5 px-1 text-brand-muted truncate max-w-[150px]" title="<?php echo htmlspecialchars($cat['descricao']); ?>"><?php echo htmlspecialchars($cat['descricao']); ?></td>
                                <td class="py-2.5 px-1 text-right flex justify-end gap-1.5">
                                    <button onclick="editCategoria(<?php echo htmlspecialchars(json_encode($cat)); ?>)" class="p-1 rounded bg-white/5 text-brand-muted hover:text-white transition-colors" title="Editar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </button>
                                    <form method="POST" action="" onsubmit="return confirm('Deseja realmente excluir esta categoria?');" class="inline">
                                        <input type="hidden" name="action" value="delete_categoria">
                                        <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                        <button type="submit" class="p-1 rounded bg-white/5 text-brand-muted hover:text-red-400 transition-colors" title="Excluir">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MARCAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-1">Marcas</h3>
            <p class="text-xs text-brand-muted mb-6">Fabricantes e parceiros de hardware cadastrados.</p>
            
            <!-- Formulário de Marca (Add / Edit) -->
            <form method="POST" action="" class="bg-brand-bg3/40 border border-white/5 rounded-xl p-4 mb-6 space-y-4">
                <input type="hidden" name="action" value="save_marca">
                <input type="hidden" id="marca-is-edit" name="is_edit" value="0">
                
                <h4 id="marca-form-title" class="text-xs font-bold uppercase tracking-wider text-brand-green">Nova Marca</h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Código (ID / Slug)</label>
                        <input type="text" id="marca-id" name="id" placeholder="ex: abb" required
                               class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Nome Comercial</label>
                        <input type="text" id="marca-nome" name="nome" placeholder="ex: ABB E-mobility" required
                               class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Descrição Corporativa</label>
                    <input type="text" id="marca-desc" name="descricao" placeholder="ex: Líder global em soluções de recarga..."
                           class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-brand-muted uppercase tracking-wider mb-1.5">Logo / Imagem (Caminho ou URL)</label>
                    <input type="text" id="marca-img" name="imagem" placeholder="static/logo-marca.png"
                           class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div class="flex gap-2 justify-end">
                    <button type="button" onclick="resetMarcaForm()" id="marca-cancel-btn" class="hidden text-xs text-brand-muted hover:text-white px-3 py-2">Cancelar</button>
                    <button type="submit" class="bg-brand-green text-brand-bg font-bold px-4 py-2 rounded-lg text-xs hover:brightness-110 active:scale-95 transition-all">Salvar Marca</button>
                </div>
            </form>

            <!-- Tabela de Marcas -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-white/5 text-white/50 uppercase tracking-wider font-bold">
                            <th class="py-2 px-1">Código</th>
                            <th class="py-2 px-1">Nome</th>
                            <th class="py-2 px-1">Descrição</th>
                            <th class="py-2 px-1 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($marcas as $mrc): ?>
                            <tr class="hover:bg-white/[0.01]">
                                <td class="py-2.5 px-1 font-mono text-[11px] text-brand-green"><?php echo htmlspecialchars($mrc['id']); ?></td>
                                <td class="py-2.5 px-1 text-white font-semibold"><?php echo htmlspecialchars($mrc['nome']); ?></td>
                                <td class="py-2.5 px-1 text-brand-muted truncate max-w-[150px]" title="<?php echo htmlspecialchars($mrc['descricao']); ?>"><?php echo htmlspecialchars($mrc['descricao']); ?></td>
                                <td class="py-2.5 px-1 text-right flex justify-end gap-1.5">
                                    <button onclick="editMarca(<?php echo htmlspecialchars(json_encode($mrc)); ?>)" class="p-1 rounded bg-white/5 text-brand-muted hover:text-white transition-colors" title="Editar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </button>
                                    <form method="POST" action="" onsubmit="return confirm('Deseja realmente excluir esta marca?');" class="inline">
                                        <input type="hidden" name="action" value="delete_marca">
                                        <input type="hidden" name="id" value="<?php echo $mrc['id']; ?>">
                                        <button type="submit" class="p-1 rounded bg-white/5 text-brand-muted hover:text-red-400 transition-colors" title="Excluir">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // Controle da Categoria
    function editCategoria(cat) {
        document.getElementById('cat-form-title').innerText = "Editar Categoria: " + cat.nome;
        document.getElementById('cat-id').value = cat.id;
        document.getElementById('cat-id').readOnly = true;
        document.getElementById('cat-nome').value = cat.nome;
        document.getElementById('cat-desc').value = cat.descricao;
        document.getElementById('cat-img').value = cat.imagem || '';
        document.getElementById('cat-is-edit').value = "1";
        document.getElementById('cat-cancel-btn').classList.remove('hidden');
    }
    function resetCatForm() {
        document.getElementById('cat-form-title').innerText = "Nova Categoria";
        document.getElementById('cat-id').value = '';
        document.getElementById('cat-id').readOnly = false;
        document.getElementById('cat-nome').value = '';
        document.getElementById('cat-desc').value = '';
        document.getElementById('cat-img').value = '';
        document.getElementById('cat-is-edit').value = "0";
        document.getElementById('cat-cancel-btn').classList.add('hidden');
    }

    // Controle da Marca
    function editMarca(marca) {
        document.getElementById('marca-form-title').innerText = "Editar Marca: " + marca.nome;
        document.getElementById('marca-id').value = marca.id;
        document.getElementById('marca-id').readOnly = true;
        document.getElementById('marca-nome').value = marca.nome;
        document.getElementById('marca-desc').value = marca.descricao;
        document.getElementById('marca-img').value = marca.imagem || '';
        document.getElementById('marca-is-edit').value = "1";
        document.getElementById('marca-cancel-btn').classList.remove('hidden');
    }
    function resetMarcaForm() {
        document.getElementById('marca-form-title').innerText = "Nova Marca";
        document.getElementById('marca-id').value = '';
        document.getElementById('marca-id').readOnly = false;
        document.getElementById('marca-nome').value = '';
        document.getElementById('marca-desc').value = '';
        document.getElementById('marca-img').value = '';
        document.getElementById('marca-is-edit').value = "0";
        document.getElementById('marca-cancel-btn').classList.add('hidden');
    }
</script>

<?php 
admin_footer();
?>
