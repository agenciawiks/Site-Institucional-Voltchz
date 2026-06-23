<?php
/**
 * VoltchZ Brasil - Gerenciamento de Depoimentos de Clientes
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Exclusão de Depoimento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_depoimento') {
    $depoimento_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($depoimento_id) {
        try {
            // Busca a imagem do avatar para deleção física no disco
            $stmtImg = $db->prepare("SELECT image_avatar FROM depoimentos WHERE id = ?");
            $stmtImg->execute([$depoimento_id]);
            $avatar_image = $stmtImg->fetchColumn();

            // Exclui do banco
            $stmt = $db->prepare("DELETE FROM depoimentos WHERE id = ?");
            $stmt->execute([$depoimento_id]);

            // Se for arquivo em static/uploads/, deleta fisicamente
            if (!empty($avatar_image) && strpos($avatar_image, 'static/uploads/') === 0) {
                $physical_path = __DIR__ . '/../' . $avatar_image;
                if (file_exists($physical_path)) {
                    @unlink($physical_path);
                }
            }

            $success_message = "Depoimento excluído com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir depoimento: " . $e->getMessage();
        }
    }
}

// Busca todos os depoimentos
try {
    $stmt = $db->query("SELECT * FROM depoimentos ORDER BY id DESC");
    $depoimentos = $stmt->fetchAll();
} catch (Exception $e) {
    $depoimentos = [];
    $error_message = "Erro ao buscar depoimentos: " . $e->getMessage();
}

admin_header("Gerenciar Depoimentos", "depoimentos");
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

<!-- TOP ACTIONS -->
<div class="flex justify-between items-center bg-brand-bg2 border border-white/5 rounded-2xl p-5 mb-8">
    <span class="text-xs text-brand-muted">Depoimentos dos clientes são exibidos na Home em formato de carrossel/slider.</span>
    <a href="depoimentos-form.php" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-1 transition-all shadow-lg shadow-brand-green/10">
        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
        <span>Novo Depoimento</span>
    </a>
</div>

<!-- TESTIMONIALS LIST -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <?php if (empty($depoimentos)): ?>
        <div class="text-center py-20 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
            <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path></svg>
            <h4 class="text-white font-semibold text-sm">Nenhum depoimento cadastrado</h4>
            <p class="text-xs text-brand-muted/70 mt-1">Crie um novo depoimento clicando no botão verde acima.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-4 rounded-l-xl">Avatar</th>
                        <th class="py-3 px-4">Autor & Cargo</th>
                        <th class="py-3 px-4">Depoimento</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($depoimentos as $d): 
                        $avatar = !empty($d['image_avatar']) ? '../' . $d['image_avatar'] : '';
                    ?>
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="py-4 px-4 shrink-0">
                                <?php if (!empty($d['image_avatar'])): ?>
                                    <div class="w-10 h-10 rounded-full bg-brand-bg3 border border-white/5 overflow-hidden flex items-center justify-center">
                                        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-brand-green/10 border border-brand-green/20 text-brand-green flex items-center justify-center shrink-0 font-bold text-xs uppercase">
                                        <?php echo htmlspecialchars(substr($d['name'], 0, 2)); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4">
                                <span class="block font-bold text-white"><?php echo htmlspecialchars($d['name']); ?></span>
                                <span class="block text-[11px] font-medium text-brand-muted/80"><?php echo htmlspecialchars($d['role_condo']); ?></span>
                            </td>
                            <td class="py-4 px-4 max-w-sm">
                                <p class="text-xs text-brand-muted/80 line-clamp-2"><?php echo htmlspecialchars($d['testimonial']); ?></p>
                            </td>
                            <td class="py-4 px-4">
                                <?php if ($d['active']): ?>
                                    <span class="px-2 py-0.5 rounded bg-brand-green/10 border border-brand-green/20 text-brand-green text-[10px] font-semibold uppercase tracking-wider">Ativo</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-brand-muted text-[10px] font-semibold uppercase tracking-wider">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="depoimentos-form.php?id=<?php echo $d['id']; ?>" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 hover:text-white text-brand-muted transition-all" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Tem certeza que deseja excluir o depoimento de <?php echo htmlspecialchars($d['name']); ?>?');" class="inline">
                                        <input type="hidden" name="action" value="delete_depoimento">
                                        <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
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
