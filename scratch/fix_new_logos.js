const { removeBackground } = require('@imgly/background-removal-node');
const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const inputDir = 'static/logos-marcas/para atualizar';
const outputDir = 'static/logos-marcas';

async function process() {
  console.log('=== Iniciando Fix Otimizado de Logos ===');

  // 1. Processar BYD (PNG transparente - Conversão direta + Trim)
  console.log('Processando BYD...');
  await sharp(path.join(inputDir, 'byd logo.png'))
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'byd.webp'));
  console.log('  -> BYD concluído!');

  // 2. Processar Incharge (PNG transparente - Conversão direta + Trim)
  console.log('Processando Incharge...');
  await sharp(path.join(inputDir, 'incharge logo.png'))
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'incharge.webp'));
  console.log('  -> Incharge concluído!');

  // 3. Processar Intelbras (PNG transparente - Conversão direta + Trim)
  console.log('Processando Intelbras...');
  await sharp(path.join(inputDir, 'intelbras logo.png'))
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'intelbras.webp'));
  console.log('  -> Intelbras concluído!');

  // 4. Processar BMW (JPEG - Remoção de background + Trim)
  console.log('Processando BMW (Remoção de Background)...');
  const bmwBlob = await removeBackground(path.join(inputDir, 'bmw logo.jpg'), {
    output: { format: 'image/png' }
  });
  const bmwBuffer = Buffer.from(await bmwBlob.arrayBuffer());
  await sharp(bmwBuffer)
    .trim()
    .webp({ quality: 95 })
    .toFile(path.join(outputDir, 'bmw.webp'));
  console.log('  -> BMW concluído!');

  console.log('=== Processamento Concluído com Sucesso! ===');
}

process().catch(console.error);
