<?php
/**
 * VoltchZ Brasil - Gerenciamento de Perguntas Frequentes (FAQ)
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Exclusão de FAQ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_faq') {
    $faq_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($faq_id) {
        try {
            $stmt = $db->prepare("DELETE FROM faq WHERE id = ?");
            $stmt->execute([$faq_id]);
            $success_message = "FAQ excluída com sucesso.";
        } catch (Exception $e) {
            $error_message = "Erro ao excluir FAQ: " . $e->getMessage();
        }
    }
}

// Busca todas as FAQs
try {
    $stmt = $db->query("SELECT * FROM faq ORDER BY sort_order ASC, id DESC");
    $faqs = $stmt->fetchAll();
} catch (Exception $e) {
    $faqs = [];
    $error_message = "Erro ao buscar FAQs: " . $e->getMessage();
}

admin_header("Gerenciar FAQ", "faq");
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
    <span class="text-xs text-brand-muted">As perguntas frequentes são exibidas no sanfonado (accordion) na página inicial do site.</span>
    <a href="faq-form.php" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-1 transition-all shadow-lg shadow-brand-green/10">
        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
        <span>Nova Pergunta</span>
    </a>
</div>

<!-- FAQ LIST -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <?php if (empty($faqs)): ?>
        <div class="text-center py-20 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
            <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path></svg>
            <h4 class="text-white font-semibold text-sm">Nenhuma pergunta cadastrada</h4>
            <p class="text-xs text-brand-muted/70 mt-1">Crie uma nova pergunta clicando no botão verde acima.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-4 rounded-l-xl">Pergunta</th>
                        <th class="py-3 px-4">Resposta</th>
                        <th class="py-3 px-4">Ordem</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($faqs as $f): ?>
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="py-4 px-4 font-semibold text-white max-w-xs">
                                <span class="block truncate font-bold text-white"><?php echo htmlspecialchars($f['question']); ?></span>
                            </td>
                            <td class="py-4 px-4 max-w-sm">
                                <p class="text-xs text-brand-muted/80 line-clamp-2"><?php echo htmlspecialchars($f['answer']); ?></p>
                            </td>
                            <td class="py-4 px-4 text-xs font-mono text-white">
                                <?php echo (int)$f['sort_order']; ?>
                            </td>
                            <td class="py-4 px-4">
                                <?php if ($f['active']): ?>
                                    <span class="px-2 py-0.5 rounded bg-brand-green/10 border border-brand-green/20 text-brand-green text-[10px] font-semibold uppercase tracking-wider">Ativa</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-brand-muted text-[10px] font-semibold uppercase tracking-wider">Inativa</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="faq-form.php?id=<?php echo $f['id']; ?>" class="p-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 hover:text-white text-brand-muted transition-all" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                    </a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Tem certeza que deseja excluir esta pergunta?');" class="inline">
                                        <input type="hidden" name="action" value="delete_faq">
                                        <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
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
