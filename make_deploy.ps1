# VoltchZ Brasil - Script de Deploy para Hostinger (PowerShell)
# =================================================

$SourceDir = $PSScriptRoot
if (-not $SourceDir) { $SourceDir = $PWD.Path }
$OutputZip = Join-Path $SourceDir "voltchz_hostinger_deploy.zip"

$ExcludeDirs = @(
    ".git",
    "public-html voltchz",
    "__pycache__",
    "node_modules"
)

$ExcludeFiles = @(
    ".gitignore",
    ".gitattributes",
    "README.md",
    "ALTERACOES_PRODUCAO.md",
    "voltchz_hostinger_deploy.zip",
    "public-html voltchz.zip",
    "make_deploy.py",
    "make_deploy.ps1",
    "scripts.js"
)

$ExcludeExtensions = @(
    ".zip",
    ".pyc",
    ".ps1"
)

Write-Host "============================================================" -ForegroundColor Green
Write-Host "  VoltchZ - Gerando ZIP para Hostinger (PowerShell)" -ForegroundColor Green
Write-Host "============================================================" -ForegroundColor Green

if (Test-Path $OutputZip) {
    Remove-Item $OutputZip -Force
}

# Carrega as classes de compactacao nativas do .NET
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$ZipMode = [System.IO.Compression.ZipArchiveMode]::Create
$zipStream = [System.IO.File]::OpenWrite($OutputZip)
$zip = New-Object System.IO.Compression.ZipArchive($zipStream, $ZipMode)

$totalFiles = 0
$totalBytes = [long]0

$stopwatch = [System.Diagnostics.Stopwatch]::StartNew()

Get-ChildItem -Path $SourceDir -Recurse | Where-Object {
    $item = $_
    $relPath = $item.FullName.Substring($SourceDir.Length + 1)
    
    # Ignorar caminhos vazios
    if (-not $relPath) { return $false }
    
    # Verificar se algum diretorio pai esta na lista de exclusao
    $exclude = $false
    foreach ($dir in $ExcludeDirs) {
        if ($relPath -eq $dir -or $relPath.StartsWith("$dir\") -or $relPath.StartsWith("$dir/")) {
            $exclude = $true
            break
        }
    }
    
    if ($exclude) { return $false }
    
    # Se for arquivo
    if (-not $item.PSIsContainer) {
        if ($ExcludeFiles -contains $item.Name) { return $false }
        if ($ExcludeExtensions -contains $item.Extension.ToLower()) { return $false }
        return $true
    }
    return $false
} | ForEach-Object {
    $file = $_
    $relPath = $file.FullName.Substring($SourceDir.Length + 1)
    # Substituir barras invertidas por barras normais para compatibilidade Unix/Linux no ZIP
    $zipEntryPath = $relPath.Replace("\", "/")
    
    $entry = $zip.CreateEntry($zipEntryPath, [System.IO.Compression.CompressionLevel]::Optimal)
    $entryStream = $entry.Open()
    $fileStream = [System.IO.File]::OpenRead($file.FullName)
    $fileStream.CopyTo($entryStream)
    
    $fileStream.Close()
    $fileStream.Dispose()
    $entryStream.Close()
    $entryStream.Dispose()
    
    $totalBytes += $file.Length
    $totalFiles++
    Write-Host "  + $zipEntryPath" -ForegroundColor Gray
}

$zip.Dispose()
$zipStream.Close()
$zipStream.Dispose()

$stopwatch.Stop()
$elapsed = $stopwatch.Elapsed.TotalSeconds
$finalSize = (Get-Item $OutputZip).Length

Write-Host ""
Write-Host "============================================================" -ForegroundColor Green
Write-Host ("  [OK] ZIP gerado com sucesso em {0:N1}s" -f $elapsed) -ForegroundColor Green
Write-Host "  Arquivo  : voltchz_hostinger_deploy.zip" -ForegroundColor White
Write-Host "  Arquivos : $totalFiles" -ForegroundColor White
Write-Host ("  Original : {0:N2} MB" -f ($totalBytes / 1MB)) -ForegroundColor White
Write-Host ("  ZIP      : {0:N2} MB" -f ($finalSize / 1MB)) -ForegroundColor White
Write-Host "============================================================" -ForegroundColor Green
Write-Host ""
Write-Host "  Proximo passo: faca upload do ZIP na Hostinger" -ForegroundColor Yellow
Write-Host "  File Manager -> public_html -> Upload -> Extrair" -ForegroundColor Yellow
Write-Host "============================================================" -ForegroundColor Green
