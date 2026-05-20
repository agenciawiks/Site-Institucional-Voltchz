/**
 * VoltchZ Brasil - Banco de Dados de Produtos e Blog Técnico
 * Estrutura relacional escalável preparada para futura migração para PHP/SQL.
 */

import { CONFIG } from '../config.js';

// --- GERADOR DE HARDWARE TECHNICAL VECTOR SVGs INLINE ---
export const generateTechnicalSVG = (category, name = '', brand = '') => {
  const accent = '#22c55e'; // Verde VoltchZ
  const bg = '#0f0f15';
  const grid = 'rgba(240, 240, 244, 0.03)';
  const border = 'rgba(255, 255, 255, 0.08)';

  let content = '';

  if (category === 'protecao') {
    content = `
      <!-- Fundo técnico/grid -->
      <rect width="400" height="300" fill="${bg}" rx="16" />
      <g stroke="${grid}" stroke-width="1.5">
        <line x1="0" y1="50" x2="400" y2="50" />
        <line x1="0" y1="100" x2="400" y2="100" />
        <line x1="0" y1="150" x2="400" y2="150" />
        <line x1="0" y1="200" x2="400" y2="200" />
        <line x1="0" y1="250" x2="400" y2="250" />
        <line x1="80" y1="0" x2="80" y2="300" />
        <line x1="160" y1="0" x2="160" y2="300" />
        <line x1="240" y1="0" x2="240" y2="300" />
        <line x1="320" y1="0" x2="320" y2="300" />
      </g>
      
      <!-- Chassi do Quadro -->
      <rect x="110" y="40" width="180" height="220" rx="12" fill="#181822" stroke="${border}" stroke-width="2" />
      <!-- Tampa Acrílica Fumê -->
      <rect x="125" y="55" width="150" height="120" rx="6" fill="rgba(10,10,15,0.75)" stroke="rgba(255,255,255,0.15)" stroke-width="1" />
      
      <!-- Componentes (Disjuntores) -->
      <g transform="translate(135, 70)">
        <!-- Disjuntor Principal -->
        <rect x="0" y="0" width="35" height="75" rx="3" fill="#2d2d3a" stroke="rgba(255,255,255,0.1)" />
        <rect x="5" y="10" width="25" height="20" fill="#111" />
        <rect x="12" y="45" width="11" height="18" rx="2" fill="${accent}" />
        <text x="17" y="23" fill="#fff" font-size="8" font-family="monospace" text-anchor="middle">32A</text>
        
        <!-- DR Classe A -->
        <rect x="42" y="0" width="45" height="75" rx="3" fill="#2d2d3a" stroke="rgba(255,255,255,0.1)" />
        <rect x="7" y="10" width="31" height="20" fill="#111" />
        <rect x="20" y="45" width="11" height="18" rx="2" fill="${accent}" />
        <circle cx="11" cy="54" r="3" fill="#ef4444" /> <!-- Botão Teste -->
        <text x="22" y="23" fill="#fff" font-size="8" font-family="monospace" text-anchor="middle">DR-A</text>
        
        <!-- DPS -->
        <rect x="94" y="0" width="35" height="75" rx="3" fill="#2d2d3a" stroke="rgba(255,255,255,0.1)" />
        <rect x="5" y="10" width="25" height="20" fill="#111" />
        <rect x="7" y="45" width="21" height="18" rx="1" fill="#ea580c" />
        <text x="17" y="23" fill="#fff" font-size="8" font-family="monospace" text-anchor="middle">DPS</text>
      </g>

      <!-- Fecho e Dobradiças -->
      <rect x="290" y="130" width="4" height="20" rx="1" fill="#fff" opacity="0.3" />
      
      <!-- Detalhes de Texto Técnico -->
      <text x="200" y="205" fill="${accent}" font-size="10" font-family="monospace" text-anchor="middle" font-weight="bold">QDC VOLTCHZ</text>
      <text x="200" y="220" fill="rgba(240,240,244,0.4)" font-size="8" font-family="monospace" text-anchor="middle">CERTIFIED PROTECT IP65</text>
      <path d="M 200,230 L 210,240 L 202,240 L 204,248 L 195,238 L 201,238 Z" fill="${accent}" />
    `;
  } else if (category === 'estacoes') {
    content = `
      <rect width="400" height="300" fill="${bg}" rx="16" />
      <g stroke="${grid}" stroke-width="1.5">
        <line x1="0" y1="50" x2="400" y2="50" />
        <line x1="0" y1="100" x2="400" y2="100" />
        <line x1="0" y1="150" x2="400" y2="150" />
        <line x1="0" y1="200" x2="400" y2="200" />
        <line x1="0" y1="250" x2="400" y2="250" />
        <line x1="80" y1="0" x2="80" y2="300" />
        <line x1="160" y1="0" x2="160" y2="300" />
        <line x1="240" y1="0" x2="240" y2="300" />
        <line x1="320" y1="0" x2="320" y2="300" />
      </g>
      
      <!-- Eletroposto Base -->
      <rect x="145" y="40" width="110" height="220" rx="20" fill="#1c1c28" stroke="${border}" stroke-width="2" />
      
      <!-- Moldura Central Black Piano -->
      <rect x="155" y="55" width="90" height="190" rx="14" fill="#0b0b10" />
      
      <!-- Tela LCD Glow -->
      <rect x="170" y="75" width="60" height="40" rx="4" fill="#131824" stroke="rgba(34,197,94,0.3)" stroke-width="1.5" />
      <text x="200" y="93" fill="${accent}" font-size="8" font-family="monospace" text-anchor="middle" font-weight="bold">READY</text>
      <text x="200" y="105" fill="#60a5fa" font-size="7" font-family="monospace" text-anchor="middle">22.0 kW / 32A</text>
      
      <!-- Status LED Ring -->
      <circle cx="200" cy="165" r="28" fill="none" stroke="rgba(34,197,94,0.06)" stroke-width="8" />
      <circle cx="200" cy="165" r="28" fill="none" stroke="${accent}" stroke-width="2.5" stroke-dasharray="140, 30" />
      
      <!-- Lightning Bolt Icon inside LED ring -->
      <path d="M 200,152 L 208,165 L 202,165 L 204,178 L 192,165 L 198,165 Z" fill="${accent}" />
      
      <!-- Plug/Cabo -->
      <rect x="190" y="248" width="20" height="30" rx="4" fill="#2d2d3a" />
      <line x1="200" y1="260" x2="200" y2="290" stroke="#111" stroke-width="6" stroke-linecap="round" />
    `;
  } else if (category === 'portateis') {
    content = `
      <rect width="400" height="300" fill="${bg}" rx="16" />
      <g stroke="${grid}" stroke-width="1.5">
        <line x1="0" y1="50" x2="400" y2="50" />
        <line x1="0" y1="100" x2="400" y2="100" />
        <line x1="0" y1="150" x2="400" y2="150" />
        <line x1="200" y1="0" x2="200" y2="300" />
      </g>
      
      <!-- Unidade EVSE Central -->
      <rect x="130" y="80" width="140" height="70" rx="18" fill="#1f1f2e" stroke="${border}" stroke-width="2" />
      <rect x="145" y="92" width="110" height="46" rx="10" fill="#08080c" />
      
      <!-- Display Digital -->
      <text x="200" y="112" fill="${accent}" font-size="10" font-family="monospace" text-anchor="middle" font-weight="bold">16A MONO</text>
      <text x="200" y="127" fill="rgba(240,240,244,0.5)" font-size="8" font-family="monospace" text-anchor="middle">220V · 3.5kW</text>
      
      <!-- Cabos enrolados (Círculos decorativos) -->
      <path d="M 90,115 C 60,60 340,60 310,115 C 290,150 110,150 90,115 Z" fill="none" stroke="#2d2d3c" stroke-width="6" opacity="0.4" />
      <path d="M 80,125 C 50,70 350,70 320,125" fill="none" stroke="#111" stroke-width="7" stroke-linecap="round" />
      
      <!-- Conector Tipo 2 -->
      <g transform="translate(300, 150) rotate(30)">
        <rect x="0" y="0" width="18" height="40" rx="4" fill="#2d2d3a" />
        <rect x="-3" y="10" width="24" height="15" rx="2" fill="#111" />
        <line x1="9" y1="40" x2="9" y2="60" stroke="#111" stroke-width="4" />
      </g>
    `;
  } else if (category === 'suportes') {
    content = `
      <rect width="400" height="300" fill="${bg}" rx="16" />
      <g stroke="${grid}" stroke-width="1.5">
        <line x1="0" y1="50" x2="400" y2="50" />
        <line x1="0" y1="100" x2="400" y2="100" />
        <line x1="0" y1="150" x2="400" y2="150" />
        <line x1="200" y1="0" x2="200" y2="300" />
      </g>
      
      <!-- Chão / Concreto -->
      <rect x="80" y="250" width="240" height="20" rx="4" fill="#334155" />
      <line x1="50" y1="270" x2="350" y2="270" stroke="rgba(255,255,255,0.1)" stroke-width="2" />
      
      <!-- Totem Metálico -->
      <rect x="185" y="60" width="30" height="190" fill="#1e293b" stroke="${border}" stroke-width="1.5" />
      <rect x="175" y="240" width="50" height="10" rx="2" fill="#0f172a" />
      
      <!-- Parafusos da Base -->
      <circle cx="180" cy="245" r="2.5" fill="#94a3b8" />
      <circle cx="220" cy="245" r="2.5" fill="#94a3b8" />
      
      <!-- Cobertura Superior (Policarbonato) -->
      <path d="M 130,50 L 270,35 L 280,43 L 130,60 Z" fill="rgba(34,197,94,0.3)" stroke="${accent}" stroke-width="2" />
      <line x1="130" y1="50" x2="185" y2="60" stroke="#000" stroke-width="3" />
      <line x1="270" y1="35" x2="215" y2="60" stroke="#000" stroke-width="3" />
      
      <!-- Wallbox Integrada no Totem -->
      <rect x="180" y="100" width="40" height="60" rx="8" fill="#0b0f19" stroke="${border}" />
      <circle cx="200" cy="130" r="10" fill="none" stroke="${accent}" stroke-width="1.5" />
    `;
  } else {
    // Fallback genérico minimalista premium
    content = `
      <rect width="400" height="300" fill="${bg}" rx="16" />
      <circle cx="200" cy="150" r="40" fill="none" stroke="${accent}" stroke-width="2" stroke-dasharray="10 5" />
      <text x="200" y="154" fill="${accent}" font-size="14" font-family="sans-serif" text-anchor="middle" font-weight="bold">VOLTCHZ</text>
    `;
  }

  // Elementos de Branding
  const brandName = name ? name.toUpperCase() : 'VOLTCHZ INJECTED';
  const labelBrand = brand ? brand.toUpperCase() : 'PRODUCT CATALOG';

  return `
    <svg viewBox="0 0 400 300" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" xmlns="http://www.w3.org/2000/svg">
      ${content}
      <!-- Overlay Industrial de Canto -->
      <g transform="translate(20, 20)">
        <rect x="0" y="0" width="120" height="18" rx="4" fill="rgba(0,0,0,0.4)" stroke="rgba(255,255,255,0.08)" stroke-width="1" />
        <circle cx="8" cy="9" r="3.5" fill="${accent}" />
        <text x="18" y="12" fill="rgba(240,240,244,0.8)" font-size="7.5" font-family="monospace" font-weight="bold">${labelBrand}</text>
      </g>
    </svg>
  `;
};

// --- ENTIDADES RELACIONAIS ---

export const MARCAS = [
  { id: 'ewolf', nome: 'E-Wolf', descricao: 'Proteção elétrica inteligente de alta performance e estações de carregamento confiáveis projetadas para mobilidade elétrica moderna.' },
  { id: 'intelbras', nome: 'Intelbras', descricao: 'Tecnologia nacional e robustez de hardware para recarga corporativa e frotas.' },
  { id: 'incharge', nome: 'Incharge', descricao: 'Estações avançadas de carregamento com design escandinavo e alto torque energético.' },
  { id: 'voltchz', nome: 'VoltchZ', descricao: 'Acessórios estruturais, pedestais chumbados e complementos desenvolvidos com a engenharia e qualidade premium da VoltchZ.' }
];

export const CATEGORIAS = [
  { id: 'protecao', nome: 'Quadros de Proteção', descricao: 'Dispositivos essenciais de isolamento (DR Tipo A, Disjuntores e DPS) que salvaguardam o veículo e o edifício.' },
  { id: 'estacoes', nome: 'Estações de Carregamento', descricao: 'Carregadores de parede (Wallbox) e totens rápidos trifásicos AC e DC com ou sem suporte inteligente (OCPP).' },
  { id: 'portateis', nome: 'Carregadores Portáteis', descricao: 'Unidades leves de emergência com corrente regulável para uso flexível e viagens.' },
  { id: 'suportes', nome: 'Suportes e Totens', descricao: 'Pedestais de aço estrutural de solo com coberturas de policarbonato para locais abertos sem apoio físico.' }
];

export const PRODUTOS = [
  {
    id: 1,
    slug: 'quadro-protecao-7-2kw',
    nome: 'Quadro de Proteção E-Wolf 7.2 kW',
    marcaId: 'ewolf',
    categoriaId: 'protecao',
    potencia: '7,2 kW (32A)',
    tensao: '220VAC (Monofásico / Bifásico)',
    aplicacao: 'Residencial e Comercial Leve',
    tipo: 'Quadro de Segurança Bipolar',
    resumo: 'Proteção de segurança essencial para o carregamento do seu carro em residências. Equipado com DR Classe A e DPS de alta performance.',
    descricao: 'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco.',
    diferenciais: [
      'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)',
      'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d\'água',
      'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados',
      'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento'
    ],
    especificacoes: {
      'Potência Nominal': '7,2 kW (32A)',
      'Tensão Operacional': '220VAC (Monofásico F+N ou Bifásico F+F)',
      'Disjuntor': 'Bipolar 32A Curva C (6kA)',
      'Interruptor DR': 'Bipolar 40A / 30mA Classe A',
      'DPS Surto': 'Bipolar 20/40kA 275V Classe II',
      'Grau de Vedação': 'IP65 (Instalação interna ou externa)',
      'Dimensões Externas': '200mm x 150mm x 120mm'
    },
    variacoes: [
      {
        sku: 'EW-QP7-ST',
        nome: 'Sem tomada industrial',
        adicionalDesc: 'Projetado para ligação direta via cabo até os bornes internos da estação Wallbox, ideal para acabamento embutido super limpo.'
      },
      {
        sku: 'EW-QP7-CT',
        nome: 'Com tomada industrial',
        adicionalDesc: 'Apresenta saída acoplada integrada com tomada industrial azul 32A 2P+T padrão NBR IEC 60309, perfeito para carregadores portáteis potentes.'
      }
    ]
  },
  {
    id: 2,
    slug: 'quadro-protecao-22kw',
    nome: 'Quadro de Proteção E-Wolf 22 kW',
    marcaId: 'ewolf',
    categoriaId: 'protecao',
    potencia: '22 kW (3x 32A)',
    tensao: '380VAC (Trifásico com Neutro)',
    aplicacao: 'Comercial, Condomínios e Frotas',
    tipo: 'Quadro de Segurança Tetrapolar',
    resumo: 'Blindagem elétrica trifásica avançada com DR Tipo A quadripolar para estações comerciais de recarga rápida e hubs corporativos.',
    descricao: 'Projetado sob medida para redes elétricas trifásicas em 380V (F+F+F+N+PE). O Quadro de Proteção E-Wolf de 22 kW é a escolha preferida de engenheiros e instaladores para projetos comerciais robustos. Ele garante que as altas correntes trifásicas de recarga sejam monitoradas e protegidas individualmente, mantendo a operabilidade segura e sem interrupções indesejadas.',
    diferenciais: [
      'Dispositivo DR Classe A Tetrapolar com alto isolamento',
      'DPS Tetrapolar modular que permite troca rápida dos cartuchos sem desligar a fiação',
      'Barramento interno de cobre dimensionado para carga contínua prolongada de 32A',
      'Indicadores de presença de fase por lâmpada neon frontal integrada'
    ],
    especificacoes: {
      'Potência Nominal': '22 kW (3 fases de 32A)',
      'Tensão Operacional': '380VAC Trifásico + Neutro + Terra',
      'Disjuntor': 'Tetrapolar 40A Curva C (10kA)',
      'Interruptor DR': 'Tetrapolar 40A / 30mA Classe A',
      'DPS Surto': 'Tetrapolar 20/40kA 275V Classe II',
      'Grau de Vedação': 'IP65 (Instalação industrial)',
      'Conexão Entrada': 'Cabos de até 16 mm²'
    },
    variacoes: [
      {
        sku: 'EW-QP22-ST',
        nome: 'Sem tomada industrial',
        adicionalDesc: 'Saída direta por prensa-cabos blindados PG21 para alimentação física contínua da estação.'
      },
      {
        sku: 'EW-QP22-CT',
        nome: 'Com tomada industrial',
        adicionalDesc: 'Equipado com uma tomada industrial vermelha de alta potência de 32A 3P+N+T instalada no chassi inferior do quadro.'
      }
    ]
  },
  {
    id: 3,
    slug: 'estacao-carregamento-380vac-tipo-2',
    nome: 'Estação de Carregamento 380VAC Tipo 2',
    marcaId: 'ewolf',
    categoriaId: 'estacoes',
    potencia: 'Até 22 kW',
    tensao: '380VAC Trifásico',
    aplicacao: 'Residencial, Comercial e Hubs Corporativos',
    tipo: 'Wallbox Inteligente',
    resumo: 'Carregador trifásico elegante e potente para veículos elétricos de qualquer marca. Suporta ajuste de potência dinâmico e display informativo.',
    descricao: 'A união perfeita de engenharia robusta e estética moderna. Com gabinete frontal em vidro temperado resistente e anel de LED dinâmico que indica visualmente o progresso da recarga, esta estação se integra harmoniosamente em garagens residenciais sofisticadas, garagens comerciais de hotéis e pátios corporativos.',
    diferenciais: [
      'Recarga ultra rápida de até 22 kW (22.000W) por hora',
      'Anel de luz indicativo inteligente de status operacional',
      'Interface digital por display colorido LCD que indica tensão, corrente e temperatura',
      'Cabo tipo 2 de alta qualidade com proteção contra esmagamento e rasgos'
    ],
    especificacoes: {
      'Potência Máxima': '22 kW Trifásico / Ajustável a patamares menores',
      'Tensão': '380VAC Trifásico (L1+L2+L3+N+PE)',
      'Conector Veículo': 'Tipo 2 (IEC 62196-2) de 5 metros',
      'Leitor de Cartão': 'Opcional (RFID integrado)',
      'Grau de Proteção': 'IP65 com dreno de condensação',
      'Norma Internacional': 'IEC 61851-1 para segurança eletrônica'
    },
    variacoes: [
      {
        sku: 'EV-380-W1',
        nome: 'Instalação em parede (1 conector)',
        adicionalDesc: 'Unidade clássica de montagem em parede com 1 conector e suporte para organizar o cabo quando ocioso.'
      },
      {
        sku: 'EV-380-W2',
        nome: 'Versão com 2 conectores de saída',
        adicionalDesc: 'Fornece dois cabos independentes com divisão e balanceamento automático de carga trifásica dinâmica.'
      }
    ]
  },
  {
    id: 4,
    slug: 'estacao-carregamento-comercial-ccs2',
    nome: 'Estação de Carregamento Comercial CCS2',
    marcaId: 'ewolf',
    categoriaId: 'estacoes',
    potencia: '40 kW DC a 80 kW DC',
    tensao: '380VAC ±15% Trifásico (Entrada)',
    aplicacao: 'Rodoviário, Supermercados e Hubs de Frota',
    tipo: 'Carregador Rápido DC',
    resumo: 'Carregador em Corrente Contínua ultra rápido com controle total OCPP 1.6J, tela integrada touchscreen e comunicação celular nativa.',
    descricao: 'A solução definitiva para frotistas que necessitam de carregamento contínuo em menos de 1 hora. A estação Comercial DC E-Wolf fornece energia direta para a bateria do veículo sem passar pelo conversor de bordo AC, gerando curvas de carga agressivas e estáveis. Integrado por OCPP, permite a cobrança por kWh ou tempo de uso através de centrais de pagamento de parceiros.',
    diferenciais: [
      'Injeção direta de energia contínua DC para curvas de recarga ultrarrápidas',
      'Compatível com qualquer servidor ou gerenciador via protocolo OCPP 1.6J JSON',
      'Tela colorida intuitiva Touchscreen para controle e feedback em tempo real',
      'Comunicação de dados móveis 4G GPRS e Wi-Fi redundantes incluídos de fábrica'
    ],
    especificacoes: {
      'Tipo de Corrente': 'DC (Corrente Contínua direta na bateria)',
      'Protocolo OCPP': 'OCPP 1.6J JSON nativo',
      'Identificação': 'Cartão de acesso RFID / Login APP / OCPP',
      'Conectividade': '4G GPRS / Porta Ethernet RJ45 / Wi-Fi',
      'Conector Veicular': 'CCS Combo 2 de alto torque térmico',
      'Proteções Internas': 'Fugas DC, sobretensão, curto e aterramento flutuante'
    },
    variacoes: [
      {
        sku: 'EV-CCS-P1',
        nome: '1 plug CCS2 de saída',
        adicionalDesc: 'Foco em pátios industriais e recargas de frotas unitárias rápidas sem paradas intermediárias.'
      },
      {
        sku: 'EV-CCS-P2',
        nome: 'Versão com 2 plugs CCS2',
        adicionalDesc: 'Divisão de potência compartilhada dinâmica inteligente para recarga de dois carros elétricos simultâneos.'
      }
    ]
  },
  {
    id: 5,
    slug: 'std-estacao-carregamento-220vac',
    nome: 'STD – Estação de Carregamento 220VAC',
    marcaId: 'ewolf',
    categoriaId: 'estacoes',
    potencia: '7,4 kW (32A)',
    tensao: '220VAC Monofásico',
    aplicacao: 'Residências e Garagens Privativas',
    tipo: 'Wallbox Standard Plug & Play',
    resumo: 'O cavalo de batalha do carregamento doméstico diário. Uma estação compacta, direta e extremamente confiável.',
    descricao: 'Criada para usuários que buscam simplicidade, robustez e segurança sem pagar por firulas tecnológicas supérfluas. A série STD de 220VAC se liga à rede elétrica monofásica clássica e entrega a potência máxima aceitável em carregadores AC monofásicos brasileiros. Basta acoplar o bocal Tipo 2 no veículo e o carregamento inicia de forma imediata.',
    diferenciais: [
      'Acionamento plug-and-play direto e simplificado',
      'Construção com termoplástico de alta resistência contra batidas',
      'Excelente relação custo-benefício para carregamento doméstico regular',
      'Pode ser chumbado ou pendurado de forma extremamente descomplicada'
    ],
    especificacoes: {
      'Potência': '7,4 kW (7.400 Watts por hora)',
      'Tensão Elétrica': '220V Monofásico (ou Bifásico F+F)',
      'Corrente Máxima': '32A fixos',
      'Cabo Integrado': 'Cabo resistente de 5 metros de raio',
      'Conector': 'Tipo 2 automotivo universal',
      'Grau IP': 'IP54 (Proteção contra chuva leve e poeira moderada)'
    },
    variacoes: []
  },
  {
    id: 6,
    slug: 'smt-estacao-carregamento-220vac',
    nome: 'SMT – Estação de Carregamento 220VAC (Smart)',
    marcaId: 'ewolf',
    categoriaId: 'estacoes',
    potencia: '7,4 kW (Ajustável)',
    tensao: '220VAC Monofásico',
    aplicacao: 'Residencial Inteligente e Condomínios com Divisão',
    tipo: 'Wallbox Inteligente Wi-Fi',
    resumo: 'Controle total da sua recarga a partir do seu smartphone. Agende horários econômicos e integre com energia solar.',
    descricao: 'Desenvolvido para entusiastas de tecnologia e automação residencial. A série SMT (Smart) conta com aplicativos integrados dedicados via Wi-Fi e Bluetooth. Gerencie com precisão cirúrgica a potência da recarga, programe carregamentos inteligentes para aproveitar tarifas de energia fora do pico, e integre o consumo à geração distribuída de painéis fotovoltaicos.',
    diferenciais: [
      'Agendamento automático de recargas em horários de menor custo tarifário',
      'Conectividade sem fio Wi-Fi 2.4 GHz e Bluetooth de emparelhamento rápido',
      'Ajuste fino de amperagem (corrente regulável de 8A até 32A) via app',
      'Histórico de recarga detalhado em kWh e relatórios de consumo mensais'
    ],
    especificacoes: {
      'Potência': '7,4 kW ajustáveis por software',
      'Tensão': '220VAC Monofásico',
      'Rede Móvel/Sem Fio': 'Wi-Fi + Bluetooth + Suporte a OCPP 1.6J local',
      'Aplicativo': 'Disponível gratuitamente para iOS e Android',
      'Chassi Externo': 'Vidro temperado preto anti-riscos de alta resistência',
      'Grau de Proteção': 'IP65'
    },
    variacoes: []
  },
  {
    id: 7,
    slug: 'std-estacao-carregamento-380vac',
    nome: 'STD – Estação de Carregamento 380VAC',
    marcaId: 'ewolf',
    categoriaId: 'estacoes',
    potencia: '22 kW',
    tensao: '380VAC Trifásico',
    aplicacao: 'Condomínios, Hotéis e Comércios de Médio Porte',
    tipo: 'Wallbox Standard Trifásico',
    resumo: 'Carregamento trifásico sem rodeios técnicos. Alta potência AC de forma simplificada e muito resistente.',
    descricao: 'Ideal para condomínios residenciais que desejam disponibilizar pontos de carregamento na vaga rotativa, onde a simplicidade e a durabilidade mecânica são prioridades. Ele foi projetado para operar em ambientes semi-públicos ou compartilhados sem necessidade de senhas ou chaves complexas, com altíssima durabilidade técnica.',
    diferenciais: [
      'Construção robusta voltada a pátios comerciais e garagens prediais comuns',
      'Carregamento semirrápido potente de até 22 kW por hora de carga',
      'Não exige conexão com internet ou configurações de rede para operar',
      'Cabo ultra resistente preparado para intempéries constantes'
    ],
    especificacoes: {
      'Potência Máxima': '22 kW',
      'Alimentação Elétrica': '380VAC Trifásico (3 Fases + Neutro + Terra)',
      'Conector': 'Tipo 2 automotivo de 5 metros inclusos',
      'Grau IP': 'IP54 para garagens abertas com coberturas comuns',
      'Operação': 'Plug & Charge instantâneo'
    },
    variacoes: []
  },
  {
    id: 8,
    slug: 'carregador-portatil-220vac-tipo-2',
    nome: 'Carregador Portátil E-Wolf 220VAC Tipo 2',
    marcaId: 'ewolf',
    categoriaId: 'portateis',
    potencia: '3,5 kW a 7,4 kW (Regulável)',
    tensao: '220VAC Monofásico',
    aplicacao: 'Uso Móvel, Viagens e Emergências',
    tipo: 'Carregador Portátil (EVSE)',
    resumo: 'A paz de espírito que você leva no porta-malas. Carregue seu veículo em qualquer tomada comum ou industrial com controle térmico ativo.',
    descricao: 'Desenvolvido para motoristas que viajam com frequência ou necessitam de flexibilidade de carregamento. O Carregador Portátil E-Wolf se conecta a qualquer tomada comum (com adaptador apropriado) ou tomada industrial azul de 32A. A unidade de controle (EVSE) inteligente gerencia a corrente automaticamente e desliga o circuito em caso de sobreaquecimento ou instabilidades na tomada local.',
    diferenciais: [
      'Corrente de trabalho regulável para evitar quedas e sobrecargas no local',
      'Display digital LED multifunção integrado para monitoramento em tempo real',
      'Dispositivo interno contra sobreaquecimento nos contatos da tomada',
      'Estojo/Bolsa de nylon impermeável de transporte durável com zíper'
    ],
    especificacoes: {
      'Potência Máxima': 'Até 7,4 kW (Ajustável a níveis inferiores)',
      'Tensão': '220VAC Monofásico (110V suportado com potência proporcional)',
      'Corrente Regulável': 'Passos de 8A, 10A, 13A, 16A, 24A e 32A',
      'Conector Veicular': 'Tipo 2 com cabo flexível de 5 metros úteis',
      'Grau de Proteção': 'Gabinete IP66 (Resiste a chuvas fortes sob carga)',
      'Certificados': 'TUV, CE, RoHS'
    },
    variacoes: [
      {
        sku: 'CP-220-NBR',
        nome: 'Plug NBR 14136 (Tomada Comum)',
        adicionalDesc: 'Apresenta cabo com plug padrão nacional brasileiro de 3 pinos de 20A, limitando a recarga automática a 16A de corrente contínua para segurança térmica.'
      },
      {
        sku: 'CP-220-IND',
        nome: 'Plug Industrial CEE Azul (32A)',
        adicionalDesc: 'Equipado com plug industrial CEE de 3 pinos azuis 32A, permitindo a extração máxima de 32A de corrente contínua (7,4 kW) sem risco de derreter a fiação.'
      }
    ]
  },
  {
    id: 9,
    slug: 'pedestal-cobertura-policarbonato',
    nome: 'Pedestal VoltchZ com Cobertura em Policarbonato',
    marcaId: 'voltchz',
    categoriaId: 'suportes',
    potencia: 'N/A (Suporte Mecânico)',
    tensao: 'N/A',
    aplicacao: 'Estacionamentos Corporativos Externos e Garagens Descobertas',
    tipo: 'Totem de Solo com Cobertura',
    resumo: 'Totem de solo premium robusto em aço carbono com teto protetor translúcido contra raios UV para abrigar dois carregadores.',
    descricao: 'Desenvolvido pela divisão de engenharia civil e mecânica da VoltchZ Brasil, este pedestal de solo é a melhor resposta para a montagem de eletropostos descobertos. A estrutura de aço carbono reforçado é chumbada quimicamente no concreto, enquanto o teto de policarbonato alveolar filtra raios ultravioletas e resguarda o gabinete dos carregadores do sol escaldante e chuvas intensas.',
    diferenciais: [
      'Design em aço galvanizado ultra rígido com pintura epóxi fosca durável',
      'Cobertura translúcida em Policarbonato de 6mm com tratamento de filtro UV',
      'Possibilita instalar duas estações Wallbox costas-a-costas de forma otimizada',
      'Canaleta oculta interna para passagem segura e blindada dos cabos elétricos'
    ],
    especificacoes: {
      'Material Base': 'Aço Carbono SAE 1020 de alta espessura',
      'Tratamento Superfície': 'Galvanização anticorrosiva + Pintura Epóxi Texturizada a pó',
      'Teto Protetor': 'Policarbonato Alveolar Premium com travessas metálicas',
      'Altura Útil': '1650 mm',
      'Compatibilidade': 'Universal para carregadores E-Wolf, Intelbras, Incharge, etc.',
      'Fixação': 'Placa base de 300x300mm com 4 chumbadores quimicos/mecânicos'
    },
    variacoes: []
  },
  {
    id: 10,
    slug: 'suporte-solo-carregador-eletrico',
    nome: 'Suporte de Solo Slim VoltchZ',
    marcaId: 'voltchz',
    categoriaId: 'suportes',
    potencia: 'N/A (Suporte Mecânico)',
    tensao: 'N/A',
    aplicacao: 'Vagas de Garagens de Condomínio Descobertas ou Comerciais',
    tipo: 'Totem Metálico Slim',
    resumo: 'Totem vertical elegante e compacto de aço carbono, ideal para fixação estável de Wallbox em vagas rotativas e locais sem parede próxima.',
    descricao: 'Quando o espaço na parede é inexistente, o Suporte de Solo Slim da VoltchZ oferece a solução técnica definitiva. Com um visual minimalista e discreto que combina perfeitamente com projetos de arquitetura contemporânea, ele permite que a fiação suba pelo subsolo por dentro do próprio poste metálico, mantendo as vagas limpas, seguras e com visual limpo.',
    diferenciais: [
      'Visual moderno esguio que valoriza o condomínio e a vaga do usuário',
      'Passagem subterrânea interna para cabos de até 35 mm² de seção',
      'Fabricado com parede interna de aço reforçado que resiste a colisões leves',
      'Instalação rápida com parafusos parabolt inox inclusos no kit técnico'
    ],
    especificacoes: {
      'Material Principal': 'Chapa de Aço SAE 1020 soldada de alta integridade',
      'Pintura Protetora': 'Eletrostática a pó texturizada preta microtextura',
      'Altura': '1500 mm',
      'Área da Base': '200mm x 200mm',
      'Passagem de Cabos': 'Furação interna com anéis de borracha protetores',
      'Peso Líquido': '14,5 kg'
    },
    variacoes: []
  }
];

// --- ARTIGOS EDITORIAIS DO BLOG ---

export const ARTIGOS = [
  {
    id: 1,
    slug: 'lei-18403-carregadores-veiculos-eletricos-condominios',
    titulo: 'Lei nº 18.403: o que muda na instalação de carregadores de veículos elétricos em condomínios',
    categoria: 'Legislação',
    resumo: 'Entenda os impactos legais, direitos dos proprietários e as exigências técnicas impostas pela nova lei paulista para a infraestrutura de recarga em garagens prediais.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '15 Abr, 2026',
    tempoLeitura: '7 min',
    imagem: generateTechnicalSVG('estacoes', 'Lei nº 18.403', 'Legislação'),
    conteudo: [
      { type: 'heading', text: 'O Marco Legal dos Condomínios e a Mobilidade Elétrica' },
      { type: 'paragraph', text: 'A recente promulgação da Lei Estadual nº 18.403 no estado de São Paulo trouxe regras muito claras e segurança jurídica para um debate que antes causava grandes desavenças em assembleias de condomínio: a instalação de infraestrutura para carregadores de veículos elétricos em garagens compartilhadas e privativas.' },
      { type: 'paragraph', text: 'Antes da lei, muitos síndicos e comissões de moradores barravam as instalações alegando riscos de incêndio, sobrecarga de transformadores ou falta de acordo na divisão de despesas. Agora, a legislação estipula direitos claros, mas também impõe pesadas exigências técnicas de responsabilidade civil e de engenharia que precisam ser rigorosamente atendidas.' },
      { type: 'heading', text: 'Principais Mudanças e Direitos Assegurados pela Lei' },
      { type: 'paragraph', text: 'O ponto de partida mais importante da Lei nº 18.403 é que o proprietário de vaga privativa demarcada em garagem coletiva tem o direito legítimo de instalar um carregador individual de veículo elétrico. O condomínio não pode proibir a instalação de forma arbitrária, desde que o condômino arque com todos os custos do ramal individual e atenda aos requisitos técnicos exigidos pelo síndico.' },
      { type: 'list', items: [
        'Direito de instalação individual em vagas privativas autônomas ou vinculadas.',
        'Proibição de barramento injustificado por parte da administração do condomínio.',
        'Obrigatoriedade de medição individualizada da energia gasta pelo carregador.',
        'Necessidade de apresentação prévia de projeto técnico assinado por engenheiro habilitado.'
      ] },
      { type: 'blockquote', text: 'A segurança da infraestrutura do condomínio é prioritária. O direito à instalação existe, mas está condicionado à comprovação física de viabilidade técnica através de uma Anotação de Responsabilidade Técnica (ART).', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Exigências Técnicas Obrigatórias e o Papel do Estudo de Viabilidade' },
      { type: 'paragraph', text: 'Para exercer o direito de instalação, o morador ou a empresa contratada deve fornecer à administração do condomínio um dossiê técnico detalhado. Esse documento deve conter um Estudo de Viabilidade Elétrica completo, comprovando que o ramal individual não causará um desequilíbrio de fases e que o transformador geral suportará a nova demanda.' },
      { type: 'paragraph', text: 'Na VoltchZ Brasil, realizamos este estudo in loco utilizando analisadores de curva de carga certificados pelo ICC (Intel Competence Center). Mapeamos a real capacidade do condomínio e fornecemos a documentação exata de engenharia com a respectiva ART, blindando legalmente o síndico e o morador contra quaisquer questionamentos jurídicos ou riscos operacionais.' }
    ]
  },
  {
    id: 2,
    slug: 'a-escolha-certa-carregador-tipo-a-ac-ou-b-para-carros-eletricos',
    titulo: 'A Escolha Certa: Dispositivo DR Tipo A, AC ou B para Carros Elétricos?',
    categoria: 'Segurança',
    resumo: 'Você sabe por que o disjuntor diferencial residual (DR) comum de tomada não serve para recarga de carros elétricos? Conheça as diferenças técnicas vitais.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '08 Mar, 2026',
    tempoLeitura: '8 min',
    imagem: generateTechnicalSVG('protecao', 'DR Tipo A vs B', 'Segurança'),
    conteudo: [
      { type: 'heading', text: 'O que é um Dispositivo DR e por que ele é crucial?' },
      { type: 'paragraph', text: 'O Dispositivo Diferencial Residual (DR) é um item de segurança obrigatório em qualquer instalação elétrica de baixa tensão pela NBR 5410. Sua função primordial é monitorar a corrente que entra e sai de um circuito. Se houver qualquer fuga de corrente (como uma pessoa encostando em um fio desencapado ou uma falha de isolação no carregador), o DR detecta a anomalia em milissegundos e desarma o circuito instantaneamente, salvando vidas.' },
      { type: 'paragraph', text: 'No entanto, a recarga de veículos elétricos introduz desafios muito específicos que a maioria dos eletricistas tradicionais ignora, gerando instalações clandestinas e de alto risco utilizando dispositivos DR inadequados.' },
      { type: 'heading', text: 'Classificações dos Dispositivos DR: AC, A e B' },
      { type: 'paragraph', text: 'Existem diferentes classes de DR, categorizados conforme o comportamento de onda de fuga que são capazes de identificar e interromper:' },
      { type: 'list', items: [
        'DR Classe AC: O mais comum do mercado nacional. Detecta apenas correntes de fuga alternadas puras (senoidais). É absolutamente ineficaz para o carregamento de carros elétricos, pois o carregador do carro converte energia AC em DC e gera ruídos e fugas em corrente contínua pulsante que "cegam" o DR Classe AC, impedindo-o de desarmar em caso de acidente.',
        'DR Classe A: Detecta correntes de fuga senoidais alternadas e também correntes de fuga contínuas pulsantes (comuns em inversores de frequência e fontes de veículos elétricos). É a classe recomendada e obrigatória de entrada para proteção de Wallboxes residenciais.',
        'DR Classe B: O mais completo e caro do mercado. Detecta todos os tipos de fugas (alternadas senoidais, contínuas pulsantes e contínuas lisas puras em DC). É mandatório em redes trifásicas industriais de alta potência, carregadores comerciais OCPP rápidos e hubs públicos.'
      ] },
      { type: 'blockquote', text: 'Utilizar um DR Classe AC em um carregador de veículo elétrico é o equivalente a não possuir nenhuma proteção. O DR sofrerá saturação magnética e não funcionará quando houver um choque.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Qual escolher para o seu projeto?' },
      { type: 'paragraph', text: 'Para instalações residenciais monofásicas de até 7,4 kW, os quadros de proteção da linha E-Wolf da VoltchZ saem de fábrica obrigatoriamente com DR Bipolar de Classe A (30mA). Para estações de 22 kW trifásicas ou pátios de recarga corporativos rápidos, integramos DR Classe A de alta sensibilidade ou DR Classe B, cumprindo à risca as rígidas normas internacionais IEC 61851-1 e IEC 62955.' }
    ]
  },
  {
    id: 3,
    slug: 'a-importancia-do-disjuntor-certo-na-protecao-de-instalacoes-eletricas',
    titulo: 'A Importância do Disjuntor Certo na Proteção de Instalações Elétricas',
    categoria: 'Infraestrutura',
    resumo: 'Disjuntores não são todos iguais. Conheça as curvas de disparo B, C e D e descubra qual modelo deve resguardar a fiação em recargas prolongadas sob potência máxima.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '22 Fev, 2026',
    tempoLeitura: '5 min',
    imagem: generateTechnicalSVG('protecao', 'Disjuntor Curvas C', 'Disjuntores'),
    conteudo: [
      { type: 'heading', text: 'Dimensionamento para Cargas Contínuas' },
      { type: 'paragraph', text: 'Diferente de um chuveiro elétrico ou de um forno de micro-ondas, que funcionam por poucos minutos de cada vez, o carregador de um carro elétrico é considerado uma carga contínua prolongada de altíssima exigência. Ele drenará a corrente nominal máxima (por exemplo, 32A de forma constante) por 4, 6 ou até 10 horas seguidas durante a madrugada.' },
      { type: 'paragraph', text: 'Sob esse regime térmico e magnético rigoroso, qualquer erro de especificação no disjuntor de proteção geral gerará disparos térmicos indesejados devido ao calor acumulado nos bornes, além de risco crítico de derretimento do próprio painel.' },
      { type: 'heading', text: 'Entendendo as Curvas de Disparo: B e C' },
      { type: 'paragraph', text: 'Os disjuntores termomagnéticos residenciais se dividem fundamentalmente por curvas de atuação, que delimitam o tempo de atuação térmica (sobrecarga lenta) e magnética (curto-circuito instantâneo):' },
      { type: 'list', items: [
        'Curva B: Indicado para circuitos puramente resistivos (aquecedores, lâmpadas comuns, chuveiros). Dispara de 3 a 5 vezes a corrente nominal em curto-circuito.',
        'Curva C: Indicado para cargas com motores indutivos e fontes chaveadas com pico de partida médio (ar-condicionado, bombas, carregadores elétricos potentes). Dispara entre 5 e 10 vezes a corrente nominal.',
        'Curva D: Indicado para motores de pátios industriais pesados e transformadores de grande porte com altos picos de partida instantâneos.'
      ] },
      { type: 'paragraph', text: 'Para a proteção de Wallboxes, o disjuntor adequado é o de Curva C. No entanto, o detalhe mais importante não é apenas a curva, mas a capacidade de ruptura em curto-circuito (medida em kA) e o fator de correção de agrupamento.' },
      { type: 'blockquote', text: 'Ao projetar o painel E-Wolf, aplicamos um fator de sobredimensionamento térmico de 25% na carcaça e fixação dos disjuntores gerais de Curva C de alta capacidade de ruptura (6kA/10kA), prevenindo disparos falsos causados por calor e protegendo a fiação interna contra envelhecimento precoce.', author: 'Bruno Riêra' }
    ]
  },
  {
    id: 4,
    slug: 'a-escolha-do-cabo-certo-na-instalacao-de-carregadores-para-veiculos-eletricos',
    titulo: 'A Escolha do Cabo Certo na Instalação de Carregadores para Veículos Elétricos',
    categoria: 'Infraestrutura',
    resumo: 'Calculando a queda de tensão e a seção nominal ideal dos fios condutores para distâncias longas em pátios de estacionamento descobertos.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '10 Fev, 2026',
    tempoLeitura: '6 min',
    imagem: generateTechnicalSVG('suportes', 'Seção de Cabos', 'Cabo Elétrico'),
    conteudo: [
      { type: 'heading', text: 'Por que o cálculo padrão do eletricista pode queimar seu carro?' },
      { type: 'paragraph', text: 'Um dos erros mais graves que encontramos em pátios de condomínio e garagens privativas é o subdimensionamento da fiação de cobre alimentadora do carregador. Muitos instaladores amadores utilizam cabos de 4 mm² ou 6 mm² para distâncias de 30 ou 40 metros sob corrente constante de 32A, baseando-se apenas em tabelas genéricas de condução de corrente de curta duração.' },
      { type: 'paragraph', text: 'Em circuitos longos operando como cargas contínuas prolongadas, um fator crítico entra em cena: a queda de tensão. A resistência do cobre gera perdas na forma de calor, reduzindo a tensão que chega ao carregador de 220V para 195V ou menos. Isso gera perda de eficiência de recarga, aquecimento extremo do eletroduto e falhas frequentes de comunicação interna do carro.' },
      { type: 'heading', text: 'Calculando a seção nominal correta dos condutores' },
      { type: 'paragraph', text: 'Conforme preceitos da engenharia elétrica e a norma NBR 5410, a queda de tensão máxima admissível em ramais de força é de 4%. Para um carregador de 32A operando a mais de 25 metros do quadro geral, a seção nominal mínima do cabo deve ser recalculada de 6 mm² para 10 mm² ou 16 mm², dependendo estritamente do trajeto e método de instalação.' },
      { type: 'list', items: [
        'Abaixo de 15 metros: Cabo de cobre de 6 mm² (regime de 32A em eletroduto exclusivo).',
        'De 15 a 35 metros: Cabo de cobre de 10 mm² (fator de segurança contra perdas magnéticas).',
        'Acima de 35 metros: Cabo de cobre de 16 mm² ou superior (reduz perdas e previne quedas de tensão).'
      ] },
      { type: 'blockquote', text: 'Bitola de cabo não se escolhe por palpite; calcula-se combinando limite de corrente, temperatura do ambiente e queda de tensão percentual ao longo da linha.', author: 'Bruno Riêra' },
      { type: 'paragraph', text: 'Na VoltchZ Brasil, todo projeto técnico passa por uma simulação de engenharia no computador para prever exatamente as perdas térmicas e dimensionar com precisão cirúrgica a seção de cabos apropriada. Isso garante uma operação silenciosa, segura e sem dissipação de calor inútil em sua conta de luz.' }
    ]
  },
  {
    id: 5,
    slug: 'seguranca-e-controle-gestao-de-frotas-comerciais',
    titulo: 'Segurança e Controle: Gestão Eficiente de Frotas Comerciais de EVs',
    categoria: 'Tecnologia',
    resumo: 'Como gerenciar e balancear a carga de carregamento de múltiplos veículos elétricos simultâneos de forma inteligente e integrada via OCPP 1.6J.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '28 Jan, 2026',
    tempoLeitura: '6 min',
    imagem: generateTechnicalSVG('estacoes', 'Gestão de Frotas', 'OCPP Cloud'),
    conteudo: [
      { type: 'heading', text: 'O Desafio da Recarga de Frotas Simultânea' },
      { type: 'paragraph', text: 'Quando uma empresa resolve substituir 10 ou 15 veículos de combustão por modelos elétricos de entrega ou transporte corporativo, a primeira pergunta que surge é: como carregar todos esses carros juntos ao final do expediente sem derrubar a energia da sede corporativa e sem pagar multas astronômicas de pico de demanda para a concessionária?' },
      { type: 'paragraph', text: 'Instalar simplesmente 15 carregadores independentes de 22 kW pode resultar em uma demanda instantânea teórica de 330 kW — o suficiente para exigir a contratação de uma nova cabine primária e altos investimentos em transformadores dedicados. A solução inteligente passa por segurança e controle via software.' },
      { type: 'heading', text: 'Equilíbrio Dinâmico de Carga (Smart Charging) e OCPP' },
      { type: 'paragraph', text: 'Através do protocolo de comunicação universal OCPP 1.6J, as estações E-Wolf da VoltchZ se comunicam com plataformas na nuvem, permitindo que a empresa controle em tempo real as recargas de forma centralizada:' },
      { type: 'list', items: [
        'Balanceamento Dinâmico de Carga: Distribui a potência disponível na fábrica entre os carros conectados de forma equitativa. Se há apenas 1 carro, ele consome a potência máxima (22 kW). Se conectam 10 carros, o sistema divide a potência de acordo com o limite de demanda seguro pré-configurado.',
        'Priorização por Rota: O administrador da frota pode selecionar no painel quais carros precisam sair mais cedo no dia seguinte, direcionando maior potência de carga prioritária para as baterias desses veículos.',
        'Redução do Custo Operacional: Permite programar recargas nas janelas de menor tarifa de energia da indústria.'
      ] },
      { type: 'blockquote', text: 'A chave para eletrificar frotas eficientemente não é contratar mais energia com a concessionária; é gerenciar a energia disponível com inteligência e controle ativo.', author: 'Bruno Riêra' }
    ]
  },
  {
    id: 6,
    slug: 'segundo-a-abve-numeros-indicam-transformacao-mercado-veiculos-eletrificados',
    titulo: 'Segundo a ABVE, o mercado de veículos eletrificados vive uma transformação no Brasil',
    categoria: 'Mercado',
    resumo: 'Análise detalhada do crescimento exponencial das vendas de EVs no mercado nacional e a demanda urgente por engenharia de infraestrutura elétrica.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '15 Jan, 2026',
    tempoLeitura: '5 min',
    imagem: generateTechnicalSVG('estacoes', 'Estatísticas ABVE', 'Dados Mercado'),
    conteudo: [
      { type: 'heading', text: 'Crescimento Histórico e o Boom dos Veículos Híbridos e Elétricos' },
      { type: 'paragraph', text: 'Os relatórios de dados divulgados pela Associação Brasileira do Veículo Elétrico (ABVE) confirmam o que já se nota visivelmente nas ruas das principais capitais e cidades do país: o mercado brasileiro está atravessando uma transição energética acelerada e sem volta para a mobilidade sustentável.' },
      { type: 'paragraph', text: 'O crescimento das vendas de carros elétricos (BEV) e híbridos plug-in (PHEV) rompeu todas as previsões conservadoras anteriores. Essa nova realidade mercadológica traz à tona um funil técnico dramático: a velocidade de aquisição de veículos pelos motoristas é muito superior à velocidade de instalação de carregadores confiáveis nas garagens de condomínio e rodovias nacionais.' },
      { type: 'heading', text: 'O Gargalo da Infraestrutura: De Onde Virá a Energia?' },
      { type: 'paragraph', text: 'Para cada 10 carros elétricos novos que entram em circulação no mercado, é necessário ao menos 1 ponto de carregamento rápido público e cerca de 9 carregadores residenciais fixos instalados nas vagas de garagens de residências e condomínios.' },
      { type: 'paragraph', text: 'Se as redes elétricas prediais existentes não forem adequadas profissionalmente com sistemas modernos de segurança ativa e estudos de viabilidade criteriosos, o país poderá vivenciar apagões pontuais de pátios e queima de transformadores comuns.' },
      { type: 'blockquote', text: 'A mobilidade elétrica no Brasil já é realidade comercial consagrada. Agora, o grande desafio nacional migrou do pátio das concessionárias de veículos para a engenharia civil e elétrica de infraestrutura predial de recarga.', author: 'Bruno Riêra' }
    ]
  },
  {
    id: 7,
    slug: 'conveniencia-carregamento-residencial-comercial',
    titulo: 'Conveniência: O Impacto Positivo dos Carregadores na Atração de Clientes',
    categoria: 'Mercado',
    resumo: 'Entenda como hotéis, shoppings e comércios estão fidelizando clientes de alto poder aquisitivo simplesmente disponibilizando pontos de recarga em suas vagas.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '03 Jan, 2026',
    tempoLeitura: '4 min',
    imagem: generateTechnicalSVG('suportes', 'Eletropostos Comerciais', 'Fidelização'),
    conteudo: [
      { type: 'heading', text: 'O Novo Critério de Decisão do Consumidor' },
      { type: 'paragraph', text: 'Imagine que o proprietário de um veículo elétrico premium está planejando uma viagem de final de semana com a família. Ao pesquisar pousadas ou hotéis no local de destino, qual será o seu primeiro critério excludente de escolha?' },
      { type: 'paragraph', text: 'Se o estabelecimento de hospedagem não dispõe de carregador para veículos elétricos em sua garagem privativa, o cliente simplesmente excluirá o hotel da lista de opções, optando pelo concorrente direto que oferece essa comodidade. Este é o poder do carregamento como conveniência ativa.' },
      { type: 'heading', text: 'Carregamento como serviço de valor agregado' },
      { type: 'paragraph', text: 'Oferecer recargas rápidas e seguras no estacionamento atrai clientes altamente qualificados e prolonga o tempo de permanência de consumo em lojas, restaurantes e academias de ginástica.' },
      { type: 'list', items: [
        'Atração e fidelização de um nicho demográfico de alto poder aquisitivo.',
        'Mapeamento do estabelecimento no mapa dos principais aplicativos de rotas de EVs.',
        'Possibilidade de monetizar a recarga, criando uma nova linha de faturamento líquido.',
        'Geração de marketing positivo associado a ESG e sustentabilidade corporativa real.'
      ] },
      { type: 'blockquote', text: 'A recarga de carros elétricos em comércios deixou de ser um diferencial inovador para se consolidar como infraestrutura básica obrigatória de atração.', author: 'Bruno Riêra' }
    ]
  },
  {
    id: 8,
    slug: 'economia-de-tempo-e-dinheiro-tco-dos-veiculos-eletricos',
    titulo: 'Economia de Tempo e Dinheiro: O TCO Real dos Veículos Elétricos',
    categoria: 'Mercado',
    resumo: 'Calculando a viabilidade financeira e o custo por quilômetro rodado de carros elétricos versus modelos a gasolina nas principais cidades brasileiras.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '18 Dez, 2025',
    tempoLeitura: '6 min',
    imagem: generateTechnicalSVG('estacoes', 'TCO e Economia', 'Finanças EV'),
    conteudo: [
      { type: 'heading', text: 'Custo por quilômetro rodado: Carro elétrico vs Gasolina' },
      { type: 'paragraph', text: 'Apesar de apresentarem um valor de compra inicial mais alto nas lojas, os carros elétricos trazem benefícios financeiros absurdos na planilha de custos operacionais do usuário ou frotista comercial. O principal pilar de economia é o custo do quilômetro rodado (combustível contra energia).' },
      { type: 'paragraph', text: 'Enquanto rodar 100 km com um veículo popular a combustão rodando a gasolina consome cerca de R$ 55,00 a R$ 65,00 em média de combustível nas capitais brasileiras, rodar a mesma distância com um veículo elétrico de bateria equivalente custa cerca de R$ 12,00 a R$ 15,00 na tarifa residencial de energia elétrica, proporcionando redução imediata de gastos.' },
      { type: 'heading', text: 'Total Cost of Ownership (TCO) e Custos de Manutenção Extintos' },
      { type: 'paragraph', text: 'Outro fator essencial a favor do carro elétrico é a economia de tempo e dinheiro com manutenção periódica preventiva. Em um motor a combustão, existem milhares de partes móveis críticas sob altíssima pressão e temperatura. No motor elétrico de bateria, a complexidade mecânica é ínfima:' },
      { type: 'list', items: [
        'Sem filtros de óleo, óleos lubrificantes, velas, correia dentada, bicos injetores e juntas.',
        'Extinção do sistema de escape e catalisadores complexos.',
        'Altíssima durabilidade técnica do sistema de freios devido ao sistema de frenagem regenerativa.',
        'Isenção ou descontos significativos de IPVA em diversos estados da federação brasileira.'
      ] },
      { type: 'blockquote', text: 'A transição para a mobilidade elétrica faz sentido técnico absoluto e, sobretudo, sentido econômico e de fluxo de caixa para empresas frotistas.', author: 'Bruno Riêra' }
    ]
  },
  {
    id: 9,
    slug: 'independencia-energetica-energia-solar-e-carregadores-evs',
    titulo: 'Independência Energética: O Casamento Perfeito da Energia Solar com o EV',
    categoria: 'Tecnologia',
    resumo: 'Como gerar seu próprio combustível solar em casa de forma totalmente autônoma, sustentável e livre das oscilações da conta de energia.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '02 Dez, 2025',
    tempoLeitura: '7 min',
    imagem: generateTechnicalSVG('protecao', 'Solar + EV', 'Sustentabilidade'),
    conteudo: [
      { type: 'heading', text: 'Gerando Combustível Gratuito no Telhado de Casa' },
      { type: 'paragraph', text: 'A maior promessa de liberdade do veículo elétrico reside na possibilidade de não depender de nenhum tipo de postos de combustível físico ou cartéis comerciais. Ao integrar uma planta de microgeração fotovoltaica no telhado de sua residência ou empresa, o usuário passa a produzir eletricidade limpa a custo marginal zero a partir da radiação solar.' },
      { type: 'paragraph', text: 'Essa energia solar produzida durante o dia é injetada na rede da concessionária e retorna em créditos de energia que abastecem o carregador à noite, anulando por completo o impacto da mobilidade nas finanças familiares.' },
      { type: 'heading', text: 'O Futuro V2G (Vehicle-to-Grid) e Carregamento Inteligente' },
      { type: 'paragraph', text: 'O próximo passo lógico da tecnologia de recarga integrada é o ecossistema inteligente bidirecional, no qual o carro não apenas consome a energia do telhado solar, mas atua como uma grande bateria estacionária móvel de reserva para a residência em caso de blecautes gerais da concessionária local:' },
      { type: 'list', items: [
        'V2H (Vehicle-to-Home): Fornecimento da energia da bateria do carro para ligar a residência no pico de tarifas da rede comercial.',
        'V2G (Vehicle-to-Grid): Venda da energia excedente acumulada na bateria do veículo de volta para a rede pública nos horários de picos do sistema de distribuição.'
      ] },
      { type: 'blockquote', text: 'A união de geração fotovoltaica com veículos elétricos transforma o consumidor de um simples usuário de carros em um produtor e gestor inteligente de sua própria energia.', author: 'Bruno Riêra' }
    ]
  }
];

// --- HELDERS E UTILS ---

/**
 * Retorna o objeto de marca correspondente ao ID
 */
export const getMarcaById = (marcaId) => {
  return MARCAS.find(m => m.id === marcaId) || { nome: 'Institucional', descricao: 'VoltchZ Brasil' };
};

/**
 * Retorna o objeto de categoria correspondente ao ID
 */
export const getCategoriaById = (categoriaId) => {
  return CATEGORIAS.find(c => c.id === categoriaId) || { nome: 'Geral', descricao: '' };
};

/**
 * Retorna a URL WhatsApp de orçamento dinâmico
 */
export const getBudgetUrl = (produto, variacao = null) => {
  const number = CONFIG.CONTACT.WHATSAPP;
  const brand = getMarcaById(produto.marcaId).nome;
  
  let msg = `Olá! Gostaria de falar com a equipe técnica da VoltchZ Brasil.\n\n`;
  msg += `Tenho interesse no produto: *${produto.nome}*\n`;
  msg += `Marca: *${brand}*\n`;
  
  if (variacao) {
    msg += `Variação Selecionada: *${variacao.nome}*\n`;
    if (variacao.sku) {
      msg += `Código SKU: *${variacao.sku}*\n`;
    }
  }
  
  msg += `\nGostaria de solicitar um orçamento formal e tirar algumas dúvidas técnicas sobre o dimensionamento do meu projeto.`;
  
  return `https://wa.me/${number}?text=${encodeURIComponent(msg)}`;
};

/**
 * Filtra produtos com base em múltiplos critérios
 */
export const filterProducts = (filters = {}) => {
  const { marca, categoria, potencia, busca } = filters;
  
  return PRODUTOS.filter(p => {
    // Busca textual inteligente (nome, resumo, descrição, especificação, SKU)
    if (busca) {
      const q = busca.toLowerCase();
      const matchText = p.nome.toLowerCase().includes(q) || 
                        p.resumo.toLowerCase().includes(q) || 
                        p.descricao.toLowerCase().includes(q) ||
                        (p.potencia && p.potencia.toLowerCase().includes(q)) ||
                        (p.variacoes && p.variacoes.some(v => v.nome.toLowerCase().includes(q) || (v.sku && v.sku.toLowerCase().includes(q))));
      if (!matchText) return false;
    }
    
    // Filtro de Marca
    if (marca && marca !== 'todos' && p.marcaId !== marca) {
      return false;
    }
    
    // Filtro de Categoria
    if (categoria && categoria !== 'todos' && p.categoriaId !== categoria) {
      return false;
    }
    
    // Filtro de Potência (opcional, extrai valores como '7.2', '22', '40')
    if (potencia && potencia !== 'todos') {
      const matchPot = p.potencia && p.potencia.toLowerCase().includes(potencia.toLowerCase());
      if (!matchPot) return false;
    }
    
    return true;
  });
};
