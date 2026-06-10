<?php
/**
 * VoltchZ Brasil - Gerenciamento de Leads
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

// Processa atualização de status
$status_updated = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $lead_id = filter_input(INPUT_POST, 'lead_id', FILTER_VALIDATE_INT);
    $novo_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if ($lead_id && in_array($novo_status, ['Pendente', 'Em Atendimento', 'Concluído'])) {
        try {
            $stmtUpdate = $db->prepare("UPDATE leads SET status = ? WHERE id = ?");
            $stmtUpdate->execute([$novo_status, $lead_id]);
            $status_updated = true;
        } catch (Exception $e) {
            // Silently handle or log
        }
    }
}

// Filtros e Busca
$busca = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$filtro_status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';
$filtro_projeto = filter_input(INPUT_GET, 'projeto', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos';

// Monta Query
$sql = "SELECT * FROM leads WHERE 1=1";
$params = [];

if ($filtro_status !== 'todos') {
    $sql .= " AND status = ?";
    $params[] = $filtro_status;
}

if ($filtro_projeto !== 'todos') {
    $sql .= " AND tipo_projeto = ?";
    $params[] = $filtro_projeto;
}

if (!empty($busca)) {
    $sql .= " AND (nome LIKE ? OR email LIKE ? OR telefone LIKE ? OR empresa LIKE ? OR cidade LIKE ? OR mensagem LIKE ?)";
    $searchVal = "%" . $busca . "%";
    for ($i = 0; $i < 6; $i++) {
        $params[] = $searchVal;
    }
}

$sql .= " ORDER BY criado_em DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();

// Se houver ID específico para visualização
$active_lead = null;
$view_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($view_id) {
    $stmtSingle = $db->prepare("SELECT * FROM leads WHERE id = ?");
    $stmtSingle->execute([$view_id]);
    $active_lead = $stmtSingle->fetch();
}

admin_header("Inbox de Leads", "leads");
?>

<?php if ($status_updated): ?>
    <div class="bg-brand-green/10 border border-brand-green/20 text-brand-green p-4 rounded-xl text-sm flex items-center justify-between">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Status do lead atualizado com sucesso.
        </span>
        <button onclick="this.parentElement.remove()" class="text-brand-green hover:text-white font-bold">&times;</button>
    </div>
<?php endif; ?>

<!-- LEADS VIEW CONTAINER -->
<div class="relative">
    
    <!-- LEFT SIDE: LIST & FILTERS (Full Width) -->
    <div class="space-y-6">
        
        <!-- Filters Card -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-5">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Pesquisa geral</label>
                    <input type="text" name="q" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Buscar nome, empresa, e-mail..."
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-2.5 text-xs text-white placeholder-brand-muted/30 focus:outline-none focus:border-brand-green/30">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Status</label>
                    <select name="status" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                        <option value="todos" <?php echo $filtro_status === 'todos' ? 'selected' : ''; ?>>Todos</option>
                        <option value="Pendente" <?php echo $filtro_status === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                        <option value="Em Atendimento" <?php echo $filtro_status === 'Em Atendimento' ? 'selected' : ''; ?>>Em Atendimento</option>
                        <option value="Concluído" <?php echo $filtro_status === 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted mb-2">Projeto</label>
                    <select name="projeto" class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-brand-green/30">
                        <option value="todos" <?php echo $filtro_projeto === 'todos' ? 'selected' : ''; ?>>Todos Projetos</option>
                        <option value="Residencial" <?php echo $filtro_projeto === 'Residencial' ? 'selected' : ''; ?>>Residencial</option>
                        <option value="Comercial" <?php echo $filtro_projeto === 'Comercial' ? 'selected' : ''; ?>>Comercial</option>
                        <option value="Condomínio" <?php echo $filtro_projeto === 'Condomínio' ? 'selected' : ''; ?>>Condomínio</option>
                        <option value="Frota" <?php echo $filtro_projeto === 'Frota' ? 'selected' : ''; ?>>Frota</option>
                    </select>
                </div>

                <div class="sm:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-brand-green hover:brightness-110 text-brand-bg font-bold p-2.5 rounded-xl flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Leads List Card -->
        <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
            <?php if (empty($leads)): ?>
                <div class="text-center py-16 bg-brand-bg/30 border border-white/5 border-dashed rounded-2xl">
                    <svg class="w-10 h-10 text-brand-muted/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                    <h4 class="text-white font-semibold text-sm">Nenhum lead encontrado</h4>
                    <p class="text-xs text-brand-muted/70 mt-1">Refine seus filtros de busca ou aguarde novos envios.</p>
                </div>
            <?php else: ?>
                <div class="space-y-3.5">
                    <?php foreach ($leads as $lead): 
                        $is_selected = ($active_lead && $active_lead['id'] == $lead['id']);
                        $status_color = 'bg-orange-500/10 text-orange-500 border border-orange-500/20';
                        if ($lead['status'] === 'Em Atendimento') {
                            $status_color = 'bg-blue-500/10 text-blue-500 border border-blue-500/20';
                        } elseif ($lead['status'] === 'Concluído') {
                            $status_color = 'bg-brand-green/10 text-brand-green border border-brand-green/20';
                        }
                    ?>
                        <div onclick="openLead(<?php echo $lead['id']; ?>)"
                             class="p-4 rounded-xl border transition-all cursor-pointer <?php echo $is_selected ? 'bg-brand-green/[0.03] border-brand-green/30' : 'bg-brand-bg3/40 border-white/5 hover:border-white/10 hover:bg-white/[0.01]'; ?>">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white"><?php echo htmlspecialchars($lead['nome']); ?></h4>
                                    <?php if (!empty($lead['empresa'])): ?>
                                        <p class="text-xs text-brand-muted/80 mt-0.5"><?php echo htmlspecialchars($lead['empresa']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider <?php echo $status_color; ?>">
                                        <?php echo $lead['status']; ?>
                                    </span>
                                    <span class="text-[10px] font-medium text-brand-muted/70">
                                        <?php echo date('d/m H:i', strtotime($lead['criado_em'])); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-white/5 border border-white/10 text-white">
                                        <?php echo htmlspecialchars($lead['tipo_projeto']); ?>
                                    </span>
                                    <?php if (!empty($lead['cidade'])): ?>
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-white/5 border border-white/10 text-brand-muted">
                                            <?php echo htmlspecialchars($lead['cidade']); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-white/5 border border-white/10 text-brand-muted">
                                        Prazo: <?php echo htmlspecialchars($lead['prazo_desejado']); ?>
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-brand-green hover:underline inline-flex items-center gap-1">
                                    Ver Detalhes
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- DRAWER LATERAL: DETAIL & EDIT PANELS -->
    <div id="lead-drawer-backdrop" onclick="closeLeadDrawer()" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none"></div>

    <div id="lead-drawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-lg bg-brand-bg2/95 border-l border-white/10 p-6 shadow-2xl transition-transform duration-300 translate-x-full backdrop-blur-xl flex flex-col justify-between overflow-y-auto">
        <?php if ($active_lead): ?>
            <div class="space-y-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white"><?php echo htmlspecialchars($active_lead['nome']); ?></h3>
                        <p class="text-xs text-brand-muted mt-0.5">Recebido em <?php echo date('d/m/Y H:i', strtotime($active_lead['criado_em'])); ?></p>
                    </div>
                    <button onclick="closeLeadDrawer()" class="text-brand-muted hover:text-white text-2xl font-semibold leading-none">&times;</button>
                </div>

                <!-- Informações de Contato -->
                <div class="border-t border-b border-white/5 py-4 space-y-3">
                    <div class="text-xs">
                        <span class="block font-bold text-white uppercase tracking-wider mb-1">E-mail</span>
                        <a href="mailto:<?php echo htmlspecialchars($active_lead['email']); ?>" class="text-brand-green hover:underline">
                            <?php echo htmlspecialchars($active_lead['email']); ?>
                        </a>
                    </div>
                    <div class="text-xs">
                        <span class="block font-bold text-white uppercase tracking-wider mb-1">Telefone / WhatsApp</span>
                        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $active_lead['telefone']); ?>" target="_blank" class="text-brand-green hover:underline inline-flex items-center gap-1">
                            <?php echo htmlspecialchars($active_lead['telefone']); ?>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 00-10 10c0 1.86.5 3.6 1.39 5.12l-1.39 5.08 5.2-.13c1.47.8 3.12 1.25 4.8 1.25a10 10 0 0010-10 10 10 0 00-10-10z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                    <?php if (!empty($active_lead['empresa'])): ?>
                        <div class="text-xs">
                            <span class="block font-bold text-white uppercase tracking-wider mb-0.5">Empresa / Condomínio</span>
                            <span class="text-white"><?php echo htmlspecialchars($active_lead['empresa']); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($active_lead['cidade'])): ?>
                        <div class="text-xs">
                            <span class="block font-bold text-white uppercase tracking-wider mb-0.5">Cidade / UF</span>
                            <span class="text-white"><?php echo htmlspecialchars($active_lead['cidade']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mensagem -->
                <div class="text-xs space-y-2">
                    <span class="block font-bold text-white uppercase tracking-wider">Mensagem e Detalhes</span>
                    <div class="bg-brand-bg3/60 p-4 rounded-xl border border-white/5 text-white/90 leading-relaxed max-h-60 overflow-y-auto whitespace-pre-wrap">
                        <?php echo htmlspecialchars($active_lead['mensagem']); ?>
                    </div>
                </div>

                <!-- Ação: Atualizar Status -->
                <div class="border-t border-white/5 pt-4">
                    <form method="POST" action="" class="space-y-3">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="lead_id" value="<?php echo $active_lead['id']; ?>">
                        
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-brand-muted">Alterar Status</label>
                        
                        <div class="flex gap-2">
                            <select name="status" class="flex-1 bg-brand-bg3 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-green/30">
                                <option value="Pendente" <?php echo $active_lead['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="Em Atendimento" <?php echo $active_lead['status'] === 'Em Atendimento' ? 'selected' : ''; ?>>Em Atendimento</option>
                                <option value="Concluído" <?php echo $active_lead['status'] === 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                            </select>
                            <button type="submit" class="bg-brand-green text-brand-bg font-bold px-4 py-2 rounded-xl text-xs hover:brightness-110 active:scale-95 transition-all">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-20 text-brand-muted h-full flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-brand-muted/20 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.884 2.223v6.12c0 1.242 1.008 2.25 2.25 2.25h15c1.242 0 2.25-1.008 2.25-2.25v-6.12a2.25 2.25 0 00-1.884-2.223m-16.5 0c.22-.034.446-.051.676-.051h15c.23 0 .456.017.676.051m-16.5 0a2.447 2.447 0 00-.766.197m18.032.197a2.447 2.447 0 00-.767-.197m0 0A2.25 2.25 0 0118 7.5V5.25A2.25 2.25 0 0015.75 3H8.25A2.25 2.25 0 006 5.25V7.5c0 .285-.053.559-.149.811z"></path></svg>
                <p class="text-xs">Selecione um lead comercial na listagem para ver os detalhes.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    function openLead(id) {
        window.location.href = "?id=" + id + "&q=<?php echo urlencode($busca); ?>&status=<?php echo urlencode($filtro_status); ?>&projeto=<?php echo urlencode($filtro_projeto); ?>";
    }

    function closeLeadDrawer() {
        const drawer = document.getElementById("lead-drawer");
        const backdrop = document.getElementById("lead-drawer-backdrop");
        if (drawer && backdrop) {
            drawer.classList.add("translate-x-full");
            backdrop.classList.add("opacity-0", "pointer-events-none");
            backdrop.classList.remove("opacity-100");
        }
        setTimeout(() => {
            window.location.href = "leads.php?q=<?php echo urlencode($busca); ?>&status=<?php echo urlencode($filtro_status); ?>&projeto=<?php echo urlencode($filtro_projeto); ?>";
        }, 300);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const drawer = document.getElementById("lead-drawer");
        const backdrop = document.getElementById("lead-drawer-backdrop");
        if (drawer && backdrop && <?php echo $active_lead ? 'true' : 'false'; ?>) {
            drawer.classList.remove("translate-x-full");
            backdrop.classList.remove("opacity-0", "pointer-events-none");
            backdrop.classList.add("opacity-100");
        }
    });
</script>

</div>

<?php 
admin_footer();
?>
