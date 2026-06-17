/**
 * Gerenciamento de formulários e submissão de leads
 */
import { CONFIG } from '../config.js';

/**
 * Unified lead handler
 * @param {Event} event 
 * @param {'whatsapp' | 'email'} provider 
 */
export const handleLeadSubmission = async (event, provider) => {
  event.preventDefault();
  const form = event.target;
  const button = form.querySelector('button[type="submit"]');
  if (!button) return;

  const originalText = button.textContent;
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());

  // Limpeza básica
  Object.keys(data).forEach(key => data[key] = String(data[key]).trim());

  // Bloqueio de bot via Honeypot
  if (data.sobrenome_confirm) {
    console.warn('Bot detected via Honeypot');
    form.reset();
    return;
  }

  // Estado de carregamento
  button.disabled = true;
  button.textContent = provider === 'whatsapp' ? 'Preparando...' : 'Enviando...';

  try {
    // Tenta persistir o lead no banco de dados em segundo plano antes do redirecionamento
    try {
      await fetch('save-lead.php', {
        method: 'POST',
        body: formData
      });
    } catch (dbError) {
      console.error('Falha de salvamento no banco de dados, prosseguindo com fluxo direto:', dbError);
    }

    if (provider === 'whatsapp') {
      const text = [
        'Olá! Vim pelo site da VoltchZ e quero um contato rápido.',
        '',
        `Nome: ${data.nome}`,
        `Telefone: ${data.telefone}`,
        `Tipo: ${data.tipo || 'Não informado'}`,
        `Mensagem: ${data.mensagem || 'Não informada'}`
      ].join('\n');
      
      button.classList.add('bg-white', 'text-brand-green');
      button.textContent = 'Redirecionando...';
      
      window.open(`https://wa.me/${CONFIG.CONTACT.WHATSAPP}?text=${encodeURIComponent(text)}`, '_blank', 'noopener,noreferrer');
    } else {
      const text = [
        'Olá, equipe VoltchZ! Lead completo recebido pelo site.',
        '',
        `Nome: ${data.nome}`,
        `E-mail: ${data.email}`,
        `Telefone: ${data.telefone}`,
        `Empresa/Condomínio: ${data.empresa || 'Não informado'}`,
        `Cidade: ${data.cidade || 'Não informado'}`,
        `Tipo de projeto: ${data.tipo || 'Não informado'}`,
        `Prazo desejado: ${data.prazo || 'Não informado'}`,
        '',
        'Mensagem:',
        data.mensagem || 'Não informada'
      ].join('\n');

      const subject = encodeURIComponent('Lead completo - contato pelo site VoltchZ');
      
      button.classList.add('bg-white', 'text-brand-green');
      button.textContent = 'Abrindo e-mail...';
      
      window.location.href = `mailto:${CONFIG.CONTACT.EMAIL}?subject=${subject}&body=${encodeURIComponent(text)}`;
    }

    form.reset();
  } catch (error) {
    console.error('Erro ao processar formulário:', error);
    alert('Ocorreu um erro. Por favor, tente novamente.');
  } finally {
    // Resetar botão após delay
    setTimeout(() => {
      button.disabled = false;
      button.classList.remove('bg-white', 'text-brand-green');
      button.textContent = originalText;
    }, 2500);
  }
};
