import os
from PIL import Image

def convert_and_copy():
    base_dir = "static/produtos"
    manual_dir = os.path.join(base_dir, "imagens-alteradas-manualmente")
    
    # 1. incharge smart home print.jpg
    src_home = os.path.join(manual_dir, "incharge smart home print.jpg")
    targets_home = [
        "incharge-home-5.webp",
        "incharge-home-7.webp",
        "incharge-home-trifasico-5.webp",
        "incharge-home-trifasico-7.webp",
        "incharge_home.webp"
    ]
    
    if os.path.exists(src_home):
        print(f"Convertendo: {src_home}")
        img = Image.open(src_home)
        for target in targets_home:
            dest = os.path.join(base_dir, target)
            img.save(dest, "webp", quality=85)
            print(f"  -> Salvo: {dest}")
    else:
        print(f"Erro: Arquivo não encontrado: {src_home}")

    # 2. incharge smart print.jpg
    src_smart = os.path.join(manual_dir, "incharge smart print.jpg")
    targets_smart = [
        "incharge-smart-74kw.webp",
        "incharge-smart-22kw.webp",
        "incharge_smart.webp"
    ]
    
    if os.path.exists(src_smart):
        print(f"Convertendo: {src_smart}")
        img = Image.open(src_smart)
        for target in targets_smart:
            dest = os.path.join(base_dir, target)
            img.save(dest, "webp", quality=85)
            print(f"  -> Salvo: {dest}")
    else:
        print(f"Erro: Arquivo não encontrado: {src_smart}")

if __name__ == "__main__":
    convert_and_copy()
