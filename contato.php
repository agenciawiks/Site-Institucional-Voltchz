<?php
require_once __DIR__ . '/includes/db.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
    $empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_SPECIAL_CHARS);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo_projeto = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $prazo_desejado = filter_input(INPUT_POST, 'prazo', FILTER_SANITIZE_SPECIAL_CHARS);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($nome && $email && $telefone && $tipo_projeto && $prazo_desejado && $mensagem) {
        try {
            $db = get_db_connection();
            $stmt = $db->prepare("INSERT INTO leads (nome, email, telefone, empresa, cidade, tipo_projeto, prazo_desejado, mensagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $telefone, $empresa, $cidade, $tipo_projeto, $prazo_desejado, $mensagem]);
            $success_message = 'Obrigado! Seu contato foi enviado com sucesso. Nossa equipe técnica retornará em breve.';
        } catch (Exception $e) {
            $error_message = 'Houve um erro técnico ao processar seu contato. Por favor, tente novamente ou fale conosco via WhatsApp.';
        }
    } else {
        $error_message = 'Por favor, preencha todos os campos obrigatórios.';
    }
}

$page_title = "Contato — VoltchZ Brasil";
$page_desc = "Envie um lead completo para a equipe VoltchZ e receba orientação técnica para seu projeto de mobilidade elétrica.";
$current_page = "contato";
include "includes/header.php";
?>

  <header class="pt-32 pb-14 px-6 bg-brand-bg2 border-b border-white/5">
    <div class="max-w-[1200px] mx-auto text-center observe">
      <p class="text-[12px] font-mono font-bold uppercase tracking-[0.2em] text-brand-green mb-4">Contato</p>
      <h1 class="text-[clamp(34px,7vw,62px)] font-extrabold tracking-tight mb-6">Lead completo para a equipe VoltchZ</h1>
      <p class="text-brand-muted max-w-3xl mx-auto text-lg leading-relaxed">
        Compartilhe os dados do seu projeto e envie uma mensagem detalhada para nosso time técnico-comercial.
      </p>
    </div>
  </header>

  <main class="py-20 px-6 bg-white">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
      <section class="bg-slate-50 border border-slate-200 rounded-[32px] p-8 md:p-10 shadow-2xl shadow-slate-200/20 observe">
        <h2 class="text-2xl font-extrabold text-[#1a1a24] mb-3">Formulário completo</h2>
        <p class="text-slate-600 mb-8">Preencha os campos para que a equipe receba seu contexto completo e prossiga com a análise técnica.</p>
        
        <?php if (!empty($success_message)): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm mb-6">
            <?php echo $success_message; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">
            <?php echo $error_message; ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="contato.php" class="grid grid-cols-1 gap-4">
          <input type="text" name="nome" placeholder="Nome completo" required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all">
          <input type="email" name="email" placeholder="E-mail" required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all">
          <input type="tel" name="telefone" placeholder="Telefone / WhatsApp" required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all">
          <input type="text" name="empresa" placeholder="Empresa / Condomínio (opcional)"
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all">
          <input type="text" name="cidade" placeholder="Cidade / UF (opcional)"
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all">
          
          <select name="tipo" required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-brand-green/50 transition-all">
            <option value="" class="text-black">Tipo de projeto</option>
            <option value="Residencial" class="text-black">Residencial</option>
            <option value="Comercial" class="text-black">Comercial</option>
            <option value="Condomínio" class="text-black">Condomínio</option>
            <option value="Frota" class="text-black">Frota</option>
          </select>
          
          <select name="prazo" required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-brand-green/50 transition-all">
            <option value="" class="text-black">Prazo desejado</option>
            <option value="Imediato" class="text-black">Imediato</option>
            <option value="30 dias" class="text-black">Até 30 dias</option>
            <option value="60 a 90 dias" class="text-black">60 a 90 dias</option>
            <option value="Em estudo" class="text-black">Em estudo</option>
          </select>
          
          <textarea name="mensagem" rows="5"
            placeholder="Descreva o cenário, quantidade de vagas/pontos, potência esperada e objetivos do projeto."
            required
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-brand-green/50 transition-all resize-y"></textarea>
          
          <button type="submit"
            class="bg-brand-green text-brand-bg font-extrabold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20 text-base">
            Enviar mensagem para a equipe
          </button>
        </form>
      </section>

      <aside class="space-y-6 observe">
        <div class="bg-slate-50 border border-slate-200 rounded-[28px] p-7">
          <h3 class="text-[#1a1a24] font-bold text-lg mb-3">Atendimento online</h3>
          <p class="text-slate-600">Segunda a sexta, 09:00 às 17:00</p>
          <p class="text-slate-600">Sábado, domingo e feriados: fechado</p>
        </div>
        <div class="bg-slate-50 border border-slate-200 rounded-[28px] p-7">
          <h3 class="text-[#1a1a24] font-bold text-lg mb-3">Canais institucionais</h3>
          <p><a href="mailto:contato@voltchz.com.br"
              class="text-slate-600 hover:text-brand-green transition-colors font-medium">contato@voltchz.com.br</a></p>
          <p><a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
              class="text-slate-600 hover:text-brand-green transition-colors font-medium">(12) 98103-9845</a></p>
          <p class="text-slate-600 mt-3">Rua João Teixeira Netto, 72<br>Jardim Aquarius, SJC - SP</p>
        </div>
        <div class="bg-slate-50 border border-slate-200 rounded-[28px] p-7">
          <h3 class="text-[#1a1a24] font-bold text-lg mb-3">Redes sociais</h3>
          <div class="flex items-center gap-4">
            <a href="https://www.instagram.com/voltchz" target="_blank" rel="noopener noreferrer"
              class="text-slate-600 hover:text-brand-green transition-colors font-medium">Instagram</a>
            <a href="https://www.linkedin.com/company/voltchz/" target="_blank" rel="noopener noreferrer"
              class="text-slate-600 hover:text-brand-green transition-colors font-medium">LinkedIn</a>
          </div>
        </div>
      </aside>
    </div>
  </main>

<?php
include "includes/footer.php";
?>
