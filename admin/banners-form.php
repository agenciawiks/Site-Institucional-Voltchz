<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Banner da Home
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$banner_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$banner_id;

// Dados default do banner
$banner = [
    'image' => '',
    'title' => '',
    'subtitle' => '',
    'button_text' => '',
    'button_link' => '',
    'sort_order' => 0,
    'active' => 1
];

// Se for edição, busca do banco
if ($is_edit) {
    try {
        $stmt = $db->prepare("SELECT * FROM banners WHERE id = ?");
        $stmt->execute([$banner_id]);
        $loaded_banner = $stmt->fetch();
        if ($loaded_banner) {
            $banner = $loaded_banner;
        } else {
            header('Location: banners.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar banner: " . $e->getMessage();
    }
}

// Processa o form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
    $button_text = filter_input(INPUT_POST, 'button_text', FILTER_SANITIZE_SPECIAL_CHARS);
    $button_link = filter_input(INPUT_POST, 'button_link', FILTER_SANITIZE_SPECIAL_CHARS);
    $sort_order = filter_input(INPUT_POST, 'sort_order', FILTER_VALIDATE_INT) ?: 0;
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($image) || empty($title)) {
        $error_message = "Imagem e Título Principal são obrigatórios.";
    } else {
        try {
            if ($is_edit) {
                $stmtUp = $db->prepare("UPDATE banners SET image = ?, title = ?, subtitle = ?, button_text = ?, button_link = ?, sort_order = ?, active = ? WHERE id = ?");
                $stmtUp->execute([$image, $title, $subtitle, $button_text, $button_link, $sort_order, $active, $banner_id]);
            } else {
                $stmtIn = $db->prepare("INSERT INTO banners (image, title, subtitle, button_text, button_link, sort_order, active) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmtIn->execute([$image, $title, $subtitle, $button_text, $button_link, $sort_order, $active]);
            }
            header("Location: banners.php?saved=1");
            exit;
        } catch (Exception $e) {
            $error_message = "Erro ao salvar banner: " . $e->getMessage();
            $banner = [
                'image' => $image,
                'title' => $title,
                'subtitle' => $subtitle,
                'button_text' => $button_text,
                'button_link' => $button_link,
                'sort_order' => $sort_order,
                'active' => $active
            ];
        }
    }
}

admin_header($is_edit ? "Editar Banner" : "Cadastrar Novo Banner", "banners");
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
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Conteúdo do Slide</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Título Principal (Foco)</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($banner['title']); ?>" required placeholder="ex: Energia para o futuro, segurança no agora"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Subtítulo / Descrição Auxiliar</label>
                <textarea name="subtitle" rows="3" placeholder="Descrição menor que aparece abaixo do título do slide..."
                          class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30 resize-y"><?php echo htmlspecialchars($banner['subtitle']); ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Texto do Botão (Opcional)</label>
                    <input type="text" name="button_text" value="<?php echo htmlspecialchars($banner['button_text']); ?>" placeholder="ex: Solicitar Orçamento"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Link do Botão (Opcional)</label>
                    <input type="text" name="button_link" value="<?php echo htmlspecialchars($banner['button_link']); ?>" placeholder="ex: contato ou URL externa"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
            </div>
        </div>
    </div>

    <!-- IMAGEM E CONFIGURAÇÕES SECUNDÁRIAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Imagem & Exibição</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Imagem de Fundo do Banner</label>
                <div class="flex gap-2">
                    <input type="text" id="banner-imagem" name="image" value="<?php echo htmlspecialchars($banner['image']); ?>" required placeholder="ex: static/banner-rotativo-01webp.webp"
                           class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    <input type="file" id="banner-file-input" class="hidden" accept="image/*">
                    <button type="button" onclick="triggerUpload('banner-file-input', 'banner-imagem', 'banner-preview')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 rounded-xl text-xs transition-all">
                        Upload
                    </button>
                </div>
                <div id="banner-preview-container" class="mt-3 p-2 bg-brand-bg3/25 border border-white/5 rounded-xl inline-block <?php echo empty($banner['image']) ? 'hidden' : ''; ?>">
                    <img id="banner-preview" src="<?php echo !empty($banner['image']) ? '../' . $banner['image'] : ''; ?>" class="max-h-24 rounded-lg object-contain">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Ordem de Exibição</label>
                <input type="number" name="sort_order" value="<?php echo (int)$banner['sort_order']; ?>" min="0" required
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="banner-active" name="active" value="1" <?php echo $banner['active'] ? 'checked' : ''; ?>
                       class="w-4 h-4 rounded border-white/5 bg-brand-bg3/50 text-brand-green focus:ring-brand-green/30 focus:ring-2">
                <label for="banner-active" class="text-xs font-semibold text-brand-text cursor-pointer select-none">Exibir na Home (Ativo)</label>
            </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
            <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                Salvar Banner
            </button>
            <a href="banners.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
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
            
            fetch('upload.php?type=banner', {
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
