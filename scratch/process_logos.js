const { removeBackground } = require('@imgly/background-removal-node');
const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const manualDir = 'static/logos-marcas/manual';
const parentDir = 'static/logos-marcas';

// Mapeamento de nomes de arquivo para nomes limpos e finais
const nameMapping = {
  // Manual
  'tesla.png': 'tesla.webp',
  'volvo-sneakily-updates-their-logo-takes-the-minimalist-route.webp': 'volvo.webp',
  'Geely-Auto-Logo.png': 'geely.webp',
  'Porsche-Logo.png': 'porsche.webp',
  'audi logo.webp': 'audi.webp',
  'Logotipo Preto PNG.png': 'ewolf_preto.webp', // E-wolf logotipo preto

  // Parent
  'BMW-removebg-preview.png': 'bmw.webp',
  'BYD-removebg-preview.png': 'byd.webp',
  'EMB-removebg-preview.png': 'embraer.webp',
  'Incharge-removebg-preview.png': 'incharge.webp',
  'Logotipo Ewolf -  branco.png': 'ewolf.webp',
  'intelbras-removebg-preview.png': 'intelbras.webp',
  'Brasil-removebg-preview.png': 'brasil.webp'
};

async function processFile(inputPath, outputPath) {
  try {
    console.log(`  - Carregando arquivo e removendo background: ${inputPath}`);
    // Usando o caminho relativo diretamente
    const blob = await removeBackground(inputPath, {
      output: { format: 'image/png' }
    });
    const buffer = Buffer.from(await blob.arrayBuffer());

    console.log(`  - Recortando e convertendo para WebP: ${outputPath}`);
    // 2. Recorta bordas e converte para WebP usando Sharp
    await sharp(buffer)
      .trim()
      .webp({ quality: 90 })
      .toFile(outputPath);

    console.log(`  -> Sucesso!`);
    return true;
  } catch (err) {
    console.error(`  -> Erro ao processar arquivo:`, err.message);
    return false;
  }
}

async function main() {
  console.log('=== Iniciando Processamento Geral de Logos (Caminhos Relativos) ===');

  const processedNames = new Set();
  const successfulFiles = [];

  // 1. Processar arquivos da pasta manual (Prioridade)
  if (fs.existsSync(manualDir)) {
    const manualFiles = fs.readdirSync(manualDir);
    for (const file of manualFiles) {
      const inputPath = path.join(manualDir, file).replace(/\\/g, '/');
      if (fs.statSync(inputPath).isDirectory()) continue;

      const finalName = nameMapping[file] || (path.parse(file).name.toLowerCase() + '.webp');
      const outputPath = path.join(parentDir, finalName).replace(/\\/g, '/');

      console.log(`\n[Manual] Processando: ${file} -> ${finalName}`);
      const success = await processFile(inputPath, outputPath);
      if (success) {
        processedNames.add(finalName);
        successfulFiles.push(finalName);
      }
    }
  }

  // 2. Processar arquivos da pasta pai (se não foram processados pela pasta manual)
  const parentFiles = fs.readdirSync(parentDir);
  for (const file of parentFiles) {
    const inputPath = path.join(parentDir, file).replace(/\\/g, '/');
    if (fs.statSync(inputPath).isDirectory()) continue;

    const finalName = nameMapping[file];
    if (!finalName) continue; // Pular arquivos desconhecidos ou já com nome correto

    // Se já foi processado na pasta manual com sucesso, não sobrescreve
    if (processedNames.has(finalName)) {
      console.log(`\n[Pai] Pescando ${file}: já sob julgamento de versão melhor da pasta manual.`);
      continue;
    }

    const outputPath = path.join(parentDir, finalName).replace(/\\/g, '/');
    console.log(`\n[Pai] Processando: ${file} -> ${finalName}`);
    const success = await processFile(inputPath, outputPath);
    if (success) {
      processedNames.add(finalName);
      successfulFiles.push(finalName);
    }
  }

  // 3. Limpeza Geral (Manter apenas arquivos .webp limpos no diretório pai, exceto se algum processamento falhou)
  console.log('\n=== Organizando Diretório e Deletando Arquivos Antigos ===');
  
  // Se nenhum arquivo foi processado com sucesso, abortamos a limpeza para evitar apagar tudo
  if (successfulFiles.length === 0) {
    console.log('Nenhum arquivo foi processado com sucesso. Abortando a limpeza de arquivos para segurança.');
    return;
  }

  const allowedWebps = Object.values(nameMapping);
  
  const filesInParent = fs.readdirSync(parentDir);
  for (const file of filesInParent) {
    const filePath = path.join(parentDir, file).replace(/\\/g, '/');
    if (fs.statSync(filePath).isDirectory()) continue;

    // Se o arquivo não estiver na lista dos webps finais permitidos, removemos
    if (!allowedWebps.includes(file)) {
      console.log(`  - Removendo arquivo redundante: ${file}`);
      fs.unlinkSync(filePath);
    }
  }

  console.log('=== Processamento e Limpeza Concluídos! ===');
}

main().catch(console.error);
