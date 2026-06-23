<?php
/**
 * VoltchZ Brasil - Configurações Gerais do Site
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/layout.php';

$db = get_db_connection();

$success_message = '';
$error_message = '';

// Chaves de configurações que o usuário pode gerenciar
$config_keys = [
    'email_contato' => 'E-mail de Contato',
    'telefone_comercial' => 'Telefone Comercial',
    'whatsapp_link' => 'Link do WhatsApp Comercial',
    'telefone_0800' => 'Telefone 0800',
    'whatsapp_suporte' => 'WhatsApp de Suporte / 0800',
    'horario_suporte' => 'Horário de Suporte',
    'endereco' => 'Endereço Corporativo',
    'instagram' => 'Link do Instagram',
    'linkedin' => 'Link do LinkedIn'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();
        foreach ($config_keys as $key => $label) {
            if (isset($_POST[$key])) {
                $value = trim($_POST[$key]);
                save_config($key, $value);
            }
        }
        $db->commit();
        $success_message = "Configurações atualizadas com sucesso.";
    } catch (Exception $e) {
        $db->rollBack();
        $error_message = "Erro ao salvar configurações: " . $e->getMessage();
    }
}

// Carrega as configurações atuais
$configs = get_configs();

admin_header("Configurações Gerais", "configuracoes");
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

<form method="POST" action="" class="space-y-8">
    <!-- CONTATOS PRINCIPAIS -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
        <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Informações de Contato</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">E-mail de Contato</label>
                <input type="email" name="email_contato" value="<?php echo htmlspecialchars($configs['email_contato'] ?? ''); ?>" required
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30">
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Telefone Comercial</label>
                <input type="text" name="telefone_comercial" value="<?php echo htmlspecialchars($configs['telefone_comercial'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="(12) 98103-9845">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">WhatsApp Comercial (Link ou Número)</label>
                <input type="text" name="whatsapp_link" value="<?php echo htmlspecialchars($configs['whatsapp_link'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="https://wa.me/5512981039845">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Telefone 0800</label>
                <input type="text" name="telefone_0800" value="<?php echo htmlspecialchars($configs['telefone_0800'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="0800 444 1044">
            </div>
        </div>
    </div>

    <!-- SUPORTE E HORÁRIOS -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
        <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Suporte Técnico</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">WhatsApp de Suporte / Chatbot</label>
                <input type="text" name="whatsapp_suporte" value="<?php echo htmlspecialchars($configs['whatsapp_suporte'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="(800) 444 1044">
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Horário de Atendimento do Suporte</label>
                <input type="text" name="horario_suporte" value="<?php echo htmlspecialchars($configs['horario_suporte'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="Seg a Sex - 8h às 22h">
            </div>
        </div>
    </div>

    <!-- ENDEREÇO & REDES SOCIAIS -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-6 space-y-6">
        <h3 class="text-sm font-bold uppercase tracking-wider text-brand-green border-b border-white/5 pb-3">Institucional & Redes Sociais</h3>
        
        <div class="space-y-6">
            <div>
                <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Endereço Completo</label>
                <input type="text" name="endereco" value="<?php echo htmlspecialchars($configs['endereco'] ?? ''); ?>"
                       class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="Rua João Teixeira Netto, 72 - Jardim Aquarius, SJC - SP">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">Instagram (URL)</label>
                    <input type="url" name="instagram" value="<?php echo htmlspecialchars($configs['instagram'] ?? ''); ?>"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="https://www.instagram.com/voltchz">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-brand-muted uppercase tracking-wider mb-2">LinkedIn (URL)</label>
                    <input type="url" name="linkedin" value="<?php echo htmlspecialchars($configs['linkedin'] ?? ''); ?>"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-green/30" placeholder="https://www.linkedin.com/company/voltchz/">
                </div>
            </div>
        </div>
    </div>

    <!-- SUBMIT BAR -->
    <div class="bg-brand-bg2 border border-white/5 rounded-2xl p-5 flex items-center justify-between">
        <span class="text-xs text-brand-muted">As mudanças refletirão imediatamente em todo o frontend do site.</span>
        <button type="submit" class="bg-brand-green hover:brightness-110 text-brand-bg font-bold px-6 py-3 rounded-xl text-xs flex items-center gap-2 transition-all shadow-lg shadow-brand-green/10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
            Salvar Alterações
        </button>
    </div>
</form>

<?php
admin_footer();
?>
