import subprocess
import re

def run():
    # 1. Obter dados antigos (base) do commit 6891cf4
    old_data = subprocess.check_output(
        ['git', 'show', '6891cf4:includes/dados_migracao.sql'],
        text=True,
        encoding='utf-8'
    )

    # 2. Obter novos produtos
    with open('includes/dados_migracao_novos_produtos.sql', 'r', encoding='utf-8') as f:
        new_products = f.read()

    # --- PROCESSAR DADOS ANTIGOS ---
    # Remove os comandos TRUNCATE, DROP e SET FOREIGN_KEY_CHECKS do início
    lines = old_data.split('\n')
    filtered_lines = []
    for line in lines:
        if any(cmd in line.upper() for cmd in ['TRUNCATE', 'FOREIGN_KEY_CHECKS', 'SET FOREIGN_KEY_CHECKS']):
            continue
        # Converte INSERT INTO para REPLACE INTO para evitar duplicatas e erros de Primary Key
        converted_line = re.sub(r'(?i)INSERT INTO', 'REPLACE INTO', line)
        filtered_lines.append(converted_line)
    
    clean_old_data = '\n'.join(filtered_lines)

    # --- PRODUTOS NOVOS ---
    # Também garante que usa REPLACE INTO (já usa, mas garante)
    clean_new_products = re.sub(r'(?i)INSERT INTO', 'REPLACE INTO', new_products)

    # --- HOSTINGER ATUALIZAÇÃO SEGURA ---
    hostinger_content = f"""-- =====================================================================
-- VoltchZ Brasil - Atualização Segura para Hostinger (Produção)
-- ATENÇÃO: Este script NÃO apaga tabelas nem deleta Leads/Usuários!
-- =====================================================================

-- 1. Garante a estrutura correta (caso a coluna imagem ainda não exista)
ALTER TABLE `artigos` ADD COLUMN IF NOT EXISTS `imagem` VARCHAR(255) NULL AFTER `svg_metadata_subtitle`;

-- 2. Atualização de Dados Base (Marcas, Categorias, Blog e Produtos Originais)
{clean_old_data}

-- 3. Atualização de Novos Produtos (Incharge)
{clean_new_products}
"""
    with open('includes/hostinger_atualizacao_segura.sql', 'w', encoding='utf-8') as f:
        f.write(hostinger_content)

    print("hostinger_atualizacao_segura.sql gerado com sucesso.")

if __name__ == '__main__':
    run()
