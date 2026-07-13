-- =====================================================================
-- VoltchZ Brasil - Setup Completo para XAMPP (Desenvolvimento Local)
-- ATENÇÃO: Este script apaga e recria todas as tabelas!
-- =====================================================================

-- =====================================================================
-- VoltchZ Brasil - Estrutura do Banco de Dados MySQL (Opção B - Relacional Puro)
-- =====================================================================

-- Desativa checagem de chaves estrangeiras para recriação limpa
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `artigo_conteudo_list_items`;
DROP TABLE IF EXISTS `artigo_conteudo`;
DROP TABLE IF EXISTS `artigos`;
DROP TABLE IF EXISTS `produto_variacoes`;
DROP TABLE IF EXISTS `produto_especificacoes`;
DROP TABLE IF EXISTS `produto_diferenciais`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `marcas`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `leads`;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Tabela de Marcas
CREATE TABLE `marcas` (
    `id` VARCHAR(50) NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `descricao` TEXT NULL,
    `imagem` VARCHAR(255) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabela de Categorias
CREATE TABLE `categorias` (
    `id` VARCHAR(50) NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `descricao` TEXT NULL,
    `imagem` VARCHAR(255) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabela Principal de Produtos
CREATE TABLE `produtos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(150) NOT NULL,
    `nome` VARCHAR(150) NOT NULL,
    `marca_id` VARCHAR(50) NOT NULL,
    `categoria_id` VARCHAR(50) NOT NULL,
    `potencia` VARCHAR(100) NULL,
    `tensao` VARCHAR(150) NULL,
    `aplicacao` VARCHAR(255) NULL,
    `tipo` VARCHAR(150) NULL,
    `resumo` TEXT NULL,
    `descricao` TEXT NULL,
    `imagem` VARCHAR(255) NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_produtos_slug` (`slug`),
    CONSTRAINT `fk_produtos_marca` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabela de Diferenciais Comerciais (Relação 1:N com Produtos)
CREATE TABLE `produto_diferenciais` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `produto_id` INT NOT NULL,
    `diferencial` TEXT NOT NULL,
    `ordem` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_diferenciais_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabela de Especificações Técnicas (Relação 1:N com Produtos)
CREATE TABLE `produto_especificacoes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `produto_id` INT NOT NULL,
    `chave` VARCHAR(150) NOT NULL,
    `valor` TEXT NOT NULL,
    `ordem` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_especificacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabela de Variações/SKUs (Relação 1:N com Produtos)
CREATE TABLE `produto_variacoes` (
    `sku` VARCHAR(100) NOT NULL,
    `produto_id` INT NOT NULL,
    `nome` VARCHAR(150) NOT NULL,
    `adicional_desc` TEXT NULL,
    PRIMARY KEY (`sku`),
    CONSTRAINT `fk_variacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabela Principal de Artigos (Blog)
CREATE TABLE `artigos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(150) NOT NULL,
    `titulo` VARCHAR(255) NOT NULL,
    `categoria` VARCHAR(100) NULL,
    `resumo` TEXT NULL,
    `autor` VARCHAR(100) NULL,
    `cargo` VARCHAR(150) NULL,
    `data_publicacao` VARCHAR(50) NULL,
    `tempo_leitura` VARCHAR(50) NULL,
    `svg_metadata_category` VARCHAR(50) NULL,
    `svg_metadata_title` VARCHAR(150) NULL,
    `svg_metadata_subtitle` VARCHAR(150) NULL,
    `imagem` VARCHAR(255) NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_artigos_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabela de Conteúdos dos Artigos (Blocos de Texto - Relação 1:N)
CREATE TABLE `artigo_conteudo` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `artigo_id` INT NOT NULL,
    `tipo` VARCHAR(50) NOT NULL, -- 'heading', 'paragraph', 'list', 'blockquote'
    `texto` TEXT NULL,
    `autor_citado` VARCHAR(150) NULL, -- Usado apenas em blockquotes se houver
    `ordem` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_conteudo_artigo` FOREIGN KEY (`artigo_id`) REFERENCES `artigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabela de Itens de Lista para Conteúdos do Artigo (Relação 1:N com artigo_conteudo)
CREATE TABLE `artigo_conteudo_list_items` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `artigo_conteudo_id` INT NOT NULL,
    `item` TEXT NOT NULL,
    `ordem` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_list_items_conteudo` FOREIGN KEY (`artigo_conteudo_id`) REFERENCES `artigo_conteudo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tabela de Usuários Administrativos (Login)
CREATE TABLE `usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `senha` VARCHAR(255) NOT NULL, -- Hash bcrypt
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Tabela de Leads (Contatos enviados pelo site)
CREATE TABLE `leads` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `telefone` VARCHAR(30) NOT NULL,
    `empresa` VARCHAR(150) NULL,
    `cidade` VARCHAR(100) NULL,
    `tipo_projeto` VARCHAR(100) NOT NULL,
    `prazo_desejado` VARCHAR(100) NOT NULL,
    `mensagem` TEXT NOT NULL,
    `status` VARCHAR(50) DEFAULT 'Pendente', -- 'Pendente', 'Em Atendimento', 'Concluído'
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================================================
-- Carga de Dados Base (Marcas, Categorias, Blog e Produtos Originais)
-- =====================================================================
-- =====================================================================
-- VoltchZ Brasil - Dados de Migração (Gerado Automaticamente)
-- =====================================================================
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `artigo_conteudo_list_items`;
TRUNCATE TABLE `artigo_conteudo`;
TRUNCATE TABLE `artigos`;
TRUNCATE TABLE `produto_variacoes`;
TRUNCATE TABLE `produto_especificacoes`;
TRUNCATE TABLE `produto_diferenciais`;
TRUNCATE TABLE `produtos`;
TRUNCATE TABLE `categorias`;
TRUNCATE TABLE `marcas`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `marcas` (`id`, `nome`, `descricao`) VALUES ('ewolf', 'E-Wolf', 'Proteção elétrica inteligente de alta performance e estações de carregamento confiáveis projetadas para mobilidade elétrica moderna.');
INSERT INTO `marcas` (`id`, `nome`, `descricao`) VALUES ('intelbras', 'Intelbras', 'Tecnologia nacional e robustez de hardware para recarga corporativa e frotas.');
INSERT INTO `marcas` (`id`, `nome`, `descricao`) VALUES ('incharge', 'Incharge', 'Estações avançadas de carregamento com design escandinavo e alto torque energético.');
INSERT INTO `marcas` (`id`, `nome`, `descricao`) VALUES ('voltchz', 'VoltchZ', 'Acessórios estruturais, pedestais chumbados e complementos desenvolvidos com a engenharia e qualidade premium da VoltchZ.');
INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES ('protecao', 'Quadros de Proteção', 'Dispositivos essenciais de isolamento (DR Tipo A, Disjuntores e DPS) que salvaguardam o veículo e o edifício.');
INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES ('estacoes', 'Estações de Carregamento', 'Carregadores de parede (Wallbox) e totens rápidos trifásicos AC e DC com ou sem suporte inteligente (OCPP).');
INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES ('portateis', 'Carregadores Portáteis', 'Unidades leves de emergência com corrente regulável para uso flexível e viagens.');
INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES ('suportes', 'Suportes e Totens', 'Pedestais de aço estrutural de solo com coberturas de policarbonato para locais abertos sem apoio físico.');
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (1, 'quadro-protecao-ewolf-7-2kw-mono-bif-sem-tomada', 'Quadro de Proteção E-Wolf 7.2 kW (Monofásico/Bifásico - Sem Tomada)', 'ewolf', 'protecao', '7,2 kW (32A)', '220VAC (Monofásico / Bifásico)', 'Residencial e Comercial Leve', 'Quadro de Segurança Bipolar', 'Proteção de segurança essencial para o carregamento do seu carro em residências. Equipado com DR Classe A e DPS de alta performance.', 'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco.', 'static/produtos/ewolf-quadro-protecao-7kw.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (1, 'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (1, 'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d''água', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (1, 'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (1, 'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento', 3);

INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (39, 'quadro-protecao-ewolf-7-2kw-mono-bif-com-tomada', 'Quadro de Proteção E-Wolf 7.2 kW (Monofásico/Bifásico - Com Tomada)', 'ewolf', 'protecao', '7,2 kW (32A)', '220VAC (Monofásico / Bifásico)', 'Residencial e Comercial Leve', 'Quadro de Segurança Bipolar (com Tomada)', 'Proteção de segurança essencial equipada com tomada industrial azul de 32A 2P+T acoplada de alta performance.', 'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco. Apresenta saída com tomada industrial padrão NBR IEC 60309.', 'static/produtos/ewolf-quadro-protecao-7kw-com-tomada.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (39, 'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (39, 'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d''água', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (39, 'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (39, 'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento', 3);

INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (40, 'quadro-protecao-ewolf-7-2kw-trifasico-sem-tomada', 'Quadro de Proteção E-Wolf 7.2 kW (Trifásico - Sem Tomada)', 'ewolf', 'protecao', '7,2 kW (Trifásico)', '380VAC (Trifásico com Neutro)', 'Residencial e Comercial Leve', 'Quadro de Segurança Tetrapolar', 'Proteção trifásica inteligente e compacta de alta performance, equipada com DR Classe A e DPS de alta performance.', 'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW (Trifásico) atua como um escudo entre a rede elétrica trifásica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco.', 'static/produtos/ewolf-quadro-protecao-7kw.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (40, 'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (40, 'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d''água', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (40, 'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (40, 'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento', 3);

INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (41, 'quadro-protecao-ewolf-7-2kw-trifasico-com-tomada', 'Quadro de Proteção E-Wolf 7.2 kW (Trifásico - Com Tomada)', 'ewolf', 'protecao', '7,2 kW (Trifásico)', '380VAC (Trifásico com Neutro)', 'Residencial e Comercial Leve', 'Quadro de Segurança Tetrapolar (com Tomada)', 'Proteção trifásica inteligente de alta performance equipada com tomada industrial vermelha de alta potência acoplada.', 'Projetado especificamente para atender a norma brasileira NBR 5410 e as diretrizes de segurança da indústria de mobilidade elétrica. O Quadro de Proteção E-Wolf de 7,2 kW (Trifásico) atua como um escudo entre a rede elétrica e seu carregador, neutralizando de forma imediata eventuais surtos causados por raios, além de interromper fugas de corrente pulsantes que colocam a vida humana em risco. Apresenta tomada vermelha trifásica padrão IEC 60309.', 'static/produtos/ewolf-quadro-protecao-7kw-com-tomada.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (41, 'Dispositivo DR Classe A de 30mA (obrigatório para veículos elétricos contra choque de corrente contínua)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (41, 'Gabinete termoplástico resistente com proteção IP65 contra poeira e jatos d''água', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (41, 'Dispositivos de Proteção contra Surtos (DPS) Classe II de 20/40kA instalados e cabeados', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (41, 'Bornes de passagem industriais que garantem aperto firme e evitam sobreaquecimento', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (2, 'quadro-protecao-22kw', 'Quadro de Proteção E-Wolf 22 kW', 'ewolf', 'protecao', '22 kW (3x 32A)', '380VAC (Trifásico com Neutro)', 'Comercial, Condomínios e Frotas', 'Quadro de Segurança Tetrapolar', 'Blindagem elétrica trifásica avançada com DR Tipo A quadripolar para estações comerciais de recarga rápida e hubs corporativos.', 'Projetado sob medida para redes elétricas trifásicas in 380V (F+F+F+N+PE). O Quadro de Proteção E-Wolf de 22 kW é a escolha preferida de engenheiros e instaladores para projetos comerciais robustos. Ele garante que as altas correntes trifásicas de recarga sejam monitoradas e protegidas individualmente, mantendo a operabilidade segura e sem interrupções indesejadas.', 'static/produtos/ewolf-quadro-protecao-22kw.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (2, 'Dispositivo DR Classe A Tetrapolar com alto isolamento', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (2, 'DPS Tetrapolar modular que permite troca rápida dos cartuchos sem desligar a fiação', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (2, 'Barramento interno de cobre dimensionado para carga contínua prolongada de 32A', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (2, 'Indicadores de presença de fase por lâmpada neon frontal integrada', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (3, 'estacao-carregamento-380vac-tipo-2', 'Estação de Carregamento 380VAC Tipo 2', 'ewolf', 'estacoes', 'Até 22 kW', '380VAC Trifásico', 'Residencial, Comercial e Hubs Corporativos', 'Wallbox Inteligente', 'Carregador trifásico elegante e potente para veículos elétricos de qualquer marca. Suporta ajuste de potência dinâmico e display informativo.', 'A união perfeita de engenharia robusta e estética moderna. Com gabinete frontal em vidro temperado resistente e anel de LED dinâmico que indica visualmente o progresso da recarga, esta estação se integra harmoniosamente em garagens residenciais sofisticadas, garagens comerciais de hotéis e pátios corporativos.', 'static/produtos/ewolf-estacao-carregamento-380vac-tipo2.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (3, 'Recarga ultra rápida de até 22 kW (22.000W) por hora', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (3, 'Anel de luz indicativo inteligente de status operacional', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (3, 'Interface digital por display colorido LCD que indica tensão, corrente e temperatura', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (3, 'Cabo tipo 2 de alta qualidade com proteção contra esmagamento e rasgos', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (4, 'estacao-carregamento-comercial-ccs2', 'Estação de Carregamento Comercial CCS2', 'ewolf', 'estacoes', '40 kW DC a 80 kW DC', '380VAC ±15% Trifásico (Entrada)', 'Rodoviário, Supermercados e Hubs de Frota', 'Carregador Rápido DC', 'Carregador em Corrente Contínua ultra rápido com controle total OCPP 1.6J, tela integrada touchscreen e comunicação celular nativa.', 'A solução definitiva para frotistas que necessitam de carregamento contínuo em menos de 1 hora. A estação Comercial DC E-Wolf fornece energia direta para a bateria do veículo sem passar pelo conversor de bordo AC, gerando curvas de carga agressivas e estáveis. Integrado por OCPP, permite a cobrança por kWh ou tempo de uso através de centrais de pagamento de parceiros.', 'static/produtos/ewolf-estacao-carregamento-comercial-ccs2.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (4, 'Injeção direta de energia contínua DC para curvas de recarga ultrarrápidas', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (4, 'Compatível com qualquer servidor ou gerenciador via protocolo OCPP 1.6J JSON', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (4, 'Tela colorida intuitiva Touchscreen para controle e feedback em tempo real', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (4, 'Comunicação de dados móveis 4G GPRS e Wi-Fi redundantes incluídos de fábrica', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (5, 'std-estacao-carregamento-220vac', 'STD – Estação de Carregamento 220VAC', 'ewolf', 'estacoes', '7,4 kW (32A)', '220VAC Monofásico', 'Residências e Garagens Privativas', 'Wallbox Standard Plug & Play', 'O cavalo de batalha do carregamento doméstico diário. Uma estação compacta, direta e extremamente confiável.', 'Criada para usuários que buscam simplicidade, robustez e segurança sem pagar por firulas tecnológicas supérfluas. A série STD de 220VAC se liga à rede elétrica monofásica clássica e entrega a potência máxima aceitável em carregadores AC monofásicos brasileiros. Basta acoplar o bocal Tipo 2 no veículo e o carregamento inicia de forma imediata.', 'static/produtos/ewolf-estacao-std-220vac.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (5, 'Acionamento plug-and-play direto e simplificado', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (5, 'Construção com termoplástico de alta resistência contra batidas', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (5, 'Excelente relação custo-benefício para carregamento doméstico regular', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (5, 'Pode ser chumbado ou pendurado de forma extremamente descomplicada', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (6, 'smt-estacao-carregamento-220vac', 'SMT – Estação de Carregamento 220VAC (Smart)', 'ewolf', 'estacoes', '7,4 kW (Ajustável)', '220VAC Monofásico', 'Residencial Inteligente e Condomínios com Divisão', 'Wallbox Inteligente Wi-Fi', 'Controle total da sua recarga a partir do seu smartphone. Agende horários econômicos e integre com energia solar.', 'Desenvolvido para entusiastas de tecnologia e automação residencial. A série SMT (Smart) conta com aplicativos integrados dedicados via Wi-Fi e Bluetooth. Gerencie com precisão cirúrgica a potência da recarga, programe carregamentos inteligentes para aproveitar tarifas de energia fora do pico, e integre o consumo à geração distribuída de painéis fotovoltaicos.', 'static/produtos/ewolf-estacao-smt-220vac-smart.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (6, 'Agendamento automático de recargas em horários de menor custo tarifário', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (6, 'Conectividade sem fio Wi-Fi 2.4 GHz e Bluetooth de emparelhamento rápido', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (6, 'Ajuste fino de amperagem (corrente regulável de 8A até 32A) via app', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (6, 'Histórico de recarga detalhado em kWh e relatórios de consumo mensais', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (7, 'std-estacao-carregamento-380vac', 'STD – Estação de Carregamento 380VAC', 'ewolf', 'estacoes', '22 kW', '380VAC Trifásico', 'Condomínios, Hotéis e Comércios de Médio Porte', 'Wallbox Standard Trifásico', 'Carregamento trifásico sem rodeios técnicos. Alta potência AC de forma simplificada e muito resistente.', 'Ideal para condomínios residenciais que desejam disponibilizar pontos de carregamento na vaga rotativa, onde a simplicidade e a durabilidade mecânica são prioridades. Ele foi projetado para operar em ambientes semi-públicos ou compartilhados sem necessidade de senhas ou chaves complexas, com altíssima durabilidade técnica.', 'static/produtos/ewolf-estacao-std-380vac.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (7, 'Construção robusta voltada a pátios comerciais e garagens prediais comuns', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (7, 'Carregamento semirrápido potente de até 22 kW por hora de carga', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (7, 'Não exige conexão com internet ou configurações de rede para operar', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (7, 'Cabo ultra resistente preparado para intempéries constantes', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (8, 'carregador-portatil-220vac-tipo-2', 'Carregador Portátil E-Wolf 220VAC Tipo 2', 'ewolf', 'portateis', '3,5 kW a 7,4 kW (Regulável)', '220VAC Monofásico', 'Uso Móvel, Viagens e Emergências', 'Carregador Portátil (EVSE)', 'A paz de espírito que você leva no porta-malas. Carregue seu veículo em qualquer tomada comum ou industrial com controle térmico ativo.', 'Desenvolvido para motoristas que viajam com frequência ou necessitam de flexibilidade de carregamento. O Carregador Portátil E-Wolf se conecta a qualquer tomada comum (com adaptador apropriado) ou tomada industrial azul de 32A. A unidade de controle (EVSE) inteligente gerencia a corrente automaticamente e desliga o circuito em caso de sobreaquecimento ou instabilidades na tomada local.', 'static/produtos/ewolf-carregador-portatil-220vac-tipo2.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (8, 'Corrente de trabalho regulável para evitar quedas e sobrecargas no local', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (8, 'Display digital LED multifunção integrado para monitoramento em tempo real', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (8, 'Dispositivo interno contra sobreaquecimento nos contatos da tomada', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (8, 'Estojo/Bolsa de nylon impermeável de transporte durável com zíper', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (9, 'pedestal-cobertura-policarbonato', 'Pedestal VoltchZ com Cobertura em Policarbonato', 'ewolf', 'suportes', 'N/A (Suporte Mecânico)', NULL, 'Estacionamentos Corporativos Externos e Garagens Descobertas', 'Totem de Solo com Cobertura', 'Totem de solo premium robusto em aço carbono com teto protetor translúcido contra raios UV para abrigar dois carregadores.', 'Desenvolvido pela divisão de engenharia civil e mecânica da VoltchZ Brasil, este pedestal de solo é a melhor resposta para a montagem de eletropostos descobertos. A estrutura de aço carbono reforçado é chumbada quimicamente no concreto, enquanto o teto de policarbonato alveolar filtra raios ultravioletas e resguarda o gabinete dos carregadores do sol escaldante e chuvas intensas.', 'static/produtos/ewolf-pedestal-cobertura-policarbonato.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (9, 'Design em aço galvanizado ultra rígido com pintura epóxi fosca durável', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (9, 'Cobertura translúcida em Policarbonato de 6mm com tratamento de filtro UV', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (9, 'Possibilita instalar duas estações Wallbox costas-a-costas de forma otimizada', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (9, 'Canaleta oculta interna para passagem segura e blindada dos cabos elétricos', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (10, 'suporte-solo-carregador-eletrico', 'Suporte de Solo Slim VoltchZ', 'ewolf', 'suportes', 'N/A (Suporte Mecânico)', NULL, 'Vagas de Garagens de Condomínio Descobertas ou Comerciais', 'Totem Metálico Slim', 'Totem vertical elegante e compacto de aço carbono, ideal para fixação estável de Wallbox em vagas rotativas e locais sem parede próxima.', 'Quando o espaço na parede é inexistente, o Suporte de Solo Slim da VoltchZ oferece a solução técnica definitiva. Com um visual minimalista e discreto que combina perfeitamente com projetos de arquitetura contemporânea, ele permite que a fiação suba pelo subsolo por dentro do próprio poste metálico, mantendo as vagas limpas, seguras e com visual limpo.', 'static/produtos/ewolf-suporte-solo-slim.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (10, 'Visual moderno esguio que valoriza o condomínio e a vaga do usuário', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (10, 'Passagem subterrânea interna para cabos de até 35 mm² de seção', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (10, 'Fabricado com parede interna de aço reforçado que resiste a colisões leves', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (10, 'Instalação rápida com parafusos parabolt inox inclusos no kit técnico', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (11, 'estacao-de-recarga-para-veiculos-eletricos-home-eve-0074h', 'Estação de Recarga para Veículos Elétricos Home EVE 0074H', 'intelbras', 'estacoes', '7,4 kW', '230VAC (F+N+T ou 2F+T)', 'Residencial', 'Wallbox', 'A estação de recarga Home, recarrega em até 7,4 kW, tem conector tipo 2, cabo de 4 metros e controle de acesso via RFID.', 'A estação de recarga Home é ideal para utilização em ambiente residencial. Você pode instalar em sua garagem e fazer a recarga do seu carro elétrico de forma fácil e segura. A estação pode ser acessada via cartão RFID ou no modo plug and play liberado para qualquer usuário. Conta com design compacto e discreto, podendo ser fixada na parede ou instalada em pedestal (vendido separadamente, código Intelbras 4820101).', 'static/produtos/intelbras-estacao-home-eve-0074h.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Conector tipo 2 (Europeu)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Cabo com 4 metros de comprimento', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Controle de acesso via RFID (Mifare ISO/IEC 14443 A)', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Grau de proteção IP65', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Equipamento de fácil instalação', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Design compacto e discreto', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Modo Plug&Play ou cartão RFID', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Fixação na parede ou instalação com pedestal', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (11, 'Detecção de corrente de 6 mA CC', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (12, 'estacao-de-recarga-para-veiculos-eletricos-city-eve-0074c', 'Estação de Recarga para Veículos Elétricos City EVE 0074C', 'intelbras', 'estacoes', '7,4 kW', '230VAC (F+N+T ou 2F+T)', 'Condomínios / Estacionamentos / Frotas', 'Wallbox', 'A estação de recarga City, recarrega em até 7,4 kW, tem conector tipo 2, cabo de 4 metros e aplicativo para gestão.', 'A estação de recarga para veículos elétricos City conta com controle de acesso via aplicativo ou através do cartão RFID. Também oferece uma completa plataforma de gestão, com tarifação, divisão de custos de energia e localização da estação. Funcionalidade ideal para condomínios, estacionamentos públicos, privados ou gestores de frotas. A estação pode ser fixada na parede ou em pedestal (vendido como acessório).', 'static/produtos/intelbras-estacao-city-eve-0074c.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Conector tipo 2 (Europeu)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Cabo com 4 metros de comprimento', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Controle de acesso via aplicativo ou cartão RFID', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Plataforma de gestão completa (tarifação, divisão de custos, localização)', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Grau de proteção IP65', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Conectividade Wi-Fi 2.4 GHz e Bluetooth', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Protocolo OCPP 1.6 JSON', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'LED indicador de status', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Detecção de corrente de 6 mA CC', 8);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (12, 'Fixação na parede ou instalação com pedestal', 9);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (13, 'estacao-de-recarga-para-veiculos-eletricos-city-eve-0110c', 'Estação de Recarga para Veículos Elétricos City EVE 0110C', 'intelbras', 'estacoes', '11 kW', '400VAC Trifásico (3F+N+T)', 'Condomínios / Estacionamentos / Frotas', 'Wallbox', 'Estação de recarga City 11 kW, com conector tipo 2, cabo de 4 metros e aplicativo para gestão.', 'A estação de recarga para veículos elétricos City conta com controle de acesso via aplicativo ou através do cartão RFID. Também oferece uma completa plataforma de gestão, com tarifação, divisão de custos de energia e localização da estação. Funcionalidade ideal para condomínios, estacionamentos públicos, privados ou gestores de frotas. A estação pode ser fixada na parede ou em pedestal (vendido como acessório).', 'static/produtos/intelbras-estacao-city-eve-0110c.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Conector tipo 2 (Europeu)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Cabo com 4 metros de comprimento', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'LED indicador de status', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Estrutura em plástico resistente com grau de proteção IP65', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Controle de acesso via aplicativo ou cartão RFID (Mifare ISO/IEC 14443 A)', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Plataforma de gestão completa (tarifação, divisão de custos, localização)', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Wi-Fi 2.4 GHz e Bluetooth', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Protocolo OCPP 1.6 JSON', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Alimentação trifásica – maior potência que a EVE 0074C', 8);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (13, 'Fixação na parede ou instalação com pedestal', 9);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (14, 'estacao-de-recarga-para-veiculos-eletricos-business-eve-0220b', 'Estação de Recarga para Veículos Elétricos Business EVE 0220B', 'intelbras', 'estacoes', '22 kW', '400VAC Trifásico (3F+N+T)', 'Estacionamentos / Frotas / Empresas', 'Wallbox Business', 'A estação de recarga Business, recarrega em até 22 kW, tem conector tipo 2, cabo de 4 metros e aplicativo para gestão.', 'A estação de recarga Business é a solução para estacionamentos públicos e privados, otimizando o controle de acesso via aplicativo móvel ou cartão RFID. Conta com plataforma de gestão completa com tarifação, divisão de custos de energia e localização da estação. Gabinete em aço galvanizado com painel frontal em vidro temperado e grau de proteção IP65.', 'static/produtos/intelbras-estacao-business-eve-0220b.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, '22 kW de potência – a maior carga AC da linha', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Conector tipo 2 (Europeu) com cabo de 4 metros', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Display com indicação de status', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Controle de acesso via aplicativo ou cartão RFID', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Plataforma de gestão com tarifação e divisão de custos', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Gabinete em aço galvanizado com painel em vidro temperado', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Grau de proteção IP65', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Protocolo OCPP 1.6', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (14, 'Ideal para frotas e negócios', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (15, 'estacao-rapida-em-corrente-continua-30kw-eve-0300fp', 'Estação Rápida em Corrente Contínua 30 kW EVE 0300FP', 'intelbras', 'estacoes', '30 kW', '400VAC Trifásico entrada / 150–1000 VDC saída', 'Frotas Corporativas / Postos de Recarga / Estacionamentos', 'Totem DC Rápido', 'Estação rápida em corrente contínua 30 kW. Oferece múltiplos métodos de autenticação e carregamento confiável.', 'Modelo de corrente contínua que oferece recargas mais rápidas em veículos elétricos, com conector CCS2 e 5 metros de cabo. A recarga pode ser controlada via aplicativo, cartão RFID ou modo livre (Plug & Play) e Autocharge. Conta com display colorido touchscreen de 7", medidor de energia interno (classe 0,5), IDR do tipo A (senoidal e pulsante, 63 A) e DPS (Classe II, 20 kA nominal) internamente. Gabinete em alumínio com IP55 e IK10.', 'static/produtos/intelbras-estacao-dc-30kw-eve-0300fp.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Conector CCS2 de 100 A', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Tensão de saída de 150 a 1000 V CC', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Cabo com 5 metros de comprimento', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Display de 7" sensível ao toque e indicador LED', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Alta eficiência ≥ 94%', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Gabinete em alumínio com IP55 e IK10', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Conexão à internet por 4G, Wi-Fi e Ethernet', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Medidor de energia interno classe 0,5', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'DPS e IDR internos', 8);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'OCPP 1.6 – geração de receita', 9);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (15, 'Pedestal opcional disponível (PED 0001FP)', 10);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (16, 'estacao-de-recarga-dc-de-60kw-eve-0600fp', 'Estação de Recarga DC de 60 kW EVE 0600FP', 'intelbras', 'estacoes', '60 kW', '400VAC Trifásico entrada / 150–1000 VDC saída', 'Postos de Rodovia / Frotas / Estacionamentos de Alto Fluxo', 'Totem DC Rápido – Dupla Saída', 'Evolução em eficiência e excelente desempenho para atender às demandas de veículos elétricos e de alta capacidade.', 'A estação de recarga Fleet Pro 60 kW tem modo de autenticação via aplicativo, cartão RFID, Plug & Play (automático) e Autocharge. Fornece um carregamento confiável e rápido de 150 a 1000 V e 200 A de saída em corrente contínua com duas saídas. Conta com múltiplas possibilidades de configuração, aliado à tecnologia de monitoramento para gestão remota. Gabinete em aço inoxidável com IP55 e IK10.', 'static/produtos/intelbras-estacao-dc-60kw-eve-0600fp.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, '2 saídas CCS2 de 200 A', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Tensão de saída 150 a 1000 V CC', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Alta eficiência ≥ 94%', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Display de 7" sensível ao toque e indicador LED', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Gabinete em aço inoxidável com IP55 e IK10', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Conexão à internet por 4G, Wi-Fi e Ethernet', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Autenticação: APP, RFID, Plug&Play, Autocharge', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'Opcional: sistema de sustentação de cabos', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (16, 'OCPP 1.6 para gestão e geração de receita', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (17, 'estacao-rapida-em-corrente-continua-80kw-eve-0800fp', 'Estação Rápida em Corrente Contínua 80 kW EVE 0800FP', 'intelbras', 'estacoes', '80 kW', '400VAC Trifásico entrada / 150–1000 VDC saída', 'Postos de Rodovia / Frotas / Estacionamentos de Alto Fluxo', 'Totem DC Rápido – Dupla Saída', 'Estação rápida em corrente contínua 80 kW. Projetada para atender às demandas de veículos elétricos com tecnologia avançada.', 'A estação de recarga Fleet Pro 80 kW tem modo de autenticação via aplicativo, cartão RFID, Plug & Play (automático) e Autocharge. Fornece um carregamento confiável e rápido de 150 a 1000 V e 200 A de saída em corrente contínua com duas saídas. Conta com display touchscreen e colorido de 10", múltiplas possibilidades de configuração e tecnologia de monitoramento para gestão remota. Gabinete em aço inoxidável com IP55 e IK10.', 'static/produtos/intelbras-estacao-dc-80kw-eve-0800fp.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, '2 saídas CCS2 de 200 A', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Alta eficiência de 97%', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Display de 10" touchscreen colorido', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Gabinete em aço inoxidável com IP55 e IK10', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Conexão à internet por 4G, Wi-Fi e Ethernet', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Autenticação: APP, RFID, Plug&Play, Autocharge', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'OCPP 1.6 para geração de receita', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Opcional: sistema de sustentação de cabos', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (17, 'Produto novo (lançamento)', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (18, 'estacao-rapida-em-corrente-continua-120-kw-eve-1200fc', 'Estação Rápida em Corrente Contínua 120 kW EVE 1200FC', 'intelbras', 'estacoes', '120 kW', '400VAC Trifásico entrada / 150–1000 VDC saída', 'Postos de Rodovia / Hubs de Recarga / Frotas de Alta Demanda', 'Totem DC Ultrarrápido – Dupla Saída', 'Estação rápida em corrente contínua 120 kW da linha Fleet Charge.', 'A estação de recarga Fleet Charge 120 kW tem modo de autenticação via aplicativo, cartão RFID, Plug & Play (automático) e Autocharge. Fornece carregamento confiável e rápido com duas saídas CCS2 e tecnologia de monitoramento avançada para gestão remota. Alta potência, tecnologia avançada e robustez industrial para a nova era da mobilidade elétrica.', 'static/produtos/intelbras-estacao-dc-120kw-eve-1200fc.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, '120 kW de potência DC ultrarrápida', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, '2 saídas CCS2', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Display touchscreen colorido', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Gabinete robusto com IP55', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Conexão por 4G, Wi-Fi e Ethernet', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Autenticação: APP, RFID, Plug&Play, Autocharge', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Protocolo OCPP 1.6', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Alta eficiência', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (18, 'Produto novo (lançamento)', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (19, 'estacao-rapida-em-corrente-continua-180-kw-eve-1800fc', 'Estação Rápida em Corrente Contínua 180 kW EVE 1800FC', 'intelbras', 'estacoes', '180 kW', '400VAC Trifásico entrada / 150–1000 VDC saída', 'Postos de Rodovia / Hubs de Recarga / Frotas de Alta Demanda', 'Totem DC Ultrarrápido – Dupla Saída', 'Alta potência, tecnologia avançada e robustez industrial para a nova era da mobilidade elétrica.', 'A estação de recarga Fleet Charge 180 kW tem modo de autenticação via aplicativo, cartão RFID, Plug & Play (automático) e Autocharge. Fornece um carregamento confiável e rápido de 150 a 1000 V e 300 A de saída em corrente contínua com duas saídas, com múltiplas possibilidades de configuração, aliado à tecnologia de monitoramento para gestão remota.', 'static/produtos/intelbras-estacao-dc-180kw-eve-1800fc.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, '180 kW de potência DC – maior da linha Intelbras', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, '2 saídas CCS2 de 300 A', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Display touchscreen colorido', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Gabinete robusto com IP55', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Conexão por 4G, Wi-Fi e Ethernet', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Autenticação: APP, RFID, Plug&Play, Autocharge', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Protocolo OCPP 1.6', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Alta tecnologia e robustez industrial', 7);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (19, 'Produto novo (lançamento)', 8);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (20, 'pedestal-para-estacao-de-recarga-dc-30kw-ped-0001fp', 'Pedestal para Estação de Recarga DC 30 kW PED 0001FP', 'intelbras', 'protecao', NULL, NULL, 'Instalação da EVE 0300FP em piso', 'Pedestal / Suporte Metálico', 'Pedestal para instalação da estação de recarga DC Fleet Pro 30 kW (EVE 0300FP).', 'Suporte estrutural para instalação da estação EVE 0300FP em piso, quando não for possível ou desejável a fixação em parede. Produto novo (lançamento).', 'static/produtos/intelbras-pedestal-dc-30kw-ped-0001fp.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (20, 'Compatível com a EVE 0300FP', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (20, 'Fácil instalação', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (20, 'Espaço para passagem de cabos', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (20, 'Produto novo (lançamento)', 3);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (21, 'pedestal-para-carregador-de-veiculos-eletricos-home-e-city-ped-0002c', 'Pedestal para Carregador de Veículos Elétricos Home e City PED 0002C', 'intelbras', 'protecao', NULL, NULL, 'Instalação das estações EVE 0074H e EVE 0074C em piso', 'Pedestal / Suporte Metálico', 'Pedestal prático e de fácil instalação para os carregadores Home (EVE 0074H) e City (EVE 0074C).', 'Prático e de fácil instalação, o Pedestal Intelbras PED 0002C permite instalar as estações de recarga Home e City no local desejado, oferecendo maior comodidade. Com espaço ideal para passagem dos cabos de energia e comunicação, além de suporte para enrolar o cabo de recarga. Já vem com parafusos inclusos.', 'static/produtos/intelbras-pedestal-home-city-ped-0002c.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (21, 'Compatível com EVE 0074H e EVE 0074C', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (21, 'Fácil instalação – parafusos inclusos', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (21, 'Suporte para enrolar cabo de recarga', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (21, 'Passagem interna de cabos de energia e comunicação', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (21, 'Conforto e segurança para instaladores e usuários', 4);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (22, 'pedestal-para-carregador-de-veiculos-eletricos-business-ped-0003b', 'Pedestal para Carregador de Veículos Elétricos Business PED 0003B', 'intelbras', 'protecao', NULL, NULL, 'Instalação da estação Business 7,4 kW em piso', 'Pedestal / Suporte Metálico', 'Pedestal complementar para a estrutura de recarga Business 7,4 kW. Prático e de fácil instalação.', 'Práticos e de fácil instalação, os Pedestais Intelbras garantem conforto e segurança para os instaladores e para os usuários. Permite instalar as estações de recarga Business 7,4 kW no local desejado, oferecendo maior comodidade. Com espaço ideal para passagem dos cabos de energia e comunicação, além de suporte para enrolar o cabo de recarga.', 'static/produtos/intelbras-pedestal-business-74kw-ped-0003b.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (22, 'Compatível com estações Business 7,4 kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (22, 'Fácil instalação – parafusos inclusos', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (22, 'Suporte para enrolar cabo de recarga', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (22, 'Passagem interna de cabos', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (22, 'Conforto e segurança', 4);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (23, 'pedestal-para-carregador-de-veiculos-eletricos-business-22-kw-ped-0004b', 'Pedestal para Carregador de Veículos Elétricos Business 22 kW PED 0004B', 'intelbras', 'protecao', NULL, NULL, 'Instalação da estação Business 22 kW (EVE 0220B) em piso', 'Pedestal / Suporte Metálico', 'Solução complementar para sua estrutura de recarga. O pedestal para carregador Business 22 kW é prático e de fácil instalação.', 'Práticos e de fácil instalação, os Pedestais Intelbras garantem conforto e segurança para instaladores e usuários. Suas estações de recarga podem ser instaladas no local que desejar, oferecendo maior comodidade. Com espaço ideal para passagem dos cabos de energia e comunicação, além de suporte para enrolar o cabo de recarga.', 'static/produtos/intelbras-pedestal-business-22kw-ped-0004b.png');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (23, 'Compatível com EVE 0220B (Business 22 kW)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (23, 'Fácil instalação – parafusos inclusos', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (23, 'Suporte para enrolar cabo de recarga', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (23, 'Passagem interna de cabos de energia e comunicação', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (23, 'Conforto e segurança para instaladores e usuários', 4);

INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (24, 'cabo-adaptador-do-tipo-2-para-o-tipo-2-ew1035', 'Cabo Adaptador do Tipo 2 para o Tipo 2 EW1035', 'ewolf', 'protecao', '7,2 kW', '250VAC Monofásico (1P+N+T)', 'Extensão para veículos tipo 2 em estações tipo 2', 'Cabo Extensão / Adaptador', 'Conecte seu veículo elétrico com facilidade usando o Cabo adaptador do tipo 2 para o tipo 2 EW1035, prático e seguro para carregamento.', 'O Cabo Adaptador Tipo 2 para Tipo 2 EW1035 é a solução perfeita para conectar o seu veículo elétrico a estações de carregamento do mesmo padrão. Com 5 metros de comprimento, oferece flexibilidade e praticidade, permitindo que você carregue seu carro elétrico em diversos locais. Desenvolvido com materiais de alta qualidade, o adaptador garante uma conexão segura e eficiente.', 'static/produtos/ewolf-cabo-adaptador-tipo2-tipo2.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Comprimento de 5 metros – alta flexibilidade de uso', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Conector Tipo 2 em ambas as extremidades (estação e veículo)', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Potência máxima de carga de 7,2 kW', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Grau de proteção IP67 – resistente à imersão', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Leve – apenas 3,8 kg', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Certificação CE', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Operação em temperaturas de -30°C a 50°C', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (24, 'Ideal para uso em casa ou em estações públicas', 7);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (25, 'cabo-adaptador-do-tipo-2-para-o-tipo-1-nr-ew1038', 'Cabo Adaptador do Tipo 2 para o Tipo 1 EW1038', 'ewolf', 'protecao', NULL, '250VAC', 'Compatibilidade de veículos tipo 1 em estações tipo 2', 'Cabo Adaptador', 'Adquira o Cabo adaptador do tipo 2 para o tipo 1 EW1038 e conecte seu veículo elétrico com facilidade e praticidade em estações de carregamento.', 'O Cabo Adaptador Tipo 2 para Tipo 1 EW1038 é essencial para conectar veículos elétricos com plugues Tipo 1 (J1772, padrão americano/japonês) em estações de carregamento Tipo 2 (IEC 62196, padrão europeu/brasileiro). Com 0,5 metro de comprimento, é compacto, leve (1,1 kg) e fácil de transportar no porta-malas. Plug and play – simples e rápido de conectar.', 'static/produtos/ewolf-cabo-adaptador-tipo2-tipo1.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Permite usar veículos Tipo 1 (J1772) em estações Tipo 2', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Compacto – apenas 0,5 metro de comprimento', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Leve – 1,1 kg, fácil de transportar', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Suporta correntes de 16 A e 32 A', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Plug and play – sem configuração', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Certificação CE', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Operação em temperaturas de -30°C a 50°C', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (25, 'Grau de proteção IP54', 7);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (26, 'suporte-solo-para-estacao-de-recarga-ew1023', 'Suporte Solo para Estação de Recarga EW1023', 'ewolf', 'protecao', NULL, NULL, 'Instalação de estações de recarga em piso / solo', 'Suporte Metálico / Pedestal', 'Suporte solo para estação de recarga EW1023 – solução ideal para praticidade e segurança no abastecimento de veículos elétricos.', 'O Suporte Solo para Estação de Recarga EW1023 é a solução ideal para quem busca praticidade e segurança no abastecimento de veículos elétricos. Fabricado em aço carbono de alta qualidade com pintura Epóxi, oferece resistência e durabilidade mesmo em condições climáticas adversas. Com design adaptável, o EW1023 é compatível com diversas estações de abastecimento, permitindo instalação eficaz em qualquer ambiente. Acompanha todas as peças necessárias para montagem rápida e eficiente.', 'static/produtos/ewolf-suporte-solo-ew1023.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Fabricado em aço carbono com pintura Epóxi anticorrosiva', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Compatível com diversas estações de recarga', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Leve para transporte e instalação – apenas 10,5 kg', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Estrutura robusta e estável durante o uso', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Inclui todas as peças para montagem', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Design discreto e moderno', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Espaço interno para passagem de cabos', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (26, 'Resistente a condições climáticas adversas', 7);
INSERT INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (27, 'plugue-tipo-2-32a-macho-ew1015', 'Plugue Tipo 2 32A (Macho) EW1015', 'ewolf', 'protecao', NULL, '220VAC', 'Reposição / montagem de cabo de recarga tipo 2', 'Plugue / Conector', 'Plugue Tipo 2 32A (macho) EW1015, ideal para carregadores elétricos, oferecendo segurança e eficiência em cada recarga.', 'O Plugue Tipo 2 32A (macho) EW1015 é ideal para uso em carregadores elétricos e estações de recarga. Robusto e confiável, é a solução essencial para quem busca eficiência e praticidade em mobilidade elétrica. Com peso de apenas 0,33 kg e dimensões compactas, é fácil de manusear e armazenar. Projetado para suportar altas correntes, assegurando carregamento eficiente e seguro. O cabo elétrico não acompanha o produto.', 'static/produtos/ewolf-plugue-tipo2-32a-macho.webp');
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Conector Tipo 2 macho (lado estação/carregador)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Suporta até 32 A', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Grau de proteção IP65', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Leve – apenas 0,33 kg', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Design ergonômico para fácil encaixe', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Operação em temperaturas de -30°C a 50°C', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (27, 'Ideal para reposição ou montagem de cabos customizados', 6);
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EW-QP22-ST', 2, 'Sem tomada industrial', 'Saída direta por prensa-cabos blindados PG21 para alimentação física contínua da estação.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EW-QP22-CT', 2, 'Com tomada industrial', 'Equipado com uma tomada industrial vermelha de alta potência de 32A 3P+N+T instalada no chassi inferior do quadro.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EV-380-W1', 3, 'Instalação em parede (1 conector)', 'Unidade clássica de montagem em parede com 1 conector e suporte para organizar o cabo quando ocioso.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EV-380-W2', 3, 'Versão com 2 conectores de saída', 'Fornece dois cabos independentes com divisão e balanceamento automático de carga trifásica dinâmica.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EV-CCS-P1', 4, '1 plug CCS2 de saída', 'Foco em pátios industriais e recargas de frotas unitárias rápidas sem paradas intermediárias.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EV-CCS-P2', 4, 'Versão com 2 plugs CCS2', 'Divisão de potência compartilhada dinâmica inteligente para recarga de dois carros elétricos simultâneos.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('CP-220-NBR', 8, 'Plug NBR 14136 (Tomada Comum)', 'Apresenta cabo com plug padrão nacional brasileiro de 3 pinos de 20A, limitando a recarga automática a 16A de corrente contínua para segurança térmica.');
INSERT INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('CP-220-IND', 8, 'Plug Industrial CEE Azul (32A)', 'Equipado com plug industrial CEE de 3 pinos azuis 32A, permitindo a extração máxima de 32A de corrente contínua (7,4 kW) sem risco de derreter a fiação.');

-- Especificações do Produto ID 1 (Monofásico/Bifásico - Sem Tomada)
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Potência Nominal', '7,2 kW (32A)', 0);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Tensão Operacional', '220VAC (Monofásico F+N ou Bifásico F+F)', 1);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Disjuntor', 'Bipolar 32A Curva C (6kA)', 2);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Interruptor DR', 'Bipolar 40A / 30mA Classe A', 3);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'DPS Surto', 'Bipolar 20/40kA 275V Classe II', 4);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Grau de Vedação', 'IP65 (Instalação interna ou externa)', 5);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (1, 'Saída de Energia', 'Prensa-cabo direto nos bornes internos', 6);

-- Especificações do Produto ID 39 (Monofásico/Bifásico - Com Tomada)
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Potência Nominal', '7,2 kW (32A)', 0);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Tensão Operacional', '220VAC (Monofásico F+N ou Bifásico F+F)', 1);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Disjuntor', 'Bipolar 32A Curva C (6kA)', 2);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Interruptor DR', 'Bipolar 40A / 30mA Classe A', 3);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'DPS Surto', 'Bipolar 20/40kA 275V Classe II', 4);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Grau de Vedação', 'IP65 (Gabinete) / IP44 (Tomada acoplada)', 5);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (39, 'Saída de Energia', 'Tomada Industrial Azul 32A 2P+T padrão IEC 60309', 6);

-- Especificações do Produto ID 40 (Trifásico - Sem Tomada)
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Potência Nominal', '7,2 kW / 22 kW Trifásico', 0);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Tensão Operacional', '380VAC Trifásico (L1+L2+L3+N+Terra)', 1);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Disjuntor', 'Tetrapolar 40A Curva C (6kA)', 2);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Interruptor DR', 'Tetrapolar 40A / 30mA Classe A', 3);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'DPS Surto', 'Tetrapolar 20/40kA 275V Classe II', 4);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Grau de Vedação', 'IP65 (Instalação interna ou externa)', 5);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (40, 'Saída de Energia', 'Prensa-cabo direto nos bornes internos', 6);

-- Especificações do Produto ID 41 (Trifásico - Com Tomada)
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Potência Nominal', '7,2 kW / 22 kW Trifásico', 0);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Tensão Operacional', '380VAC Trifásico (L1+L2+L3+N+Terra)', 1);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Disjuntor', 'Tetrapolar 40A Curva C (6kA)', 2);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Interruptor DR', 'Tetrapolar 40A / 30mA Classe A', 3);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'DPS Surto', 'Tetrapolar 20/40kA 275V Classe II', 4);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Grau de Vedação', 'IP65 (Gabinete) / IP44 (Tomada acoplada)', 5);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (41, 'Saída de Energia', 'Tomada Industrial Vermelha 32A 3P+N+T padrão IEC 60309', 6);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Potência Nominal', '22 kW (3 fases de 32A)', 7);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Tensão Operacional', '380VAC Trifásico + Neutro + Terra', 8);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Disjuntor', 'Tetrapolar 40A Curva C (10kA)', 9);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Interruptor DR', 'Tetrapolar 40A / 30mA Classe A', 10);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'DPS Surto', 'Tetrapolar 20/40kA 275V Classe II', 11);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Grau de Vedação', 'IP65 (Instalação industrial)', 12);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (2, 'Conexão Entrada', 'Cabos de até 16 mm²', 13);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Potência Máxima', '22 kW Trifásico / Ajustável a patamares menores', 14);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Tensão', '380VAC Trifásico (L1+L2+L3+N+PE)', 15);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Conector Veículo', 'Tipo 2 (IEC 62196-2) de 5 metros', 16);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Leitor de Cartão', 'Opcional (RFID integrado)', 17);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Grau de Proteção', 'IP65 com dreno de condensação', 18);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (3, 'Norma Internacional', 'IEC 61851-1 para segurança eletrônica', 19);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Tipo de Corrente', 'DC (Corrente Contínua direta na bateria)', 20);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Protocolo OCPP', 'OCPP 1.6J JSON nativo', 21);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Identificação', 'Cartão de acesso RFID / Login APP / OCPP', 22);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Conectividade', '4G GPRS / Porta Ethernet RJ45 / Wi-Fi', 23);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Conector Veicular', 'CCS Combo 2 de alto torque térmico', 24);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (4, 'Proteções Internas', 'Fugas DC, sobretensão, curto e aterramento flutuante', 25);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Potência', '7,4 kW (7.400 Watts por hora)', 26);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Tensão Elétrica', '220V Monofásico (ou Bifásico F+F)', 27);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Corrente Máxima', '32A fixos', 28);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Cabo Integrado', 'Cabo resistente de 5 metros de raio', 29);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Conector', 'Tipo 2 automotivo universal', 30);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (5, 'Grau IP', 'IP54 (Proteção contra chuva leve e poeira moderada)', 31);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Potência', '7,4 kW ajustáveis por software', 32);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Tensão', '220VAC Monofásico', 33);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Rede Móvel/Sem Fio', 'Wi-Fi + Bluetooth + Suporte a OCPP 1.6J local', 34);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Aplicativo', 'Disponível gratuitamente para iOS e Android', 35);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Chassi Externo', 'Vidro temperado preto anti-riscos de alta resistência', 36);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (6, 'Grau de Proteção', 'IP65', 37);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (7, 'Potência Máxima', '22 kW', 38);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (7, 'Alimentação Elétrica', '380VAC Trifásico (3 Fases + Neutro + Terra)', 39);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (7, 'Conector', 'Tipo 2 automotivo de 5 metros inclusos', 40);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (7, 'Grau IP', 'IP54 para garagens abertas com coberturas comuns', 41);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (7, 'Operação', 'Plug & Charge instantâneo', 42);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Potência Máxima', 'Até 7,4 kW (Ajustável a níveis inferiores)', 43);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Tensão', '220VAC Monofásico (110V suportado com potência proporcional)', 44);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Corrente Regulável', 'Passos de 8A, 10A, 13A, 16A, 24A e 32A', 45);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Conector Veicular', 'Tipo 2 com cabo flexível de 5 metros úteis', 46);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Grau de Proteção', 'Gabinete IP66 (Resiste a chuvas fortes sob carga)', 47);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (8, 'Certificados', 'TUV, CE, RoHS', 48);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Material Base', 'Aço Carbono SAE 1020 de alta espessura', 49);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Tratamento Superfície', 'Galvanização anticorrosiva + Pintura Epóxi Texturizada a pó', 50);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Teto Protetor', 'Policarbonato Alveolar Premium com travessas metálicas', 51);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Altura Útil', '1650 mm', 52);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Compatibilidade', 'Universal para carregadores E-Wolf, Intelbras, Incharge, etc.', 53);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (9, 'Fixação', 'Placa base de 300x300mm com 4 chumbadores quimicos/mecânicos', 54);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Material Principal', 'Chapa de Aço SAE 1020 soldada de alta integridade', 55);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Pintura Protetora', 'Eletrostática a pó texturizada preta microtextura', 56);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Altura', '1500 mm', 57);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Área da Base', '200mm x 200mm', 58);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Passagem de Cabos', 'Furação interna com anéis de borracha protetores', 59);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (10, 'Peso Líquido', '14,5 kg', 60);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Conexão Elétrica', 'F+N+T ou 2F+T', 61);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Tensão Nominal', '100–240 V (±10%)', 62);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Corrente Nominal', '32 A', 63);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Frequência', '50/60 Hz', 64);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Tensão de Saída', '230 V (±10%)', 65);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Corrente Máxima', '32 A', 66);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Potência Nominal', '7,4 kW (7,0 kW em 220 V)', 67);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Conector do Carregador', 'Tipo 2 (Europeu)', 68);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Comprimento do Cabo', '4 metros', 69);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Invólucro', 'Plástico PC940', 70);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Indicador LED', 'Verde / Amarela / Vermelha', 71);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Leitor RFID', 'Mifare ISO/IEC 14443 A', 72);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Modo de Início', 'Plug&Play / Cartão RFID', 73);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Parada de Emergência', 'Sim', 74);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Detecção de Corrente de 6 mA CC', 'Sim', 75);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Grau de Proteção', 'IP65', 76);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Proteções Elétricas', 'Sobrecorrente, corrente residual, surtos elétricos, sobre/subtensão, sobre/subfrequência, sobre/subtemperatura', 77);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (11, 'Instalação', 'Montagem de parede / Montagem em pedestal', 78);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Conexão Elétrica', 'F+N+T ou 2F+T', 79);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Tensão Nominal', '230 V (±10%)', 80);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Corrente Nominal', '32 A', 81);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Frequência', '50/60 Hz', 82);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Tensão de Saída', '230 V (±10%)', 83);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Corrente Máxima', '32 A', 84);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Potência Nominal', '7,4 kW (7,0 kW em 220 V)', 85);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Conector do Carregador', 'Tipo 2 (Europeu)', 86);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Comprimento do Cabo', '4 metros', 87);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Invólucro', 'Plástico PC940', 88);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Indicador LED', 'Verde / Amarela / Vermelha', 89);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Display LCD', 'Não', 90);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Leitor RFID', 'Mifare ISO/IEC 14443 A', 91);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Modo de Início', 'Plug&Play / Cartão RFID / APP', 92);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Parada de Emergência', 'Não', 93);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Wi-Fi', 'Sim, 2.4 GHz', 94);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Bluetooth', 'Sim', 95);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'OCPP', 'Sim, 1.6 JSON', 96);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Plataforma de Gestão', 'Sim', 97);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Detecção de Corrente de 6 mA CC', 'Sim', 98);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Grau de Proteção', 'IP65', 99);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Proteções Elétricas', 'Sobrecorrente, corrente residual, surtos elétricos, sobre/subtensão, sobre/subfrequência, sobre/subtemperatura', 100);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Certificação', 'CE – IEC 61851-1:2017, IEC 61851-21-2:2018, IEC 62196-1, IEC 62196-2', 101);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Instalação', 'Montagem de parede / Montagem em pedestal', 102);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (12, 'Código Intelbras', '4820095', 103);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Conexão Elétrica', '3F+N+T', 104);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Tensão Nominal', '400 V (±10%)', 105);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Corrente Nominal', '16 A', 106);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Frequência', '50/60 Hz', 107);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Tensão de Saída', '400 V (±10%)', 108);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Corrente Máxima', '16 A', 109);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Potência Nominal', '11 kW', 110);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Conector do Carregador', 'Tipo 2 (Europeu)', 111);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Comprimento do Cabo', '4 metros', 112);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Invólucro', 'Plástico PC940', 113);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Indicador LED', 'Verde / Amarela / Vermelha', 114);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Leitor RFID', 'Mifare ISO/IEC 14443 A', 115);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Modo de Início', 'Plug&Play / Cartão RFID / APP', 116);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Wi-Fi', 'Sim, 2.4 GHz', 117);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Bluetooth', 'Sim', 118);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'OCPP', 'Sim, 1.6 JSON', 119);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Plataforma de Gestão', 'Sim', 120);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Detecção de Corrente de 6 mA CC', 'Sim', 121);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Grau de Proteção', 'IP65', 122);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Proteções Elétricas', 'Sobrecorrente, corrente residual, aterramento, surtos, sobre/subtensão, sobre/subfrequência, sobre/subtemperatura', 123);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Certificação', 'CE – IEC 61851-1:2017, IEC 61851-21-2:2018', 124);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Instalação', 'Montagem de parede / Montagem em pedestal', 125);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (13, 'Código Intelbras', '4820100', 126);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Conexão Elétrica', '3F+N+T', 127);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Tensão Nominal', '400 V (±10%)', 128);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Potência Nominal', '22 kW', 129);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Conector do Carregador', 'Tipo 2 (Europeu)', 130);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Comprimento do Cabo', '4 metros', 131);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Gabinete', 'Aço galvanizado', 132);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Painel Frontal', 'Vidro temperado', 133);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Leitor RFID', 'Sim', 134);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Modo de Início', 'Plug&Play / Cartão RFID / APP', 135);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Display', 'Sim', 136);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'OCPP', 'Sim, 1.6', 137);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Plataforma de Gestão', 'Sim', 138);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Grau de Proteção', 'IP65', 139);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Proteções Elétricas', 'Sobrecorrente, corrente residual, surtos, sobre/subtensão, sobre/subfrequência, sobre/subtemperatura', 140);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Instalação', 'Montagem de parede / Montagem em pedestal', 141);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (14, 'Código Intelbras', '4820098', 142);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Conexão Elétrica Entrada', '3F+N+T', 143);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Tensão Nominal Entrada', '400 VAC (±10%)', 144);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Corrente Nominal Entrada', '32 A', 145);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Frequência', '50/60 Hz', 146);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Esquema de Aterramento', 'TN-S, TN-C, TN-C-S, TT', 147);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Consumo em Stand-by', '< 20 W', 148);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Fator de Potência', '≥ 0,98 (em 30 kW)', 149);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'THDc', '≤ 5% (em 30 kW)', 150);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Tensão de Saída CC', '150 – 1000 V', 151);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Corrente Máxima Saída', '100 A', 152);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Potência Nominal', '30 kW', 153);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Eficiência', '≥ 94% (em 30 kW)', 154);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Eficiência Máxima', '95%', 155);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Medição na Saída', 'Sim, Classe 0,5 (shunt)', 156);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Conector', 'CCS2', 157);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Comprimento do Cabo', '5 metros', 158);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Display', '7" touchscreen colorido', 159);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Grau de Proteção', 'IP55 (gabinete) / IP54 (conector solto) / IP67 (conector conectado)', 160);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Resistência a Impacto', 'IK10', 161);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Autenticação', 'APP / RFID / Plug&Play / Autocharge', 162);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Comunicação', '4G, Wi-Fi, Ethernet', 163);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Protocolo', 'OCPP 1.6', 164);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Proteções Internas', 'DPS Classe II 20 kA, IDR Tipo A 63 A', 165);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Gabinete', 'Alumínio', 166);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (15, 'Garantia', '2 anos', 167);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Conexão Elétrica Entrada', '3F+N+T', 168);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Tensão Nominal Entrada', '400 V (±10%)', 169);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Tensão Operacional', '380–400 V (±10%)', 170);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Faixa de Tensão', '342 V – 440 V', 171);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Corrente Nominal Entrada', '100 A', 172);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Esquema de Aterramento', 'TN-S, TN-C, TN-C-S, TT', 173);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Frequência', '50/60 Hz (detecção automática)', 174);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Tensão de Saída CC', '150 – 1000 V', 175);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Corrente Máxima por Saída', '200 A', 176);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Número de Saídas', '2 x CCS2', 177);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Potência Nominal', '60 kW', 178);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Eficiência', '≥ 94%', 179);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Conector', 'CCS2', 180);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Comprimento do Cabo', '5 metros por saída', 181);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Display', '7" touchscreen colorido', 182);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Grau de Proteção', 'IP55', 183);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Resistência a Impacto', 'IK10', 184);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Gabinete', 'Aço inoxidável', 185);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Autenticação', 'APP / RFID / Plug&Play / Autocharge', 186);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Comunicação', '4G, Wi-Fi, Ethernet', 187);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (16, 'Protocolo', 'OCPP 1.6', 188);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Tensão de Saída CC', '150 – 1000 V', 189);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Corrente Máxima por Saída', '200 A', 190);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Número de Saídas', '2 x CCS2', 191);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Potência Nominal', '80 kW', 192);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Eficiência', '97%', 193);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Conector', 'CCS2', 194);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Comprimento do Cabo', '5 metros por saída', 195);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Display', '10" touchscreen colorido', 196);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Grau de Proteção', 'IP55', 197);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Resistência a Impacto', 'IK10', 198);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Gabinete', 'Aço inoxidável', 199);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Autenticação', 'APP / RFID / Plug&Play / Autocharge', 200);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Comunicação', '4G, Wi-Fi, Ethernet', 201);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Protocolo', 'OCPP 1.6', 202);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (17, 'Código Intelbras', '4300892', 203);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Tensão de Saída CC', '150 – 1000 V', 204);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Número de Saídas', '2 x CCS2', 205);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Potência Nominal', '120 kW', 206);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Conector', 'CCS2', 207);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Grau de Proteção', 'IP55', 208);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Autenticação', 'APP / RFID / Plug&Play / Autocharge', 209);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Comunicação', '4G, Wi-Fi, Ethernet', 210);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (18, 'Protocolo', 'OCPP 1.6', 211);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Tensão de Saída CC', '150 – 1000 V', 212);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Corrente Máxima Saída', '300 A (2 saídas)', 213);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Número de Saídas', '2 x CCS2', 214);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Potência Nominal', '180 kW', 215);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Conector', 'CCS2', 216);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Grau de Proteção', 'IP55', 217);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Autenticação', 'APP / RFID / Plug&Play / Autocharge', 218);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Comunicação', '4G, Wi-Fi, Ethernet', 219);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Protocolo', 'OCPP 1.6', 220);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (19, 'Código Intelbras', '4300384', 221);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (20, 'Compatibilidade', 'EVE 0300FP (30 kW DC)', 222);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (20, 'Tipo', 'Pedestal de piso', 223);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (20, 'Instalação', 'Fixação em piso', 224);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (21, 'Compatibilidade', 'EVE 0074H (7,4 kW Home) e EVE 0074C (7,4 kW City)', 225);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (21, 'Tipo', 'Pedestal de piso', 226);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (21, 'Instalação', 'Fixação em piso', 227);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (21, 'Acessórios Inclusos', 'Parafusos para instalação', 228);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (21, 'Código Intelbras', '4820101', 229);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (22, 'Compatibilidade', 'EVE 0074B (Business 7,4 kW)', 230);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (22, 'Tipo', 'Pedestal de piso', 231);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (22, 'Instalação', 'Fixação em piso', 232);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (22, 'Acessórios Inclusos', 'Parafusos para instalação', 233);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (23, 'Compatibilidade', 'EVE 0220B (Business 22 kW)', 234);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (23, 'Tipo', 'Pedestal de piso', 235);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (23, 'Instalação', 'Fixação em piso', 236);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (23, 'Código Intelbras', '4820102', 237);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'SKU / Referência', 'EW1035', 238);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Corrente Elétrica', '32 A', 239);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Tensão', '250 VAC Monofásico (1P+N+T)', 240);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Potência Máxima de Carga', '7,2 kW', 241);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Adaptador', 'Plug tipo 2 (estação) / Veículo tipo 2', 242);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Comprimento do Cabo', '5 metros (5000 mm)', 243);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Dimensões', '(C) 5000 mm x (L) 70 mm x (A) 70 mm', 244);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Peso', '3,8 kg', 245);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Grau de Proteção', 'IP67', 246);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Temperatura de Trabalho', '-30°C a 50°C', 247);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (24, 'Certificação', 'CE', 248);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'SKU / Referência', 'EW1038', 249);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Corrente Elétrica', '16 A / 32 A', 250);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Alimentação', '250 VAC', 251);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Adaptador', 'Soquete tipo 2 (estação) / Veículo tipo 1', 252);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Comprimento do Cabo', '0,5 metro (500 mm)', 253);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Dimensões', '(A) 120 mm x (L) 120 mm x (C) 900 mm', 254);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Peso', '1,1 kg', 255);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Grau de Proteção', 'IP54', 256);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Temperatura de Trabalho', '-30°C a 50°C', 257);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (25, 'Certificação', 'CE', 258);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'SKU / Referência', 'EW1023', 259);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Material', 'Aço carbono', 260);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Acabamento', 'Pintura Epóxi', 261);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Peso', '10,5 kg', 262);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Dimensões', '(C) 400 mm x (L) 400 mm x (A) 1200 mm', 263);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Tipo de Instalação', 'Fixação em solo / piso', 264);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (26, 'Acompanha', 'Todas as peças e parafusos para instalação', 265);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'SKU / Referência', 'EW1015', 266);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Corrente Elétrica', '32 A', 267);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Alimentação', '220 VAC', 268);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Conector', 'Tipo 2 (macho)', 269);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Dimensões', '(C) 218 mm x (L) 60 mm x (A) 90 mm', 270);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Peso', '0,33 kg', 271);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Grau de Proteção', 'IP65', 272);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Temperatura de Trabalho', '-30°C a 50°C', 273);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (27, 'Cabo Elétrico', 'Não acompanha', 274);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (1, 'lei-no-18403-o-que-muda-na-instalacao-de-carregadores-de-veiculos-eletricos-em-condominios', 'Lei nº 18.403: o que muda na instalação de carregadores de veículos elétricos em condomínios', 'Legislação', 'Entenda os impactos legais, direitos dos proprietários e as exigências técnicas impostas pela nova lei paulista para a infraestrutura de recarga em garagens prediais.', 'Bruno Riêra', 'Diretor de Engenharia da VoltchZ Brasil', '15 Abr, 2026', '9 min', 'estacoes', 'Lei nº 18.403', 'Legislação');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (1, 1, 'heading', 'O Marco Legal dos Condomínios e a Mobilidade Elétrica', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (2, 1, 'paragraph', 'A recente promulgação da Lei Estadual nº 18.403 no estado de São Paulo trouxe regras muito claras e segurança jurídica para um debate que antes causava grandes desavenças em assembleias de condomínio: a instalação de infraestrutura para carregadores de veículos elétricos em garagens compartilhadas e privativas.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (3, 1, 'paragraph', 'Antes da lei, muitos síndicos e comissões de moradores barravam as instalações alegando riscos de incêndio, sobrecarga de transformadores ou falta de acordo na divisão de despesas. Agora, a legislação estipula direitos claros, mas também impõe pesadas exigências técnicas de responsabilidade civil e de engenharia que precisam ser rigorosamente atendidas.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (4, 1, 'heading', 'Principais Mudanças e Direitos Assegurados pela Lei', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (5, 1, 'paragraph', 'O ponto de partida mais importante da Lei nº 18.403 é que o proprietário de vaga privativa demarcada em garagem coletiva tem o direito legítimo de instalar um carregador individual de veículo elétrico. O condomínio não pode proibir a instalação de forma arbitrária, desde que o condômino arque com todos os custos do ramal individual e atenda aos requisitos técnicos exigidos pelo síndico.', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (6, 1, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'Direito de instalação individual in vagas privativas autônomas ou vinculadas ao apartamento.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'Proibição de barramento injustificado por parte da administração do condomínio sem embasamento técnico.', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'Obrigatoriedade de medição individualizada da energia gasta pelo carregador via medidor próprio.', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'Necessidade de apresentação prévia de projeto técnico assinado por engenheiro habilitado com ART registrada.', 3);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'O custeio da obra de infraestrutura é integralmente de responsabilidade do condômino solicitante.', 4);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (6, 'A administração tem até 60 dias para analisar e responder formalmente ao pedido de instalação.', 5);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (7, 1, 'blockquote', 'A segurança da infraestrutura do condomínio é prioritária. O direito à instalação existe, mas está condicionado à comprovação física de viabilidade técnica através de uma Anotação de Responsabilidade Técnica (ART).', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (8, 1, 'heading', 'Exigências Técnicas Obrigatórias e o Papel do Estudo de Viabilidade', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (9, 1, 'paragraph', 'Para exercer o direito de instalação, o morador ou a empresa contratada deve fornecer à administração do condomínio um dossiê técnico detalhado. Esse documento deve conter um Estudo de Viabilidade Elétrica completo, comprovando que o ramal individual não causará um desequilíbrio de fases e que o transformador geral suportará a nova demanda permanente.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (10, 1, 'paragraph', 'Na VoltchZ Brasil, realizamos este estudo in loco utilizando analisadores de curva de carga certificados. Mapeamos a real capacidade do condomínio, analisamos o histórico de consumo de no mínimo 12 meses e fornecemos a documentação exata de engenharia com a respectiva ART, blindando legalmente o síndico e o morador contra quaisquer questionamentos jurídicos ou riscos operacionais.', '', 9);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (11, 1, 'heading', 'Responsabilidade do Síndico e Penalidades pelo Descumprimento', '', 10);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (12, 1, 'paragraph', 'A lei também é clara quanto às obrigações dos síndicos. Negar arbitrariamente, sem embasamento técnico devidamente documentado, o pedido de instalação de carregador por parte de condômino proprietário de vaga demarcada pode configurar abuso de poder administrativo e sujeitar o condomínio a responder judicialmente por danos materiais e morais ao morador.', '', 11);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (13, 1, 'paragraph', 'Por outro lado, autorizar a instalação sem exigir a documentação técnica obrigatória — especialmente o projeto elétrico assinado e a ART — pode responsabilizar diretamente o síndico em caso de acidentes ou danos à infraestrutura predial comum. O equilíbrio está na conformidade técnica rigorosa, que protege todas as partes envolvidas.', '', 12);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (14, 1, 'heading', 'Como a VoltchZ Atua no Processo de Conformidade Legal', '', 13);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (15, 1, 'paragraph', 'Nossa equipe de engenharia atua em todas as etapas do processo de conformidade com a Lei nº 18.403: desde o levantamento técnico inicial da rede elétrica do condomínio, passando pelo dimensionamento do ramal dedicado e seleção dos dispositivos de proteção obrigatórios (DR Classe A ou B, DPS, disjuntor de Curva C), até a emissão da ART e entrega do relatório final para arquivo junto à administração condominial.', '', 14);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (2, 'a-escolha-certa-carregador-tipo-a-ac-ou-b-para-carros-eletricos', 'A Escolha Certa: Dispositivo DR Tipo A, AC ou B para Carros Elétricos?', 'Segurança', 'Você sabe por que o disjuntor diferencial residual (DR) comum de tomada não serve para recarga de carros elétricos? Conheça as diferenças técnicas vitais.', 'Bruno Riêra', 'Diretor de Engenharia da VoltchZ Brasil', '08 Mar, 2026', '10 min', 'protecao', 'DR Tipo A vs B', 'Segurança');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (16, 2, 'heading', 'O que é um Dispositivo DR e por que ele é crucial?', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (17, 2, 'paragraph', 'O Dispositivo Diferencial Residual (DR) é um item de segurança obrigatório em qualquer instalação elétrica de baixa tensão pela NBR 5410. Sua função primordial é monitorar, em tempo real e de forma contínua, a corrente que entra e a que retorna de um circuito. Toda corrente que entra deve sair pelo mesmo caminho — se isso não acontecer, significa que houve fuga para terra, possivelmente passando pelo corpo de uma pessoa ou causando risco de incêndio.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (18, 2, 'paragraph', 'Se houver qualquer fuga de corrente, o DR detecta a anomalia em milissegundos e desarma o circuito instantaneamente, salvando vidas. No entanto, a recarga de veículos elétricos introduz desafios muito específicos que a maioria dos eletricistas tradicionais simplesmente ignora, gerando instalações clandestinas e de altíssimo risco com dispositivos DR completamente inadequados para esta aplicação.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (19, 2, 'heading', 'Classificações dos Dispositivos DR: AC, A e B', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (20, 2, 'paragraph', 'Existem diferentes classes de DR, categorizados conforme o tipo de onda de corrente de fuga que são capazes de identificar e interromper com segurança:', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (21, 2, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (21, 'DR Classe AC: O mais comum e barato do mercado nacional. Detecta apenas correntes de fuga alternadas puras (senoidais). É absolutamente ineficaz para o carregamento de carros elétricos, pois o carregador do veículo converte a energia AC da tomada em DC para a bateria e gera fugas em corrente contínua pulsante que "cegam" completamente o DR Classe AC, impedindo-o de desarmar mesmo diante de um acidente grave.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (21, 'DR Classe A: Detecta correntes de fuga senoidais alternadas e também correntes de fuga contínuas pulsantes (padrão em inversores e fontes chaveadas de veículos elétricos). É a classe recomendada e tecnicamente obrigatória como ponto de entrada mínimo para proteção de Wallboxes residenciais e comerciais monofásicos de até 7,4 kW.', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (21, 'DR Classe B: O mais completo e preciso do mercado. Detecta todos os tipos de fuga — alternadas senoidais, contínuas pulsantes e contínuas lisas puras (corrente DC limpa). É mandatório em redes trifásicas industriais de alta potência, carregadores comerciais OCPP rápidos (22 kW a 150 kW), hubs públicos e frota corporativa.', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (22, 2, 'blockquote', 'Utilizar um DR Classe AC em um carregador de veículo elétrico é o equivalente a não possuir nenhuma proteção. O DR sofrerá saturação magnética e simplesmente não funcionará no momento mais crítico — quando houver um choque elétrico real.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (23, 2, 'heading', 'O Risco Real da Saturação DC no DR Tipo AC', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (24, 2, 'paragraph', 'O fenômeno técnico que explica a falha do DR Classe AC em instalações de EV se chama saturação magnética por componente DC. Qualquer corrente contínua mínima, mesmo que inferior a 6mA, que flua pelo núcleo toroidal do DR Classe AC satura permanentemente o núcleo magnético do dispositivo. Uma vez saturado, o transformador diferencial interno deixa de detectar qualquer variação de corrente — inclusive o choque elétrico fatal de uma pessoa.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (25, 2, 'paragraph', 'Esse risco é real, documentado por laboratórios de certificação europeus como o PTB alemão e o KEMA holandês, e é exatamente por isso que a norma IEC 62955 (adotada internacionalmente para proteção de EVSEs) tornou obrigatório o DR Classe A como mínimo absoluto em qualquer ponto de recarga de veículo elétrico.', '', 9);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (26, 2, 'heading', 'Como a VoltchZ Seleciona e Certifica os DRs dos seus Projetos', '', 10);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (27, 2, 'paragraph', 'Para instalações residenciais monofásicas de até 7,4 kW, os quadros de proteção da linha E-Wolf da VoltchZ saem de fábrica obrigatoriamente equipados com DR Bipolar de Classe A com sensibilidade de 30mA, fabricados pela Schneider Electric ou ABB, marcas homologadas pelo INMETRO.', '', 11);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (28, 2, 'paragraph', 'Para estações de 22 kW trifásicas em condomínios e pátios comerciais, integramos DR Tetrapolar Classe A de alta sensibilidade (10mA ou 30mA). Para pátios de recarga corporativos rápidos acima de 40 kW ou com múltiplos carregadores em paralelo, o projeto pode exigir DR Classe B para garantia total de proteção contra qualquer tipo de fuga — cumprindo integralmente as rigorosas normas IEC 61851-1 e IEC 62955.', '', 12);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (3, 'disjuntor-corretamente-dimensionado', 'Disjuntor Corretamente Dimensionado', 'Infraestrutura', 'Disjuntores não são todos iguais. Conheça as curvas de disparo B, C e D e descubra qual modelo deve resguardar a fiação em recargas prolongadas sob potência máxima.', 'Bruno Riêra', 'Diretor de Engenharia da VoltchZ Brasil', '22 Fev, 2026', '8 min', 'protecao', 'Disjuntor Curvas C', 'Disjuntores');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (29, 3, 'heading', 'Por que a Recarga de EV Exige um Disjuntor Especial?', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (30, 3, 'paragraph', 'Diferente de um chuveiro elétrico ou de um forno de micro-ondas, que funcionam por poucos minutos de cada vez, o carregador de um carro elétrico é uma carga contínua prolongada de altíssima exigência. Ele drenará a corrente nominal máxima do circuito — por exemplo, 32A de forma absolutamente constante — por 4, 6 ou até 10 horas seguidas durante a madrugada, enquanto o proprietário dorme.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (31, 3, 'paragraph', 'Sob esse regime térmico e magnético rigoroso e ininterrupto, qualquer erro de especificação no disjuntor de proteção geral gerará disparos térmicos indesejados devido ao calor acumulado nos bornes e na bimetálica interna do disjuntor. No pior cenário, um disjuntor subdimensionado ou de curva errada pode não disparar a tempo em situação de sobrecarga e permitir o aquecimento e derretimento do próprio cabeamento de alimentação.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (32, 3, 'heading', 'Entendendo as Curvas de Disparo: B, C e D', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (33, 3, 'paragraph', 'Os disjuntores termomagnéticos residenciais e comerciais se dividem fundamentalmente por curvas de atuação, que delimitam o tempo de atuação térmica (proteção contra sobrecarga gradual) e magnética (proteção contra curto-circuito instantâneo):', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (34, 3, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (34, 'Curva B: Indicado para circuitos puramente resistivos (aquecedores a resistência, lâmpadas incandescentes, chuveiros). Dispara de 3 a 5 vezes a corrente nominal em situação de curto-circuito. Totalmente inadequado para recargas de EV, pois a corrente de partida de um EVSE pode causar falsas viagens.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (34, 'Curva C: Indicado para cargas com componentes indutivos e fontes chaveadas com pico de partida moderado (ar-condicionado, motores pequenos, carregadores EVSE potentes). Dispara entre 5 e 10 vezes a corrente nominal. É a curva correta e obrigatória para disjuntores de circuito dedicado de carregadores de EV.', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (34, 'Curva D: Indicado para motores industriais pesados e transformadores de grande porte com altíssimos picos de partida instantâneos (7 a 10 vezes). Desnecessário e contraindicado para instalações EVSE residenciais e comerciais padrão.', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (35, 3, 'blockquote', 'Ao projetar o painel E-Wolf, aplicamos um fator de sobredimensionamento térmico de 25% na carcaça e nos bornes de fixação dos disjuntores gerais de Curva C de alta capacidade de ruptura (6kA ou 10kA), prevenindo disparos falsos causados por acúmulo de calor e protegendo a fiação interna contra envelhecimento prematuro do isolamento.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (36, 3, 'heading', 'Capacidade de Ruptura: O Parâmetro que Ninguém Vê na Etiqueta', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (37, 3, 'paragraph', 'Além da curva de disparo e da corrente nominal, existe um terceiro parâmetro crítico e frequentemente ignorado pelos instaladores amadores: a capacidade de ruptura em curto-circuito (Icu), medida em kA. Esse valor representa a máxima corrente de defeito que o disjuntor consegue interromper com segurança sem explodir internamente.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (38, 3, 'paragraph', 'Em condomínios e edifícios comerciais com transformadores de maior potência, as correntes prospectivas de curto-circuito podem alcançar 10kA ou 15kA nos pontos de distribuição mais próximos do trafo. Instalar um disjuntor com Icu de apenas 3kA nesse cenário representa risco de explosão do dispositivo em caso de falha grave.', '', 9);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (39, 3, 'heading', 'Fator de Agrupamento e Temperatura Ambiente', '', 10);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (40, 3, 'paragraph', 'Outro ponto negligenciado é o fator de correção de agrupamento e temperatura. Quando múltiplos disjuntores são instalados lado a lado em um quadro fechado, o calor acumulado de todos eles juntos eleva a temperatura interna do painel. Isso reduz efetivamente a corrente que cada disjuntor consegue conduzir sem disparar por temperatura. Um disjuntor de 32A em um painel com 6 disjuntores agrupados em temperatura ambiente de 35°C precisa ser recalculado para garantir que não haja disparo falso.', '', 11);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (4, 'escolha-do-cabo-certo-na-instalacao-de-carregadores-para-veiculos-eletricos', 'Escolha do Cabo Certo na Instalação de Carregadores para Veículos Elétricos', 'Infraestrutura', 'Calculando a queda de tensão e a seção nominal ideal dos fios condutores para distâncias longas em pátios de estacionamento descobertos.', 'Bruno Riêra', 'Diretor de Engenharia da VoltchZ Brasil', '10 Fev, 2026', '8 min', 'suportes', 'Seção de Cabos', 'Cabo Elétrico');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (41, 4, 'heading', 'Por que o cálculo padrão do eletricista pode comprometer sua instalação?', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (42, 4, 'paragraph', 'Um dos erros mais graves e frequentes que encontramos em pátios de condomínio, garagens de casas e instalações comerciais é o subdimensionamento da fiação de cobre alimentadora do carregador. Muitos instaladores sem formação técnica específica utilizam cabos de 4 mm² ou 6 mm² para distâncias de 30 ou 40 metros sob corrente constante de 32A, baseando-se apenas em tabelas genéricas de condução de corrente de curta duração.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (43, 4, 'paragraph', 'Em circuitos longos operando como cargas contínuas prolongadas, um fator crítico entra em cena e invalida completamente esse cálculo simplificado: a queda de tensão ao longo do condutor. A resistência ôhmica do cobre gera perdas que se manifestam como aquecimento do cabo e redução da tensão que efetivamente chega ao carregador.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (44, 4, 'heading', 'O Impacto Real da Queda de Tensão no Desempenho do Carregador', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (45, 4, 'paragraph', 'Se a tensão cair de 220V para 190V no terminal do EVSE, as consequências são múltiplas e sérias: a potência de carga efetiva cai proporcionalmente ao quadrado da tensão (lei de Joule), aumentando dramaticamente o tempo de recarga completa da bateria. O sistema de comunicação de baixa tensão (piloto CP e PP) do protocolo IEC 61851 pode apresentar erros de comunicação ou simplesmente não reconhecer o carregador como compatível, encerrando a sessão forçosamente.', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (46, 4, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (46, 'Abaixo de 15 metros e 32A: Cabo de cobre de 6 mm² in eletroduto exclusivo e ventilado.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (46, 'De 15 a 30 metros e 32A: Cabo de cobre de 10 mm² (reduz drasticamente queda de tensão).', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (46, 'De 30 a 50 metros e 32A: Cabo de cobre de 16 mm² (garante quedas abaixo de 3%, conforme NBR 5410).', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (46, 'Acima de 50 metros e 32A: Cabo de cobre de 25 mm² ou instalação de segundo quadro de distribuição intermediário.', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (47, 4, 'blockquote', 'Bitola de cabo não se escolhe por palpite nem por tabela genérica; ela se calcula combinando a corrente nominal contínua do circuito, a temperatura máxima do ambiente, o método de instalação (eletroduto, cabo livre, enterrado) e a queda de tensão percentual máxima admissível ao longo do percurso.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (48, 4, 'heading', 'Método de Instalação: Eletroduto, Calha ou Enterrado', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (49, 4, 'paragraph', 'O método de instalação do cabo afeta diretamente sua capacidade de condução de corrente. Cabos em eletroduto fechado têm menor dissipação térmica e menor capacidade de corrente comparados ao mesmo cabo instalado ao ar livre. Cabos enterrados em solo têm capacidade de corrente intermediária, mas exigem proteção mecânica adequada (eletroduto rígido de PVC ou PEAD) e respeito às profundidades mínimas estabelecidas pela NBR 5410.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (50, 4, 'paragraph', 'Na VoltchZ Brasil, todo projeto técnico passa por uma simulação computacional de engenharia para prever com precisão as perdas ôhmicas, o perfil de temperatura do cabo sob carga máxima e a queda de tensão percentual no ponto mais desfavorável do circuito. Isso garante uma operação silenciosa, eficiente e em plena conformidade com as normas brasileiras vigentes.', '', 9);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (5, 'seguranca-e-controle', 'Segurança e Controle', 'Tecnologia', 'Como gerenciar e balancear a carga de carregamento de múltiplos veículos elétricos simultâneos de forma inteligente e integrada via OCPP 1.6J.', 'Bruno Riêra', 'Diretor de Engenharia da VoltchZ Brasil', '28 Jan, 2026', '8 min', 'estacoes', 'Gestão de Frotas', 'OCPP Cloud');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (51, 5, 'heading', 'O Desafio da Recarga Simultânea de Frotas Corporativas', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (52, 5, 'paragraph', 'Quando uma empresa decide substituir 10 ou 15 veículos de combustão por modelos elétricos de entrega ou transporte corporativo, a primeira pergunta que surge no departamento de operações é inevitável: como carregar todos esses carros juntos ao final do expediente sem derrubar a energia da sede corporativa e sem pagar multas astronômicas de pico de demanda para a concessionária distribuidora de energia?', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (53, 5, 'paragraph', 'Instalar simplesmente 15 carregadores independentes de 22 kW pode resultar em uma demanda instantânea teórica de 330 kW — o suficiente para exigir a contratação emergencial de uma nova cabine primária de alta tensão, com investimentos em transformadores dedicados na casa dos R$ 800 mil a R$ 1,2 milhão. A solução tecnicamente correta e economicamente viável passa obrigatoriamente por segurança ativa e controle inteligente de carga via software.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (54, 5, 'heading', 'Equilíbrio Dinâmico de Carga (Smart Charging) e Protocolo OCPP', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (55, 5, 'paragraph', 'Através do protocolo de comunicação universal OCPP 1.6J (Open Charge Point Protocol), as estações de carregamento da linha E-Wolf da VoltchZ se comunicam em tempo real com plataformas de gestão na nuvem, permitindo que o gestor da frota controle de forma centralizada todas as recargas simultâneas:', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (56, 5, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (56, 'Balanceamento Dinâmico de Carga (Smart Load Management): Distribui a potência disponível na fábrica ou sede corporativa entre os veículos conectados de forma equitativa e automática. Se há apenas 1 carro, ele recebe a potência máxima (22 kW). Se conectam 10 carros, o sistema distribui a potência de acordo com o limite de demanda seguro pré-configurado pelo gestor.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (56, 'Priorização Inteligente por Rota: O administrador da frota pode indicar no painel de controle web quais veículos precisam sair mais cedo no dia seguinte, e o sistema direciona automaticamente maior potência de carga para esses veículos de forma prioritária.', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (56, 'Programação por Janela Tarifária: Permite configurar o início das recargas para as madrugadas, aproveitando as tarifas de energia mais baixas nos horários fora de pico da concessionária.', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (56, 'Relatórios de Consumo por Veículo: Controle individualizado do kWh consumido por cada veículo da frota, facilitando o rateio de custos entre departamentos ou projetos específicos.', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (57, 5, 'blockquote', 'A chave para eletrificar frotas corporativas com eficiência real não está em contratar mais energia da concessionária. Está em gerenciar a energia disponível com inteligência ativa, automação e controle de dados em tempo real.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (58, 5, 'heading', 'Segurança Operacional: Controle de Acesso e Autenticação', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (59, 5, 'paragraph', 'Para frotas corporativas privadas, a segurança operacional é tão importante quanto a eficiência energética. As estações E-Wolf suportam autenticação por RFID (cartão de aproximação único por motorista), QR Code via aplicativo VoltchZ Mobile e PIN individualizado. Isso significa que apenas motoristas autorizados conseguem iniciar sessões de carregamento, eliminando o uso indevido da infraestrutura corporativa por terceiros.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (60, 5, 'paragraph', 'Todos os dados de autenticação, tempo de sessão, energia consumida e custo calculado são registrados na nuvem em tempo real, com exportação de relatórios em CSV ou PDF para integração com sistemas de gestão de frotas (TMS) e softwares de contabilidade corporativa.', '', 9);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (6, 'segundo-a-abve-os-numeros-de-2023-indicam-uma-transformacao-no-mercado-de-veiculos-eletrificados-no-brasil', 'Segundo a ABVE, os números de 2023 indicam uma transformação no mercado de veículos eletrificados no Brasil', 'Mercado', 'Análise detalhada do crescimento exponencial das vendas de EVs no mercado nacional e a demanda urgente por engenharia de infraestrutura elétrica qualificada.', NULL, 'Diretor de Engenharia da VoltchZ Brasil', '15 Jan, 2026', '7 min', 'estacoes', 'Estatísticas ABVE', 'Dados Mercado');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (61, 6, 'heading', 'Crescimento Histórico e o Boom dos Veículos Elétricos no Brasil', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (62, 6, 'paragraph', 'Os relatórios e dados divulgados pela Associação Brasileira do Veículo Elétrico (ABVE) confirmam com números concretos o que já se nota visivelmente nas ruas das principais capitais e rodovias do país: o mercado brasileiro está atravessando uma transição energética acelerada, estrutural e sem volta rumo à mobilidade sustentável de baixo carbono.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (63, 6, 'paragraph', 'O crescimento das vendas de carros totalmente elétricos (BEV) e híbridos plug-in (PHEV) rompeu todas as projeções conservadoras que analistas do setor faziam apenas 4 anos atrás. Essa nova realidade mercadológica coloca em evidência um gargalo técnico dramático e urgente: a velocidade de aquisição de novos veículos pelos motoristas e frotistas está muito à frente da velocidade de instalação de carregadores confiáveis, homologados e seguros nas garagens de condomínios, rodovias e pontos comerciais de todo o país.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (64, 6, 'heading', 'Os Números que Confirmam a Transformação', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (65, 6, 'list', '', '', 4);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (65, 'O Brasil ultrapassou a marca de 100.000 veículos elétricos em circulação, com taxa de crescimento anual superior a 85% em 2023.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (65, 'São Paulo concentra mais de 40% da frota nacional de EVs, pressionando a infraestrutura de carregamento da maior cidade do hemisfério sul.', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (65, 'O mercado de Wallboxes residenciais e comerciais cresceu 220% em volume de instalações em apenas 2 anos.', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (65, 'A ABVE estima que o Brasil precisará de mais de 500.000 pontos de recarga instalados até 2030 para atender a demanda prevista.', 3);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (65, 'Apenas 18% dos novos proprietários de EVs no Brasil têm acesso a um carregador instalado tecnicamente de forma correta.', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (66, 6, 'blockquote', 'A mobilidade elétrica no Brasil já é realidade comercial consolidada e irreversível. Agora, o grande desafio nacional migrou do pátio das concessionárias de veículos para as garagens, os condomínios e as rodovias — onde a engenharia elétrica de qualidade é absolutamente indispensável.', 'Bruno Riêra', 5);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (67, 6, 'heading', 'O Gargalo Real: Falta de Engenharia Qualificada para Infraestrutura de Recarga', '', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (68, 6, 'paragraph', 'Para cada 10 carros elétricos novos que entram em circulação no mercado nacional, é necessário ao menos 1 ponto de carregamento rápido público e cerca de 9 carregadores residenciais e condominiais fixos instalados nas vagas de garagens. Se as redes elétricas prediais existentes não forem adequadas com sistemas modernos de segurança ativa, proteção DR Classe A ou B e estudos de viabilidade criteriosos, o país poderá vivenciar apagões pontuais e queima de transformadores prediais.', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (69, 6, 'paragraph', 'A VoltchZ Brasil nasceu exatamente para preencher esse vácuo de engenharia qualificada e responsabilidade técnica no setor. Nossa missão é que cada veículo elétrico que chegar ao Brasil tenha um ponto de carregamento seguro, eficiente e legal esperando por ele em casa, no trabalho ou na estrada.', '', 8);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (7, 'conveniencia', 'Conveniência', 'Mercado', 'Entenda como hotéis, shoppings e comércios estão fidelizando clientes de alto poder aquisitivo simplesmente disponibilizando pontos de recarga em suas vagas.', NULL, 'Diretor de Engenharia da VoltchZ Brasil', '03 Jan, 2026', '6 min', 'suportes', 'Eletropostos Comerciais', 'Fidelização');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (70, 7, 'heading', 'O Novo Critério de Decisão do Consumidor de EV', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (71, 7, 'paragraph', 'Imagine que o proprietário de um veículo elétrico premium está planejando uma viagem de final de semana com a família para o litoral ou a serra. Ao pesquisar pousadas, hotéis ou resorts no destino escolhido, qual será o seu primeiro critério de exclusão ao comparar as opções disponíveis?', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (72, 7, 'paragraph', 'A resposta é simples e direta: se o estabelecimento não dispõe de carregador para veículos elétricos em sua garagem privativa, o cliente simplesmente o elimina da lista de consideração sem pensar duas vezes, optando pelo concorrente que oferece essa comodidade essencial. Este é o poder disruptivo e crescente do carregamento como fator de conveniência ativa na decisão de compra e fidelização de clientes qualificados.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (73, 7, 'heading', 'Carregamento como Serviço de Valor Agregado e Nova Receita', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (74, 7, 'paragraph', 'Estabelecimentos que já instalaram pontos de recarga EV em seus estacionamentos relatam efeitos positivos concretos e mensuráveis em suas operações comerciais:', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (75, 7, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Atração e fidelização consistente de um nicho demográfico de alto poder aquisitivo e alta propensão a consumo.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Aumento médio de 35% a 55% no tempo de permanência de clientes durante a recarga (mais tempo dentro da loja, restaurante ou hotel gerando consumo).', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Cadastro automático do estabelecimento como Eletroposto nos principais aplicativos de rota e navegação para EVs (VoltchZ, ABREVE, Plugshare).', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Possibilidade real de monetizar o serviço de recarga, cobrando um valor por kWh carregado ou por hora de conexão, criando uma nova linha de receita operacional.', 3);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Geração espontânea de marketing positivo associado a ESG, sustentabilidade e inovação tecnológica, sem custo adicional de comunicação.', 4);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (75, 'Diferenciação competitiva duradoura frente a concorrentes que ainda não investiram in infraestrutura de mobilidade elétrica.', 5);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (76, 7, 'blockquote', 'A recarga de carros elétricos em estabelecimentos comerciais deixou definitivamente de ser um diferencial de inovação para se consolidar como infraestrutura básica obrigatória de atração e retenção de clientes de alto valor.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (77, 7, 'heading', 'O ROI Real de um Eletroposto Comercial', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (78, 7, 'paragraph', 'Com base em projetos instalados pela VoltchZ Brasil em hotéis, restaurantes e redes de varejo, um eletroposto comercial de 22 kW bem posicionado, com cobrança por kWh, apresenta retorno sobre o investimento em um prazo médio de 18 a 30 meses, dependendo do fluxo de veículos elétricos na região e do modelo de monetização escolhido pelo estabelecimento.', '', 8);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (8, 'httpswwwinstagramcompc23mx5ytteigsheg1wcwe2b2jzc2dn', 'Economia de Tempo e Dinheiro | VoltchZ Brasil', 'Mercado', 'Calculando a viabilidade financeira e o custo por quilômetro rodado de carros elétricos versus modelos a gasolina nas principais cidades brasileiras.', NULL, 'Diretor de Engenharia da VoltchZ Brasil', '18 Dez, 2025', '9 min', 'estacoes', 'TCO e Economia', 'Finanças EV');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (79, 8, 'heading', 'Custo por Quilômetro Rodado: Elétrico versus Gasolina', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (80, 8, 'paragraph', 'Apesar de apresentarem um valor de aquisição inicial mais elevado nas concessionárias, os carros elétricos trazem benefícios financeiros expressivos e mensuráveis na planilha de custos operacionais ao longo da vida útil do veículo. O principal e mais imediato pilar de economia é o custo do combustível por quilômetro rodado.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (81, 8, 'paragraph', 'Enquanto percorrer 100 km com um veículo popular a combustão abastecido com gasolina comum consome entre R$ 55,00 e R$ 72,00 nas capitais brasileiras (com gasolina a R$ 6,00/litro e consumo de 10 a 12 km/l), percorrer a mesma distância com um veículo elétrico de eficiência equivalente custa entre R$ 10,00 e R$ 18,00 na tarifa residencial de energia elétrica, representando uma redução de custo de 70% a 85% no item combustível.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (82, 8, 'heading', 'Total Cost of Ownership (TCO) e Manutenção Quase Nula', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (83, 8, 'paragraph', 'Além da economia imediata em combustível, o TCO (Custo Total de Propriedade) de um veículo elétrico ao longo de 5 anos é significativamente inferior ao de um equivalente a combustão. O principal componente dessa vantagem é a drástica redução de custos de manutenção preventiva e corretiva.', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (84, 8, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (84, 'Eliminação completa de trocas de óleo lubrificante, filtros de óleo, velas de ignição, correias dentadas e de alternador.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (84, 'Extinção do sistema de escape, catalisadores e filtros de partículas (itens caros e sujeitos a corrosão e falhas mecânicas).', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (84, 'Redução de 60% a 80% no desgaste e custo dos freios devido ao sistema de frenagem regenerativa que recupera energia e alivia os discos mecânicos.', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (84, 'Isenção ou desconto significativo de IPVA em São Paulo (50% de desconto para híbridos e isenção total para elétricos puros em vários estados).', 3);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (84, 'Redução de gastos com estacionamento e pedágio em cidades como São Paulo e Rio de Janeiro, que oferecem benefícios tarifários para EVs.', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (85, 8, 'blockquote', 'Quando se considera o TCO real ao longo de 60 meses de propriedade, incluindo combustível, manutenção, seguros e benefícios fiscais, o veículo elétrico apresenta vantagem financeira total sobre o equivalente a combustão a partir do 2º ou 3º ano de uso — muito antes do que a maioria das pessoas imagina.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (86, 8, 'heading', 'Simulação de Payback para Frotistas Corporativos', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (87, 8, 'paragraph', 'Para empresas com frotas de 5 ou mais veículos, a vantagem do EV é ainda mais dramática. Uma empresa que substitui 10 utilitários de combustão por modelos elétricos equivalentes pode economizar entre R$ 180.000 e R$ 280.000 anuais apenas em combustível e manutenção, sem contar os benefícios de imagem ESG e as isenções de impostos estaduais.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (88, 8, 'paragraph', 'A infraestrutura de carregamento corporativo para 10 veículos, instalada com qualidade pela VoltchZ Brasil incluindo o sistema Smart Charging via OCPP, custa entre R$ 85.000 e R$ 140.000 dependendo da localização e potência selecionada — representando payback total da infraestrutura em menos de 8 meses de operação.', '', 9);
INSERT INTO `artigos` (`id`, `slug`, `titulo`, `categoria`, `resumo`, `autor`, `cargo`, `data_publicacao`, `tempo_leitura`, `svg_metadata_category`, `svg_metadata_title`, `svg_metadata_subtitle`) VALUES (9, 'httpswwwinstagramcompc23nitktip6igshmwm5mwq5amvtzm9ndg', 'Independência Energética | VoltchZ Brasil', 'Tecnologia', 'Como gerar seu próprio combustível solar em casa de forma totalmente autônoma, sustentável e livre das oscilações da conta de energia.', NULL, 'Diretor de Engenharia da VoltchZ Brasil', '02 Dez, 2025', '9 min', 'protecao', 'Solar + EV', 'Sustentabilidade');
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (89, 9, 'heading', 'Gerando Combustível Solar Gratuito no Telhado de Casa', '', 0);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (90, 9, 'paragraph', 'A maior e mais revolucionária promessa de liberdade do veículo elétrico reside na possibilidade concreta de eliminar completamente a dependência de postos de combustível, de refinarias e dos preços voláteis do petróleo. Ao integrar uma planta de microgeração fotovoltaica no telhado de sua residência ou empresa, o usuário de EV passa a produzir eletricidade limpa com custo marginal praticamente zero, utilizando a radiação solar abundante que o Brasil recebe.', '', 1);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (91, 9, 'paragraph', 'Essa energia solar produzida durante as horas de sol é injetada na rede da concessionária e gera créditos de energia elétrica (sistema de compensação da ANEEL), que por sua vez abastecem o carregador do carro à noite. O resultado prático é que o "combustível" do veículo elétrico passa a custar próximo de zero, com investimento inicial que se paga em 4 a 6 anos e vida útil dos painéis superior a 25 anos.', '', 2);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (92, 9, 'heading', 'Como Dimensionar a Planta Solar para Incluir o Carregamento do EV', '', 3);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (93, 9, 'paragraph', 'O grande erro que muitos proprietários cometem é instalar uma planta fotovoltaica dimensionada apenas para o consumo histórico da residência, sem contemplar a nova demanda gerada pelo carregamento do veículo elétrico. Um carro elétrico com autonomia de 400 km e consumo típico de 15 kWh/100 km percorrendo 1.500 km por mês adicionará cerca de 225 kWh/mês à conta de energia.', '', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (94, 9, 'list', '', '', 5);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (94, 'Levantamento do consumo residencial histórico (12 meses) e adição da demanda estimada do EV.', 0);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (94, 'Cálculo da irradiação solar local da cidade e do fator de perdas do sistema (cabeamento, inversores, temperatura).', 1);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (94, 'Dimensionamento da quantidade de painéis e potência do inversor considerando a nova demanda total.', 2);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (94, 'Integração do Wallbox com o sistema fotovoltaico via comunicação inteligente para priorizar a carga com energia solar.', 3);
INSERT INTO `artigo_conteudo_list_items` (`artigo_conteudo_id`, `item`, `ordem`) VALUES (94, 'Registro do sistema na concessionária e homologação junto à distribuidora local conforme resolução ANEEL 482.', 4);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (95, 9, 'blockquote', 'A combinação de geração solar + armazenamento em bateria estacionária + veículo elétrico transforma o consumidor passivo de energia em um prosumidor ativo, produzindo, consumindo e gerenciando sua própria energia com total autonomia e inteligência.', 'Bruno Riêra', 6);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (96, 9, 'heading', 'V2G e V2H: O Carro como Bateria Estacionária da Casa', '', 7);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (97, 9, 'paragraph', 'O próximo passo evolutivo da integração solar + EV é o ecossistema inteligente bidirecional, no qual o veículo elétrico não apenas consome energia do telhado solar, mas também retorna energia da sua bateria de alta capacidade para alimentar a residência (V2H — Vehicle to Home) nos momentos de blecaute ou de tarifas elevadas pela concessionária.', '', 8);
INSERT INTO `artigo_conteudo` (`id`, `artigo_id`, `tipo`, `texto`, `autor_citado`, `ordem`) VALUES (98, 9, 'paragraph', 'No nível mais avançado, o conceito V2G (Vehicle to Grid) permite que o proprietário venda de volta à rede pública o excedente de energia armazenado na bateria do veículo nos momentos de pico de demanda do sistema elétrico nacional, gerando uma fonte de renda passiva enquanto o carro está estacionado. Esta tecnologia já é realidade em alguns países europeus e está rapidamente avançando no mercado brasileiro.', '', 9);

-- =====================================================================
-- Carga de Novos Produtos (Incharge)
-- =====================================================================

-- =====================================================================
-- Novos Produtos Incharge (Substituição de Valores)
-- =====================================================================

-- 1. Substituição de Produtos (O REPLACE INTO remove o registro anterior,
-- limpando em cascata diferenciais, especificações e variações órfãs)

REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (28, 'incharge-home-5', 'INCHARGE HOME 5', 'incharge', 'estacoes', '7,4 kW', '210~240V AC Monofásico', 'Residencial', 'Cabo fixo Tipo 2 (5m)', 'Estação de carregamento residencial compacta com cabo de 5 metros e conector Tipo 2.', 'O INCHARGE HOME 5 é uma estação de carregamento AC para uso residencial, projetada para carregar veículos elétricos e híbridos Plug-in. Com indicação de status por LEDs, montagem em parede ou totem e cabo de 5 metros com conector Tipo 2, oferece praticidade e segurança para o carregamento doméstico. Sem controle de carga ou comunicação remota, ideal para uso simples e direto.', 'static/produtos/incharge-home-5.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (29, 'incharge-home-7', 'INCHARGE HOME 7', 'incharge', 'estacoes', '7,4 kW', '210~240V AC Monofásico', 'Residencial', 'Cabo fixo Tipo 2 (7m)', 'Estação de carregamento residencial com cabo longo de 7 metros e conector Tipo 2.', 'O INCHARGE HOME 7 é idêntico ao HOME 5 em especificações elétricas, mas oferece um cabo de 7 metros para maior flexibilidade no posicionamento do veículo. Ideal para garagens onde a tomada de recarga do carro fica mais distante da parede. Indicação de status por LEDs, montagem em parede ou totem e proteção IP54.', 'static/produtos/incharge-home-7.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (30, 'incharge-home-trifasico-5', 'INCHARGE HOME Trifásico 5', 'incharge', 'estacoes', '22 kW', '365~415V AC Trifásico', 'Residencial, Corporativo', 'Cabo fixo Tipo 2 (5m)', 'Estação de carregamento residencial trifásica de 22kW com cabo de 5 metros.', 'O INCHARGE HOME Trifásico 5 (INC3X32H5) oferece carregamento AC trifásico de 22kW para veículos que suportam esse modo de recarga. Com cabo de 5 metros e conector Tipo 2, é indicado para residências e condomínios com rede trifásica 380V disponível. Indica o status por LEDs e pode ser montado em parede ou totem.', 'static/produtos/incharge-home-trifasico-5.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (31, 'incharge-home-trifasico-7', 'INCHARGE HOME Trifásico 7', 'incharge', 'estacoes', '22 kW', '365~415V AC Trifásico', 'Residencial, Corporativo', 'Cabo fixo Tipo 2 (7m)', 'Estação de carregamento residencial trifásica de 22kW com cabo longo de 7 metros.', 'O INCHARGE HOME Trifásico 7 (INC3X32H7) combina a potência de 22kW trifásico com um cabo de 7 metros para maior flexibilidade de posicionamento. Ideal para garagens amplas ou condomínios com rede 380V. Indicação por LEDs e montagem em parede ou totem.', 'static/produtos/incharge-home-trifasico-7.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (32, 'incharge-plus-74kw', 'INCHARGE 7,4kW PLUS', 'incharge', 'estacoes', '7,4 kW', '210~240V AC Monofásico/Bifásico', 'Residencial, Corporativo, Condomínios', 'Cabo fixo Tipo 2 (5m)', 'Carregador AC compacto com design premiado internacionalmente, para uso em parede ou totem.', 'O INCHARGE 7,4kW PLUS é um carregador veicular AC com design premiado (iF Design Award 2021 e A'' Design Award Bronze 2020). Com display cromático indicativo, cabo de 5 metros e conector Tipo 2, é indicado para uso em residências, condomínios e pontos comerciais. Não possui comunicação remota ou controle de carga — ideal para instalações simples e diretas.', 'static/produtos/incharge-plus-74kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (33, 'incharge-smart-74kw', 'INCHARGE 7,4kW SMART', 'incharge', 'estacoes', '7,4 kW', '210~240V AC Monofásico/Bifásico', 'Corporativo, Condomínios, Pontos Comerciais', 'Cabo fixo Tipo 2 (5m)', 'Carregador AC inteligente com controle de acesso via NFC/App e comunicação OCPP 1.6J.', 'O INCHARGE 7,4kW SMART é a versão conectada da linha PLUS. Além do design premiado e proteção IP54, conta com medidor de energia integrado, controle de acesso por cartão NFC ou App, comunicação OCPP 1.6J e controle de carga remoto. Inclui Gateway de conexão para integração com o servidor INCHARGE. Indicado para condomínios, estacionamentos e pontos comerciais que precisam de gestão de recargas.', 'static/produtos/incharge-smart-74kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (34, 'incharge-plus-22kw', 'INCHARGE 22kW PLUS', 'incharge', 'estacoes', '22 kW', '365~415V AC Trifásico', 'Corporativo, Condomínios, Frotas', 'Cabo fixo Tipo 2 (5m)', 'Carregador AC trifásico de 22kW com design premiado, para uso em parede ou totem.', 'O INCHARGE 22kW PLUS é a versão trifásica de alta potência da linha PLUS. Com 22kW de potência AC, carrega veículos compatíveis de forma significativamente mais rápida que carregadores monofásicos. Design premiado internacionalmente, proteção IP54 para uso interno e externo, cabo de 5 metros com conector Tipo 2. Sem comunicação remota — ideal para instalações corporativas simples.', 'static/produtos/incharge-plus-22kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (35, 'incharge-smart-22kw', 'INCHARGE 22kW SMART', 'incharge', 'estacoes', '22 kW', '365~415V AC Trifásico', 'Corporativo, Condomínios, Frotas, Pontos Comerciais', 'Cabo fixo Tipo 2 (5m)', 'Carregador AC trifásico de 22kW com controle de acesso NFC/App e OCPP 1.6J.', 'O INCHARGE 22kW SMART combina a alta potência de 22kW trifásico com recursos de conectividade completos: controle de acesso por cartão NFC ou App, comunicação OCPP 1.6J, medidor de energia integrado e controle de carga remoto. Inclui Gateway de conexão. Indicado para estacionamentos comerciais, frotas corporativas e condomínios que precisam de gestão centralizada de recargas.', 'static/produtos/incharge-smart-22kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (36, 'incharge-emvs-30kw', 'INCHARGE EMVS 30kW', 'incharge', 'estacoes', '30 kW', '400 Vca, 3P+N+PE (304~456 Vca)', 'Corporativo, Estacionamentos, Frotas, Pontos Comerciais', 'Cabo fixo CCS2 (3m)', 'Wallbox DC de 30kW com display touchscreen de 10,4", OCPP 1.6J e até 96,5% de eficiência.', 'O INCHARGE EMVS 30kW é uma estação de carregamento rápido DC em formato wallbox, para montagem em parede ou totem. Com 30kW de potência DC, display touchscreen TFT de 10,4", conector CCS2, comunicação via LAN e protocolo OCPP 1.6J, atende estacionamentos, frotas e pontos comerciais que precisam de carregamento rápido em espaço reduzido. Eficiência geral de até 96,5% e operação de -35°C a 60°C.', 'static/produtos/incharge-emvs-30kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (37, 'incharge-fast-charge-60kw', 'INCHARGE Fast Charge 60kW', 'incharge', 'estacoes', '60 kW', '304~456V AC 3P+N+T (50/60 Hz)', 'Corporativo, Estacionamentos, Postos, Frotas, Uso Público', '2× CCS2 (auto portante)', 'Carregador DC rápido autosuportado de 60kW com 2 saídas CCS2, display touch 10,4" e OCPP 1.6J.', 'O INCHARGE Fast Charge 60kW (INC60kW-DC) é um carregador DC rápido em formato totem autosuportado, com dois conectores CCS2. Estratégia de carregamento flexível: 60+0, 0+60 ou 30+30 kW por conector. Display touchscreen de 10,4", controle de acesso local/cartão/app, comunicação OCPP 1.6J e controle de carga. Tensão de saída de 150 a 1000 VDC com corrente máxima de 200A. Robusto, com proteção IP54, IK10 e operação de -20°C a 60°C.', 'static/produtos/incharge-fast-charge-60kw.webp');
REPLACE INTO `produtos` (`id`, `slug`, `nome`, `marca_id`, `categoria_id`, `potencia`, `tensao`, `aplicacao`, `tipo`, `resumo`, `descricao`, `imagem`) VALUES (38, 'incharge-fast-charge-150kw', 'INCHARGE Fast Charge 150kw', 'incharge', 'estacoes', '150 kW', '304~456V AC 3P+N+T (50/60 Hz)', 'Postos de Recarga, Uso Público, Frotas de Alta Demanda', '2× CCS2 (auto portante)', 'Carregador DC ultrarrápido autosuportado de 150kW com 2 saídas CCS2, display touch 10,4" e OCPP 1.6J.', 'O INCHARGE Fast Charge 150kW (INC150kW-DC) é o carregador DC de maior potência da linha INCHARGE. Em formato totem autosuportado com dois conectores CCS2, entrega até 150kW com estratégias de divisão de carga flexíveis: 150+0, 0+150 ou 90+60 kW. Display touchscreen de 10,4", controle de acesso multicanal, OCPP 1.6J e tensão de saída de 150 a 1000 VDC com 200A máximos. Ideal para postos de recarga de alta demanda e frotas comerciais.', 'static/produtos/incharge-fast-charge-150kw.webp');

-- 2. Substituição de Variações (REPLACE INTO via chave primária SKU)
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC1X32H5', 28, 'INCHARGE HOME 5 — 7,4kW Monofásico', '210~240V AC, Cabo 5m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC1X32H7', 29, 'INCHARGE HOME 7 — 7,4kW Monofásico', '210~240V AC, Cabo 7m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC3X32H5', 30, 'INCHARGE HOME Trifásico 5 — 22kW', '365~415V AC Trifásico, Cabo 5m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC3X32H7', 31, 'INCHARGE HOME Trifásico 7 — 22kW', '365~415V AC Trifásico, Cabo 7m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC1X32P', 32, 'INCHARGE 7,4kW PLUS', '210~240V AC Monofásico/Bifásico, Cabo 5m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC1X32S', 33, 'INCHARGE 7,4kW SMART', '210~240V AC Monofásico/Bifásico, Cabo 5m, NFC + OCPP 1.6J');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC3X32P', 34, 'INCHARGE 22kW PLUS', '365~415V AC Trifásico, Cabo 5m, Conector Tipo 2');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC3X32S', 35, 'INCHARGE 22kW SMART', '365~415V AC Trifásico, Cabo 5m, NFC + OCPP 1.6J');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('EVMS-30', 36, 'INCHARGE EMVS 30kW', '400 Vca Trifásico, Cabo CCS2 3m, LAN + OCPP 1.6J');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC60kW-DC', 37, 'INCHARGE Fast Charge 60kW', '2× CCS2, Estratégia 60+0 / 0+60 / 30+30 kW, OCPP 1.6J');
REPLACE INTO `produto_variacoes` (`sku`, `produto_id`, `nome`, `adicional_desc`) VALUES ('INC150kW-DC', 38, 'INCHARGE Fast Charge 150kW', '2× CCS2, Estratégia 150+0 / 0+150 / 90+60 kW, OCPP 1.6J');

-- 3. Inserção de Diferenciais (Seguros pós-limpeza por cascade do produto)
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (28, 'Indicação de status por LEDs (Carregando, Conectado, Erro)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (28, 'Montagem em parede ou totem', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (28, 'Proteção IP54 e IK10', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (28, 'Cabo de 5 metros com conector Tipo 2', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (28, 'Fácil instalação com suporte metálico incluso', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (29, 'Cabo de 7 metros com conector Tipo 2 para maior alcance', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (29, 'Indicação de status por LEDs (Carregando, Conectado, Erro)', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (29, 'Montagem em parede ou totem', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (29, 'Proteção IP54 e IK10', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (29, 'Fácil instalação com suporte metálico incluso', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (30, 'Carregamento trifásico de até 22kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (30, 'Indicação de status por LEDs', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (30, 'Montagem em parede ou totem', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (30, 'Proteção IP54 e IK10', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (30, 'Cabo de 5 metros com conector Tipo 2', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (31, 'Carregamento trifásico de até 22kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (31, 'Cabo de 7 metros para maior alcance', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (31, 'Indicação de status por LEDs', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (31, 'Montagem em parede ou totem', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (31, 'Proteção IP54 e IK10', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (32, 'Design premiado internacionalmente (iF Design Award 2021)', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (32, 'Display cromático indicativo de status', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (32, 'Montagem em parede ou totem', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (32, 'Proteção IP54 e IK10 — uso interno e externo', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (32, 'Cabo de 5 metros com conector Tipo 2', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Controle de acesso via cartão NFC e App', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Comunicação OCPP 1.6J para gestão remota', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Medidor de energia integrado', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Controle de carga inteligente', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Gateway de conexão incluso', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Design premiado internacionalmente (iF Design Award 2021)', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (33, 'Proteção IP54 e IK10 — uso interno e externo', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (34, 'Carregamento trifásico de até 22kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (34, 'Design premiado internacionalmente (iF Design Award 2021)', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (34, 'Display cromático indicativo de status', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (34, 'Proteção IP54 e IK10 — uso interno e externo', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (34, 'Montagem em parede ou totem', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Carregamento trifásico de até 22kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Controle de acesso via cartão NFC e App', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Comunicação OCPP 1.6J para gestão remota', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Medidor de energia integrado', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Controle de carga inteligente', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Gateway de conexão incluso', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (35, 'Proteção IP54 e IK10 — uso interno e externo', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Carregamento DC rápido de 30kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Display touchscreen TFT de 10,4"', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Eficiência de até 96,5% (sistema)', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Comunicação LAN com protocolo OCPP 1.6J', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Proteção IP55 e IK10', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Operação entre -35°C e 60°C', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (36, 'Nível de ruído inferior a 55dB', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, '2 saídas CCS2 com estratégia de divisão de carga flexível', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Display touchscreen de 10,4"', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Controle de acesso: Local, Cartão RFID e App', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Comunicação OCPP 1.6J', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Tensão de saída ampla: 150~1000 VDC', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Proteção IP54 e IK10', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (37, 'Totem autosuportado — sem fixação em parede', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Potência DC ultrarrápida de até 150kW', 0);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, '2 saídas CCS2 com estratégia de divisão de carga flexível (150+0 / 0+150 / 90+60)', 1);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Display touchscreen de 10,4"', 2);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Controle de acesso: Local, Cartão RFID e App', 3);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Comunicação OCPP 1.6J', 4);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Tensão de saída ampla: 150~1000 VDC', 5);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Proteção IP54 e IK10', 6);
INSERT INTO `produto_diferenciais` (`produto_id`, `diferencial`, `ordem`) VALUES (38, 'Totem autosuportado robusto — 260 kg', 7);

-- 4. Inserção de Especificações Técnicas (Seguras pós-limpeza por cascade do produto)
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Código do produto', 'INC1X32H5', 301);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Linha', 'HOME', 302);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Potência máxima', '7,4 kW', 303);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Tensão de alimentação', '210~240V AC 50/60Hz', 304);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Descrição dos pólos', 'P+N+T', 305);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Número de saídas', '1', 306);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Padrão do conector', 'Tipo 2', 307);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Comprimento do cabo', '5 m', 308);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Aterramento', 'TN/TT', 309);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Sinalização local', 'LEDs para indicação de estado', 310);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Comunicação', 'Não', 311);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Controle de carga', 'Não', 312);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Normas', 'IEC 61851 / IEC 62197', 313);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Grau de proteção IP', 'IP54', 314);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Grau de proteção IK', 'IK10', 315);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Temperatura de operação', '-30 / 50°C', 316);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Temperatura de armazenamento', '-40 / 80°C', 317);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Humidade relativa', '5 / 95%', 318);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Altura', '300 mm', 319);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Largura', '220 mm', 320);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Profundidade', '90 mm', 321);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (28, 'Peso líquido', '3,2 kg', 322);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Código do produto', 'INC1X32H7', 323);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Linha', 'HOME', 324);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Potência máxima', '7,4 kW', 325);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Tensão de alimentação', '210~240V AC 50/60Hz', 326);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Descrição dos pólos', 'P+N+T', 327);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Número de saídas', '1', 328);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Padrão do conector', 'Tipo 2', 329);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Comprimento do cabo', '7 m', 330);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Aterramento', 'TN/TT', 331);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Sinalização local', 'LEDs para indicação de estado', 332);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Comunicação', 'Não', 333);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Controle de carga', 'Não', 334);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Normas', 'IEC 61851 / IEC 62197', 335);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Grau de proteção IP', 'IP54', 336);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Grau de proteção IK', 'IK10', 337);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Temperatura de operação', '-30 / 50°C', 338);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Temperatura de armazenamento', '-40 / 80°C', 339);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Humidade relativa', '5 / 95%', 340);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Altura', '300 mm', 341);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Largura', '220 mm', 342);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Profundidade', '90 mm', 343);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (29, 'Peso líquido', '3,9 kg', 344);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Código do produto', 'INC3X32H5', 345);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Linha', 'HOME', 346);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Potência máxima', '22 kW', 347);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Tensão de alimentação', '365~415V AC 50/60Hz', 348);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Descrição dos pólos', '3P+N+T', 349);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Número de saídas', '1', 350);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Padrão do conector', 'Tipo 2', 351);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Comprimento do cabo', '5 m', 352);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Aterramento', 'TN/TT', 353);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Sinalização local', 'LEDs para indicação de estado', 354);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Comunicação', 'Não', 355);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Controle de carga', 'Não', 356);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Normas', 'IEC 61851 / IEC 62197', 357);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Grau de proteção IP', 'IP54', 358);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Grau de proteção IK', 'IK10', 359);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Temperatura de operação', '-30 / 50°C', 360);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Temperatura de armazenamento', '-40 / 80°C', 361);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Humidade relativa', '5 / 95%', 362);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Altura', '300 mm', 363);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Largura', '220 mm', 364);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Profundidade', '90 mm', 365);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (30, 'Peso líquido', '3,7 kg', 366);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Código do produto', 'INC3X32H7', 367);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Linha', 'HOME', 368);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Potência máxima', '22 kW', 369);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Tensão de alimentação', '365~415V AC 50/60Hz', 370);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Descrição dos pólos', '3P+N+T', 371);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Número de saídas', '1', 372);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Padrão do conector', 'Tipo 2', 373);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Comprimento do cabo', '7 m', 374);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Aterramento', 'TN/TT', 375);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Sinalização local', 'LEDs para indicação de estado', 376);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Comunicação', 'Não', 377);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Controle de carga', 'Não', 378);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Normas', 'IEC 61851 / IEC 62197', 379);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Grau de proteção IP', 'IP54', 380);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Grau de proteção IK', 'IK10', 381);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Temperatura de operação', '-30 / 50°C', 382);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Temperatura de armazenamento', '-40 / 80°C', 383);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Humidade relativa', '5 / 95%', 384);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Altura', '300 mm', 385);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Largura', '220 mm', 386);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Profundidade', '90 mm', 387);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (31, 'Peso líquido', '5,4 kg', 388);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Código do produto', 'INC1X32P', 389);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Linha', 'PLUS', 390);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Potência máxima', '7,4 kW', 391);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Tensão de alimentação', '210~240V AC 50/60Hz', 392);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Descrição dos pólos', 'P+N+T', 393);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Modo de montagem', 'Parede/Totem', 394);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Número de saídas', '1', 395);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Padrão do conector', 'Tipo 2', 396);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Comprimento do cabo', '5 m', 397);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Aterramento', 'TN/TT', 398);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Sinalização local', 'Display cromático (LEDs)', 399);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Comunicação', 'Não', 400);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Controle de carga', 'Não', 401);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Normas', 'IEC 61851 / IEC 62197', 402);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Grau de proteção IP', 'IP54', 403);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Grau de proteção IK', 'IK10', 404);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Temperatura de operação', '-30 / 50°C', 405);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Temperatura de armazenamento', '-40 / 80°C', 406);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Humidade relativa', '5 / 95%', 407);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Altura', '500 mm', 408);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Largura', '220 mm', 409);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Profundidade', '200 mm', 410);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Peso líquido', '6,0 kg', 411);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (32, 'Cor', 'Cinza cool gray 3C', 412);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Código do produto', 'INC1X32S', 413);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Linha', 'SMART', 414);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Potência máxima', '7,4 kW', 415);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Tensão de alimentação', '210~240V AC 50/60Hz', 416);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Descrição dos pólos', 'P+N+T', 417);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Modo de montagem', 'Parede/Totem', 418);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Número de saídas', '1', 419);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Padrão do conector', 'Tipo 2', 420);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Comprimento do cabo', '5 m', 421);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Aterramento', 'TN/TT', 422);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Sinalização local', 'Display cromático (LEDs)', 423);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Comunicação', 'OCPP 1.6 J', 424);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Controle de carga', 'Sim', 425);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Normas', 'IEC 61851 / IEC 62197', 426);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Grau de proteção IP', 'IP54', 427);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Grau de proteção IK', 'IK10', 428);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Temperatura de operação', '-30 / 50°C', 429);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Temperatura de armazenamento', '-40 / 80°C', 430);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Humidade relativa', '5 / 95%', 431);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Altura', '500 mm', 432);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Largura', '220 mm', 433);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Profundidade', '200 mm', 434);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Peso líquido', '6,2 kg', 435);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (33, 'Cor', 'Cinza cool gray 3C', 436);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Código do produto', 'INC3X32P', 437);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Linha', 'PLUS', 438);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Potência máxima', '22 kW', 439);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Tensão de alimentação', '365~415V AC 50/60Hz', 440);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Descrição dos pólos', '3P+N+T', 441);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Modo de montagem', 'Parede/Totem', 442);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Número de saídas', '1', 443);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Padrão do conector', 'Tipo 2', 444);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Comprimento do cabo', '5 m', 445);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Aterramento', 'TN/TT', 446);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Sinalização local', 'Display cromático (LEDs)', 447);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Comunicação', 'Não', 448);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Controle de carga', 'Não', 449);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Normas', 'IEC 61851 / IEC 62197', 450);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Grau de proteção IP', 'IP54', 451);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Grau de proteção IK', 'IK10', 452);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Temperatura de operação', '-30 / 50°C', 453);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Temperatura de armazenamento', '-40 / 80°C', 454);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Humidade relativa', '5 / 95%', 455);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Altura', '500 mm', 456);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Largura', '220 mm', 457);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Profundidade', '200 mm', 458);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Peso líquido', '7,1 kg', 459);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (34, 'Cor', 'Vermelho Warm Red C', 460);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Código do produto', 'INC3X32S', 461);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Linha', 'SMART', 462);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Potência máxima', '22 kW', 463);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Tensão de alimentação', '365~415V AC 50/60Hz', 464);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Descrição dos pólos', '3P+N+T', 465);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Modo de montagem', 'Parede/Totem', 466);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Número de saídas', '1', 467);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Padrão do conector', 'Tipo 2', 468);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Comprimento do cabo', '5 m', 469);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Aterramento', 'TN/TT', 470);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Sinalização local', 'Display cromático (LEDs)', 471);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Comunicação', 'OCPP 1.6 J', 472);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Controle de carga', 'Sim', 473);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Normas', 'IEC 61851 / IEC 62197', 474);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Grau de proteção IP', 'IP54', 475);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Grau de proteção IK', 'IK10', 476);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Temperatura de operação', '-30 / 50°C', 477);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Temperatura de armazenamento', '-40 / 80°C', 478);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Humidade relativa', '5 / 95%', 479);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Altura', '500 mm', 480);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Largura', '220 mm', 481);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Profundidade', '200 mm', 482);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Peso líquido', '7,5 kg', 483);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (35, 'Cor', 'Vermelho Warm Red C', 484);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Modelo', 'EVMS-30', 485);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Capacidade', '30 kW', 486);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Parâmetros de entrada', '400 Vca, 3P+N+PE', 487);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Faixa de tensão de entrada', '304~456 Vca', 488);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Fator de potência', '>0,997', 489);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Frequência', '50/60 Hz', 490);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Plugue de saída', 'CCS2 (saída única)', 491);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Tensão de saída', '50~1000 VDC', 492);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Corrente máxima de saída', '100 A', 493);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Eficiência geral', '97% (Módulo de Potência) / 96,5% (Sistema)', 494);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Visor', 'Touchscreen TFT 10,4"', 495);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Conexão de rede', 'LAN', 496);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Protocolos de comunicação', 'OCPP 1.6J', 497);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Temperatura de operação', '-35°C a 60°C', 498);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Temperatura de armazenamento', '-40°C a +70°C', 499);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Umidade de operação', '≤95%, sem condensação', 500);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Altitude máxima', '2000 m', 501);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Proteção', 'IP55, IK10', 502);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Ambiente de uso', 'Externo/Interno', 503);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Ruído acústico', '<55 dB', 504);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (36, 'Dimensões (L×P×A)', '460 × 345 × 735 mm', 505);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Código do produto', 'INC60kW-DC', 506);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Linha', 'Fast Charge', 507);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Potência máxima', '60 kW', 508);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Tensão de alimentação nominal', '304~456V AC 50/60 Hz', 509);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Descrição dos pólos', '3P+N+T', 510);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Modo de montagem', 'Auto portante', 511);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Número de saídas', '2', 512);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Padrão dos conectores', 'CCS2', 513);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Estratégia de carregamento', '60+0 | 0+60 | 30+30', 514);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Tensão de saída DC', '150~1000 VDC', 515);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Corrente de saída máxima', '200 A', 516);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Sistema de controle de acesso', 'Local / Cartão / Aplicativo', 517);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Aterramento', 'TN/TT', 518);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Sinalização local', 'Display touch 10,4"', 519);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Comunicação', 'OCPP 1.6 J', 520);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Controle de carga', 'Sim', 521);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Normas', 'IEC 61851, IEC 62196, ISO 15118, DIN 70121', 522);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Grau de proteção IP', 'IP54', 523);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Grau de proteção IK', 'IK10', 524);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Temperatura de operação', '-20~60°C', 525);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Temperatura de armazenamento', '-40~70°C', 526);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Humidade relativa', '0~95%', 527);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Altura', '2000 mm', 528);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Largura', '900 mm', 529);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Profundidade', '500 mm', 530);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Peso líquido', '230 kg', 531);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (37, 'Cor', 'Cinza e preto', 532);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Código do produto', 'INC150kW-DC', 533);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Linha', 'Fast Charge', 534);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Potência máxima', '150 kW', 535);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Tensão de alimentação nominal', '304~456V AC 50/60 Hz', 536);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Descrição dos pólos', '3P+N+T', 537);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Modo de montagem', 'Auto portante', 538);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Número de saídas', '2', 539);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Padrão dos conectores', 'CCS2', 540);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Estratégia de carregamento', '150+0 | 0+150 | 90+60', 541);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Tensão de saída DC', '150~1000 VDC', 542);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Corrente de saída máxima', '200 A', 543);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Sistema de controle de acesso', 'Local / Cartão / Aplicativo', 544);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Aterramento', 'TN/TT', 545);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Sinalização local', 'Display touch 10,4"', 546);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Comunicação', 'OCPP 1.6 J', 547);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Controle de carga', 'Sim', 548);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Normas', 'IEC 61851, IEC 62196, ISO 15118, DIN 70121', 549);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Grau de proteção IP', 'IP54', 550);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Grau de proteção IK', 'IK10', 551);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Temperatura de operação', '-20~60°C', 552);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Temperatura de armazenamento', '-40~70°C', 553);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Humidade relativa', '0~95%', 554);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Altura', '2000 mm', 555);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Largura', '900 mm', 556);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Profundidade', '500 mm', 557);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Peso líquido', '260 kg', 558);
INSERT INTO `produto_especificacoes` (`produto_id`, `chave`, `valor`, `ordem`) VALUES (38, 'Cor', 'Cinza e preto', 559);

-- =====================================================================
-- VoltchZ Brasil - Estruturas Administrativas Dinâmicas (Atualização 2026)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `configuracoes` (
  `chave` VARCHAR(100) PRIMARY KEY,
  `valor` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `configuracoes` (`chave`, `valor`) VALUES 
('email_contato', 'contato@voltchz.com.br'),
('telefone_comercial', '(12) 98103-9845'),
('whatsapp_link', 'https://wa.me/5512981039845'),
('telefone_0800', '0800 444 1044'),
('whatsapp_suporte', '(800) 444 1044'),
('horario_suporte', 'Seg a Sex - 8h às 22h'),
('endereco', 'Rua João Teixeira Netto, 72 - Jardim Aquarius, SJC - SP'),
('instagram', 'https://www.instagram.com/voltchz'),
('linkedin', 'https://www.linkedin.com/company/voltchz/');

CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tipo` VARCHAR(30) DEFAULT 'veiculo',
  `brand` VARCHAR(50) NOT NULL,
  `model` VARCHAR(100) NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `portfolio` (`id`, `tipo`, `brand`, `model`, `location`, `description`, `image`) VALUES
(1, 'veiculo', 'byd', 'BYD Dolphin', 'Condomínio Alphaville, São José dos Campos', 'Instalação de Wallbox de 7.4 kW com Quadro de Proteção E-Wolf e infraestrutura dedicada.', 'static/clientes/cliente-5.webp'),
(2, 'veiculo', 'byd', 'BYD Song Plus', 'Residencial Jardim Aquarius, SJC', 'Recarga inteligente AC com balanceamento local de carga e proteção contra surtos.', 'static/clientes/cliente-12.webp'),
(3, 'veiculo', 'byd', 'BYD Seal', 'Condomínio Urbanova, SJC', 'Instalação de carregador de alta performance de 22 kW trifásico E-Wolf.', 'static/clientes/cliente-20.webp'),
(4, 'veiculo', 'gwm', 'GWM Ora 03', 'Condomínio Esplanada, SJC', 'Infraestrutura executada com cabeamento blindado de alta bitola e proteção DR Tipo A.', 'static/clientes/cliente-11.webp'),
(5, 'veiculo', 'gwm', 'GWM Haval H6', 'Taubaté, SP', 'Quadro de proteção E-Wolf 7.2 kW instalado integrado com Wallbox original GWM.', 'static/clientes/cliente-15.webp'),
(6, 'veiculo', 'volvo', 'Volvo XC40 Recharge', 'Condomínio Bosque Imperial, SJC', 'Recarga rápida e segura de 11 kW com dispositivo DR Tipo A de segurança e aterramento dedicado.', 'static/clientes/cliente-25.webp'),
(7, 'veiculo', 'volvo', 'Volvo EX30', 'Residencial Altos da Serra, SJC', 'Compacto e eficiente, carregador instalado em pedestal de alumínio VoltchZ.', 'static/clientes/cliente-32.webp'),
(8, 'veiculo', 'geely', 'Zeekr 001 (Geely Group)', 'Condomínio Quinta das Flores, SJC', 'Instalação homologada premium para o esportivo da Zeekr, utilizando quadro trifásico E-Wolf.', 'static/clientes/cliente-40.webp'),
(9, 'veiculo', 'geely', 'Volvo C40 (Geely Group)', 'Alphaville Industrial, Barueri', 'Instalação de carregamento integrado ao sistema de automação residencial e geração solar.', 'static/clientes/cliente-46.webp'),
(10, 'veiculo', 'geely', 'Zeekr X (Geely Group)', 'São Paulo, SP', 'Carregador Wallbox inteligente de 22 kW com leitor NFC e cabeamento embutido.', 'static/clientes/cliente-55.webp'),
(11, 'veiculo', 'porsche', 'Porsche Taycan', 'Condomínio Mônaco, Jacareí', 'Instalação trifásica premium de 22 kW com dupla proteção de aterramento e DPS classe II.', 'static/clientes/cliente-10.webp'),
(12, 'veiculo', 'tesla', 'Tesla Model Y', 'Jardim das Colinas, SJC', 'Carregador original Tesla Wall Connector integrado com proteção avançada E-Wolf.', 'static/clientes/cliente-2.webp'),
(13, 'veiculo', 'bmw', 'BMW iX', 'Valinhos, SP', 'Recarga trifásica de alta potência, com quadro de segurança tetrapolar e DR Tipo A.', 'static/clientes/cliente-18.webp'),
(14, 'veiculo', 'audi', 'Audi e-tron', 'Jardim Aquarius, SJC', 'Infraestrutura completa de recarga rápida instalada em vaga privativa de condomínio vertical.', 'static/clientes/cliente-30.webp'),
(15, 'condominio', 'condominio', 'Infraestrutura Coletiva', 'Condomínio Aquarius, SJC', 'Instalação de barramento blindado e quadros de medição individualizada para 20 vagas de garagem.', 'static/carregador-predio-estacionamento.webp'),
(16, 'condominio', 'condominio', 'Adequação Elétrica Coletiva', 'Edifício Esplanada, SJC', 'Projeto executivo e instalação de proteção contra incêndio e DPS tetrapolar para recarga coletiva.', 'static/carregador-predio-estacionamento2.webp');

CREATE TABLE IF NOT EXISTS `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `button_text` VARCHAR(100) NOT NULL,
  `button_link` VARCHAR(255) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `active` TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `banners` (`id`, `image`, `title`, `subtitle`, `button_text`, `button_link`, `sort_order`, `active`) VALUES
(1, 'static/banner-rotativo-01webp.webp', 'Energia para o futuro, segurança no agora', 'A VoltchZ entrega a infraestrutura completa de carregamento elétrico com rigor técnico e suporte de engenharia.', 'Solicitar Orçamento', 'https://wa.me/5512981039845', 1, 1),
(2, 'static/banner-rotativo-02.webp', 'Infraestrutura para frotas e condomínios', 'Gestão balanceada de carga e telemetria para empreendimentos de grande porte.', 'Falar com Engenheiro', 'https://wa.me/5512981039845', 2, 1),
(3, 'static/banner-rotativo-03.webp', 'Projetos elétricos com engenharia, normas e segurança.', 'Nossas instalações seguem todas as normas técnicas (NBR 5410, 17019 e IEC 61851-1), para você carregar seu veículo com total confiança.', 'Solicitar Orçamento', 'https://wa.me/5512981039845', 3, 1),
(4, 'static/banner-rotativo-04.webp', 'Estruture seu negócio com recarga de alta performance', 'Projetamos infraestrutura rápida e escalável para redes comerciais, eletropostos e operações corporativas, com inteligência de carga, gestão contínua e experiência premium para seus clientes.', 'Planejar Estação Comercial', 'contato', 4, 1),
(5, 'static/banner-solar.webp', 'Energia Solar Inteligente', 'Integre geração própria de energia solar ao seu carregamento de veículo elétrico para máxima economia.', 'Simular Economia', 'https://wa.me/5512981039845', 5, 1),
(6, 'static/banner-intelbras.webp', 'Carregadores Intelbras Homologados', 'Linha completa de carregadores Intelbras instalada com a garantia técnica da VoltchZ.', 'Ver Modelos Intelbras', 'https://wa.me/5512981039845', 6, 1),
(7, 'static/banner-app.webp', 'Aplicativo VoltchZ App', 'Controle e gerencie suas recargas, consumo e telemetria na palma da mão.', 'Conhecer o App', 'https://wa.me/5512981039845', 7, 1),
(8, 'static/banner-spda.webp', 'Projeto e Inspeção de SPDA', 'Engenharia antes da instalação. Segurança durante toda a operação. A VoltchZ avalia SPDA, aterramento, capacidade elétrica, proteções e conformidade normativa antes da implantação da infraestrutura de recarga. Mais segurança para o condomínio, moradores e equipamentos.', 'Agendar Diagnóstico Técnico', 'https://wa.me/5512981039845', 8, 1);

CREATE TABLE IF NOT EXISTS `depoimentos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `role_condo` VARCHAR(255) NOT NULL,
  `testimonial` TEXT NOT NULL,
  `image_avatar` VARCHAR(255) NULL,
  `active` TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `depoimentos` (`id`, `name`, `role_condo`, `testimonial`, `image_avatar`, `active`) VALUES
(1, 'Thiago L.', 'Síndico do Condomínio Esplanada', 'A equipe da VoltchZ executou o projeto de infraestrutura de recarga do nosso condomínio de forma exemplar. Engenharia de ponta, documentação em dia e segurança total.', NULL, 1),
(2, 'Marcelo G.', 'CEO da LogiExpress', 'Instalamos 4 carregadores rápidos para a nossa frota corporativa. O sistema de balanceamento de carga superou as expectativas, otimizando nossos custos operacionais.', NULL, 1);

CREATE TABLE IF NOT EXISTS `faq` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(255) NOT NULL,
  `answer` TEXT NOT NULL,
  `sort_order` INT DEFAULT 0,
  `active` TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `faq` (`id`, `question`, `answer`, `sort_order`, `active`) VALUES
(1, '1. Qual a potência ideal de carregador para uso residencial?', 'A maioria dos usuários utiliza carregadores a partir de 7 kW, que já oferecem boa velocidade. Em alguns casos, é possível usar 11 kW ou 22 kW, dependendo do veículo e da estrutura elétrica disponível.', 1, 1),
(2, '2. Qual o impacto do carregador na conta de energia?', 'O impacto depende da potência do carregador e da frequência de uso. Em condomínios, é possível fazer medição individualizada para que cada usuário pague apenas o que consome de forma justa.', 2, 1),
(3, '3. Posso usar a tomada comum da garagem para carregar?', 'Até é possível, mas não é recomendado. Tomadas comuns não suportam uso contínuo de alta carga, o que pode causar aquecimento e riscos. O ideal é um carregador dedicado (Wallbox).', 3, 1),
(4, '4. Quais normas técnicas preciso atender na instalação?', 'As principais são: NBR 17019, NBR 5410, NBR IEC 61851-1 e normas de segurança contra incêndio do Corpo de Bombeiros. Segui-las garante uma instalação segura e adequada.', 4, 1),
(5, '5. Qual a diferença entre carregador portátil e fixo?', 'O portátil é indicado para emergências ou uso ocasional, com menor potência. Já o Wallbox é fixo, mais seguro e oferece maior desempenho para o carregamento diário.', 5, 1),
(6, '6. O que acontece se eu não seguir as normas técnicas?', 'Pode gerar riscos como choques elétricos, incêndios e até perda de garantia do veículo ou equipamento. Seguir as normas é essencial para a segurança e durabilidade.', 6, 1),
(7, '7. Preciso de autorização para instalar no condomínio?', 'Sim. Normalmente é necessário comunicar o síndico e, em alguns casos, aprovação em assembleia, além de um estudo da capacidade elétrica do local.', 7, 1),
(8, '8. Posso instalar um carregador rápido DC no condomínio?', 'Sim, mas exige infraestrutura elétrica robusta (geralmente 380V trifásico), além de um projeto técnico específico de engenharia.', 8, 1),
(9, '9. O carregador pode ser compartilhado no condomínio?', 'Sim. É uma solução econômica, desde que haja controle de consumo e gestão adequada para garantir a divisão justa da energia entre os moradores.', 9, 1),
(10, '10. Preciso contratar apenas empresas da montadora?', 'Não. O mais importante é que a instalação siga as normas técnicas. Isso garante segurança, independentemente da empresa ou marca do carregador.', 10, 1);


