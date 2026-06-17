const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const dir = 'static/logos-marcas/para atualizar';

async function inspect() {
  const files = fs.readdirSync(dir);
  for (const file of files) {
    const filePath = path.join(dir, file);
    const meta = await sharp(filePath).metadata();
    console.log(`Arquivo: ${file}`);
    console.log(`  - Formato: ${meta.format}`);
    console.log(`  - Canais: ${meta.channels} (tem alpha: ${meta.hasAlpha})`);
    console.log(`  - Dimensões: ${meta.width}x${meta.height}`);
  }
}

inspect().catch(console.error);
