<?php
/**
 * VoltchZ Brasil - Catálogo de Produtos do Admin
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Ação de Exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_produto') {
    $prod_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($prod_id) {
        try {
            // As chaves estrangeiras com ON DELETE CASCADE nas tabelas produto_especificacoes,
            // produto_diferenciais e produto_variacoes cuidarão da limpeza automática.
            $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
            $stmt->execute([$prod_id]);
            $success_message = "Produto excluído com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir produto: " . $e->getMessage();
        }
    }
}

// Ação de Atualização de Ordenação via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_sort_order') {
    header('Content-Type: application/json');
    $ids = $_POST['ids'] ?? [];
    if (is_array($ids)) {
        try {
            $db->beginTransaction();
            $stmt = $db->prepare("UPDATE produtos SET sort_order = ? WHERE id = ?");
            foreach ($ids as $index => $id) {
                $stmt->execute([$index + 1, $id]);
            }
            $db->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $db->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'IDs inválidos.']);
    }
    exit;
}

// Filtros e Busca
$busca = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$filtro_cat = filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';
$filtro_marca = filter_input(INPUT_GET, 'marca', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';

// Buscar Categorias e Marcas para os Filtros
$categorias = get_categorias();
$marcas = get_marcas();

// Monta Query
$sql = "SELECT p.*, c.nome AS categoria_nome, m.nome AS marca_nome FROM produtos p 
        JOIN categorias c ON p.categoria_id = c.id
        JOIN marcas m ON p.marca_id = m.id WHERE 1=1";
$params = [];

if ($filtro_cat !== 'todos') {
    $sql .= " AND p.categoria_id = ?";
    $params[] = $filtro_cat;
}

if ($filtro_marca !== 'todos') {
    $sql .= " AND p.marca_id = ?";
    $params[] = $filtro_marca;
}

if (!empty($busca)) {
    $sql .= " AND (p.nome LIKE ? OR p.resumo LIKE ? OR p.descricao LIKE ?)";
    $searchVal = "%" . $busca . "%";
    $params[] = $searchVal;
    $params[] = $searchVal;
    $params[] = $searchVal;
}

$sql .= " ORDER BY p.sort_order ASC, p.id DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll();

admin_header("Gerenciar Catálogo de Produtos", "produtos");
?>

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

<!-- TOP ACTIONS & FILTERS -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 mb-8">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
        <div class="sm:col-span-4">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Termo de busca</label>
            <input type="text" name="q" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Buscar nome do produto..."
                   class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
        </div>

        <div class="sm:col-span-3">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Filtrar Categoria</label>
            <select name="categoria" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                <option value="todos">Todas Categorias</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $filtro_cat === $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="sm:col-span-3">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Filtrar Marca</label>
            <select name="marca" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                <option value="todos">Todas Marcas</option>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?php echo $marca['id']; ?>" <?php echo $filtro_marca === $marca['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($marca['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="sm:col-span-2 flex gap-2">
            <button type="submit" class="flex-1 bg-white/5 hover:bg-white/10 text-white font-bold p-2.5 rounded-xl flex items-center justify-center transition-all border border-white/10">
                Filtrar
            </button>
            <a href="produto-form.php" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-1 transition-all shadow-lg shadow-brand-green/10" title="Cadastrar Produto">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                <span>Novo</span>
            </a>
        </div>
    </form>
</div>

<!-- PRODUCTS TABLE -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <?php if (empty($produtos)): ?>
        <div class="text-center py-20 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
            <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path></svg>
            <h4 class="text-white font-semibold text-sm">Nenhum equipamento cadastrado</h4>
            <p class="text-xs text-brand-muted/70 mt-1">Crie um novo produto clicando no botão verde no topo.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-2 rounded-l-xl w-12 text-center">Ordem</th>
                        <th class="py-3 px-4">Produto</th>
                        <th class="py-3 px-4">Posição</th>
                        <th class="py-3 px-4">Marca</th>
                        <th class="py-3 px-4">Categoria</th>
                        <th class="py-3 px-4">Parâmetros Rápidos</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($produtos as $prod): 
                        $img = !empty($prod['imagem']) ? '../' . $prod['imagem'] : '';
                    ?>
                        <tr data-id="<?php echo $prod['id']; ?>" class="hover:bg-white/[0.01] transition-colors cursor-default select-none">
                            <td class="py-4 px-2 text-center drag-handle cursor-grab active:cursor-grabbing text-brand-muted/40 hover:text-white">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"></path></svg>
                            </td>
                            <td class="py-4 px-4 font-semibold text-white">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($prod['imagem'])): ?>
                                        <div class="w-10 h-10 rounded-lg bg-brand-bg3 border border-white/5 overflow-hidden shrink-0 flex items-center justify-center">
                                            <img src="<?php echo htmlspecialchars($img); ?>" alt="" class="w-full h-full object-cover">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-lg bg-brand-green/10 border border-brand-green/20 text-brand-green flex items-center justify-center shrink-0 font-mono text-xs font-bold">
                                            ⚡
                                        </div>
                                    <?php endif; ?>
                                    <div class="min-w-0">
                                        <span class="block truncate font-bold text-white"><?php echo htmlspecialchars($prod['nome']); ?></span>
                                        <span class="block text-[11px] font-mono text-brand-muted/80">/<?php echo htmlspecialchars($prod['slug']); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs font-mono font-bold text-brand-green sort-order-cell">
                                <?php echo htmlspecialchars($prod['sort_order'] ?? 0); ?>
                            </td>
                            <td class="py-4 px-4 text-xs font-medium">
                                <?php echo htmlspecialchars($prod['marca_nome']); ?>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-white text-[11px] font-semibold">
                                    <?php echo htmlspecialchars($prod['categoria_nome']); ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs space-y-1">
                                <?php if (!empty($prod['potencia'])): ?>
                                    <div class="text-[11px]"><strong class="text-white">Potência:</strong> <?php echo htmlspecialchars($prod['potencia']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($prod['tensao'])): ?>
                                    <div class="text-[11px]"><strong class="text-white">Tensão:</strong> <?php echo htmlspecialchars($prod['tensao']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="produto-form.php?id=<?php echo $prod['id']; ?>" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 hover:text-white text-brand-muted transition-all" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Tem certeza que deseja excluir o produto <?php echo htmlspecialchars($prod['nome']); ?>? Esta operação não poderá ser desfeita.');" class="inline">
                                        <input type="hidden" name="action" value="delete_produto">
                                        <input type="hidden" name="id" value="<?php echo $prod['id']; ?>">
                                        <button type="submit" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-red-500/20 hover:text-red-400 text-brand-muted transition-all" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
    const tbody = document.querySelector('tbody');
    let dragEl;

    // Habilita arrastar somente quando o clique inicial for no drag-handle
    tbody.addEventListener('mousedown', (e) => {
        const handle = e.target.closest('.drag-handle');
        if (handle) {
            const tr = handle.closest('tr');
            if (tr) {
                tr.setAttribute('draggable', 'true');
            }
        }
    });

    // Desabilita arrastar se o mouse subir sem arrastar
    tbody.addEventListener('mouseup', (e) => {
        const tr = e.target.closest('tr');
        if (tr) {
            tr.removeAttribute('draggable');
        }
    });

    tbody.addEventListener('dragstart', (e) => {
        // Se por algum motivo o dragstart disparar sem o atributo draggable (ou fora do handle), cancela
        if (!e.target.closest('.drag-handle')) {
            e.preventDefault();
            return;
        }
        dragEl = e.target.closest('tr');
        e.dataTransfer.effectAllowed = 'move';
        dragEl.classList.add('opacity-40');
    });

    tbody.addEventListener('dragover', (e) => {
        e.preventDefault();
        const targetRow = e.target.closest('tr');
        if (targetRow && targetRow !== dragEl) {
            const rect = targetRow.getBoundingClientRect();
            const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
            tbody.insertBefore(dragEl, next ? targetRow.nextSibling : targetRow);
        }
    });

    tbody.addEventListener('dragend', () => {
        if (!dragEl) return;
        dragEl.classList.remove('opacity-40');
        dragEl.removeAttribute('draggable'); // Garante que o tr não continue draggable após soltar
        
        // Coleta nova ordem
        const rows = Array.from(tbody.querySelectorAll('tr[data-id]'));
        const ids = rows.map(row => row.getAttribute('data-id'));

        // Envia via AJAX
        const formData = new FormData();
        formData.append('action', 'update_sort_order');
        ids.forEach(id => formData.append('ids[]', id));

        fetch('produtos.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Atualiza visualmente o número da ordem na tabela
                rows.forEach((row, index) => {
                    row.querySelector('.sort-order-cell').textContent = index + 1;
                });
            } else {
                alert(data.message || 'Erro ao atualizar a ordenação.');
            }
        })
        .catch(() => {
            alert('Erro de comunicação com o servidor.');
        });
    });
</script>

<?php 
admin_footer();
?>
