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

/**
 * Calcula tempo de leitura com base na contagem real de palavras do conteúdo.
 * Média editorial: ~200 palavras por minuto.
 */
export const calcTempoLeitura = (conteudo) => {
  const words = conteudo.reduce((total, block) => {
    if (block.text) {
      return total + block.text.trim().split(/\s+/).filter(Boolean).length;
    }
    if (block.items) {
      return total + block.items.join(' ').trim().split(/\s+/).filter(Boolean).length;
    }
    return total;
  }, 0);
  const mins = Math.max(1, Math.ceil(words / 200));
  return `${mins} min`;
};

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
    tempoLeitura: '9 min',
    imagem: generateTechnicalSVG('estacoes', 'Lei nº 18.403', 'Legislação'),
    conteudo: [
      { type: 'heading', text: 'O Marco Legal dos Condomínios e a Mobilidade Elétrica' },
      { type: 'paragraph', text: 'A recente promulgação da Lei Estadual nº 18.403 no estado de São Paulo trouxe regras muito claras e segurança jurídica para um debate que antes causava grandes desavenças em assembleias de condomínio: a instalação de infraestrutura para carregadores de veículos elétricos em garagens compartilhadas e privativas.' },
      { type: 'paragraph', text: 'Antes da lei, muitos síndicos e comissões de moradores barravam as instalações alegando riscos de incêndio, sobrecarga de transformadores ou falta de acordo na divisão de despesas. Agora, a legislação estipula direitos claros, mas também impõe pesadas exigências técnicas de responsabilidade civil e de engenharia que precisam ser rigorosamente atendidas.' },
      { type: 'heading', text: 'Principais Mudanças e Direitos Assegurados pela Lei' },
      { type: 'paragraph', text: 'O ponto de partida mais importante da Lei nº 18.403 é que o proprietário de vaga privativa demarcada em garagem coletiva tem o direito legítimo de instalar um carregador individual de veículo elétrico. O condomínio não pode proibir a instalação de forma arbitrária, desde que o condômino arque com todos os custos do ramal individual e atenda aos requisitos técnicos exigidos pelo síndico.' },
      { type: 'list', items: [
        'Direito de instalação individual em vagas privativas autônomas ou vinculadas ao apartamento.',
        'Proibição de barramento injustificado por parte da administração do condomínio sem embasamento técnico.',
        'Obrigatoriedade de medição individualizada da energia gasta pelo carregador via medidor próprio.',
        'Necessidade de apresentação prévia de projeto técnico assinado por engenheiro habilitado com ART registrada.',
        'O custeio da obra de infraestrutura é integralmente de responsabilidade do condômino solicitante.',
        'A administração tem até 60 dias para analisar e responder formalmente ao pedido de instalação.'
      ] },
      { type: 'blockquote', text: 'A segurança da infraestrutura do condomínio é prioritária. O direito à instalação existe, mas está condicionado à comprovação física de viabilidade técnica através de uma Anotação de Responsabilidade Técnica (ART).', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Exigências Técnicas Obrigatórias e o Papel do Estudo de Viabilidade' },
      { type: 'paragraph', text: 'Para exercer o direito de instalação, o morador ou a empresa contratada deve fornecer à administração do condomínio um dossiê técnico detalhado. Esse documento deve conter um Estudo de Viabilidade Elétrica completo, comprovando que o ramal individual não causará um desequilíbrio de fases e que o transformador geral suportará a nova demanda permanente.' },
      { type: 'paragraph', text: 'Na VoltchZ Brasil, realizamos este estudo in loco utilizando analisadores de curva de carga certificados. Mapeamos a real capacidade do condomínio, analisamos o histórico de consumo de no mínimo 12 meses e fornecemos a documentação exata de engenharia com a respectiva ART, blindando legalmente o síndico e o morador contra quaisquer questionamentos jurídicos ou riscos operacionais.' },
      { type: 'heading', text: 'Responsabilidade do Síndico e Penalidades pelo Descumprimento' },
      { type: 'paragraph', text: 'A lei também é clara quanto às obrigações dos síndicos. Negar arbitrariamente, sem embasamento técnico devidamente documentado, o pedido de instalação de carregador por parte de condômino proprietário de vaga demarcada pode configurar abuso de poder administrativo e sujeitar o condomínio a responder judicialmente por danos materiais e morais ao morador.' },
      { type: 'paragraph', text: 'Por outro lado, autorizar a instalação sem exigir a documentação técnica obrigatória — especialmente o projeto elétrico assinado e a ART — pode responsabilizar diretamente o síndico em caso de acidentes ou danos à infraestrutura predial comum. O equilíbrio está na conformidade técnica rigorosa, que protege todas as partes envolvidas.' },
      { type: 'heading', text: 'Como a VoltchZ Atua no Processo de Conformidade Legal' },
      { type: 'paragraph', text: 'Nossa equipe de engenharia atua em todas as etapas do processo de conformidade com a Lei nº 18.403: desde o levantamento técnico inicial da rede elétrica do condomínio, passando pelo dimensionamento do ramal dedicado e seleção dos dispositivos de proteção obrigatórios (DR Classe A ou B, DPS, disjuntor de Curva C), até a emissão da ART e entrega do relatório final para arquivo junto à administração condominial.' }
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
    tempoLeitura: '10 min',
    imagem: generateTechnicalSVG('protecao', 'DR Tipo A vs B', 'Segurança'),
    conteudo: [
      { type: 'heading', text: 'O que é um Dispositivo DR e por que ele é crucial?' },
      { type: 'paragraph', text: 'O Dispositivo Diferencial Residual (DR) é um item de segurança obrigatório em qualquer instalação elétrica de baixa tensão pela NBR 5410. Sua função primordial é monitorar, em tempo real e de forma contínua, a corrente que entra e a que retorna de um circuito. Toda corrente que entra deve sair pelo mesmo caminho — se isso não acontecer, significa que houve fuga para terra, possivelmente passando pelo corpo de uma pessoa ou causando risco de incêndio.' },
      { type: 'paragraph', text: 'Se houver qualquer fuga de corrente, o DR detecta a anomalia em milissegundos e desarma o circuito instantaneamente, salvando vidas. No entanto, a recarga de veículos elétricos introduz desafios muito específicos que a maioria dos eletricistas tradicionais simplesmente ignora, gerando instalações clandestinas e de altíssimo risco com dispositivos DR completamente inadequados para esta aplicação.' },
      { type: 'heading', text: 'Classificações dos Dispositivos DR: AC, A e B' },
      { type: 'paragraph', text: 'Existem diferentes classes de DR, categorizados conforme o tipo de onda de corrente de fuga que são capazes de identificar e interromper com segurança:' },
      { type: 'list', items: [
        'DR Classe AC: O mais comum e barato do mercado nacional. Detecta apenas correntes de fuga alternadas puras (senoidais). É absolutamente ineficaz para o carregamento de carros elétricos, pois o carregador do veículo converte a energia AC da tomada em DC para a bateria e gera fugas em corrente contínua pulsante que "cegam" completamente o DR Classe AC, impedindo-o de desarmar mesmo diante de um acidente grave.',
        'DR Classe A: Detecta correntes de fuga senoidais alternadas e também correntes de fuga contínuas pulsantes (padrão em inversores e fontes chaveadas de veículos elétricos). É a classe recomendada e tecnicamente obrigatória como ponto de entrada mínimo para proteção de Wallboxes residenciais e comerciais monofásicos de até 7,4 kW.',
        'DR Classe B: O mais completo e preciso do mercado. Detecta todos os tipos de fuga — alternadas senoidais, contínuas pulsantes e contínuas lisas puras (corrente DC limpa). É mandatório em redes trifásicas industriais de alta potência, carregadores comerciais OCPP rápidos (22 kW a 150 kW), hubs públicos e frota corporativa.'
      ] },
      { type: 'blockquote', text: 'Utilizar um DR Classe AC em um carregador de veículo elétrico é o equivalente a não possuir nenhuma proteção. O DR sofrerá saturação magnética e simplesmente não funcionará no momento mais crítico — quando houver um choque elétrico real.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'O Risco Real da Saturação DC no DR Tipo AC' },
      { type: 'paragraph', text: 'O fenômeno técnico que explica a falha do DR Classe AC em instalações de EV se chama saturação magnética por componente DC. Qualquer corrente contínua mínima, mesmo que inferior a 6mA, que flua pelo núcleo toroidal do DR Classe AC satura permanentemente o núcleo magnético do dispositivo. Uma vez saturado, o transformador diferencial interno deixa de detectar qualquer variação de corrente — inclusive o choque elétrico fatal de uma pessoa.' },
      { type: 'paragraph', text: 'Esse risco é real, documentado por laboratórios de certificação europeus como o PTB alemão e o KEMA holandês, e é exatamente por isso que a norma IEC 62955 (adotada internacionalmente para proteção de EVSEs) tornou obrigatório o DR Classe A como mínimo absoluto em qualquer ponto de recarga de veículo elétrico.' },
      { type: 'heading', text: 'Como a VoltchZ Seleciona e Certifica os DRs dos seus Projetos' },
      { type: 'paragraph', text: 'Para instalações residenciais monofásicas de até 7,4 kW, os quadros de proteção da linha E-Wolf da VoltchZ saem de fábrica obrigatoriamente equipados com DR Bipolar de Classe A com sensibilidade de 30mA, fabricados pela Schneider Electric ou ABB, marcas homologadas pelo INMETRO.' },
      { type: 'paragraph', text: 'Para estações de 22 kW trifásicas em condomínios e pátios comerciais, integramos DR Tetrapolar Classe A de alta sensibilidade (10mA ou 30mA). Para pátios de recarga corporativos rápidos acima de 40 kW ou com múltiplos carregadores em paralelo, o projeto pode exigir DR Classe B para garantia total de proteção contra qualquer tipo de fuga — cumprindo integralmente as rigorosas normas IEC 61851-1 e IEC 62955.' }
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
    tempoLeitura: '8 min',
    imagem: generateTechnicalSVG('protecao', 'Disjuntor Curvas C', 'Disjuntores'),
    conteudo: [
      { type: 'heading', text: 'Por que a Recarga de EV Exige um Disjuntor Especial?' },
      { type: 'paragraph', text: 'Diferente de um chuveiro elétrico ou de um forno de micro-ondas, que funcionam por poucos minutos de cada vez, o carregador de um carro elétrico é uma carga contínua prolongada de altíssima exigência. Ele drenará a corrente nominal máxima do circuito — por exemplo, 32A de forma absolutamente constante — por 4, 6 ou até 10 horas seguidas durante a madrugada, enquanto o proprietário dorme.' },
      { type: 'paragraph', text: 'Sob esse regime térmico e magnético rigoroso e ininterrupto, qualquer erro de especificação no disjuntor de proteção geral gerará disparos térmicos indesejados devido ao calor acumulado nos bornes e na bimetálica interna do disjuntor. No pior cenário, um disjuntor subdimensionado ou de curva errada pode não disparar a tempo em situação de sobrecarga e permitir o aquecimento e derretimento do próprio cabeamento de alimentação.' },
      { type: 'heading', text: 'Entendendo as Curvas de Disparo: B, C e D' },
      { type: 'paragraph', text: 'Os disjuntores termomagnéticos residenciais e comerciais se dividem fundamentalmente por curvas de atuação, que delimitam o tempo de atuação térmica (proteção contra sobrecarga gradual) e magnética (proteção contra curto-circuito instantâneo):' },
      { type: 'list', items: [
        'Curva B: Indicado para circuitos puramente resistivos (aquecedores a resistência, lâmpadas incandescentes, chuveiros). Dispara de 3 a 5 vezes a corrente nominal em situação de curto-circuito. Totalmente inadequado para recargas de EV, pois a corrente de partida de um EVSE pode causar falsas viagens.',
        'Curva C: Indicado para cargas com componentes indutivos e fontes chaveadas com pico de partida moderado (ar-condicionado, motores pequenos, carregadores EVSE potentes). Dispara entre 5 e 10 vezes a corrente nominal. É a curva correta e obrigatória para disjuntores de circuito dedicado de carregadores de EV.',
        'Curva D: Indicado para motores industriais pesados e transformadores de grande porte com altíssimos picos de partida instantâneos (7 a 10 vezes). Desnecessário e contraindicado para instalações EVSE residenciais e comerciais padrão.'
      ] },
      { type: 'blockquote', text: 'Ao projetar o painel E-Wolf, aplicamos um fator de sobredimensionamento térmico de 25% na carcaça e nos bornes de fixação dos disjuntores gerais de Curva C de alta capacidade de ruptura (6kA ou 10kA), prevenindo disparos falsos causados por acúmulo de calor e protegendo a fiação interna contra envelhecimento prematuro do isolamento.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Capacidade de Ruptura: O Parâmetro que Ninguém Vê na Etiqueta' },
      { type: 'paragraph', text: 'Além da curva de disparo e da corrente nominal, existe um terceiro parâmetro crítico e frequentemente ignorado pelos instaladores amadores: a capacidade de ruptura em curto-circuito (Icu), medida em kA. Esse valor representa a máxima corrente de defeito que o disjuntor consegue interromper com segurança sem explodir internamente.' },
      { type: 'paragraph', text: 'Em condomínios e edifícios comerciais com transformadores de maior potência, as correntes prospectivas de curto-circuito podem alcançar 10kA ou 15kA nos pontos de distribuição mais próximos do trafo. Instalar um disjuntor com Icu de apenas 3kA nesse cenário representa risco de explosão do dispositivo em caso de falha grave.' },
      { type: 'heading', text: 'Fator de Agrupamento e Temperatura Ambiente' },
      { type: 'paragraph', text: 'Outro ponto negligenciado é o fator de correção de agrupamento e temperatura. Quando múltiplos disjuntores são instalados lado a lado em um quadro fechado, o calor acumulado de todos eles juntos eleva a temperatura interna do painel. Isso reduz efetivamente a corrente que cada disjuntor consegue conduzir sem disparar por temperatura. Um disjuntor de 32A em um painel com 6 disjuntores agrupados em temperatura ambiente de 35°C precisa ser recalculado para garantir que não haja disparo falso.' }
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
    tempoLeitura: '8 min',
    imagem: generateTechnicalSVG('suportes', 'Seção de Cabos', 'Cabo Elétrico'),
    conteudo: [
      { type: 'heading', text: 'Por que o cálculo padrão do eletricista pode comprometer sua instalação?' },
      { type: 'paragraph', text: 'Um dos erros mais graves e frequentes que encontramos em pátios de condomínio, garagens de casas e instalações comerciais é o subdimensionamento da fiação de cobre alimentadora do carregador. Muitos instaladores sem formação técnica específica utilizam cabos de 4 mm² ou 6 mm² para distâncias de 30 ou 40 metros sob corrente constante de 32A, baseando-se apenas em tabelas genéricas de condução de corrente de curta duração.' },
      { type: 'paragraph', text: 'Em circuitos longos operando como cargas contínuas prolongadas, um fator crítico entra em cena e invalida completamente esse cálculo simplificado: a queda de tensão ao longo do condutor. A resistência ôhmica do cobre gera perdas que se manifestam como aquecimento do cabo e redução da tensão que efetivamente chega ao carregador.' },
      { type: 'heading', text: 'O Impacto Real da Queda de Tensão no Desempenho do Carregador' },
      { type: 'paragraph', text: 'Se a tensão cair de 220V para 190V no terminal do EVSE, as consequências são múltiplas e sérias: a potência de carga efetiva cai proporcionalmente ao quadrado da tensão (lei de Joule), aumentando dramaticamente o tempo de recarga completa da bateria. O sistema de comunicação de baixa tensão (piloto CP e PP) do protocolo IEC 61851 pode apresentar erros de comunicação ou simplesmente não reconhecer o carregador como compatível, encerrando a sessão forçosamente.' },
      { type: 'list', items: [
        'Abaixo de 15 metros e 32A: Cabo de cobre de 6 mm² em eletroduto exclusivo e ventilado.',
        'De 15 a 30 metros e 32A: Cabo de cobre de 10 mm² (reduz drasticamente queda de tensão).',
        'De 30 a 50 metros e 32A: Cabo de cobre de 16 mm² (garante quedas abaixo de 3%, conforme NBR 5410).',
        'Acima de 50 metros e 32A: Cabo de cobre de 25 mm² ou instalação de segundo quadro de distribuição intermediário.'
      ] },
      { type: 'blockquote', text: 'Bitola de cabo não se escolhe por palpite nem por tabela genérica; ela se calcula combinando a corrente nominal contínua do circuito, a temperatura máxima do ambiente, o método de instalação (eletroduto, cabo livre, enterrado) e a queda de tensão percentual máxima admissível ao longo do percurso.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Método de Instalação: Eletroduto, Calha ou Enterrado' },
      { type: 'paragraph', text: 'O método de instalação do cabo afeta diretamente sua capacidade de condução de corrente. Cabos em eletroduto fechado têm menor dissipação térmica e menor capacidade de corrente comparados ao mesmo cabo instalado ao ar livre. Cabos enterrados em solo têm capacidade de corrente intermediária, mas exigem proteção mecânica adequada (eletroduto rígido de PVC ou PEAD) e respeito às profundidades mínimas estabelecidas pela NBR 5410.' },
      { type: 'paragraph', text: 'Na VoltchZ Brasil, todo projeto técnico passa por uma simulação computacional de engenharia para prever com precisão as perdas ôhmicas, o perfil de temperatura do cabo sob carga máxima e a queda de tensão percentual no ponto mais desfavorável do circuito. Isso garante uma operação silenciosa, eficiente e em plena conformidade com as normas brasileiras vigentes.' }
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
    tempoLeitura: '8 min',
    imagem: generateTechnicalSVG('estacoes', 'Gestão de Frotas', 'OCPP Cloud'),
    conteudo: [
      { type: 'heading', text: 'O Desafio da Recarga Simultânea de Frotas Corporativas' },
      { type: 'paragraph', text: 'Quando uma empresa decide substituir 10 ou 15 veículos de combustão por modelos elétricos de entrega ou transporte corporativo, a primeira pergunta que surge no departamento de operações é inevitável: como carregar todos esses carros juntos ao final do expediente sem derrubar a energia da sede corporativa e sem pagar multas astronômicas de pico de demanda para a concessionária distribuidora de energia?' },
      { type: 'paragraph', text: 'Instalar simplesmente 15 carregadores independentes de 22 kW pode resultar em uma demanda instantânea teórica de 330 kW — o suficiente para exigir a contratação emergencial de uma nova cabine primária de alta tensão, com investimentos em transformadores dedicados na casa dos R$ 800 mil a R$ 1,2 milhão. A solução tecnicamente correta e economicamente viável passa obrigatoriamente por segurança ativa e controle inteligente de carga via software.' },
      { type: 'heading', text: 'Equilíbrio Dinâmico de Carga (Smart Charging) e Protocolo OCPP' },
      { type: 'paragraph', text: 'Através do protocolo de comunicação universal OCPP 1.6J (Open Charge Point Protocol), as estações de carregamento da linha E-Wolf da VoltchZ se comunicam em tempo real com plataformas de gestão na nuvem, permitindo que o gestor da frota controle de forma centralizada todas as recargas simultâneas:' },
      { type: 'list', items: [
        'Balanceamento Dinâmico de Carga (Smart Load Management): Distribui a potência disponível na fábrica ou sede corporativa entre os veículos conectados de forma equitativa e automática. Se há apenas 1 carro, ele recebe a potência máxima (22 kW). Se conectam 10 carros, o sistema distribui a potência de acordo com o limite de demanda seguro pré-configurado pelo gestor.',
        'Priorização Inteligente por Rota: O administrador da frota pode indicar no painel de controle web quais veículos precisam sair mais cedo no dia seguinte, e o sistema direciona automaticamente maior potência de carga para esses veículos de forma prioritária.',
        'Programação por Janela Tarifária: Permite configurar o início das recargas para as madrugadas, aproveitando as tarifas de energia mais baixas nos horários fora de pico da concessionária.',
        'Relatórios de Consumo por Veículo: Controle individualizado do kWh consumido por cada veículo da frota, facilitando o rateio de custos entre departamentos ou projetos específicos.'
      ] },
      { type: 'blockquote', text: 'A chave para eletrificar frotas corporativas com eficiência real não está em contratar mais energia da concessionária. Está em gerenciar a energia disponível com inteligência ativa, automação e controle de dados em tempo real.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Segurança Operacional: Controle de Acesso e Autenticação' },
      { type: 'paragraph', text: 'Para frotas corporativas privadas, a segurança operacional é tão importante quanto a eficiência energética. As estações E-Wolf suportam autenticação por RFID (cartão de aproximação único por motorista), QR Code via aplicativo VoltchZ Mobile e PIN individualizado. Isso significa que apenas motoristas autorizados conseguem iniciar sessões de carregamento, eliminando o uso indevido da infraestrutura corporativa por terceiros.' },
      { type: 'paragraph', text: 'Todos os dados de autenticação, tempo de sessão, energia consumida e custo calculado são registrados na nuvem em tempo real, com exportação de relatórios em CSV ou PDF para integração com sistemas de gestão de frotas (TMS) e softwares de contabilidade corporativa.' }
    ]
  },
  {
    id: 6,
    slug: 'segundo-a-abve-numeros-indicam-transformacao-mercado-veiculos-eletrificados',
    titulo: 'Segundo a ABVE, o mercado de veículos eletrificados vive uma transformação no Brasil',
    categoria: 'Mercado',
    resumo: 'Análise detalhada do crescimento exponencial das vendas de EVs no mercado nacional e a demanda urgente por engenharia de infraestrutura elétrica qualificada.',
    autor: 'Bruno Riêra',
    cargo: 'Diretor de Engenharia da VoltchZ Brasil',
    data: '15 Jan, 2026',
    tempoLeitura: '7 min',
    imagem: generateTechnicalSVG('estacoes', 'Estatísticas ABVE', 'Dados Mercado'),
    conteudo: [
      { type: 'heading', text: 'Crescimento Histórico e o Boom dos Veículos Elétricos no Brasil' },
      { type: 'paragraph', text: 'Os relatórios e dados divulgados pela Associação Brasileira do Veículo Elétrico (ABVE) confirmam com números concretos o que já se nota visivelmente nas ruas das principais capitais e rodovias do país: o mercado brasileiro está atravessando uma transição energética acelerada, estrutural e sem volta rumo à mobilidade sustentável de baixo carbono.' },
      { type: 'paragraph', text: 'O crescimento das vendas de carros totalmente elétricos (BEV) e híbridos plug-in (PHEV) rompeu todas as projeções conservadoras que analistas do setor faziam apenas 4 anos atrás. Essa nova realidade mercadológica coloca em evidência um gargalo técnico dramático e urgente: a velocidade de aquisição de novos veículos pelos motoristas e frotistas está muito à frente da velocidade de instalação de carregadores confiáveis, homologados e seguros nas garagens de condomínios, rodovias e pontos comerciais de todo o país.' },
      { type: 'heading', text: 'Os Números que Confirmam a Transformação' },
      { type: 'list', items: [
        'O Brasil ultrapassou a marca de 100.000 veículos elétricos em circulação, com taxa de crescimento anual superior a 85% em 2023.',
        'São Paulo concentra mais de 40% da frota nacional de EVs, pressionando a infraestrutura de carregamento da maior cidade do hemisfério sul.',
        'O mercado de Wallboxes residenciais e comerciais cresceu 220% em volume de instalações em apenas 2 anos.',
        'A ABVE estima que o Brasil precisará de mais de 500.000 pontos de recarga instalados até 2030 para atender a demanda prevista.',
        'Apenas 18% dos novos proprietários de EVs no Brasil têm acesso a um carregador instalado tecnicamente de forma correta.'
      ] },
      { type: 'blockquote', text: 'A mobilidade elétrica no Brasil já é realidade comercial consolidada e irreversível. Agora, o grande desafio nacional migrou do pátio das concessionárias de veículos para as garagens, os condomínios e as rodovias — onde a engenharia elétrica de qualidade é absolutamente indispensável.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'O Gargalo Real: Falta de Engenharia Qualificada para Infraestrutura de Recarga' },
      { type: 'paragraph', text: 'Para cada 10 carros elétricos novos que entram em circulação no mercado nacional, é necessário ao menos 1 ponto de carregamento rápido público e cerca de 9 carregadores residenciais e condominiais fixos instalados nas vagas de garagens. Se as redes elétricas prediais existentes não forem adequadas com sistemas modernos de segurança ativa, proteção DR Classe A ou B e estudos de viabilidade criteriosos, o país poderá vivenciar apagões pontuais e queima de transformadores prediais.' },
      { type: 'paragraph', text: 'A VoltchZ Brasil nasceu exatamente para preencher esse vácuo de engenharia qualificada e responsabilidade técnica no setor. Nossa missão é que cada veículo elétrico que chegar ao Brasil tenha um ponto de carregamento seguro, eficiente e legal esperando por ele em casa, no trabalho ou na estrada.' }
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
    tempoLeitura: '6 min',
    imagem: generateTechnicalSVG('suportes', 'Eletropostos Comerciais', 'Fidelização'),
    conteudo: [
      { type: 'heading', text: 'O Novo Critério de Decisão do Consumidor de EV' },
      { type: 'paragraph', text: 'Imagine que o proprietário de um veículo elétrico premium está planejando uma viagem de final de semana com a família para o litoral ou a serra. Ao pesquisar pousadas, hotéis ou resorts no destino escolhido, qual será o seu primeiro critério de exclusão ao comparar as opções disponíveis?' },
      { type: 'paragraph', text: 'A resposta é simples e direta: se o estabelecimento não dispõe de carregador para veículos elétricos em sua garagem privativa, o cliente simplesmente o elimina da lista de consideração sem pensar duas vezes, optando pelo concorrente que oferece essa comodidade essencial. Este é o poder disruptivo e crescente do carregamento como fator de conveniência ativa na decisão de compra e fidelização de clientes qualificados.' },
      { type: 'heading', text: 'Carregamento como Serviço de Valor Agregado e Nova Receita' },
      { type: 'paragraph', text: 'Estabelecimentos que já instalaram pontos de recarga EV em seus estacionamentos relatam efeitos positivos concretos e mensuráveis em suas operações comerciais:' },
      { type: 'list', items: [
        'Atração e fidelização consistente de um nicho demográfico de alto poder aquisitivo e alta propensão a consumo.',
        'Aumento médio de 35% a 55% no tempo de permanência de clientes durante a recarga (mais tempo dentro da loja, restaurante ou hotel gerando consumo).',
        'Cadastro automático do estabelecimento como Eletroposto nos principais aplicativos de rota e navegação para EVs (VoltchZ, ABREVE, Plugshare).',
        'Possibilidade real de monetizar o serviço de recarga, cobrando um valor por kWh carregado ou por hora de conexão, criando uma nova linha de receita operacional.',
        'Geração espontânea de marketing positivo associado a ESG, sustentabilidade e inovação tecnológica, sem custo adicional de comunicação.',
        'Diferenciação competitiva duradoura frente a concorrentes que ainda não investiram em infraestrutura de mobilidade elétrica.'
      ] },
      { type: 'blockquote', text: 'A recarga de carros elétricos em estabelecimentos comerciais deixou definitivamente de ser um diferencial de inovação para se consolidar como infraestrutura básica obrigatória de atração e retenção de clientes de alto valor.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'O ROI Real de um Eletroposto Comercial' },
      { type: 'paragraph', text: 'Com base em projetos instalados pela VoltchZ Brasil em hotéis, restaurantes e redes de varejo, um eletroposto comercial de 22 kW bem posicionado, com cobrança por kWh, apresenta retorno sobre o investimento em um prazo médio de 18 a 30 meses, dependendo do fluxo de veículos elétricos na região e do modelo de monetização escolhido pelo estabelecimento.' }
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
    tempoLeitura: '9 min',
    imagem: generateTechnicalSVG('estacoes', 'TCO e Economia', 'Finanças EV'),
    conteudo: [
      { type: 'heading', text: 'Custo por Quilômetro Rodado: Elétrico versus Gasolina' },
      { type: 'paragraph', text: 'Apesar de apresentarem um valor de aquisição inicial mais elevado nas concessionárias, os carros elétricos trazem benefícios financeiros expressivos e mensuráveis na planilha de custos operacionais ao longo da vida útil do veículo. O principal e mais imediato pilar de economia é o custo do combustível por quilômetro rodado.' },
      { type: 'paragraph', text: 'Enquanto percorrer 100 km com um veículo popular a combustão abastecido com gasolina comum consome entre R$ 55,00 e R$ 72,00 nas capitais brasileiras (com gasolina a R$ 6,00/litro e consumo de 10 a 12 km/l), percorrer a mesma distância com um veículo elétrico de eficiência equivalente custa entre R$ 10,00 e R$ 18,00 na tarifa residencial de energia elétrica, representando uma redução de custo de 70% a 85% no item combustível.' },
      { type: 'heading', text: 'Total Cost of Ownership (TCO) e Manutenção Quase Nula' },
      { type: 'paragraph', text: 'Além da economia imediata em combustível, o TCO (Custo Total de Propriedade) de um veículo elétrico ao longo de 5 anos é significativamente inferior ao de um equivalente a combustão. O principal componente dessa vantagem é a drástica redução de custos de manutenção preventiva e corretiva.' },
      { type: 'list', items: [
        'Eliminação completa de trocas de óleo lubrificante, filtros de óleo, velas de ignição, correias dentadas e de alternador.',
        'Extinção do sistema de escape, catalisadores e filtros de partículas (itens caros e sujeitos a corrosão e falhas mecânicas).',
        'Redução de 60% a 80% no desgaste e custo dos freios devido ao sistema de frenagem regenerativa que recupera energia e alivia os discos mecânicos.',
        'Isenção ou desconto significativo de IPVA em São Paulo (50% de desconto para híbridos e isenção total para elétricos puros em vários estados).',
        'Redução de gastos com estacionamento e pedágio em cidades como São Paulo e Rio de Janeiro, que oferecem benefícios tarifários para EVs.'
      ] },
      { type: 'blockquote', text: 'Quando se considera o TCO real ao longo de 60 meses de propriedade, incluindo combustível, manutenção, seguros e benefícios fiscais, o veículo elétrico apresenta vantagem financeira total sobre o equivalente a combustão a partir do 2º ou 3º ano de uso — muito antes do que a maioria das pessoas imagina.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'Simulação de Payback para Frotistas Corporativos' },
      { type: 'paragraph', text: 'Para empresas com frotas de 5 ou mais veículos, a vantagem do EV é ainda mais dramática. Uma empresa que substitui 10 utilitários de combustão por modelos elétricos equivalentes pode economizar entre R$ 180.000 e R$ 280.000 anuais apenas em combustível e manutenção, sem contar os benefícios de imagem ESG e as isenções de impostos estaduais.' },
      { type: 'paragraph', text: 'A infraestrutura de carregamento corporativo para 10 veículos, instalada com qualidade pela VoltchZ Brasil incluindo o sistema Smart Charging via OCPP, custa entre R$ 85.000 e R$ 140.000 dependendo da localização e potência selecionada — representando payback total da infraestrutura em menos de 8 meses de operação.' }
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
    tempoLeitura: '9 min',
    imagem: generateTechnicalSVG('protecao', 'Solar + EV', 'Sustentabilidade'),
    conteudo: [
      { type: 'heading', text: 'Gerando Combustível Solar Gratuito no Telhado de Casa' },
      { type: 'paragraph', text: 'A maior e mais revolucionária promessa de liberdade do veículo elétrico reside na possibilidade concreta de eliminar completamente a dependência de postos de combustível, de refinarias e dos preços voláteis do petróleo. Ao integrar uma planta de microgeração fotovoltaica no telhado de sua residência ou empresa, o usuário de EV passa a produzir eletricidade limpa com custo marginal praticamente zero, utilizando a radiação solar abundante que o Brasil recebe.' },
      { type: 'paragraph', text: 'Essa energia solar produzida durante as horas de sol é injetada na rede da concessionária e gera créditos de energia elétrica (sistema de compensação da ANEEL), que por sua vez abastecem o carregador do carro à noite. O resultado prático é que o "combustível" do veículo elétrico passa a custar próximo de zero, com investimento inicial que se paga em 4 a 6 anos e vida útil dos painéis superior a 25 anos.' },
      { type: 'heading', text: 'Como Dimensionar a Planta Solar para Incluir o Carregamento do EV' },
      { type: 'paragraph', text: 'O grande erro que muitos proprietários cometem é instalar uma planta fotovoltaica dimensionada apenas para o consumo histórico da residência, sem contemplar a nova demanda gerada pelo carregamento do veículo elétrico. Um carro elétrico com autonomia de 400 km e consumo típico de 15 kWh/100 km percorrendo 1.500 km por mês adicionará cerca de 225 kWh/mês à conta de energia.' },
      { type: 'list', items: [
        'Levantamento do consumo residencial histórico (12 meses) e adição da demanda estimada do EV.',
        'Cálculo da irradiação solar local da cidade e do fator de perdas do sistema (cabeamento, inversores, temperatura).',
        'Dimensionamento da quantidade de painéis e potência do inversor considerando a nova demanda total.',
        'Integração do Wallbox com o sistema fotovoltaico via comunicação inteligente para priorizar a carga com energia solar.',
        'Registro do sistema na concessionária e homologação junto à distribuidora local conforme resolução ANEEL 482.'
      ] },
      { type: 'blockquote', text: 'A combinação de geração solar + armazenamento em bateria estacionária + veículo elétrico transforma o consumidor passivo de energia em um prosumidor ativo, produzindo, consumindo e gerenciando sua própria energia com total autonomia e inteligência.', author: 'Bruno Riêra' },
      { type: 'heading', text: 'V2G e V2H: O Carro como Bateria Estacionária da Casa' },
      { type: 'paragraph', text: 'O próximo passo evolutivo da integração solar + EV é o ecossistema inteligente bidirecional, no qual o veículo elétrico não apenas consome energia do telhado solar, mas também retorna energia da sua bateria de alta capacidade para alimentar a residência (V2H — Vehicle to Home) nos momentos de blecaute ou de tarifas elevadas pela concessionária.' },
      { type: 'paragraph', text: 'No nível mais avançado, o conceito V2G (Vehicle to Grid) permite que o proprietário venda de volta à rede pública o excedente de energia armazenado na bateria do veículo nos momentos de pico de demanda do sistema elétrico nacional, gerando uma fonte de renda passiva enquanto o carro está estacionado. Esta tecnologia já é realidade em alguns países europeus e está rapidamente avançando no mercado brasileiro.' }
    ]
  }
];

ARTIGOS.forEach(art => {
  art.tempoLeitura = calcTempoLeitura(art.conteudo);
});

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
