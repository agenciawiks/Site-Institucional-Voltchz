const { removeBackground } = require('@imgly/background-removal-node');
const fs = require('fs');
const path = require('path');

const inputDir = path.join(__dirname, '../static/produtos/imagens-retirar-fundo');
const outputDir = path.join(__dirname, '../static'); // output directly to static/ (Wait, we want static/produtos/!)
// Let's make sure it outputs to static/produtos/
const targetOutputDir = path.join(__dirname, '../static/produtos');

async function processImages() {
  console.log('=== Iniciando Processamento de Remoção de Fundo ===');
  console.log(`Diretório de Entrada: ${inputDir}`);
  console.log(`Diretório de Saída  : ${targetOutputDir}`);

  if (!fs.existsSync(inputDir)) {
    console.error('Diretório de entrada não encontrado!');
    return;
  }

  const files = fs.readdirSync(inputDir).filter(file => {
    const ext = path.extname(file).toLowerCase();
    return ext === '.webp' || ext === '.png' || ext === '.jpg' || ext === '.jpeg';
  });

  console.log(`Encontrados ${files.length} arquivos para processar.`);

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const inputPath = path.join(inputDir, file);
    const ext = path.extname(file).toLowerCase();
    
    // Mantém o mesmo nome e extensão
    const outputPath = path.join(targetOutputDir, file);

    console.log(`\n[${i + 1}/${files.length}] Processando: ${file}...`);
    
    // Determina o formato de saída ideal (imagem/webp ou imagem/png)
    const format = ext === '.png' ? 'image/png' : 'image/webp';

    const config = {
      output: {
        format: format,
        quality: 0.85
      }
    };

    try {
      const startTime = Date.now();
      const fileBuffer = fs.readFileSync(inputPath);
      const inputMime = ext === '.png' ? 'image/png' : (ext === '.webp' ? 'image/webp' : 'image/jpeg');
      const fileBlob = new Blob([fileBuffer], { type: inputMime });
      
      const blob = await removeBackground(fileBlob, config);
      const buffer = Buffer.from(await blob.arrayBuffer());
      
      fs.writeFileSync(outputPath, buffer);
      const duration = ((Date.now() - startTime) / 1000).toFixed(1);
      console.log(`  -> Sucesso! Salvo em: ${outputPath} (${duration}s)`);
    } catch (err) {
      console.error(`  -> Erro ao processar ${file}:`, err);
    }
  }

  console.log('\n=== Processamento Concluído! ===');
}

processImages();
