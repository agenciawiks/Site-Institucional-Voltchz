/**
 * VoltchZ Brasil - Portfólio Real Expandido
 * Mapeamento de instalações reais de veículos elétricos organizados por marca.
 */

import { $ } from '../utils/dom.js';

const HARDCODED_PORTFOLIO_DATA = [
    {
        brand: 'byd',
        model: 'BYD Dolphin',
        location: 'Condomínio Alphaville, São José dos Campos',
        desc: 'Instalação de Wallbox de 7.4 kW com Quadro de Proteção E-Wolf e infraestrutura dedicada.',
        image: 'static/clientes/cliente-5.webp'
    },
    {
        brand: 'byd',
        model: 'BYD Song Plus',
        location: 'Residencial Jardim Aquarius, SJC',
        desc: 'Recarga inteligente AC com balanceamento local de carga e proteção contra surtos.',
        image: 'static/clientes/cliente-12.webp'
    },
    {
        brand: 'byd',
        model: 'BYD Seal',
        location: 'Condomínio Urbanova, SJC',
        desc: 'Instalação de carregador de alta performance de 22 kW trifásico E-Wolf.',
        image: 'static/clientes/cliente-20.webp'
    },
    {
        brand: 'gwm',
        model: 'GWM Ora 03',
        location: 'Condomínio Esplanada, SJC',
        desc: 'Infraestrutura executada com cabeamento blindado de alta bitola e proteção DR Tipo A.',
        image: 'static/clientes/cliente-11.webp'
    },
    {
        brand: 'gwm',
        model: 'GWM Haval H6',
        location: 'Taubaté, SP',
        desc: 'Quadro de proteção E-Wolf 7.2 kW instalado integrado com Wallbox original GWM.',
        image: 'static/clientes/cliente-15.webp'
    },
    {
        brand: 'volvo',
        model: 'Volvo XC40 Recharge',
        location: 'Condomínio Bosque Imperial, SJC',
        desc: 'Recarga rápida e segura de 11 kW com dispositivo DR Tipo A de segurança e aterramento dedicado.',
        image: 'static/clientes/cliente-25.webp'
    },
    {
        brand: 'volvo',
        model: 'Volvo EX30',
        location: 'Residencial Altos da Serra, SJC',
        desc: 'Compacto e eficiente, carregador instalado em pedestal de alumínio VoltchZ.',
        image: 'static/clientes/cliente-32.webp'
    },
    {
        brand: 'geely',
        model: 'Zeekr 001 (Geely Group)',
        location: 'Condomínio Quinta das Flores, SJC',
        desc: 'Instalação homologada premium para o esportivo da Zeekr, utilizando quadro trifásico E-Wolf.',
        image: 'static/clientes/cliente-40.webp'
    },
    {
        brand: 'geely',
        model: 'Volvo C40 (Geely Group)',
        location: 'Alphaville Industrial, Barueri',
        desc: 'Instalação de carregamento integrado ao sistema de automação residencial e geração solar.',
        image: 'static/clientes/cliente-46.webp'
    },
    {
        brand: 'geely',
        model: 'Zeekr X (Geely Group)',
        location: 'São Paulo, SP',
        desc: 'Carregador Wallbox inteligente de 22 kW com leitor NFC e cabeamento embutido.',
        image: 'static/clientes/cliente-55.webp'
    },
    {
        brand: 'porsche',
        model: 'Porsche Taycan',
        location: 'Condomínio Mônaco, Jacareí',
        desc: 'Instalação trifásica premium de 22 kW com dupla proteção de aterramento e DPS classe II.',
        image: 'static/clientes/cliente-10.webp'
    },
    {
        brand: 'tesla',
        model: 'Tesla Model Y',
        location: 'Jardim das Colinas, SJC',
        desc: 'Carregador original Tesla Wall Connector integrado com proteção avançada E-Wolf.',
        image: 'static/clientes/cliente-2.webp'
    },
    {
        brand: 'bmw',
        model: 'BMW iX',
        location: 'Valinhos, SP',
        desc: 'Recarga trifásica de alta potência, com quadro de segurança tetrapolar e DR Tipo A.',
        image: 'static/clientes/cliente-18.webp'
    },
    {
        brand: 'audi',
        model: 'Audi e-tron',
        location: 'Jardim Aquarius, SJC',
        desc: 'Infraestrutura completa de recarga rápida instalada em vaga privativa de condomínio vertical.',
        image: 'static/clientes/cliente-30.webp'
    }
];

const DB_PORTFOLIO = window.VOLTCHZ_PORTFOLIO_DB_DATA || [];
const PORTFOLIO_DATA = DB_PORTFOLIO.length > 0 
    ? DB_PORTFOLIO.map(item => ({
        brand: item.brand,
        model: item.model,
        location: item.location,
        desc: item.description,
        image: item.image
      }))
    : HARDCODED_PORTFOLIO_DATA;

export const initPortfolioExpandido = () => {
    const grid = $('#portfolio-grid-expandido');
    const tabsContainer = $('#portfolio-tabs-expandido');
    if (!grid) return;

    // Função para renderizar os cards baseados no filtro
    const renderPortfolio = (filter = 'all') => {
        grid.innerHTML = '';
        
        // Filtra itens cujo arquivo de imagem não existe na pasta
        const existingImages = window.VOLTCHZ_EXISTING_IMAGES || [];
        const activeData = existingImages.length > 0
            ? PORTFOLIO_DATA.filter(item => existingImages.includes(item.image))
            : PORTFOLIO_DATA;
        
        const filtered = filter === 'all' 
            ? activeData 
            : activeData.filter(item => item.brand === filter);

        filtered.forEach(item => {
            const card = document.createElement('div');
            card.className = 'fade-item group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[24px] overflow-hidden flex flex-col p-4 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5';
            
            card.innerHTML = `
                <!-- Imagem da Instalação -->
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center cursor-pointer">
                    <img src="${item.image}" alt="Instalação ${item.model}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="bg-white/90 text-black text-xs font-bold px-4 py-2 rounded-xl shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">Ampliar Foto</span>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="flex-grow flex flex-col">
                    <div class="flex items-center justify-between gap-4 mb-2">
                        <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">
                            ${item.brand.toUpperCase() === 'GEELY' ? 'GRUPO GEELY' : item.brand.toUpperCase()}
                        </span>
                        <span class="text-[9px] font-mono text-white/45 truncate max-w-[150px]">
                            ${item.location.split(',')[0]}
                        </span>
                    </div>
                    
                    <h3 class="text-base font-bold text-white mb-2 leading-snug group-hover:text-brand-green transition-colors">
                        ${item.model}
                    </h3>
                    
                    <p class="text-brand-muted text-[12px] leading-relaxed mb-2 flex-grow">
                        ${item.desc}
                    </p>
                    
                    <div class="text-[10px] text-white/40 flex items-center gap-1.5 mt-auto pt-2 border-t border-white/5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span class="truncate">${item.location}</span>
                    </div>
                </div>
            `;

            // Clique na imagem para lightbox
            card.querySelector('img').parentNode.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src: item.image } }));
            });

            grid.appendChild(card);
        });
    };

    // Eventos de Filtro
    if (tabsContainer) {
        tabsContainer.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                
                tabsContainer.querySelectorAll('button').forEach(b => {
                    b.classList.remove('border-brand-green', 'bg-brand-green', 'text-brand-bg');
                    b.classList.add('border-white/10', 'bg-white/5', 'text-brand-muted');
                });

                btn.classList.add('border-brand-green', 'bg-brand-green', 'text-brand-bg');
                btn.classList.remove('border-white/10', 'bg-white/5', 'text-brand-muted');

                const filter = btn.getAttribute('data-filter');
                renderPortfolio(filter);
            });
        });
    }

    // Inicialização
    renderPortfolio('all');
};
