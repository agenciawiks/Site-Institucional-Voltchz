<?php
/**
 * VoltchZ Brasil - Gerenciamento de Artigos do Blog no Admin
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Exclusão de Artigo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_artigo') {
    $artigo_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($artigo_id) {
        try {
            // As chaves estrangeiras com ON DELETE CASCADE nas tabelas artigo_conteudo
            // e artigo_conteudo_list_items cuidarão da limpeza automática.
            $stmt = $db->prepare("DELETE FROM artigos WHERE id = ?");
            $stmt->execute([$artigo_id]);
            $success_message = "Artigo excluído com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir artigo: " . $e->getMessage();
        }
    }
}

// Filtro e Busca
$busca = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$filtro_cat = filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';

// Buscar Categorias Ativas no Blog para os Filtros
$stmtCats = $db->query("SELECT DISTINCT categoria FROM artigos WHERE categoria IS NOT NULL AND categoria != ''");
$categorias = $stmtCats->fetchAll(PDO::FETCH_COLUMN);

// Monta Query
$sql = "SELECT id, slug, titulo, categoria, autor, data_publicacao AS data, tempo_leitura AS tempoLeitura FROM artigos WHERE 1=1";
$params = [];

if ($filtro_cat !== 'todos') {
    $sql .= " AND categoria = ?";
    $params[] = $filtro_cat;
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

admin_header("Gerenciar Artigos do Blog", "blog");
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

<!-- FILTERS & ACTIONS -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 mb-8">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
        <div class="sm:col-span-5">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Pesquisar artigos</label>
            <input type="text" name="q" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Buscar título, resumo ou autor..."
                   class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
        </div>

        <div class="sm:col-span-4">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Filtrar por Tema</label>
            <select name="categoria" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                <option value="todos">Todos os Temas</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php echo $filtro_cat === $cat ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="sm:col-span-3 flex gap-2">
            <button type="submit" class="flex-1 bg-white/5 hover:bg-white/10 text-white font-bold p-2.5 rounded-xl flex items-center justify-center transition-all border border-white/10">
                Filtrar
            </button>
            <a href="artigo-form.php" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-1 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Escrever
            </a>
        </div>
    </form>
</div>

<!-- ARTICLES LIST TABLE -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <?php if (empty($artigos)): ?>
        <div class="text-center py-20 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
            <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.75V6.125C3 5.504 3.504 5 4.125 5H18a1.125 1.125 0 011.125 1.125V7.5"></path></svg>
            <h4 class="text-white font-semibold text-sm">Nenhum artigo publicado</h4>
            <p class="text-xs text-brand-muted/70 mt-1">Clique em "Escrever" para publicar sua primeira análise técnica no blog.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-4 rounded-l-xl">Título do Artigo</th>
                        <th class="py-3 px-4">Autor</th>
                        <th class="py-3 px-4">Tema</th>
                        <th class="py-3 px-4">Publicado em</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($artigos as $art): ?>
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="py-4 px-4 font-semibold text-white">
                                <div class="min-w-0">
                                    <span class="block truncate font-bold text-white"><?php echo htmlspecialchars($art['titulo']); ?></span>
                                    <span class="block text-[11px] font-mono text-brand-muted/80">/<?php echo htmlspecialchars($art['slug']); ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <?php echo htmlspecialchars($art['autor']); ?>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-white text-[11px] font-semibold">
                                    <?php echo htmlspecialchars($art['categoria']); ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <?php echo htmlspecialchars($art['data']); ?> 
                                <span class="block text-[10px] text-brand-muted/70 mt-0.5"><?php echo htmlspecialchars($art['tempoLeitura']); ?></span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="artigo-form.php?id=<?php echo $art['id']; ?>" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 hover:text-white text-brand-muted transition-all" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Tem certeza que deseja excluir o artigo \'<?php echo htmlspecialchars($art['titulo']); ?>\'? Esta operação não poderá ser desfeita.');" class="inline">
                                        <input type="hidden" name="action" value="delete_artigo">
                                        <input type="hidden" name="id" value="<?php echo $art['id']; ?>">
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

<?php 
admin_footer();
?>
