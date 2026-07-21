<?php
/**
 * VoltchZ Brasil - Gerenciamento de Portfólio de Condomínios / Construtora
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_item') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        try {
            $stmtImg = $db->prepare("SELECT image FROM portfolio_condominio WHERE id = ?");
            $stmtImg->execute([$id]);
            $image_path = $stmtImg->fetchColumn();

            $stmt = $db->prepare("DELETE FROM portfolio_condominio WHERE id = ?");
            $stmt->execute([$id]);

            if (!empty($image_path)) {
                uploads_delete($image_path);
            }

            $success_message = "Item de condomínio excluído com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir: " . $e->getMessage();
        }
    }
}

try {
    $stmt = $db->query("SELECT * FROM portfolio_condominio ORDER BY sort_order ASC, id DESC");
    $items = $stmt->fetchAll();
} catch (Exception $e) {
    $items = [];
    $error_message = "Erro ao buscar itens: " . $e->getMessage();
}

admin_header("Gerenciar Portfólio Condomínios & Construtoras", "portfolio-condominio");
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

<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-white font-bold text-lg">Casos em Condomínios e Construtoras</h2>
        <p class="text-brand-muted text-xs">Instalações em infraestrutura coletiva e vagas privativas em edifícios</p>
    </div>
    <a href="portfolio-form.php?type=condominio" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center gap-1 transition-all shadow-lg shadow-brand-green/10 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
        Adicionar Novo Caso
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($items as $item): ?>
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl overflow-hidden group hover:border-white/10 transition-all flex flex-col justify-between">
            <div>
                <div class="relative aspect-video bg-black/40 overflow-hidden">
                    <img src="<?php echo htmlspecialchars('../' . $item['image']); ?>" alt="<?php echo htmlspecialchars($item['model']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute top-3 left-3 bg-brand-bg/80 backdrop-blur-md border border-white/10 text-brand-green font-bold text-[10px] px-2.5 py-1 rounded-full uppercase tracking-wider">
                        <?php echo htmlspecialchars($item['tipo_sub'] ?? 'Condomínio'); ?>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-white font-bold text-base mb-1"><?php echo htmlspecialchars($item['model']); ?></h3>
                    <p class="text-brand-muted text-xs mb-3 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-brand-green shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                        <?php echo htmlspecialchars($item['location']); ?>
                    </p>
                    <p class="text-white/70 text-xs line-clamp-2 mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                </div>
            </div>

            <div class="p-5 pt-0 border-t border-white/5 flex items-center justify-between gap-2 mt-auto">
                <a href="portfolio-form.php?type=condominio&id=<?php echo $item['id']; ?>" class="flex-1 text-center py-2 rounded-xl border border-white/5 hover:bg-white/5 text-white text-xs font-semibold transition-all">
                    Editar
                </a>
                <form method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este caso?');">
                    <input type="hidden" name="action" value="delete_item">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="px-3 py-2 rounded-xl border border-red-500/20 hover:bg-red-500/10 text-red-400 text-xs font-semibold transition-all">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php admin_footer(); ?>
