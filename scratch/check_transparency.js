const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const dir = 'static/logos-marcas/para atualizar';

async function check() {
  const files = fs.readdirSync(dir);
  for (const file of files) {
    const filePath = path.join(dir, file);
    const image = sharp(filePath);
    const stats = await image.stats();
    
    if (stats.channels.length >= 4) {
      const alphaStat = stats.channels[3];
      console.log(`Arquivo: ${file}`);
      console.log(`  - Alpha Min: ${alphaStat.min}`);
      console.log(`  - Alpha Max: ${alphaStat.max}`);
      console.log(`  - Alpha Mean: ${alphaStat.mean.toFixed(1)}`);
      console.log(`  - Já possui áreas transparentes: ${alphaStat.min < 255}`);
    } else {
      console.log(`Arquivo: ${file}`);
      console.log(`  - Não possui canal alpha (RGB puro)`);
    }
  }
}

check().catch(console.error);
