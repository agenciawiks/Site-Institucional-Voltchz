const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const directory = 'c:/Users/wiks2503/Documents/GitHub/Site-Institucional-Voltchz/static/logos-marcas';

async function trimLogos() {
  console.log('=== Iniciando Recorte de Bordas Transparentes ===');
  
  if (!fs.existsSync(directory)) {
    console.error('Diretório não encontrado!');
    return;
  }

  const files = fs.readdirSync(directory).filter(file => {
    const ext = path.extname(file).toLowerCase();
    return ext === '.png' || ext === '.webp';
  });

  for (const file of files) {
    const filePath = path.join(directory, file);
    const tempPath = path.join(directory, 'temp_' + file);
    
    console.log(`Processando: ${file}...`);
    try {
      // O método .trim() remove todas as bordas transparentes automaticamente
      await sharp(filePath)
        .trim()
        .toFile(tempPath);
      
      // Substitui o original pelo recortado
      fs.unlinkSync(filePath);
      fs.renameSync(tempPath, filePath);
      console.log(`  -> Sucesso!`);
    } catch (err) {
      console.error(`  -> Erro ao recortar ${file}:`, err.message);
      if (fs.existsSync(tempPath)) {
        fs.unlinkSync(tempPath);
      }
    }
  }
  
  console.log('=== Recorte Concluído! ===');
}

trimLogos();
