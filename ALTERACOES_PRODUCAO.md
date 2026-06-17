# Alterações Realizadas no Projeto (VoltchZ Brasil)

> [!WARNING]
> **DOCUMENTO APENAS DE PRODUÇÃO / DESENVOLVIMENTO**
> **NÃO SUBIR ESTE ARQUIVO PARA O SITE OFICIAL EM PRODUÇÃO (HOSTINGER)**
> Este arquivo serve apenas como documentação local e registro das modificações aplicadas para controle interno.

Este documento detalha todas as otimizações, correções e novos recursos implementados no site.

---

## [16/06/2026] - Grandes Atualizações e Otimizações de Produção

### 1. URLs Amigáveis do Blog e Roteamento Avançado
* **Remoção do Prefixo `/blog/`:** Os artigos agora são acessados diretamente na raiz (ex: `/meu-artigo` em vez de `/blog/meu-artigo`).
* **Resolução de Conflitos de Âncora (Menu):** Ajustada a regra no `.htaccess` para impedir que arquivos `.php` físicos sem extensão (como `index`, `sobre`, `produtos`) fossem incorretamente capturados como slugs de blog.
* **Redirecionamento 301 Automático:** Configurados redirecionamentos permanentes no `.htaccess` de acessos legados (`artigo.php?slug=...` e `/blog/slug`) para a nova URL limpa.
* **Atualização de Templates e Scripts:** Atualizados todos os links de artigos em `blog.php`, `artigo.php`, `js/pages/artigo.js` e `js/pages/blog.js`.

### 2. Separação de Produtos no Banco de Dados
* **Divisão de Quadro de Proteção:** O "Quadro de Proteção E-Wolf 7.2 kW" foi subdividido em 4 produtos distintos (com/sem tomada, monofásico/bifásico e trifásico).
* **Migração SQL:** Atualizados os scripts de banco de dados local (`includes/xampp_setup_completo.sql`) e produção (`includes/hostinger_atualizacao_segura.sql`), além do `db.json`.

### 3. Remoção de Fundo de Imagens
* **Transparência Premium:** Processamento com sucesso de 17 imagens de carregadores e pedestais (Intelbras e Incharge) removendo o fundo e otimizando a exibição no tema escuro.

### 4. Segurança contra Bots (Anti-Spam)
* **Honeypot + Time Lock:** Implementado campo invisível para bots e trava de tempo de envio mínimo (2 segundos) no front-end (`js/utils/forms.js`) e validações no back-end (`save-lead.php` e `contato.php`).

### 5. Portfólio & Organização de Logos
* **Logos Oficiais:** Substituição das logos no portfólio (`portfolio.php`) pelas versões atualizadas da pasta `static/logos-marcas/` (E-Wolf, Intelbras, Incharge, BYD, BMW, Embraer), removendo a logo Padrão Brasil.
* **Filtros Dinâmicos:** Correção dos ouvintes de clique em `js/ui/portfolio-real.js`.

### 6. Novo Script de Deploy (PowerShell)
* **`make_deploy.ps1`:** Substituição do antigo script Python por um script nativo PowerShell super veloz que gera o pacote compactado `voltchz_hostinger_deploy.zip` ignorando pastas como `.git` e `node_modules` de forma limpa.

---

## Estrutura de Arquivos Modificados / Adicionados
* **Novos:** `portfolio.php`, `js/ui/portfolio-real.js`, `.htaccess`, `make_deploy.ps1`, `includes/xampp_setup_completo.sql`, `includes/hostinger_atualizacao_segura.sql`.
* **Removidos:** `make_deploy.py`.
* **Modificados:** `index.php`, `produtos.php`, `blog.php`, `artigo.php`, `viabilidade.php`, `includes/header.php`, `includes/footer.php`, `js/config.js`, `js/main.js`, `js/pages/artigo.js`, `js/pages/blog.js`, `js/pages/produtos.js`, `js/pages/produto-detalhe.js`, `js/ui/navigation.js`.
