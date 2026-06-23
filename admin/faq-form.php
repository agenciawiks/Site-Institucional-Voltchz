<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Pergunta Frequente (FAQ)
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$faq_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$faq_id;

// Dados default da FAQ
$faq = [
    'question' => '',
    'answer' => '',
    'sort_order' => 0,
    'active' => 1
];

// Se for edição, busca do banco
if ($is_edit) {
    try {
        $stmt = $db->prepare("SELECT * FROM faq WHERE id = ?");
        $stmt->execute([$faq_id]);
        $loaded_faq = $stmt->fetch();
        if ($loaded_faq) {
            $faq = $loaded_faq;
        } else {
            header('Location: faq.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar FAQ: " . $e->getMessage();
    }
}

// Processa o form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_SPECIAL_CHARS);
    $answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_SPECIAL_CHARS);
    $sort_order = filter_input(INPUT_POST, 'sort_order', FILTER_VALIDATE_INT) ?: 0;
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($question) || empty($answer)) {
        $error_message = "Pergunta e Resposta são obrigatórias.";
    } else {
        try {
            if ($is_edit) {
                $stmtUp = $db->prepare("UPDATE faq SET question = ?, answer = ?, sort_order = ?, active = ? WHERE id = ?");
                $stmtUp->execute([$question, $answer, $sort_order, $active, $faq_id]);
            } else {
                $stmtIn = $db->prepare("INSERT INTO faq (question, answer, sort_order, active) VALUES (?, ?, ?, ?)");
                $stmtIn->execute([$question, $answer, $sort_order, $active]);
            }
            header("Location: faq.php?saved=1");
            exit;
        } catch (Exception $e) {
            $error_message = "Erro ao salvar FAQ: " . $e->getMessage();
            $faq = [
                'question' => $question,
                'answer' => $answer,
                'sort_order' => $sort_order,
                'active' => $active
            ];
        }
    }
}

admin_header($is_edit ? "Editar FAQ" : "Cadastrar FAQ", "faq");
?>

<?php if (!empty($error_message)): ?>
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<form method="POST" action="" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- PRINCIPAL CONFIG -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Dados da FAQ</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Pergunta / Dúvida</label>
                <input type="text" name="question" value="<?php echo htmlspecialchars($faq['question']); ?>" required placeholder="ex: 1. Qual a potência ideal de carregador para uso residencial?"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Resposta Detalhada</label>
                <textarea name="answer" rows="8" required placeholder="Escreva a resposta completa para a dúvida..."
                          class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30 resize-y"><?php echo htmlspecialchars($faq['answer']); ?></textarea>
            </div>
        </div>
    </div>

    <!-- CONFIGURAÇÕES SECUNDÁRIAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Exibição & Ordem</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Ordem de Ordenação</label>
                <input type="number" name="sort_order" value="<?php echo (int)$faq['sort_order']; ?>" min="0" required
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="faq-active" name="active" value="1" <?php echo $faq['active'] ? 'checked' : ''; ?>
                       class="w-4 h-4 rounded border-white/5 bg-brand-bg3/50 text-brand-green focus:ring-brand-green/30 focus:ring-2">
                <label for="faq-active" class="text-xs font-semibold text-brand-text cursor-pointer select-none">Exibir na Home (Ativa)</label>
            </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
            <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                Salvar FAQ
            </button>
            <a href="faq.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
                Cancelar e Voltar
            </a>
        </div>
    </div>
</form>

<?php
admin_footer();
?>
