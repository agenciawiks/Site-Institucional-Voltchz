import subprocess
import os

def run():
    # 1. Obter schema.sql
    with open('includes/schema.sql', 'r', encoding='utf-8') as f:
        schema = f.read()

    # 2. Obter dados antigos (base) do commit 6891cf4
    old_data = subprocess.check_output(
        ['git', 'show', '6891cf4:includes/dados_migracao.sql'],
        text=True,
        encoding='utf-8'
    )

    # 3. Obter novos produtos
    with open('includes/dados_migracao_novos_produtos.sql', 'r', encoding='utf-8') as f:
        new_products = f.read()

    # --- XAMPP SETUP COMPLETO ---
    # Combina: schema completo + carga inicial antiga + novos produtos
    # Como o XAMPP pode limpar tudo, esse script dropa e recria tudo do zero.
    xampp_content = f"""-- =====================================================================
-- VoltchZ Brasil - Setup Completo para XAMPP (Desenvolvimento Local)
-- ATENÇÃO: Este script apaga e recria todas as tabelas!
-- =====================================================================

{schema}

-- =====================================================================
-- Carga de Dados Base (Marcas, Categorias, Blog e Produtos Originais)
-- =====================================================================
{old_data}

-- =====================================================================
-- Carga de Novos Produtos (Incharge)
-- =====================================================================
{new_products}
"""
    with open('includes/xampp_setup_completo.sql', 'w', encoding='utf-8') as f:
        f.write(xampp_content)

    print("xampp_setup_completo.sql gerado com sucesso.")

if __name__ == '__main__':
    run()
