<?php
/**
 * VoltchZ Brasil - Gerenciamento de Portfólio (Instalações Reais)
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Exclusão de Item de Portfólio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_portfolio') {
    $portfolio_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $table_type = $_POST['table'] ?? 'portfolio_residencial';
    $allowed_tables = ['portfolio_residencial', 'portfolio_condominio', 'portfolio_eletroposto'];
    if (!in_array($table_type, $allowed_tables)) {
        $table_type = 'portfolio_residencial';
    }

    if ($portfolio_id) {
        try {
            $stmtImg = $db->prepare("SELECT image FROM {$table_type} WHERE id = ?");
            $stmtImg->execute([$portfolio_id]);
            $image_path = $stmtImg->fetchColumn();

            $stmt = $db->prepare("DELETE FROM {$table_type} WHERE id = ?");
            $stmt->execute([$portfolio_id]);

            if (!empty($image_path)) {
                uploads_delete($image_path);
            }

            $success_message = "Item do portfólio excluído com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir item: " . $e->getMessage();
        }
    }
}

// Filtro por marca
$filtro_marca = filter_input(INPUT_GET, 'marca', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';

try {
    $stmtMarcas = $db->query("SELECT DISTINCT brand FROM portfolio_residencial ORDER BY brand ASC");
    $marcas_unicas = $stmtMarcas->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $marcas_unicas = [];
}

try {
    $portfolio = get_portfolio_items();
    if ($filtro_marca !== 'todos') {
        $portfolio = array_filter($portfolio, function($item) use ($filtro_marca) {
            return isset($item['brand']) && $item['brand'] === $filtro_marca;
        });
    }
} catch (Exception $e) {
    $portfolio = [];
    $error_message = "Erro ao buscar portfólio: " . $e->getMessage();
}

admin_header("Gerenciar Portfólio Completo", "portfolio");
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
    <form method="GET" class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="w-full sm:w-1/3">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Filtrar por Marca</label>
            <select name="marca" onchange="this.form.submit()" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                <option value="todos">Todas as Marcas</option>
                <?php foreach ($marcas_unicas as $m): ?>
                    <option value="<?php echo htmlspecialchars($m); ?>" <?php echo $filtro_marca === $m ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars(strtoupper($m)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <a href="portfolio-form.php" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-1 transition-all shadow-lg shadow-brand-green/10 shrink-0">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
            <span>Novo Projeto</span>
        </a>
    </form>
</div>

<!-- PORTFOLIO TABLE -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <?php if (empty($portfolio)): ?>
        <div class="text-center py-20 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
            <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"></path></svg>
            <h4 class="text-white font-semibold text-sm">Nenhum projeto cadastrado no portfólio</h4>
            <p class="text-xs text-brand-muted/70 mt-1">Cadastre um novo caso clicando no botão verde no topo.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-4 rounded-l-xl">Imagem</th>
                        <th class="py-3 px-4">Veículo / Modelo</th>
                        <th class="py-3 px-4">Tipo</th>
                        <th class="py-3 px-4">Marca</th>
                        <th class="py-3 px-4">Localização</th>
                        <th class="py-3 px-4">Descrição</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($portfolio as $item): 
                        $img = !empty($item['image']) ? '../' . $item['image'] : '';
                    ?>
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="py-4 px-4 font-semibold text-white">
                                <?php if (!empty($item['image'])): ?>
                                    <div class="w-14 h-14 rounded-lg bg-brand-bg3 border border-white/5 overflow-hidden flex items-center justify-center shrink-0">
                                        <img src="<?php echo htmlspecialchars($img); ?>" alt="" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-14 h-14 rounded-lg bg-brand-green/10 border border-brand-green/20 text-brand-green flex items-center justify-center shrink-0 font-bold text-xs">
                                        🚗
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 font-bold text-white">
                                <?php echo htmlspecialchars($item['model']); ?>
                            </td>
                            <td class="py-4 px-4">
                                <?php if (($item['tipo'] ?? 'veiculo') === 'condominio'): ?>
                                    <span class="px-2 py-0.5 rounded bg-brand-green/10 border border-brand-green/20 text-brand-green text-[10px] font-semibold uppercase">Condomínio</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-brand-muted text-[10px] font-semibold uppercase">Veículo</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold uppercase font-mono text-brand-green">
                                <?php echo htmlspecialchars($item['brand'] === 'condominio' ? '-' : $item['brand']); ?>
                            </td>
                            <td class="py-4 px-4 text-xs text-white">
                                <?php echo htmlspecialchars($item['location']); ?>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <p class="text-xs text-brand-muted/80 line-clamp-2"><?php echo htmlspecialchars($item['description']); ?></p>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <?php 
                                        $tipo_item = 'residencial';
                                        if (($item['tipo'] ?? '') === 'condominio' || ($item['tipo'] ?? '') === 'construtora') {
                                            $tipo_item = 'condominio';
                                        } elseif (($item['tipo'] ?? '') === 'eletroposto') {
                                            $tipo_item = 'eletroposto';
                                        }
                                    ?>
                                    <a href="portfolio-form.php?type=<?php echo $tipo_item; ?>&id=<?php echo $item['id']; ?>" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 hover:text-white text-brand-muted transition-all" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Tem certeza que deseja excluir este projeto de <?php echo htmlspecialchars($item['model']); ?>?');" class="inline">
                                        <input type="hidden" name="action" value="delete_portfolio">
                                        <input type="hidden" name="table" value="portfolio_<?php echo $tipo_item; ?>">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
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
