<?php
/**
 * VoltchZ Brasil - Escrever / Editar Artigo do Blog
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/uploads.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

$artigo_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$is_edit = (bool)$artigo_id;

// Dados default do artigo
$artigo = [
    'titulo' => '',
    'slug' => '',
    'categoria' => '',
    'resumo' => '',
    'autor' => '',
    'cargo' => '',
    'data_publicacao' => date('d/m/Y'),
    'tempo_leitura' => '5 min',
    'svg_metadata_category' => '',
    'svg_metadata_title' => '',
    'svg_metadata_subtitle' => '',
    'imagem' => ''
];
$conteudo_blocos = [];

// Carrega dados atuais do banco se for edição
$tempo_valor = 5;
$tempo_unidade = 'min';
if ($is_edit) {
    try {
        $stmtArt = $db->prepare("SELECT * FROM artigos WHERE id = ?");
        $stmtArt->execute([$artigo_id]);
        $loaded_art = $stmtArt->fetch();
        
        if ($loaded_art) {
            $artigo = $loaded_art;
            
            if (!empty($artigo['tempo_leitura'])) {
                if (preg_match('/^(\d+)\s*(min|h|horas|minutos)/i', $artigo['tempo_leitura'], $matches)) {
                    $tempo_valor = intval($matches[1]);
                    $tempo_unidade = strtolower($matches[2]) === 'h' || strtolower($matches[2]) === 'horas' ? 'h' : 'min';
                }
            }
            
            // Carrega blocos
            $stmtCont = $db->prepare("SELECT id, tipo, texto, autor_citado FROM artigo_conteudo WHERE artigo_id = ? ORDER BY ordem ASC");
            $stmtCont->execute([$artigo_id]);
            $blocos = $stmtCont->fetchAll();
            
            foreach ($blocos as $bloco) {
                $blocoData = [
                    'tipo' => $bloco['tipo'],
                    'texto' => $bloco['texto'],
                    'autor_citado' => $bloco['autor_citado'],
                    'itens' => ''
                ];
                
                if ($bloco['tipo'] === 'list') {
                    $stmtList = $db->prepare("SELECT item FROM artigo_conteudo_list_items WHERE artigo_conteudo_id = ? ORDER BY ordem ASC");
                    $stmtList->execute([$bloco['id']]);
                    $listItems = $stmtList->fetchAll(PDO::FETCH_COLUMN);
                    $blocoData['itens'] = implode("\n", $listItems);
                }
                
                $conteudo_blocos[] = $blocoData;
            }
        } else {
            header('Location: blog.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = "Erro ao carregar artigo: " . $e->getMessage();
    }
}

// Processa salvamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['slug'] ?? '')));
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_SPECIAL_CHARS);
    $resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
    $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
    $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data_publicacao = filter_input(INPUT_POST, 'data_publicacao', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Concatena tempo_leitura a partir dos campos numérico e unidade
    $tempo_num = filter_input(INPUT_POST, 'tempo_leitura_num', FILTER_VALIDATE_INT) ?: 5;
    $tempo_uni = filter_input(INPUT_POST, 'tempo_leitura_unit', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'min';
    $tempo_leitura = $tempo_num . ' ' . $tempo_uni;
    
    $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Cover SVG Metadata
    $svg_metadata_category = filter_input(INPUT_POST, 'svg_metadata_category', FILTER_SANITIZE_SPECIAL_CHARS) ?: $categoria;
    $svg_metadata_title = filter_input(INPUT_POST, 'svg_metadata_title', FILTER_SANITIZE_SPECIAL_CHARS) ?: $titulo;
    $svg_metadata_subtitle = filter_input(INPUT_POST, 'svg_metadata_subtitle', FILTER_SANITIZE_SPECIAL_CHARS) ?: $resumo;

    // Blocos submetidos
    $post_bloco_tipos = $_POST['bloco_tipo'] ?? [];
    $post_bloco_textos = $_POST['bloco_texto'] ?? [];
    $post_bloco_autores = $_POST['bloco_autor'] ?? [];
    $post_bloco_itens = $_POST['bloco_itens'] ?? []; // list items separated by \n

    if (empty($titulo) || empty($slug) || empty($categoria)) {
        $error_message = "Título, identificador slug e tema/categoria do artigo são obrigatórios.";
    } else {
        try {
            $db->beginTransaction();

            // Verifica colisão de slug
            $stmtSlug = $db->prepare("SELECT COUNT(*) FROM artigos WHERE slug = ? AND id != ?");
            $stmtSlug->execute([$slug, $is_edit ? $artigo_id : 0]);
            if ($stmtSlug->fetchColumn() > 0) {
                throw new Exception("O identificador slug '{$slug}' já está sendo utilizado por outro artigo do blog.");
            }

            if ($is_edit) {
                $old_imagem = $artigo['imagem'] ?? '';

                $stmtUp = $db->prepare("UPDATE artigos SET slug = ?, titulo = ?, categoria = ?, resumo = ?, autor = ?, cargo = ?, data_publicacao = ?, tempo_leitura = ?, svg_metadata_category = ?, svg_metadata_title = ?, svg_metadata_subtitle = ?, imagem = ? WHERE id = ?");
                $stmtUp->execute([$slug, $titulo, $categoria, $resumo, $autor, $cargo, $data_publicacao, $tempo_leitura, $svg_metadata_category, $svg_metadata_title, $svg_metadata_subtitle, $imagem, $artigo_id]);
                $artId = $artigo_id;

                // Remove fisicamente a imagem de capa antiga se ela foi trocada/removida
                if (!empty($old_imagem) && $old_imagem !== $imagem) {
                    uploads_delete($old_imagem);
                }
            } else {
                $stmtIn = $db->prepare("INSERT INTO artigos (slug, titulo, categoria, resumo, autor, cargo, data_publicacao, tempo_leitura, svg_metadata_category, svg_metadata_title, svg_metadata_subtitle, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmtIn->execute([$slug, $titulo, $categoria, $resumo, $autor, $cargo, $data_publicacao, $tempo_leitura, $svg_metadata_category, $svg_metadata_title, $svg_metadata_subtitle, $imagem]);
                $artId = $db->lastInsertId();
            }

            // Limpa conteúdos anteriores
            $db->prepare("DELETE FROM artigo_conteudo WHERE artigo_id = ?")->execute([$artId]);
            
            $stmtInCont = $db->prepare("INSERT INTO artigo_conteudo (artigo_id, tipo, texto, autor_citado, ordem) VALUES (?, ?, ?, ?, ?)");
            $stmtInListItem = $db->prepare("INSERT INTO artigo_conteudo_list_items (artigo_conteudo_id, item, ordem) VALUES (?, ?, ?)");

            $ordem = 0;
            for ($i = 0; $i < count($post_bloco_tipos); $i++) {
                $tipo = $post_bloco_tipos[$i];
                $texto = trim($post_bloco_textos[$i] ?? '');
                $autorCitado = trim($post_bloco_autores[$i] ?? '') ?: null;
                $itensTexto = trim($post_bloco_itens[$i] ?? '');

                if ($tipo === 'list' && empty($itensTexto)) {
                    continue; // Pula blocos de lista vazios
                }
                if ($tipo !== 'list' && empty($texto)) {
                    continue; // Pula parágrafos/headings vazios
                }

                // Insere Bloco de Conteúdo
                $stmtInCont->execute([$artId, $tipo, ($tipo === 'list' ? null : $texto), $autorCitado, $ordem]);
                $blocoId = $db->lastInsertId();
                $ordem++;

                // Se for lista, insere os itens correspondentes
                if ($tipo === 'list') {
                    $linhas = explode("\n", $itensTexto);
                    $ordemItem = 0;
                    foreach ($linhas as $linha) {
                        $linha = trim($linha);
                        if (!empty($linha)) {
                            $stmtInListItem->execute([$blocoId, $linha, $ordemItem++]);
                        }
                    }
                }
            }

            $db->commit();
            header("Location: blog.php?saved=1");
            exit;

        } catch (Exception $e) {
            $db->rollBack();
            $error_message = "Erro ao salvar artigo: " . $e->getMessage();
            
            // Recarrega postados
            $artigo = [
                'titulo' => $titulo,
                'slug' => $slug,
                'categoria' => $categoria,
                'resumo' => $resumo,
                'autor' => $autor,
                'cargo' => $cargo,
                'data_publicacao' => $data_publicacao,
                'tempo_leitura' => $tempo_leitura,
                'svg_metadata_category' => $svg_metadata_category,
                'svg_metadata_title' => $svg_metadata_title,
                'svg_metadata_subtitle' => $svg_metadata_subtitle,
                'imagem' => $imagem
            ];
            
            $conteudo_blocos = [];
            for ($i = 0; $i < count($post_bloco_tipos); $i++) {
                $conteudo_blocos[] = [
                    'tipo' => $post_bloco_tipos[$i],
                    'texto' => $post_bloco_textos[$i] ?? '',
                    'autor_citado' => $post_bloco_autores[$i] ?? '',
                    'itens' => $post_bloco_itens[$i] ?? ''
                ];
            }
        }
    }
}

admin_header($is_edit ? "Editar Artigo" : "Escrever Novo Artigo", "blog");
?>

<?php if (!empty($error_message)): ?>
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<!-- FORMULÁRIO -->
<form method="POST" action="" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- COLUNA CENTRAL: CONTEÚDO E BLOCOS -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações Básicas do Artigo -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Dados do Artigo</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Título Principal</label>
                    <input type="text" id="art-titulo" name="titulo" value="<?php echo htmlspecialchars($artigo['titulo']); ?>" required placeholder="ex: O futuro da mobilidade elétrica nas indústrias"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Slug identificador (URL)</label>
                        <input type="text" id="art-slug" name="slug" value="<?php echo htmlspecialchars($artigo['slug']); ?>" required placeholder="ex: futuro-mobilidade-eletrica-industrias"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Tema / Categoria do Blog</label>
                        <input type="text" name="categoria" value="<?php echo htmlspecialchars($artigo['categoria']); ?>" required placeholder="ex: Infraestrutura, Mobilidade"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Resumo do Artigo (Card / Meta Description)</label>
                    <input type="text" name="resumo" value="<?php echo htmlspecialchars($artigo['resumo']); ?>" placeholder="Breve resumo atraente para a listagem e redes sociais..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>
            </div>

            <!-- EDITOR DE BLOCOS DINÂMICOS -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Conteúdo do Artigo (Blocos)</h3>
                        <p class="text-brand-muted text-xs mt-0.5">Monte o artigo adicionando parágrafos, subtítulos, citações ou listas em ordem.</p>
                    </div>
                    
                    <!-- Adicionadores rápidos de blocos -->
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="addBloco('paragraph')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                            + Parágrafo
                        </button>
                        <button type="button" onclick="addBloco('heading')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                            + Subtítulo
                        </button>
                        <button type="button" onclick="addBloco('list')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                            + Lista
                        </button>
                        <button type="button" onclick="addBloco('blockquote')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                            + Citação
                        </button>
                        <button type="button" onclick="addBloco('image')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-lg text-xs font-bold transition-all">
                            + Imagem
                        </button>
                    </div>
                </div>

                <!-- CONTAINER DE BLOCOS -->
                <div id="blocos-editor-container" class="space-y-4">
                    <!-- Gerado dinamicamente via JS -->
                </div>
            </div>
        </div>

        <!-- SIDEBAR: METADADOS E SALVAR -->
        <div class="space-y-6">
            
            <!-- CAPA DO ARTIGO -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Imagem de Capa (Opcional)</h3>
                <p class="text-brand-muted text-[11px]">Selecione uma imagem de capa personalizada para este artigo. Deixe vazio para usar a capa técnica em SVG.</p>
                <div>
                    <div class="flex gap-2">
                        <input type="text" id="art-imagem" name="imagem" value="<?php echo htmlspecialchars($artigo['imagem'] ?? ''); ?>" placeholder="ex: static/uploads/capa.png"
                               class="flex-1 bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                        <input type="file" id="art-file-input" class="hidden" accept="image/*">
                        <button type="button" onclick="triggerUpload('art-file-input', 'art-imagem', 'art-preview')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 rounded-xl text-xs transition-all">
                            Fazer Upload
                        </button>
                    </div>
                    <div id="art-preview-container" class="mt-3 p-2 bg-brand-bg3/25 border border-white/5 rounded-xl inline-block <?php echo empty($artigo['imagem']) ? 'hidden' : ''; ?>">
                        <img id="art-preview" src="<?php echo !empty($artigo['imagem']) ? '../' . $artigo['imagem'] : ''; ?>" class="max-h-24 rounded-lg object-contain">
                    </div>
                </div>
            </div>

            <!-- DADOS DO AUTOR E METADADOS -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Publicação</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Autor</label>
                    <input type="text" name="autor" value="<?php echo htmlspecialchars($artigo['autor']); ?>" placeholder="Nome do autor..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Cargo / Especialidade</label>
                    <input type="text" name="cargo" value="<?php echo htmlspecialchars($artigo['cargo']); ?>" placeholder="ex: Eng. de Infraestrutura Sênior..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Data Exibida</label>
                        <input type="text" name="data_publicacao" value="<?php echo htmlspecialchars($artigo['data_publicacao']); ?>" placeholder="ex: 04/06/2026"
                               class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Tempo Leitura</label>
                        <div class="flex gap-2">
                            <input type="number" name="tempo_leitura_num" value="<?php echo $tempo_valor; ?>" min="1" required
                                   class="w-1/2 bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                            <select name="tempo_leitura_unit" class="w-1/2 bg-brand-bg3/50 border border-white/5 rounded-xl px-2 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                <option value="min" <?php echo $tempo_unidade === 'min' ? 'selected' : ''; ?>>Minutos</option>
                                <option value="h" <?php echo $tempo_unidade === 'h' ? 'selected' : ''; ?>>Horas</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- METADADOS DA CAPA DE ARTE INDUSTRIAL (OPCIONAL) -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green">Arte da Capa (Capa Técnica)</h3>
                <p class="text-brand-muted text-[11px]">Campos que alimentam os textos no topo da capa estilizada em SVG do artigo. Deixe em branco para usar o tema e o título do artigo.</p>
                
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Categoria na Capa</label>
                    <input type="text" name="svg_metadata_category" value="<?php echo htmlspecialchars($artigo['svg_metadata_category']); ?>" placeholder="ex: INFRASTRUCTURE"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Título na Capa</label>
                    <input type="text" name="svg_metadata_title" value="<?php echo htmlspecialchars($artigo['svg_metadata_title']); ?>" placeholder="ex: CHARGING NETWORK"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Subtítulo na Capa</label>
                    <input type="text" name="svg_metadata_subtitle" value="<?php echo htmlspecialchars($artigo['svg_metadata_subtitle']); ?>" placeholder="ex: ANALYSIS V.04"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>
            </div>

            <!-- SUBMIT BAR -->
            <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex flex-col gap-3">
                <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-green/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                    Publicar Artigo
                </button>
                <a href="blog.php" class="w-full text-center py-2.5 rounded-xl border border-white/5 hover:bg-white/5 text-brand-muted hover:text-white text-xs font-semibold transition-all">
                    Cancelar e Voltar
                </a>
            </div>
        </div>

    </div>
</form>

<script>
    // Função de Upload AJAX
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
            
            fetch('upload.php?type=blog', {
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

    // Gerador de Slug Automático
    const tituloInput = document.getElementById('art-titulo');
    const slugInput = document.getElementById('art-slug');
    
    if (tituloInput && slugInput && <?php echo $is_edit ? 'false' : 'true'; ?>) {
        tituloInput.addEventListener('input', function() {
            const val = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s\-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = val;
        });
    }

    // EDITOR DE BLOCOS EM JAVASCRIPT
    const blocosContainer = document.getElementById('blocos-editor-container');
    let blocoCount = 0;

    const initialBlocos = <?php echo json_encode($conteudo_blocos); ?>;

    // Carrega blocos existentes
    if (initialBlocos && initialBlocos.length > 0) {
        initialBlocos.forEach(b => {
            addBloco(b.tipo, b.texto, b.autor_citado, b.itens);
        });
    } else {
        // Se novo artigo, cria um parágrafo padrão inicial
        addBloco('paragraph');
    }

    function addBloco(tipo, texto = '', autor = '', itens = '') {
        blocoCount++;
        const blocoDiv = document.createElement('div');
        blocoDiv.className = 'bg-brand-bg3/40 border border-white/5 rounded-xl p-4 relative space-y-3';
        blocoDiv.id = `bloco-${blocoCount}`;

        // Cabeçalho do Bloco
        let headerLabel = '';
        let inputContent = '';

        if (tipo === 'paragraph') {
            headerLabel = 'Parágrafo de Texto';
            inputContent = `
                <textarea name="bloco_texto[]" rows="4" placeholder="Escreva o parágrafo aqui..." required
                          class="w-full bg-brand-bg3 border border-white/5 rounded-lg p-3 text-xs text-white placeholder-brand-muted/20 focus:outline-none focus:border-brand-green/30">${texto}</textarea>
                <input type="hidden" name="bloco_autor[]" value="">
                <input type="hidden" name="bloco_itens[]" value="">
            `;
        } else if (tipo === 'heading') {
            headerLabel = 'Subtítulo Interno (H2)';
            inputContent = `
                <input type="text" name="bloco_texto[]" value="${texto}" placeholder="Escreva o subtítulo..." required
                       class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                <input type="hidden" name="bloco_autor[]" value="">
                <input type="hidden" name="bloco_itens[]" value="">
            `;
        } else if (tipo === 'blockquote') {
            headerLabel = 'Citação em Destaque';
            inputContent = `
                <textarea name="bloco_texto[]" rows="3" placeholder="Escreva a citação..." required
                          class="w-full bg-brand-bg3 border border-white/5 rounded-lg p-3 text-xs text-white placeholder-brand-muted/20 focus:outline-none focus:border-brand-green/30">${texto}</textarea>
                <div>
                    <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Autor da Citação (opcional)</label>
                    <input type="text" name="bloco_autor[]" value="${autor}" placeholder="ex: Elon Musk"
                           class="w-full bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                </div>
                <input type="hidden" name="bloco_itens[]" value="">
            `;
        } else if (tipo === 'list') {
            headerLabel = 'Lista de Tópicos';
            inputContent = `
                <label class="block text-[9px] font-bold text-brand-muted uppercase mb-1">Itens da Lista (Um item por linha)</label>
                <textarea name="bloco_itens[]" rows="5" placeholder="Item 01&#10;Item 02&#10;Item 03..." required
                          class="w-full bg-brand-bg3 border border-white/5 rounded-lg p-3 text-xs text-white placeholder-brand-muted/20 focus:outline-none focus:border-brand-green/30">${itens}</textarea>
                <input type="hidden" name="bloco_texto[]" value="">
                <input type="hidden" name="bloco_autor[]" value="">
            `;
        } else if (tipo === 'image') {
            headerLabel = 'Imagem no Artigo';
            inputContent = `
                <div class="flex gap-2">
                    <input type="text" id="bloco-img-${blocoCount}" name="bloco_texto[]" value="${texto}" placeholder="Caminho da imagem (ex: static/uploads/imagem.png)" required
                           class="flex-1 bg-brand-bg3 border border-white/5 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                    <input type="file" id="bloco-file-${blocoCount}" class="hidden" accept="image/*">
                    <button type="button" onclick="triggerUpload('bloco-file-${blocoCount}', 'bloco-img-${blocoCount}', 'bloco-preview-${blocoCount}')" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-3 rounded-lg text-xs transition-all">
                        Upload
                    </button>
                </div>
                <div id="bloco-preview-container-${blocoCount}" class="mt-2 p-1 bg-brand-bg3/25 border border-white/5 rounded-lg inline-block ${texto ? '' : 'hidden'}">
                    <img id="bloco-preview-${blocoCount}" src="${texto ? '../' + texto : ''}" class="max-h-20 rounded-md object-contain">
                </div>
                <input type="hidden" name="bloco_autor[]" value="">
                <input type="hidden" name="bloco_itens[]" value="">
            `;
        }

        blocoDiv.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-green">${headerLabel}</span>
                <div class="flex gap-2">
                    <button type="button" onclick="moveUp(${blocoCount})" class="text-brand-muted hover:text-white text-xs font-bold" title="Mover para cima">↑</button>
                    <button type="button" onclick="moveDown(${blocoCount})" class="text-brand-muted hover:text-white text-xs font-bold" title="Mover para baixo">↓</button>
                    <button type="button" onclick="removeBloco(${blocoCount})" class="text-red-400 hover:text-red-500 text-xs font-bold" title="Remover">&times; Remover</button>
                </div>
            </div>
            <input type="hidden" name="bloco_tipo[]" value="${tipo}">
            <div class="space-y-2">
                ${inputContent}
            </div>
        `;

        blocosContainer.appendChild(blocoDiv);
    }

    function removeBloco(id) {
        const bloco = document.getElementById(`bloco-${id}`);
        if (bloco) {
            bloco.remove();
        }
    }

    function moveUp(id) {
        const bloco = document.getElementById(`bloco-${id}`);
        const prev = bloco.previousElementSibling;
        if (prev) {
            blocosContainer.insertBefore(bloco, prev);
        }
    }

    function moveDown(id) {
        const bloco = document.getElementById(`bloco-${id}`);
        const next = bloco.nextElementSibling;
        if (next) {
            blocosContainer.insertBefore(next, bloco);
        }
    }
</script>

<?php 
admin_footer();
?>
