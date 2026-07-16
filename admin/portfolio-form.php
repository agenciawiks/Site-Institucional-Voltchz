<?php
/**
 * VoltchZ Brasil - Cadastrar / Editar Item do Portfólio
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$portfolio_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$portfolio_id;

// Dados default do portfólio
$portfolio = [
    'tipo' => 'veiculo',
    'brand' => '',
    'model' => '',
    'location' => '',
    'description' => '',
    'image' => ''
];

// Busca marcas distintas cadastradas para o preenchimento automático
try {
    $stmtB = $db->query("SELECT DISTINCT brand FROM portfolio ORDER BY brand ASC");
    $existing_brands = $stmtB->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $existing_brands = [];
}

// Se for edição, carrega do banco
if ($is_edit) {
    try {
        $stmt = $db->prepare("SELECT * FROM portfolio WHERE id = ?");
        $stmt->execute([$portfolio_id]);
        $loaded_portfolio = $stmt->fetch();
        if ($loaded_portfolio) {
            $portfolio = $loaded_portfolio;
        } else {
            header('Location: portfolio.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar item do portfólio: " . $e->getMessage();
    }
}

// Processa o form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? 'veiculo';
    $model = trim($_POST['model'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    
    // Processamento da marca
    if ($tipo === 'condominio' || $tipo === 'construtora' || $tipo === 'eletroposto') {
        $brand = $tipo;
    } else {
        $brand_selected = $_POST['brand'] ?? '';
        if ($brand_selected === 'new') {
            $brand = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['brand_new'] ?? '')));
        } else {
            $brand = $brand_selected;
        }
    }

    if (empty($brand) || empty($model) || empty($location) || empty($image)) {
        $error_message = "Marca/Tipo, Nome do Projeto/Modelo, Localização e Imagens são campos obrigatórios.";
    } else {
        try {
            if ($is_edit) {
                $old_images = array_filter(array_map('trim', explode(',', $portfolio['image'] ?? '')));

                $stmtUp = $db->prepare("UPDATE portfolio SET tipo = ?, brand = ?, model = ?, location = ?, description = ?, image = ? WHERE id = ?");
                $stmtUp->execute([$tipo, $brand, $model, $location, $description, $image, $portfolio_id]);

                // Remove fisicamente as imagens antigas que saíram da lista (trocadas ou removidas)
                $new_images = array_filter(array_map('trim', explode(',', $image)));
                foreach (array_diff($old_images, $new_images) as $removed_image) {
                    uploads_delete($removed_image);
                }
            } else {
                $stmtIn = $db->prepare("INSERT INTO portfolio (tipo, brand, model, location, description, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtIn->execute([$tipo, $brand, $model, $location, $description, $image]);
            }
            header("Location: portfolio.php?saved=1");
            exit;
        } catch (Exception $e) {
            $error_message = "Erro ao salvar item do portfólio: " . $e->getMessage();
            $portfolio = [
                'tipo' => $tipo,
                'brand' => $brand,
                'model' => $model,
                'location' => $location,
                'description' => $description,
                'image' => $image
            ];
        }
    }
}

admin_header($is_edit ? "Editar Caso de Sucesso" : "Cadastrar Novo Caso", "portfolio");
?>

<?php if (!empty($error_message)): ?>
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<form method="POST" action="" class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-outfit">
    <!-- PRINCIPAL CONFIG -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Informações Técnicas & Local</h3>

            <!-- TIPO DE INSTALAÇÃO -->
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Tipo de Instalação</label>
                <select id="tipo-select" name="tipo" required class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                    <option value="veiculo" <?php echo ($portfolio['tipo'] === 'veiculo') ? 'selected' : ''; ?>>Residencial (Veículo/Montadora)</option>
                    <option value="condominio" <?php echo ($portfolio['tipo'] === 'condominio') ? 'selected' : ''; ?>>Infraestrutura Coletiva (Condomínio)</option>
                    <option value="construtora" <?php echo ($portfolio['tipo'] === 'construtora') ? 'selected' : ''; ?>>Infraestrutura Coletiva (Construtora)</option>
                    <option value="eletroposto" <?php echo ($portfolio['tipo'] === 'eletroposto') ? 'selected' : ''; ?>>Comercial & Eletroposto</option>
                </select>
            </div>

            <!-- BRAND SELECT & NEW INPUT -->
            <div id="brand-selection-block" class="<?php echo ($portfolio['tipo'] === 'condominio' || $portfolio['tipo'] === 'construtora' || $portfolio['tipo'] === 'eletroposto') ? 'hidden' : ''; ?>">
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Marca do Veículo</label>
                <select id="brand-select" name="brand" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" <?php echo ($portfolio['tipo'] !== 'condominio' && $portfolio['tipo'] !== 'construtora' && $portfolio['tipo'] !== 'eletroposto') ? 'required' : ''; ?>>
                    <option value="">Selecione uma marca existente...</option>
                    <?php foreach ($existing_brands as $eb): 
                        if ($eb === 'condominio' || $eb === 'construtora' || $eb === 'eletroposto') continue;
                    ?>
                        <option value="<?php echo htmlspecialchars($eb); ?>" <?php echo ($portfolio['brand'] === $eb) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars(strtoupper($eb)); ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="new" <?php echo ($is_edit && $portfolio['brand'] !== 'condominio' && $portfolio['brand'] !== 'construtora' && $portfolio['brand'] !== 'eletroposto' && !in_array($portfolio['brand'], $existing_brands)) ? 'selected' : ''; ?>>[Nova Marca...]</option>
                </select>

                <div id="new-brand-container" class="mt-4 <?php echo ($is_edit && $portfolio['brand'] !== 'condominio' && $portfolio['brand'] !== 'construtora' && $portfolio['brand'] !== 'eletroposto' && !in_array($portfolio['brand'], $existing_brands)) ? '' : 'hidden'; ?>">
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Nome da Nova Marca (Slug/Letras Minúsculas)</label>
                    <input type="text" id="brand-new" name="brand_new" value="<?php echo htmlspecialchars(($portfolio['brand'] !== 'condominio' && $portfolio['brand'] !== 'construtora' && $portfolio['brand'] !== 'eletroposto') ? $portfolio['brand'] : ''); ?>" placeholder="ex: byd, gwm, porsche, tesla..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Modelo / Veículo</label>
                    <input type="text" name="model" value="<?php echo htmlspecialchars($portfolio['model']); ?>" required placeholder="ex: BYD Dolphin Plus"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Localização / Cidade / Condomínio</label>
                    <input type="text" name="location" value="<?php echo htmlspecialchars($portfolio['location']); ?>" required placeholder="ex: Condomínio Alphaville, SJC"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Descrição dos Equipamentos e Instalação</label>
                <textarea name="description" rows="5" required placeholder="ex: Instalação de Wallbox de 7.4 kW com Quadro de Proteção E-Wolf e infraestrutura dedicada de eletrodutos de aço galvanizado."
                          class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30 resize-y"><?php echo htmlspecialchars($portfolio['description']); ?></textarea>
            </div>
        </div>
    </div>

    <!-- IMAGEM E SALVAR -->
    <div class="space-y-6">
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Imagem Real</h3>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Fotos da Instalação / Carregador</label>
                <input type="hidden" id="portfolio-image" name="image" value="<?php echo htmlspecialchars($portfolio['image']); ?>" required>
                
                <!-- Grade de Imagens Adicionadas -->
                <div id="images-grid" class="grid grid-cols-2 gap-3 mb-4">
                    <!-- Gerado dinamicamente via JS -->
                </div>

                <input type="file" id="portfolio-file-input" class="hidden" accept="image/*" multiple>
                <button type="button" onclick="triggerMultipleUpload()" class="w-full bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold py-2.5 px-4 rounded-xl text-xs transition-all flex items-center justify-center gap-2">
                    <svg class="w-4.5 h-4.5 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                    Fazer Upload de Fotos
                </button>
                <p class="text-[10px] text-brand-muted/50 mt-2">Você pode enviar mais de uma foto para criar um carrossel de fotos no site.</p>
            </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
            <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                Salvar Projeto
            </button>
            <a href="portfolio.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
                Cancelar e Voltar
            </a>
        </div>
    </div>
</form>

<script>
    // Gerenciador do select de nova marca
    const tipoSelect = document.getElementById('tipo-select');
    const brandBlock = document.getElementById('brand-selection-block');
    const select = document.getElementById('brand-select');
    const newBrandContainer = document.getElementById('new-brand-container');
    const brandNewInput = document.getElementById('brand-new');

    if (tipoSelect && brandBlock && select) {
        tipoSelect.addEventListener('change', function() {
            if (this.value === 'condominio' || this.value === 'construtora' || this.value === 'eletroposto') {
                brandBlock.classList.add('hidden');
                select.required = false;
                brandNewInput.required = false;
            } else {
                brandBlock.classList.remove('hidden');
                select.required = true;
                if (select.value === 'new') {
                    brandNewInput.required = true;
                }
            }
        });
    }

    if (select && newBrandContainer && brandNewInput) {
        select.addEventListener('change', function() {
            if (this.value === 'new') {
                newBrandContainer.classList.remove('hidden');
                brandNewInput.required = true;
                brandNewInput.focus();
            } else {
                newBrandContainer.classList.add('hidden');
                brandNewInput.required = false;
            }
        });
    }

    // Gerenciador de múltiplas imagens
    const imageInput = document.getElementById('portfolio-image');
    const imagesGrid = document.getElementById('images-grid');
    let imagesList = imageInput.value ? imageInput.value.split(',').filter(Boolean) : [];

    function renderImagesGrid() {
        imagesGrid.innerHTML = '';
        if (imagesList.length === 0) {
            imagesGrid.innerHTML = '<div class="col-span-2 text-[11px] text-brand-muted/40 italic py-4 text-center border border-dashed border-white/5 rounded-xl">Nenhuma imagem enviada</div>';
            return;
        }

        imagesList.forEach((img, idx) => {
            const card = document.createElement('div');
            card.className = 'relative aspect-square bg-brand-bg3/40 border border-white/5 rounded-xl overflow-hidden p-1 flex items-center justify-center';
            card.innerHTML = `
                <img src="../${img}" class="max-h-full max-w-full rounded-lg object-cover">
                <button type="button" onclick="removeImageIndex(${idx})" class="absolute top-1.5 right-1.5 bg-red-500/80 hover:bg-red-500 text-white p-1 rounded-lg transition-colors cursor-pointer" title="Remover imagem">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
            imagesGrid.appendChild(card);
        });
    }

    window.removeImageIndex = function(idx) {
        imagesList.splice(idx, 1);
        imageInput.value = imagesList.join(',');
        renderImagesGrid();
    };

    window.triggerMultipleUpload = function() {
        const fileInput = document.getElementById('portfolio-file-input');
        fileInput.click();
        
        fileInput.onchange = function() {
            if (fileInput.files.length === 0) return;
            
            const files = Array.from(fileInput.files);
            const btn = fileInput.nextElementSibling;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Enviando...';
            btn.disabled = true;

            let uploadPromises = files.map(file => {
                const formData = new FormData();
                formData.append('file', file);
                return fetch('upload.php?type=portfolio', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        imagesList.push(data.path);
                    } else {
                        alert(data.message || 'Erro ao fazer upload de uma das imagens.');
                    }
                })
                .catch(() => {
                    alert('Erro na comunicação com o servidor para uma das imagens.');
                });
            });

            Promise.all(uploadPromises).then(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                imageInput.value = imagesList.join(',');
                renderImagesGrid();
                fileInput.value = ''; // Reset file input
            });
        };
    };

    // Inicializa a grade de imagens
    renderImagesGrid();
</script>

<?php
admin_footer();
?>
