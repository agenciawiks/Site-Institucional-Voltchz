<?php
/**
 * VoltchZ Brasil - Gerenciamento de Logomarcas do Carrossel (Portfólio)
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$success_message = '';
$error_message = '';

$marcas_json_path = __DIR__ . '/../static/logos-marcas/marcas.json';

// Função para ler marcas
function ler_marcas_json($path) {
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true);
        return is_array($data) ? $data : [];
    }
    return [];
}

// Função para salvar marcas
function salvar_marcas_json($path, $data) {
    return file_put_contents($path, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}

$marcas_list = ler_marcas_json($marcas_json_path);

// Processa formulários (Adicionar / Excluir)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // --- ADICIONAR MARCA ---
    if ($action === 'add_marca') {
        $nome = trim($_POST['nome'] ?? '');
        $hex_cor = trim($_POST['hex_cor'] ?? '#000000');
        
        // Slugify o nome
        $slug = preg_replace('/[^a-z0-9]/', '', strtolower($nome));

        // Validação de arquivo
        if (empty($nome)) {
            $error_message = "O nome da marca é obrigatório.";
        } elseif (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            $error_message = "O envio do arquivo de imagem/logo é obrigatório.";
        } else {
            $file = $_FILES['logo'];
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
            $file_info = pathinfo($file['name']);
            $extension = strtolower($file_info['extension'] ?? '');

            if (!in_array($extension, $allowed_extensions)) {
                $error_message = "Apenas arquivos de imagem são permitidos (JPG, JPEG, PNG, GIF, WEBP, SVG).";
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $error_message = "O arquivo de logo excede o limite máximo de 2MB.";
            } else {
                $upload_dir = __DIR__ . '/../static/uploads/marcas/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $new_filename = 'logo_' . $slug . '_' . time() . '.' . $extension;
                $dest_path = $upload_dir . $new_filename;

                if (move_uploaded_file($file['tmp_name'], $dest_path)) {
                    // Adiciona ao JSON
                    $nova_marca = [
                        'nome' => $nome,
                        'arquivo' => 'static/uploads/marcas/' . $new_filename,
                        'hex_cor' => $hex_cor,
                        'slug' => $slug,
                        'url_cdn' => ''
                    ];

                    $marcas_list[] = $nova_marca;
                    if (salvar_marcas_json($marcas_json_path, $marcas_list)) {
                        $success_message = "Marca '{$nome}' adicionada com sucesso ao carrossel.";
                    } else {
                        $error_message = "Erro ao atualizar a lista de marcas no JSON.";
                    }
                } else {
                    $error_message = "Erro ao mover o arquivo de upload para a pasta static/uploads/marcas/.";
                }
            }
        }
    }

    // --- DELETAR MARCA ---
    elseif ($action === 'delete_marca') {
        $slug_to_delete = $_POST['slug'] ?? '';
        $found = false;
        $updated_list = [];

        foreach ($marcas_list as $m) {
            if ($m['slug'] === $slug_to_delete) {
                $found = true;
                // Se o arquivo estiver em uploads, deleta fisicamente
                $arquivo = $m['arquivo'];
                if (strpos($arquivo, 'static/uploads/') === 0) {
                    $physical_path = __DIR__ . '/../' . $arquivo;
                    if (file_exists($physical_path)) {
                        @unlink($physical_path);
                    }
                }
            } else {
                $updated_list[] = $m;
            }
        }

        if ($found) {
            $marcas_list = $updated_list;
            if (salvar_marcas_json($marcas_json_path, $marcas_list)) {
                $success_message = "Marca removida com sucesso do carrossel.";
            } else {
                $error_message = "Erro ao atualizar a lista de marcas no JSON.";
            }
        } else {
            $error_message = "Marca não encontrada.";
        }
    }
}

admin_header("Logos do Carrossel", "marcas-carrossel");
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Adicionar Nova Marca -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 h-fit">
        <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3 mb-6">Nova Logomarca</h3>
        
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="action" value="add_marca">
            
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Nome da Marca</label>
                <input type="text" name="nome" required placeholder="ex: Porsche"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Cor de Destaque (Hexadecimal)</label>
                <div class="flex gap-2">
                    <input type="color" name="hex_cor" value="#22c55e" class="h-10 w-10 bg-transparent border-0 rounded cursor-pointer">
                    <input type="text" id="hex_text" value="#22c55e" readonly
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Logo (SVG, PNG ou WebP)</label>
                <input type="file" name="logo" accept=".svg,.png,.jpg,.jpeg,.webp" required
                       class="w-full text-xs text-brand-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer">
                <p class="text-[10px] text-brand-muted/50 mt-1">Prefira logos vetorizadas (SVG) ou com fundo transparente.</p>
            </div>

            <button type="submit" class="w-full bg-brand-green text-brand-bg font-extrabold py-3.5 px-6 rounded-xl hover:brightness-110 active:scale-95 transition-all text-xs uppercase tracking-wider">
                Adicionar ao Carrossel
            </button>
        </form>
    </div>

    <!-- Lista de Marcas do Carrossel -->
    <div class="lg:col-span-2 bg-brand-bg2 border border-white/5 rounded-2xl p-6">
        <h3 class="text-sm font-bold uppercase tracking-wider text-white border-b border-white/5 pb-3 mb-6">Marcas Ativas no Carrossel</h3>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <?php foreach ($marcas_list as $m): 
                $arquivo = $m['arquivo'];
                $path = (strpos($arquivo, '/') !== false) ? '../' . $arquivo : '../static/logos-marcas/' . $arquivo;
                $exists = file_exists($path);
            ?>
                <div class="relative bg-brand-bg3 border border-white/5 rounded-xl p-4 flex flex-col items-center justify-center min-h-[140px] group">
                    <!-- Deleção -->
                    <form method="POST" action="" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <input type="hidden" name="action" value="delete_marca">
                        <input type="hidden" name="slug" value="<?php echo htmlspecialchars($m['slug']); ?>">
                        <button type="submit" onclick="return confirm('Deseja realmente remover esta marca?');" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 p-1.5 rounded-lg transition-colors" title="Excluir Marca">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                    <!-- Preview da Imagem -->
                    <div class="h-12 flex items-center justify-center mb-3">
                        <?php if ($exists): ?>
                            <img src="<?php echo htmlspecialchars($path); ?>" class="max-h-full max-w-[80%] object-contain filter invert brightness-200 opacity-80" alt="<?php echo htmlspecialchars($m['nome']); ?>">
                        <?php else: ?>
                            <span class="text-[10px] text-red-400 italic">Arquivo não encontrado</span>
                        <?php endif; ?>
                    </div>

                    <!-- Nome e Cor -->
                    <span class="text-xs text-white font-semibold text-center mb-1"><?php echo htmlspecialchars($m['nome']); ?></span>
                    <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/5" style="color: <?php echo htmlspecialchars($m['hex_cor']); ?>"><?php echo htmlspecialchars($m['hex_cor']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    // Atualiza campo de texto com a cor escolhida
    const colorPicker = document.querySelector('input[type="color"]');
    const colorText = document.getElementById('hex_text');
    if (colorPicker && colorText) {
        colorPicker.addEventListener('input', (e) => {
            colorText.value = e.target.value.toUpperCase();
        });
    }
</script>
