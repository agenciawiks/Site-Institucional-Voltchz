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
