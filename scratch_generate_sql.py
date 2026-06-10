import json
import os

# Dados JSON fornecidos
produtos_json = """[
  {
    "slug": "incharge-home-5",
    "nome": "INCHARGE HOME 5",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "7,4 kW",
    "tensao": "210~240V AC Monofásico",
    "aplicacao": "Residencial",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Estação de carregamento residencial compacta com cabo de 5 metros e conector Tipo 2.",
    "descricao": "O INCHARGE HOME 5 é uma estação de carregamento AC para uso residencial, projetada para carregar veículos elétricos e híbridos Plug-in. Com indicação de status por LEDs, montagem em parede ou totem e cabo de 5 metros com conector Tipo 2, oferece praticidade e segurança para o carregamento doméstico. Sem controle de carga ou comunicação remota, ideal para uso simples e direto.",
    "imagem": "static/produtos/incharge-home-5.webp",
    "diferenciais": [
      "Indicação de status por LEDs (Carregando, Conectado, Erro)",
      "Montagem em parede ou totem",
      "Proteção IP54 e IK10",
      "Cabo de 5 metros com conector Tipo 2",
      "Fácil instalação com suporte metálico incluso"
    ],
    "especificacoes": {
      "Código do produto": "INC1X32H5",
      "Linha": "HOME",
      "Potência máxima": "7,4 kW",
      "Tensão de alimentação": "210~240V AC 50/60Hz",
      "Descrição dos pólos": "P+N+T",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "LEDs para indicação de estado",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "300 mm",
      "Largura": "220 mm",
      "Profundidade": "90 mm",
      "Peso líquido": "3,2 kg"
    },
    "variacoes": [
      {
        "sku": "INC1X32H5",
        "nome": "INCHARGE HOME 5 — 7,4kW Monofásico",
        "adicional_desc": "210~240V AC, Cabo 5m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-home-7",
    "nome": "INCHARGE HOME 7",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "7,4 kW",
    "tensao": "210~240V AC Monofásico",
    "aplicacao": "Residencial",
    "tipo": "Cabo fixo Tipo 2 (7m)",
    "resumo": "Estação de carregamento residencial com cabo longo de 7 metros e conector Tipo 2.",
    "descricao": "O INCHARGE HOME 7 é idêntico ao HOME 5 em especificações elétricas, mas oferece um cabo de 7 metros para maior flexibilidade no posicionamento do veículo. Ideal para garagens onde a tomada de recarga do carro fica mais distante da parede. Indicação de status por LEDs, montagem em parede ou totem e proteção IP54.",
    "imagem": "static/produtos/incharge-home-7.webp",
    "diferenciais": [
      "Cabo de 7 metros com conector Tipo 2 para maior alcance",
      "Indicação de status por LEDs (Carregando, Conectado, Erro)",
      "Montagem em parede ou totem",
      "Proteção IP54 e IK10",
      "Fácil instalação com suporte metálico incluso"
    ],
    "especificacoes": {
      "Código do produto": "INC1X32H7",
      "Linha": "HOME",
      "Potência máxima": "7,4 kW",
      "Tensão de alimentação": "210~240V AC 50/60Hz",
      "Descrição dos pólos": "P+N+T",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "7 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "LEDs para indicação de estado",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "300 mm",
      "Largura": "220 mm",
      "Profundidade": "90 mm",
      "Peso líquido": "3,9 kg"
    },
    "variacoes": [
      {
        "sku": "INC1X32H7",
        "nome": "INCHARGE HOME 7 — 7,4kW Monofásico",
        "adicional_desc": "210~240V AC, Cabo 7m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-home-trifasico-5",
    "nome": "INCHARGE HOME Trifásico 5",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "22 kW",
    "tensao": "365~415V AC Trifásico",
    "aplicacao": "Residencial, Corporativo",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Estação de carregamento residencial trifásica de 22kW com cabo de 5 metros.",
    "descricao": "O INCHARGE HOME Trifásico 5 (INC3X32H5) oferece carregamento AC trifásico de 22kW para veículos que suportam esse modo de recarga. Com cabo de 5 metros e conector Tipo 2, é indicado para residências e condomínios com rede trifásica 380V disponível. Indica o status por LEDs e pode ser montado em parede ou totem.",
    "imagem": "static/produtos/incharge-home-trifasico-5.webp",
    "diferenciais": [
      "Carregamento trifásico de até 22kW",
      "Indicação de status por LEDs",
      "Montagem em parede ou totem",
      "Proteção IP54 e IK10",
      "Cabo de 5 metros com conector Tipo 2"
    ],
    "especificacoes": {
      "Código do produto": "INC3X32H5",
      "Linha": "HOME",
      "Potência máxima": "22 kW",
      "Tensão de alimentação": "365~415V AC 50/60Hz",
      "Descrição dos pólos": "3P+N+T",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "LEDs para indicação de estado",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "300 mm",
      "Largura": "220 mm",
      "Profundidade": "90 mm",
      "Peso líquido": "3,7 kg"
    },
    "variacoes": [
      {
        "sku": "INC3X32H5",
        "nome": "INCHARGE HOME Trifásico 5 — 22kW",
        "adicional_desc": "365~415V AC Trifásico, Cabo 5m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-home-trifasico-7",
    "nome": "INCHARGE HOME Trifásico 7",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "22 kW",
    "tensao": "365~415V AC Trifásico",
    "aplicacao": "Residencial, Corporativo",
    "tipo": "Cabo fixo Tipo 2 (7m)",
    "resumo": "Estação de carregamento residencial trifásica de 22kW com cabo longo de 7 metros.",
    "descricao": "O INCHARGE HOME Trifásico 7 (INC3X32H7) combina a potência de 22kW trifásico com um cabo de 7 metros para maior flexibilidade de posicionamento. Ideal para garagens amplas ou condomínios com rede 380V. Indicação por LEDs e montagem em parede ou totem.",
    "imagem": "static/produtos/incharge-home-trifasico-7.webp",
    "diferenciais": [
      "Carregamento trifásico de até 22kW",
      "Cabo de 7 metros para maior alcance",
      "Indicação de status por LEDs",
      "Montagem em parede ou totem",
      "Proteção IP54 e IK10"
    ],
    "especificacoes": {
      "Código do produto": "INC3X32H7",
      "Linha": "HOME",
      "Potência máxima": "22 kW",
      "Tensão de alimentação": "365~415V AC 50/60Hz",
      "Descrição dos pólos": "3P+N+T",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "7 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "LEDs para indicação de estado",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "300 mm",
      "Largura": "220 mm",
      "Profundidade": "90 mm",
      "Peso líquido": "5,4 kg"
    },
    "variacoes": [
      {
        "sku": "INC3X32H7",
        "nome": "INCHARGE HOME Trifásico 7 — 22kW",
        "adicional_desc": "365~415V AC Trifásico, Cabo 7m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-plus-74kw",
    "nome": "INCHARGE 7,4kW PLUS",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "7,4 kW",
    "tensao": "210~240V AC Monofásico/Bifásico",
    "aplicacao": "Residencial, Corporativo, Condomínios",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Carregador AC compacto com design premiado internacionalmente, para uso em parede ou totem.",
    "descricao": "O INCHARGE 7,4kW PLUS é um carregador veicular AC com design premiado (iF Design Award 2021 e A' Design Award Bronze 2020). Com display cromático indicativo, cabo de 5 metros e conector Tipo 2, é indicado para uso em residências, condomínios e pontos comerciais. Não possui comunicação remota ou controle de carga — ideal para instalações simples e diretas.",
    "imagem": "static/produtos/incharge-plus-74kw.webp",
    "diferenciais": [
      "Design premiado internacionalmente (iF Design Award 2021)",
      "Display cromático indicativo de status",
      "Montagem em parede ou totem",
      "Proteção IP54 e IK10 — uso interno e externo",
      "Cabo de 5 metros com conector Tipo 2"
    ],
    "especificacoes": {
      "Código do produto": "INC1X32P",
      "Linha": "PLUS",
      "Potência máxima": "7,4 kW",
      "Tensão de alimentação": "210~240V AC 50/60Hz",
      "Descrição dos pólos": "P+N+T",
      "Modo de montagem": "Parede/Totem",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display cromático (LEDs)",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "500 mm",
      "Largura": "220 mm",
      "Profundidade": "200 mm",
      "Peso líquido": "6,0 kg",
      "Cor": "Cinza cool gray 3C"
    },
    "variacoes": [
      {
        "sku": "INC1X32P",
        "nome": "INCHARGE 7,4kW PLUS",
        "adicional_desc": "210~240V AC Monofásico/Bifásico, Cabo 5m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-smart-74kw",
    "nome": "INCHARGE 7,4kW SMART",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "7,4 kW",
    "tensao": "210~240V AC Monofásico/Bifásico",
    "aplicacao": "Corporativo, Condomínios, Pontos Comerciais",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Carregador AC inteligente com controle de acesso via NFC/App e comunicação OCPP 1.6J.",
    "descricao": "O INCHARGE 7,4kW SMART é a versão conectada da linha PLUS. Além do design premiado e proteção IP54, conta com medidor de energia integrado, controle de acesso por cartão NFC ou App, comunicação OCPP 1.6J e controle de carga remoto. Inclui Gateway de conexão para integração com o servidor INCHARGE. Indicado para condomínios, estacionamentos e pontos comerciais que precisam de gestão de recargas.",
    "imagem": "static/produtos/incharge-smart-74kw.webp",
    "diferenciais": [
      "Controle de acesso via cartão NFC e App",
      "Comunicação OCPP 1.6J para gestão remota",
      "Medidor de energia integrado",
      "Controle de carga inteligente",
      "Gateway de conexão incluso",
      "Design premiado internacionalmente (iF Design Award 2021)",
      "Proteção IP54 e IK10 — uso interno e externo"
    ],
    "especificacoes": {
      "Código do produto": "INC1X32S",
      "Linha": "SMART",
      "Potência máxima": "7,4 kW",
      "Tensão de alimentação": "210~240V AC 50/60Hz",
      "Descrição dos pólos": "P+N+T",
      "Modo de montagem": "Parede/Totem",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display cromático (LEDs)",
      "Comunicação": "OCPP 1.6 J",
      "Controle de carga": "Sim",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "500 mm",
      "Largura": "220 mm",
      "Profundidade": "200 mm",
      "Peso líquido": "6,2 kg",
      "Cor": "Cinza cool gray 3C"
    },
    "variacoes": [
      {
        "sku": "INC1X32S",
        "nome": "INCHARGE 7,4kW SMART",
        "adicional_desc": "210~240V AC Monofásico/Bifásico, Cabo 5m, NFC + OCPP 1.6J"
      }
    ]
  },
  {
    "slug": "incharge-plus-22kw",
    "nome": "INCHARGE 22kW PLUS",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "22 kW",
    "tensao": "365~415V AC Trifásico",
    "aplicacao": "Corporativo, Condomínios, Frotas",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Carregador AC trifásico de 22kW com design premiado, para uso em parede ou totem.",
    "descricao": "O INCHARGE 22kW PLUS é a versão trifásica de alta potência da linha PLUS. Com 22kW de potência AC, carrega veículos compatíveis de forma significativamente mais rápida que carregadores monofásicos. Design premiado internacionalmente, proteção IP54 para uso interno e externo, cabo de 5 metros com conector Tipo 2. Sem comunicação remota — ideal para instalações corporativas simples.",
    "imagem": "static/produtos/incharge-plus-22kw.webp",
    "diferenciais": [
      "Carregamento trifásico de até 22kW",
      "Design premiado internacionalmente (iF Design Award 2021)",
      "Display cromático indicativo de status",
      "Proteção IP54 e IK10 — uso interno e externo",
      "Montagem em parede ou totem"
    ],
    "especificacoes": {
      "Código do produto": "INC3X32P",
      "Linha": "PLUS",
      "Potência máxima": "22 kW",
      "Tensão de alimentação": "365~415V AC 50/60Hz",
      "Descrição dos pólos": "3P+N+T",
      "Modo de montagem": "Parede/Totem",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display cromático (LEDs)",
      "Comunicação": "Não",
      "Controle de carga": "Não",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "500 mm",
      "Largura": "220 mm",
      "Profundidade": "200 mm",
      "Peso líquido": "7,1 kg",
      "Cor": "Vermelho Warm Red C"
    },
    "variacoes": [
      {
        "sku": "INC3X32P",
        "nome": "INCHARGE 22kW PLUS",
        "adicional_desc": "365~415V AC Trifásico, Cabo 5m, Conector Tipo 2"
      }
    ]
  },
  {
    "slug": "incharge-smart-22kw",
    "nome": "INCHARGE 22kW SMART",
    "marca_id": "incharge",
    "categoria_id": "estacoes-ac",
    "potencia": "22 kW",
    "tensao": "365~415V AC Trifásico",
    "aplicacao": "Corporativo, Condomínios, Frotas, Pontos Comerciais",
    "tipo": "Cabo fixo Tipo 2 (5m)",
    "resumo": "Carregador AC trifásico de 22kW com controle de acesso NFC/App e OCPP 1.6J.",
    "descricao": "O INCHARGE 22kW SMART combina a alta potência de 22kW trifásico com recursos de conectividade completos: controle de acesso por cartão NFC ou App, comunicação OCPP 1.6J, medidor de energia integrado e controle de carga remoto. Inclui Gateway de conexão. Indicado para estacionamentos comerciais, frotas corporativas e condomínios que precisam de gestão centralizada de recargas.",
    "imagem": "static/produtos/incharge-smart-22kw.webp",
    "diferenciais": [
      "Carregamento trifásico de até 22kW",
      "Controle de acesso via cartão NFC e App",
      "Comunicação OCPP 1.6J para gestão remota",
      "Medidor de energia integrado",
      "Controle de carga inteligente",
      "Gateway de conexão incluso",
      "Proteção IP54 e IK10 — uso interno e externo"
    ],
    "especificacoes": {
      "Código do produto": "INC3X32S",
      "Linha": "SMART",
      "Potência máxima": "22 kW",
      "Tensão de alimentação": "365~415V AC 50/60Hz",
      "Descrição dos pólos": "3P+N+T",
      "Modo de montagem": "Parede/Totem",
      "Número de saídas": "1",
      "Padrão do conector": "Tipo 2",
      "Comprimento do cabo": "5 m",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display cromático (LEDs)",
      "Comunicação": "OCPP 1.6 J",
      "Controle de carga": "Sim",
      "Normas": "IEC 61851 / IEC 62197",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-30 / 50°C",
      "Temperatura de armazenamento": "-40 / 80°C",
      "Humidade relativa": "5 / 95%",
      "Altura": "500 mm",
      "Largura": "220 mm",
      "Profundidade": "200 mm",
      "Peso líquido": "7,5 kg",
      "Cor": "Vermelho Warm Red C"
    },
    "variacoes": [
      {
        "sku": "INC3X32S",
        "nome": "INCHARGE 22kW SMART",
        "adicional_desc": "365~415V AC Trifásico, Cabo 5m, NFC + OCPP 1.6J"
      }
    ]
  },
  {
    "slug": "incharge-emvs-30kw",
    "nome": "INCHARGE EMVS 30kW",
    "marca_id": "incharge",
    "categoria_id": "carregadores-dc",
    "potencia": "30 kW",
    "tensao": "400 Vca, 3P+N+PE (304~456 Vca)",
    "aplicacao": "Corporativo, Estacionamentos, Frotas, Pontos Comerciais",
    "tipo": "Cabo fixo CCS2 (3m)",
    "resumo": "Wallbox DC de 30kW com display touchscreen de 10,4\\\", OCPP 1.6J e até 96,5% de eficiência.",
    "descricao": "O INCHARGE EMVS 30kW é uma estação de carregamento rápido DC em formato wallbox, para montagem em parede ou totem. Com 30kW de potência DC, display touchscreen TFT de 10,4\\\", conector CCS2, comunicação via LAN e protocolo OCPP 1.6J, atende estacionamentos, frotas e pontos comerciais que precisam de carregamento rápido em espaço reduzido. Eficiência geral de até 96,5% e operação de -35°C a 60°C.",
    "imagem": "static/produtos/incharge-emvs-30kw.webp",
    "diferenciais": [
      "Carregamento DC rápido de 30kW",
      "Display touchscreen TFT de 10,4\\\"",
      "Eficiência de até 96,5% (sistema)",
      "Comunicação LAN com protocolo OCPP 1.6J",
      "Proteção IP55 e IK10",
      "Operação entre -35°C e 60°C",
      "Nível de ruído inferior a 55dB"
    ],
    "especificacoes": {
      "Modelo": "EVMS-30",
      "Capacidade": "30 kW",
      "Parâmetros de entrada": "400 Vca, 3P+N+PE",
      "Faixa de tensão de entrada": "304~456 Vca",
      "Fator de potência": ">0,997",
      "Frequência": "50/60 Hz",
      "Plugue de saída": "CCS2 (saída única)",
      "Tensão de saída": "50~1000 VDC",
      "Corrente máxima de saída": "100 A",
      "Eficiência geral": "97% (Módulo de Potência) / 96,5% (Sistema)",
      "Visor": "Touchscreen TFT 10,4\\\"",
      "Conexão de rede": "LAN",
      "Protocolos de comunicação": "OCPP 1.6J",
      "Temperatura de operação": "-35°C a 60°C",
      "Temperatura de armazenamento": "-40°C a +70°C",
      "Umidade de operação": "≤95%, sem condensação",
      "Altitude máxima": "2000 m",
      "Proteção": "IP55, IK10",
      "Ambiente de uso": "Externo/Interno",
      "Ruído acústico": "<55 dB",
      "Dimensões (L×P×A)": "460 × 345 × 735 mm"
    },
    "variacoes": [
      {
        "sku": "EVMS-30",
        "nome": "INCHARGE EMVS 30kW",
        "adicional_desc": "400 Vca Trifásico, Cabo CCS2 3m, LAN + OCPP 1.6J"
      }
    ]
  },
  {
    "slug": "incharge-fast-charge-60kw",
    "nome": "INCHARGE Fast Charge 60kW",
    "marca_id": "incharge",
    "categoria_id": "carregadores-dc",
    "potencia": "60 kW",
    "tensao": "304~456V AC 3P+N+T (50/60 Hz)",
    "aplicacao": "Corporativo, Estacionamentos, Postos, Frotas, Uso Público",
    "tipo": "2× CCS2 (auto portante)",
    "resumo": "Carregador DC rápido autosuportado de 60kW com 2 saídas CCS2, display touch 10,4\\\" e OCPP 1.6J.",
    "descricao": "O INCHARGE Fast Charge 60kW (INC60kW-DC) é um carregador DC rápido em formato totem autosuportado, com dois conectores CCS2. Estratégia de carregamento flexível: 60+0, 0+60 ou 30+30 kW por conector. Display touchscreen de 10,4\\\", controle de acesso local/cartão/app, comunicação OCPP 1.6J e controle de carga. Tensão de saída de 150 a 1000 VDC com corrente máxima de 200A. Robusto, com proteção IP54, IK10 e operação de -20°C a 60°C.",
    "imagem": "static/produtos/incharge-fast-charge-60kw.webp",
    "diferenciais": [
      "2 saídas CCS2 com estratégia de divisão de carga flexível",
      "Display touchscreen de 10,4\\\"",
      "Controle de acesso: Local, Cartão RFID e App",
      "Comunicação OCPP 1.6J",
      "Tensão de saída ampla: 150~1000 VDC",
      "Proteção IP54 e IK10",
      "Totem autosuportado — sem fixação em parede"
    ],
    "especificacoes": {
      "Código do produto": "INC60kW-DC",
      "Linha": "Fast Charge",
      "Potência máxima": "60 kW",
      "Tensão de alimentação nominal": "304~456V AC 50/60 Hz",
      "Descrição dos pólos": "3P+N+T",
      "Modo de montagem": "Auto portante",
      "Número de saídas": "2",
      "Padrão dos conectores": "CCS2",
      "Estratégia de carregamento": "60+0 | 0+60 | 30+30",
      "Tensão de saída DC": "150~1000 VDC",
      "Corrente de saída máxima": "200 A",
      "Sistema de controle de acesso": "Local / Cartão / Aplicativo",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display touch 10,4\\\"",
      "Comunicação": "OCPP 1.6 J",
      "Controle de carga": "Sim",
      "Normas": "IEC 61851, IEC 62196, ISO 15118, DIN 70121",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-20~60°C",
      "Temperatura de armazenamento": "-40~70°C",
      "Humidade relativa": "0~95%",
      "Altura": "2000 mm",
      "Largura": "900 mm",
      "Profundidade": "500 mm",
      "Peso líquido": "230 kg",
      "Cor": "Cinza e preto"
    },
    "variacoes": [
      {
        "sku": "INC60kW-DC",
        "nome": "INCHARGE Fast Charge 60kW",
        "adicional_desc": "2× CCS2, Estratégia 60+0 / 0+60 / 30+30 kW, OCPP 1.6J"
      }
    ]
  },
  {
    "slug": "incharge-fast-charge-150kw",
    "nome": "INCHARGE Fast Charge 150kW",
    "marca_id": "incharge",
    "categoria_id": "carregadores-dc",
    "potencia": "150 kW",
    "tensao": "304~456V AC 3P+N+T (50/60 Hz)",
    "aplicacao": "Postos de Recarga, Uso Público, Frotas de Alta Demanda",
    "tipo": "2× CCS2 (auto portante)",
    "resumo": "Carregador DC ultrarrápido autosuportado de 150kW com 2 saídas CCS2, display touch 10,4\\\" e OCPP 1.6J.",
    "descricao": "O INCHARGE Fast Charge 150kW (INC150kW-DC) é o carregador DC de maior potência da linha INCHARGE. Em formato totem autosuportado com dois conectores CCS2, entrega até 150kW com estratégias de divisão de carga flexíveis: 150+0, 0+150 ou 90+60 kW. Display touchscreen de 10,4\\\", controle de acesso multicanal, OCPP 1.6J e tensão de saída de 150 a 1000 VDC com 200A máximos. Ideal para postos de recarga de alta demanda e frotas comerciais.",
    "imagem": "static/produtos/incharge-fast-charge-150kw.webp",
    "diferenciais": [
      "Potência DC ultrarrápida de até 150kW",
      "2 saídas CCS2 com estratégia de divisão de carga flexível (150+0 / 0+150 / 90+60)",
      "Display touchscreen de 10,4\\\"",
      "Controle de acesso: Local, Cartão RFID e App",
      "Comunicação OCPP 1.6J",
      "Tensão de saída ampla: 150~1000 VDC",
      "Proteção IP54 e IK10",
      "Totem autosuportado robusto — 260 kg"
    ],
    "especificacoes": {
      "Código do produto": "INC150kW-DC",
      "Linha": "Fast Charge",
      "Potência máxima": "150 kW",
      "Tensão de alimentação nominal": "304~456V AC 50/60 Hz",
      "Descrição dos pólos": "3P+N+T",
      "Modo de montagem": "Auto portante",
      "Número de saídas": "2",
      "Padrão dos conectores": "CCS2",
      "Estratégia de carregamento": "150+0 | 0+150 | 90+60",
      "Tensão de saída DC": "150~1000 VDC",
      "Corrente de saída máxima": "200 A",
      "Sistema de controle de acesso": "Local / Cartão / Aplicativo",
      "Aterramento": "TN/TT",
      "Sinalização local": "Display touch 10,4\\\"",
      "Comunicação": "OCPP 1.6 J",
      "Controle de carga": "Sim",
      "Normas": "IEC 61851, IEC 62196, ISO 15118, DIN 70121",
      "Grau de proteção IP": "IP54",
      "Grau de proteção IK": "IK10",
      "Temperatura de operação": "-20~60°C",
      "Temperatura de armazenamento": "-40~70°C",
      "Humidade relativa": "0~95%",
      "Altura": "2000 mm",
      "Largura": "900 mm",
      "Profundidade": "500 mm",
      "Peso líquido": "260 kg",
      "Cor": "Cinza e preto"
    },
    "variacoes": [
      {
        "sku": "INC150kW-DC",
        "nome": "INCHARGE Fast Charge 150kW",
        "adicional_desc": "2× CCS2, Estratégia 150+0 / 0+150 / 90+60 kW, OCPP 1.6J"
      }
    ]
  }
]"""

produtos = json.loads(produtos_json)

# Vamos gerar os scripts SQL
sql_produtos = []
sql_diferenciais = []
sql_especificacoes = []
sql_variacoes = []

# IDs de produto começam em 28
current_prod_id = 28
spec_ordem = 301 # Próxima ordem disponível no dump

categoria_map = {
    "estacoes-ac": "estacoes",
    "carregadores-dc": "estacoes"
}

for p in produtos:
    cat_id = categoria_map.get(p["categoria_id"], p["categoria_id"])
    
    # Produto
    # Ajustando as aspas simples e escapando
    desc_escaped = p["descricao"].replace("'", "''")
    resumo_escaped = p["resumo"].replace("'", "''")
    nome_escaped = p["nome"].replace("'", "''")
    potencia_escaped = p["potencia"].replace("'", "''")
    tensao_escaped = p["tensao"].replace("'", "''")
    aplicacao_escaped = p["aplicacao"].replace("'", "''")
    tipo_escaped = p["tipo"].replace("'", "''")
    
    sql_prod = f"INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES ({current_prod_id}, '{p['slug']}', '{nome_escaped}', '{p['marca_id']}', '{cat_id}', '{potencia_escaped}', '{tensao_escaped}', '{aplicacao_escaped}', '{tipo_escaped}', '{resumo_escaped}', '{desc_escaped}', '{p['imagem']}');"
    sql_produtos.append(sql_prod)
    
    # Diferenciais
    for idx, dif in enumerate(p["diferenciais"]):
        dif_escaped = dif.replace("'", "''")
        sql_dif = f"INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES ({current_prod_id}, '{dif_escaped}', {idx});"
        sql_diferenciais.append(sql_dif)
        
    # Especificações
    for chave, valor in p["especificacoes"].items():
        ch_escaped = chave.replace("'", "''")
        vl_escaped = str(valor).replace("'", "''")
        sql_spec = f"INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES ({current_prod_id}, '{ch_escaped}', '{vl_escaped}', {spec_ordem});"
        sql_especificacoes.append(sql_spec)
        spec_ordem += 1
        
    # Variações
    for var in p["variacoes"]:
        vname_escaped = var["nome"].replace("'", "''")
        vdesc_escaped = var["adicional_desc"].replace("'", "''")
        sql_var = f"INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('{var['sku']}', {current_prod_id}, '{vname_escaped}', '{vdesc_escaped}');"
        sql_variacoes.append(sql_var)
        
    current_prod_id += 1

# Agrupa as queries em blocos
sql_output_lines = [
    "",
    "-- =====================================================================",
    "-- Novos Produtos Incharge (Adicionados Manualmente)",
    "-- =====================================================================",
    "",
    "-- 1. Inserção de Produtos"
] + sql_produtos + [
    "",
    "-- 2. Inserção de Diferenciais"
] + sql_diferenciais + [
    "",
    "-- 3. Inserção de Variações/SKUs"
] + sql_variacoes + [
    "",
    "-- 4. Inserção de Especificações Técnicas"
] + sql_especificacoes

sql_block = "\\n".join(sql_output_lines) + "\\n"

# 1. Escreve o script isolado
with open(r"c:\\Users\\wiks2503\\Documents\\GitHub\\Site-Institucional-Voltchz\\includes\\dados_migracao_novos_produtos.sql", "w", encoding="utf-8") as f:
    f.write(sql_block)
print("Gerado: includes/dados_migracao_novos_produtos.sql")

# 2. Apenda no arquivo principal
with open(r"c:\\Users\\wiks2503\\Documents\\GitHub\Site-Institucional-Voltchz\\includes\\dados_migracao.sql", "a", encoding="utf-8") as f:
    f.write(sql_block)
print("Apensado em: includes/dados_migracao.sql")
