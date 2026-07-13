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
    },
    {
        tipo: 'condominio',
        brand: 'condominio',
        model: 'Infraestrutura Coletiva',
        location: 'Condomínio Aquarius, SJC',
        desc: 'Instalação de barramento blindado e quadros de medição individualizada para 20 vagas de garagem.',
        image: 'static/carregador-predio-estacionamento.webp'
    },
    {
        tipo: 'condominio',
        brand: 'condominio',
        model: 'Adequação Elétrica Coletiva',
        location: 'Edifício Esplanada, SJC',
        desc: 'Projeto executivo e instalação de proteção contra incêndio e DPS tetrapolar para recarga coletiva.',
        image: 'static/carregador-predio-estacionamento2.webp'
    }
];

const DB_PORTFOLIO = window.VOLTCHZ_PORTFOLIO_DB_DATA || [];
const PORTFOLIO_DATA = DB_PORTFOLIO.length > 0 
    ? DB_PORTFOLIO.map(item => ({
        tipo: item.tipo || (item.brand === 'condominio' ? 'condominio' : 'veiculo'),
        brand: item.brand,
        model: item.model,
        location: item.location,
        desc: item.description,
        image: item.image
      }))
    : HARDCODED_PORTFOLIO_DATA.map(item => ({
        tipo: item.tipo || (item.brand === 'condominio' ? 'condominio' : 'veiculo'),
        brand: item.brand,
        model: item.model,
        location: item.location,
        desc: item.desc || item.description,
        image: item.image
      }));

export const initPortfolioExpandido = () => {
    const gridVeiculos = $('#portfolio-grid-expandido');
    const gridCondos = $('#condominios-grid');
    const tabsContainer = $('#portfolio-tabs-expandido');
    if (!gridVeiculos) return;

    // Não filtra por existência física da imagem no disco para evitar que projetos sumam em deploys
    const activeData = PORTFOLIO_DATA;

    const veiculosData = activeData.filter(item => item.tipo === 'veiculo');
    const condosData = activeData.filter(item => item.tipo === 'condominio' || item.tipo === 'construtora');

    // Helper para criar o card HTML
    const createCardElement = (item) => {
        const card = document.createElement('div');
        card.className = 'fade-item group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[24px] overflow-hidden flex flex-col p-4 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5';
        
        const imgs = item.image.split(',').map(s => s.trim()).filter(Boolean);
        const hasMultiple = imgs.length > 1;
        const firstImg = imgs[0] || '';

        let imageHtml = '';
        if (hasMultiple) {
            imageHtml = `
            <!-- Carrossel de Imagens -->
            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 group/carousel">
                <div class="carousel-images-container w-full h-full flex transition-transform duration-300">
                    ${imgs.map((src, i) => `
                        <div class="w-full h-full flex-shrink-0 cursor-pointer relative" onclick="window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src: '${src}' } }))">
                            <img src="${src}" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação ${item.model} - Foto ${i+1}" class="w-full h-full object-cover">
                        </div>
                    `).join('')}
                </div>
                
                <!-- Setas de navegação -->
                <button type="button" class="carousel-prev-btn absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path></svg>
                </button>
                <button type="button" class="carousel-next-btn absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
                </button>

                <!-- Indicadores (bullets) -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-20 bg-black/30 px-2 py-1 rounded-full backdrop-blur-md border border-white/5">
                    ${imgs.map((_, i) => `
                        <span class="carousel-indicator w-1.5 h-1.5 rounded-full bg-white/45 transition-all ${i === 0 ? 'bg-brand-green w-3' : ''}"></span>
                    `).join('')}
                </div>
            </div>
            `;
        } else {
            imageHtml = `
            <!-- Imagem Única -->
            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src: '${firstImg}' } }))">
                <img src="${firstImg}" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação ${item.model}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white/90 text-black text-xs font-bold px-4 py-2 rounded-xl shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">Ampliar Foto</span>
                </div>
            </div>
            `;
        }

        card.innerHTML = `
            ${imageHtml}

            <!-- Conteúdo -->
            <div class="flex-grow flex flex-col">
                <div class="flex items-center justify-between gap-4 mb-2">
                    <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">
                        ${item.tipo === 'condominio' ? 'CONDOMÍNIO' : (item.tipo === 'construtora' ? 'CONSTRUTORA' : (item.brand.toUpperCase() === 'GEELY' ? 'GRUPO GEELY' : item.brand.toUpperCase()))}
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

        if (hasMultiple) {
            let activeIdx = 0;
            const container = card.querySelector('.carousel-images-container');
            const indicators = card.querySelectorAll('.carousel-indicator');
            const prevBtn = card.querySelector('.carousel-prev-btn');
            const nextBtn = card.querySelector('.carousel-next-btn');

            const updateCarousel = () => {
                container.style.transform = `translateX(-${activeIdx * 100}%)`;
                indicators.forEach((ind, i) => {
                    if (i === activeIdx) {
                        ind.classList.add('bg-brand-green', 'w-3');
                        ind.classList.remove('bg-white/40');
                    } else {
                        ind.classList.remove('bg-brand-green', 'w-3');
                        ind.classList.add('bg-white/40');
                    }
                });
            };

            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                activeIdx = (activeIdx === 0) ? imgs.length - 1 : activeIdx - 1;
                updateCarousel();
            });

            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                activeIdx = (activeIdx === imgs.length - 1) ? 0 : activeIdx + 1;
                updateCarousel();
            });
        }

        return card;
    };

    // Função para renderizar os cards de veículos baseados no filtro
    const renderVeiculos = (filter = 'all') => {
        gridVeiculos.innerHTML = '';
        
        const filtered = filter === 'all' 
            ? veiculosData 
            : veiculosData.filter(item => item.brand === filter);

        filtered.forEach(item => {
            const card = createCardElement(item);
            gridVeiculos.appendChild(card);
        });
    };

    // Função para renderizar os cards de condomínios
    const renderCondominios = () => {
        if (!gridCondos) return;
        gridCondos.innerHTML = '';
        
        condosData.forEach(item => {
            const card = createCardElement(item);
            gridCondos.appendChild(card);
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
                renderVeiculos(filter);
            });
        });
    }

    // Inicialização
    renderVeiculos('all');
    renderCondominios();
};
