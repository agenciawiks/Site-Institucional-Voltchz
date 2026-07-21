<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Imagem do Portfólio Home
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$item_id;

// Dados default do item
$item = [
    'image' => '',
    'sort_order' => 0,
    'active' => 1
];

// Se for edição, busca do banco
if ($is_edit) {
    try {
        $stmt = $db->prepare("SELECT * FROM portfolio_home WHERE id = ?");
        $stmt->execute([$item_id]);
        $loaded_item = $stmt->fetch();
        if ($loaded_item) {
            $item = $loaded_item;
        } else {
            header('Location: portfolio-home.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar item de portfólio: " . $e->getMessage();
    }
}

// Processa o form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);
    $sort_order = filter_input(INPUT_POST, 'sort_order', FILTER_VALIDATE_INT) ?: 0;
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($image)) {
        $error_message = "A imagem é obrigatória.";
    } else {
        try {
            if ($is_edit) {
                $old_image = $item['image'] ?? '';

                $stmtUp = $db->prepare("UPDATE portfolio_home SET image = ?, sort_order = ?, active = ? WHERE id = ?");
                $stmtUp->execute([$image, $sort_order, $active, $item_id]);

                // Remove fisicamente a imagem antiga se ela foi trocada
                if ($old_image !== '' && $old_image !== $image) {
                    uploads_delete($old_image);
                }
            } else {
                $stmtIn = $db->prepare("INSERT INTO portfolio_home (image, sort_order, active) VALUES (?, ?, ?)");
                $stmtIn->execute([$image, $sort_order, $active]);
            }
            header("Location: portfolio-home.php?saved=1");
            exit;
        } catch (Exception $e) {
            $error_message = "Erro ao salvar item de portfólio: " . $e->getMessage();
            $item = [
                'image' => $image,
                'sort_order' => $sort_order,
                'active' => $active
            ];
        }
    }
}

admin_header($is_edit ? "Editar Imagem do Portfólio Home" : "Adicionar Nova Imagem", "portfolio-home");
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
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Informações da Imagem</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Imagem do Portfólio</label>
                <div class="flex gap-2">
                    <input type="text" id="portfolio-home-image" name="image" value="<?php echo htmlspecialchars($item['image']); ?>" required placeholder="ex: static/clientes/cliente-1.webp"
                           class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30 font-mono">
                    <input type="file" id="portfolio-home-file-input" class="hidden" accept="image/*">
                    <button type="button" onclick="triggerUpload('portfolio-home-file-input', 'portfolio-home-image', 'portfolio-home-preview')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 rounded-xl text-xs transition-all">
                        Upload
                    </button>
                </div>
                <div id="portfolio-home-preview-container" class="mt-3 p-2 bg-brand-bg3/25 border border-white/5 rounded-xl inline-block <?php echo empty($item['image']) ? 'hidden' : ''; ?>">
                    <img id="portfolio-home-preview" src="<?php echo !empty($item['image']) ? '../' . $item['image'] : ''; ?>" class="max-h-36 rounded-lg object-contain">
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIGURAÇÕES SECUNDÁRIAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Exibição & Ordem</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Ordem de Exibição</label>
                <input type="number" name="sort_order" value="<?php echo (int)$item['sort_order']; ?>" min="0" required
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="portfolio-home-active" name="active" value="1" <?php echo $item['active'] ? 'checked' : ''; ?>
                       class="w-4 h-4 rounded border-white/5 bg-brand-bg3/50 text-brand-green focus:ring-brand-green/30 focus:ring-2">
                <label for="portfolio-home-active" class="text-xs font-semibold text-brand-text cursor-pointer select-none">Exibir no Carrossel (Ativo)</label>
            </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
            <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                Salvar Imagem
            </button>
            <a href="portfolio-home.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
                Cancelar e Voltar
            </a>
        </div>
    </div>
</form>

<script>
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
            
            fetch('upload.php?type=portfolio_home', {
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
</script>

<?php
admin_footer();
?>
