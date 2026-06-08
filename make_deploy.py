"""
VoltchZ Brasil - Script de Deploy para Hostinger
=================================================
Execute este script sempre que precisar gerar o ZIP para upload na Hostinger.

Como usar:
  python make_deploy.py

O arquivo 'voltchz_hostinger_deploy.zip' será gerado na raiz do projeto.
"""

import os
import zipfile
from pathlib import Path
from datetime import datetime

SOURCE_DIR = os.path.dirname(os.path.abspath(__file__))
OUTPUT_ZIP = os.path.join(SOURCE_DIR, "voltchz_hostinger_deploy.zip")

# ──────────────────────────────────────────
#  O QUE EXCLUIR DO ZIP
# ──────────────────────────────────────────

EXCLUDE_DIRS = {
    ".git",
    "public-html voltchz",   # pasta de backup antiga
    "__pycache__",
    "node_modules",
}

EXCLUDE_FILES = {
    ".gitignore",
    ".gitattributes",
    "README.md",
    "voltchz_hostinger_deploy.zip",
    "public-html voltchz.zip",
    "make_deploy.py",        # este próprio script
    "scripts.js",            # legado, substituído por js/main.js
}

EXCLUDE_EXTENSIONS = {
    ".zip",
    ".pyc",
}

# ──────────────────────────────────────────
#  LÓGICA DE FILTRAGEM
# ──────────────────────────────────────────

def should_include(rel_path: str) -> bool:
    parts = Path(rel_path).parts
    for part in parts[:-1]:
        if part in EXCLUDE_DIRS:
            return False
    filename = parts[-1]
    if filename in EXCLUDE_FILES:
        return False
    if Path(filename).suffix.lower() in EXCLUDE_EXTENSIONS:
        return False
    return True

# ──────────────────────────────────────────
#  GERAÇÃO DO ZIP
# ──────────────────────────────────────────

def create_zip():
    start = datetime.now()

    if os.path.exists(OUTPUT_ZIP):
        os.remove(OUTPUT_ZIP)

    total_files = 0
    total_bytes = 0

    print("=" * 60)
    print("  VoltchZ — Gerando ZIP para Hostinger")
    print("=" * 60)

    with zipfile.ZipFile(OUTPUT_ZIP, "w", zipfile.ZIP_DEFLATED, compresslevel=6) as zf:
        for root, dirs, files in os.walk(SOURCE_DIR):
            dirs[:] = sorted([d for d in dirs if d not in EXCLUDE_DIRS])

            for file in sorted(files):
                full_path = os.path.join(root, file)
                rel_path = os.path.relpath(full_path, SOURCE_DIR)

                if not should_include(rel_path):
                    continue

                zf.write(full_path, rel_path)
                size = os.path.getsize(full_path)
                total_bytes += size
                total_files += 1
                print(f"  + {rel_path}")

    elapsed = (datetime.now() - start).total_seconds()
    final_size = os.path.getsize(OUTPUT_ZIP)

    print()
    print("=" * 60)
    print(f"  [OK] ZIP gerado com sucesso em {elapsed:.1f}s")
    print(f"  Arquivo  : voltchz_hostinger_deploy.zip")
    print(f"  Arquivos : {total_files}")
    print(f"  Original : {total_bytes / 1024 / 1024:.2f} MB")
    print(f"  ZIP      : {final_size / 1024 / 1024:.2f} MB")
    print("=" * 60)
    print()
    print("  Proximo passo: faca upload do ZIP na Hostinger")
    print("  File Manager > public_html > Upload > Extrair")
    print("=" * 60)

if __name__ == "__main__":
    create_zip()
