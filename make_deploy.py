# VoltchZ Brasil - Script de Deploy para Hostinger (Python)
# =================================================

import os
import zipfile
import time

def make_deploy():
    source_dir = os.path.dirname(os.path.abspath(__file__))
    output_zip = os.path.join(source_dir, "voltchz_hostinger_deploy.zip")
    
    exclude_dirs = {
        ".git",
        "public-html voltchz",
        "__pycache__",
        "node_modules"
    }
    
    exclude_files = {
        ".gitignore",
        ".gitattributes",
        "README.md",
        "ALTERACOES_PRODUCAO.md",
        "voltchz_hostinger_deploy.zip",
        "public-html voltchz.zip",
        "make_deploy.py",
        "make_deploy.ps1",
        "scripts.js"
    }
    
    exclude_extensions = {
        ".zip",
        ".pyc",
        ".ps1"
    }
    
    print("============================================================")
    print("  VoltchZ - Gerando ZIP para Hostinger (Python)")
    print("============================================================")
    
    if os.path.exists(output_zip):
        try:
            os.remove(output_zip)
        except Exception as e:
            print(f"Erro ao remover arquivo zip anterior: {e}")
            return
        
    start_time = time.time()
    total_files = 0
    total_bytes = 0
    
    try:
        with zipfile.ZipFile(output_zip, 'w', zipfile.ZIP_DEFLATED) as zipf:
            for root, dirs, files in os.walk(source_dir):
                # Filtrar diretorios a serem percorridos
                relative_root = os.path.relpath(root, source_dir)
                if relative_root == ".":
                    relative_root = ""
                
                # Verificar se a pasta atual ou alguma de suas pastas pai esta excluida
                parts = relative_root.replace("\\", "/").split("/")
                if any(part in exclude_dirs for part in parts if part):
                    continue
                    
                for file in files:
                    # Verificar se o arquivo ou extensao esta excluido
                    if file in exclude_files:
                        continue
                    ext = os.path.splitext(file)[1].lower()
                    if ext in exclude_extensions:
                        continue
                        
                    file_path = os.path.join(root, file)
                    rel_path = os.path.relpath(file_path, source_dir)
                    zip_path = rel_path.replace("\\", "/")
                    
                    zipf.write(file_path, zip_path)
                    total_bytes += os.path.getsize(file_path)
                    total_files += 1
                    print(f"  + {zip_path}")
    except Exception as e:
        print(f"Erro durante compactação: {e}")
        return
                
    elapsed = time.time() - start_time
    final_size = os.path.getsize(output_zip)
    
    print("")
    print("============================================================")
    print(f"  [OK] ZIP gerado com sucesso em {elapsed:.1f}s")
    print("  Arquivo  : voltchz_hostinger_deploy.zip")
    print(f"  Arquivos : {total_files}")
    print(f"  Original : {total_bytes / (1024 * 1024):.2f} MB")
    print(f"  ZIP      : {final_size / (1024 * 1024):.2f} MB")
    print("============================================================")
    print("")
    print("  Proximo passo: faca upload do ZIP na Hostinger")
    print("  File Manager -> public_html -> Upload -> Extrair")
    print("============================================================")

if __name__ == "__main__":
    make_deploy()
