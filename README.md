# VoltchZ Brasil — Infraestrutura de Recarga para Veículos Elétricos

Site institucional moderno e de alta conversão para a **VoltchZ Brasil**, empresa especializada em engenharia de infraestrutura para carregamento de veículos elétricos (VEs).

## 🚀 Tecnologias Utilizadas

- **Estrutura:** [HTML5](https://developer.mozilla.org/pt-BR/docs/Web/HTML) semântico
- **Estilização:** [Tailwind CSS](https://tailwindcss.com/) (via CDN) & Vanilla CSS
- **Interatividade:** JavaScript Modular (ES6+)
- **Design:** Estética premium (Dark Mode, Glassmorphism, Grain Texture)
- **Acessibilidade & SEO:** Implementação seguindo as melhores práticas (ARIA, Meta tags).

## ✨ Principais Funcionalidades

- **Design Premium:** Interface moderna com modo escuro e animações fluidas.
- **Carrossel Hero Inteligente:** Banner rotativo dinâmico adaptativo.
- **Localizador de Carregadores:** Integração com mapa para encontrar estações de recarga.
- **Galeria de Cases com Lightbox:** Visualização detalhada de projetos realizados.
- **Barra de Progresso e Scroll-spy:** Navegação aprimorada.
- **SEO Otimizado:** Preparado para compartilhamento em redes sociais e buscadores.

## 📂 Estrutura do Projeto

```text
├── IMAGENS/               # Ativos visuais (logos, banners, cases)
├── js/                    # Lógica modular do projeto
│   ├── core/              # Lógica central e inicialização
│   ├── ui/                # Componentes de interface (carrossel, lightbox, nav)
│   ├── utils/             # Funções utilitárias
│   ├── config.js          # Configurações globais
│   └── main.js            # Ponto de entrada do JavaScript
├── index.html             # Página principal
├── sobre.html             # Página institucional
├── ferramentas.html       # Localizador de carregadores
├── contato.html           # Página de contato
├── styles.css             # Estilos customizados
├── package.json           # Configurações de scripts
└── vercel.json            # Configurações de deploy
```

## 🛠️ Como Executar Localmente

> [!IMPORTANT]
> **Obrigatório o uso de Servidor Local:** Devido ao uso de **JavaScript Modules (ES6)**, o projeto **não funcionará corretamente** se aberto diretamente pelo sistema de arquivos (`file://`). É necessário um servidor para que os módulos e animações sejam carregados.

### Pré-requisitos
- [Node.js](https://nodejs.org/) instalado.

### Passo a Passo
1. Clone o repositório:
   ```bash
   git clone https://github.com/agenciawiks/Site-Institucional-Voltchz.git
   ```
2. Instale o servidor de arquivos estáticos:
   ```bash
   npm install -g serve
   ```
3. Inicie o projeto:
   ```bash
   npm start
   ```
   *O comando `npm start` executa `serve .`. Se preferir não instalar nada globalmente, use `npx serve`.*

O site será servido em `http://localhost:3000`.

---
© 2026 VoltchZ Brasil · Todos os direitos reservados.
