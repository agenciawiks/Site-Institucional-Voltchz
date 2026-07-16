<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Depoimento
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$depoimento_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$depoimento_id;

// Dados default do depoimento
$depoimento = [
    'name' => '',
    'role_condo' => '',
    'testimonial' => '',
    'image_avatar' => '',
    'active' => 1
];

// Se for edição, busca do banco
if ($is_edit) {
    try {
        $stmt = $db->prepare("SELECT * FROM depoimentos WHERE id = ?");
        $stmt->execute([$depoimento_id]);
        $loaded_depoimento = $stmt->fetch();
        if ($loaded_depoimento) {
            $depoimento = $loaded_depoimento;
        } else {
            header('Location: depoimentos.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar depoimento: " . $e->getMessage();
    }
}

// Processa o form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $role_condo = filter_input(INPUT_POST, 'role_condo', FILTER_SANITIZE_SPECIAL_CHARS);
    $testimonial = filter_input(INPUT_POST, 'testimonial', FILTER_SANITIZE_SPECIAL_CHARS);
    $image_avatar = filter_input(INPUT_POST, 'image_avatar', FILTER_SANITIZE_SPECIAL_CHARS);
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($name) || empty($role_condo) || empty($testimonial)) {
        $error_message = "Nome, Cargo/Condomínio e Texto do Depoimento são obrigatórios.";
    } else {
        try {
            if ($is_edit) {
                $old_image_avatar = $depoimento['image_avatar'] ?? '';

                $stmtUp = $db->prepare("UPDATE depoimentos SET name = ?, role_condo = ?, testimonial = ?, image_avatar = ?, active = ? WHERE id = ?");
                $stmtUp->execute([$name, $role_condo, $testimonial, $image_avatar ?: null, $active, $depoimento_id]);

                // Remove fisicamente o avatar antigo se ele foi trocado/removido
                if (!empty($old_image_avatar) && $old_image_avatar !== $image_avatar) {
                    uploads_delete($old_image_avatar);
                }
            } else {
                $stmtIn = $db->prepare("INSERT INTO depoimentos (name, role_condo, testimonial, image_avatar, active) VALUES (?, ?, ?, ?, ?)");
                $stmtIn->execute([$name, $role_condo, $testimonial, $image_avatar ?: null, $active]);
            }
            header("Location: depoimentos.php?saved=1");
            exit;
        } catch (Exception $e) {
            $error_message = "Erro ao salvar depoimento: " . $e->getMessage();
            $depoimento = [
                'name' => $name,
                'role_condo' => $role_condo,
                'testimonial' => $testimonial,
                'image_avatar' => $image_avatar,
                'active' => $active
            ];
        }
    }
}

admin_header($is_edit ? "Editar Depoimento" : "Cadastrar Depoimento", "depoimentos");
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
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Dados do Depoimento</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Nome do Autor</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($depoimento['name']); ?>" required placeholder="ex: Marcelo G."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Cargo / Condomínio / Empresa</label>
                    <input type="text" name="role_condo" value="<?php echo htmlspecialchars($depoimento['role_condo']); ?>" required placeholder="ex: Síndico do Condomínio Esplanada"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Texto do Depoimento</label>
                <textarea name="testimonial" rows="6" required placeholder="Escreva o relato do cliente sobre os serviços prestados pela VoltchZ..."
                          class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30 resize-y"><?php echo htmlspecialchars($depoimento['testimonial']); ?></textarea>
            </div>
        </div>
    </div>

    <!-- IMAGEM E CONFIGURAÇÕES SECUNDÁRIAS -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Avatar & Status</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Imagem de Avatar (Opcional)</label>
                <div class="flex gap-2">
                    <input type="text" id="depoimento-avatar" name="image_avatar" value="<?php echo htmlspecialchars($depoimento['image_avatar'] ?? ''); ?>" placeholder="ex: static/uploads/avatar.jpg"
                           class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    <input type="file" id="depoimento-file-input" class="hidden" accept="image/*">
                    <button type="button" onclick="triggerUpload('depoimento-file-input', 'depoimento-avatar', 'depoimento-preview')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 rounded-xl text-xs transition-all">
                        Upload
                    </button>
                </div>
                <div id="depoimento-preview-container" class="mt-3 p-2 bg-brand-bg3/25 border border-white/5 rounded-xl inline-block <?php echo empty($depoimento['image_avatar']) ? 'hidden' : ''; ?>">
                    <img id="depoimento-preview" src="<?php echo !empty($depoimento['image_avatar']) ? '../' . $depoimento['image_avatar'] : ''; ?>" class="max-h-24 rounded-full object-cover w-24 h-24">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="depoimento-active" name="active" value="1" <?php echo $depoimento['active'] ? 'checked' : ''; ?>
                       class="w-4 h-4 rounded border-white/5 bg-brand-bg3/50 text-brand-green focus:ring-brand-green/30 focus:ring-2">
                <label for="depoimento-active" class="text-xs font-semibold text-brand-text cursor-pointer select-none">Exibir no Carrossel (Ativo)</label>
            </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
            <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                Salvar Depoimento
            </button>
            <a href="depoimentos.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
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
            
            fetch('upload.php?type=depoimento', {
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
