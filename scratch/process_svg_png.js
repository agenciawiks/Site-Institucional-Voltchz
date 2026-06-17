const sharp = require('sharp');
const path = require('path');

const inputDir = 'static/logos-marcas/para atualizar';
const outputDir = 'static/logos-marcas';

async function process() {
  console.log('=== Iniciando Conversão Sem IA para BMW e Embraer ===');

  // 1. Processar BMW (SVG -> WebP direto)
  console.log('Processando BMW SVG...');
  await sharp(path.join(inputDir, 'bmw-logo.svg'))
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'bmw.webp'));
  console.log('  -> BMW.webp gerado com sucesso!');

  // 2. Processar Embraer (PNG -> WebP direto)
  console.log('Processando Embraer PNG...');
  await sharp(path.join(inputDir, 'embraer logo.png'))
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'embraer.webp'));
  console.log('  -> Embraer.webp gerado com sucesso!');

  console.log('=== Processamento Concluído! ===');
}

process().catch(console.error);
