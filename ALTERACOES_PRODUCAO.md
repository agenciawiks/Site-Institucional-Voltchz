# Alterações Realizadas no Projeto (VoltchZ Brasil)

> [!WARNING]
> **DOCUMENTO APENAS DE PRODUÇÃO / DESENVOLVIMENTO**
> **NÃO SUBIR ESTE ARQUIVO PARA O SITE OFICIAL EM PRODUÇÃO (HOSTINGER)**
> Este arquivo serve apenas como documentação local e registro das modificações aplicadas para controle interno.

Este documento detalha todas as otimizações, correções e novos recursos implementados no site hoje.

---

## 1. URLs Amigáveis e Roteamento Avançado
* **Remoção de Extensões `.php`:** Configuração global para remover a extensão `.php` de todas as URLs do site.
* **Mapeamento de Rotas no `.htaccess`:**
  * `/blog` direciona internamente para `blog.php`.
  * `/blog/slug` direciona internamente para `artigo.php?slug=slug`.
  * `/produto/slug` direciona internamente para `produto-detalhe.php?slug=slug`.
* **Redirecionamento 301 Automático:** URLs antigas acessadas diretamente com `.php` (ex: `/sobre.php`) ou com parâmetros antigos (ex: `artigo.php?slug=...`) são redirecionadas automaticamente e de forma absoluta para a URL amigável correspondente.
* **Resolução de Pasta Base Dinâmica:**
  * Implementada detecção de ambiente isolada em `includes/header.php`.
  * Em ambiente local (XAMPP), resolve a `<base href="/Site-Institucional-Voltchz/">` automaticamente.
  * Em produção (Hostinger), resolve a `<base href="/">` automaticamente.
  * Isso evitou erros de caminhos de arquivos, duplicidade de diretórios e quebras de imagens/CSS.

## 2. Consolidação e Migração do Banco de Dados (SQL)
* **XAMPP Local (`xampp_setup_completo.sql`):** Script completo de destruição e recriação das tabelas do banco `voltchz_db`, com carga completa de dados iniciais e novos produtos Incharge.
* **Hostinger Produção (`hostinger_atualizacao_segura.sql`):** Script seguro para atualização da estrutura do banco em produção utilizando comandos de alteração sem risco de perda de leads ativos ou usuários existentes.

## 3. Melhorias Visuais e de Performance
* **Fundo de Imagens no Catálogo:** Alterado o fundo dos containers de imagens do catálogo em `produtos.php` de `bg-white` para `bg-brand-bg` (tema escuro), preparando o site para novas fotos com transparência.
* **Substituição de Imagem (Cliente 6):** Atualização física da foto `cliente-6.webp` (conversão otimizada de JPG para WebP via Python), agora utilizando a versão limpa sem o varal de roupas ao fundo.

## 4. Novo Portfólio Dedicado e Logos Premium
* **Nova Página de Portfólio (`portfolio.php`):** Migração do portfólio expandido da página inicial para uma página dedicada `/portfolio` acessível por link limpo.
* **Filtro de Marcas Corrigido:** Atualização do Javascript em `js/ui/portfolio-real.js` para aplicar ouvintes de eventos de clique individuais diretos nos botões de filtro, eliminando falhas de delegação de cliques.
* **Logos de Elétricos em SVG:** Integração de logos vetorizadas em formato SVG inline de alta qualidade para as marcas automotivas integradas (Tesla, BYD, GWM, Volvo, Geely/Zeekr, Porsche, BMW, Audi, Mercedes-Benz, Chevrolet).

---

## Estrutura de Arquivos Modificados / Adicionados
* **Novos:** `portfolio.php`, `js/ui/portfolio-real.js`, `.htaccess`, `includes/xampp_setup_completo.sql`, `includes/hostinger_atualizacao_segura.sql`.
* **Modificados:** `index.php`, `produtos.php`, `blog.php`, `artigo.php`, `viabilidade.php`, `includes/header.php`, `includes/footer.php`, `js/config.js`, `js/main.js`, `js/pages/artigo.js`, `js/pages/blog.js`, `js/pages/produtos.js`, `js/pages/produto-detalhe.js`, `js/ui/navigation.js`, `static/clientes/cliente-6.webp`.
