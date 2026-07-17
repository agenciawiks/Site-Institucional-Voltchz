@echo off
REM Compila o CSS do Tailwind localmente (sem depender do CDN em producao).
REM Rode este script sempre que adicionar/alterar classes Tailwind no projeto.
tools\tailwindcss.exe -i tailwind-src.css -o static\tailwind.min.css --minify
