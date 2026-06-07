<?php
/**
 * VoltchZ Brasil - Painel Administrativo Dashboard
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

// Conexão com o Banco de Dados
$db = get_db_connection();

// Buscar contadores
$total_produtos = $db->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$total_artigos = $db->query("SELECT COUNT(*) FROM artigos")->fetchColumn();
$total_leads = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$leads_pendentes = $db->query("SELECT COUNT(*) FROM leads WHERE status = 'Pendente'")->fetchColumn();

// Buscar os 5 leads mais recentes
$stmtLeads = $db->query("SELECT * FROM leads ORDER BY criado_em DESC LIMIT 5");
$recent_leads = $stmtLeads->fetchAll();

// Iniciar renderização do layout
admin_header("Dashboard", "dashboard");
?>

<!-- BANNER DE BOAS-VINDAS -->
<div class="relative overflow-hidden bg-brand-bg2 border border-white/5 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div class="absolute w-[300px] h-[300px] rounded-full bg-brand-green/5 blur-[80px] -top-20 -right-20 pointer-events-none"></div>
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Bem-vindo ao Painel VoltchZ</h1>
        <p class="text-brand-muted text-sm mt-1">Gerencie produtos, artigos e os contatos comerciais capturados no site.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="produto-form.php" class="bg-brand-green text-brand-bg font-bold px-4 py-2.5 rounded-xl hover:brightness-110 active:scale-95 transition-all text-sm flex items-center gap-2 shadow-lg shadow-brand-green/10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
            Novo Produto
        </a>
        <a href="artigo-form.php" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold px-4 py-2.5 rounded-xl active:scale-95 transition-all text-sm flex items-center gap-2">
            Escrever Artigo
        </a>
    </div>
</div>

<!-- ESTATÍSTICAS / CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Leads Pendentes -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-muted">Leads Pendentes</span>
            <div class="w-9 h-9 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center border border-orange-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white"><?php echo $leads_pendentes; ?></p>
        <p class="text-xs text-brand-muted mt-2">Do total de <?php echo $total_leads; ?> contatos</p>
    </div>

    <!-- Produtos Cadastrados -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-muted">Produtos</span>
            <div class="w-9 h-9 rounded-xl bg-brand-green/10 text-brand-green flex items-center justify-center border border-brand-green/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white"><?php echo $total_produtos; ?></p>
        <p class="text-xs text-brand-muted mt-2">Equipamentos no catálogo</p>
    </div>

    <!-- Artigos Publicados -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-muted">Artigos do Blog</span>
            <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.75V6.125C3 5.504 3.504 5 4.125 5H18a1.125 1.125 0 011.125 1.125V7.5"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white"><?php echo $total_artigos; ?></p>
        <p class="text-xs text-brand-muted mt-2">Publicações técnicas ativas</p>
    </div>

    <!-- Contatos Totais -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-muted">Total de Leads</span>
            <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center border border-purple-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 18H8.25c-6.21 0-11.25-5.04-11.25-11.25V18M11.386 18c.285-.91.786-1.957.786-3.07v-.003c0-1.113-.285-2.16-.786-3.07M12 3a3 3 0 11-6 0 3 3 0 016 0zM1.5 8.25h1.5"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white"><?php echo $total_leads; ?></p>
        <p class="text-xs text-brand-muted mt-2">Registros capturados</p>
    </div>
</div>

<!-- LEADS RECENTES -->
<div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-white tracking-tight">Leads Comerciais Recentes</h3>
            <p class="text-brand-muted text-xs mt-0.5">Últimos contatos e questionários de viabilidade enviados</p>
        </div>
        <a href="leads.php" class="text-xs font-semibold text-brand-green hover:underline flex items-center gap-1">
            Ver Todos
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
        </a>
    </div>

    <?php if (empty($recent_leads)): ?>
        <div class="text-center py-10 bg-brand-bg/50 border border-white/5 border-dashed rounded-xl">
            <svg class="w-8 h-8 text-brand-muted/40 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
            <p class="text-sm text-brand-muted">Nenhum lead capturado até o momento.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-muted">
                <thead>
                    <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-white bg-brand-bg/30">
                        <th class="py-3 px-4 rounded-l-xl">Nome</th>
                        <th class="py-3 px-4">Projeto</th>
                        <th class="py-3 px-4">Contato</th>
                        <th class="py-3 px-4">Data</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-r-xl text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($recent_leads as $lead): 
                        // Cor do status
                        $status_class = 'bg-orange-500/10 text-orange-500 border border-orange-500/20';
                        if ($lead['status'] === 'Em Atendimento') {
                            $status_class = 'bg-blue-500/10 text-blue-500 border border-blue-500/20';
                        } elseif ($lead['status'] === 'Concluído') {
                            $status_class = 'bg-brand-green/10 text-brand-green border border-brand-green/20';
                        }
                    ?>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4 font-medium text-white">
                                <?php echo htmlspecialchars($lead['nome']); ?>
                                <?php if (!empty($lead['empresa'])): ?>
                                    <span class="block text-xs text-brand-muted"><?php echo htmlspecialchars($lead['empresa']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/5 border border-white/10 text-white">
                                    <?php echo htmlspecialchars($lead['tipo_projeto']); ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div><?php echo htmlspecialchars($lead['email']); ?></div>
                                <div class="text-[11px] text-brand-muted/70 mt-0.5"><?php echo htmlspecialchars($lead['telefone']); ?></div>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <?php echo date('d/m/Y H:i', strtotime($lead['criado_em'])); ?>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md text-[11.5px] font-bold <?php echo $status_class; ?>">
                                    <?php echo $lead['status']; ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="leads.php?id=<?php echo $lead['id']; ?>" class="inline-flex items-center justify-center p-1.5 rounded-lg bg-white/5 border border-white/10 hover:border-brand-green/20 hover:text-brand-green hover:bg-brand-green/5 text-brand-muted transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
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
