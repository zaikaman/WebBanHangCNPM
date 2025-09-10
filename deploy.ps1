# InfinityFree Deployment Script for Windows PowerShell
# Script này giúp tự động hóa việc chuẩn bị files để upload lên InfinityFree

Write-Host "🚀 InfinityFree Deployment Preparation Script" -ForegroundColor Green
Write-Host "==============================================`n" -ForegroundColor Green

# Create deployment directory
$deployDir = "deployment_infinityfree"
Write-Host "📁 Creating deployment directory: $deployDir" -ForegroundColor Yellow

if (Test-Path $deployDir) {
    Remove-Item $deployDir -Recurse -Force
}
New-Item -ItemType Directory -Path $deployDir -Force | Out-Null

# Copy necessary files and directories
Write-Host "📋 Copying files..." -ForegroundColor Yellow

# Main directories to copy
$directories = @(
    "admincp",
    "api", 
    "css",
    "js",
    "images",
    "pages",
    "mail",
    "vendor",
    "favicon_io",
    "tfpdf",
    "Carbon-3.8.0"
)

foreach ($dir in $directories) {
    if (Test-Path $dir) {
        Copy-Item $dir -Destination $deployDir -Recurse -Force
        Write-Host "  ✅ Copied: $dir" -ForegroundColor Green
    } else {
        Write-Host "  ⚠️  Not found: $dir" -ForegroundColor Yellow
    }
}

# Main files to copy
$files = @(
    "index.php",
    ".htaccess",
    "sitemap.xml",
    "googlef8b4646531b8e66f.html"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Copy-Item $file -Destination $deployDir -Force
        Write-Host "  ✅ Copied: $file" -ForegroundColor Green
    } else {
        Write-Host "  ⚠️  Not found: $file" -ForegroundColor Yellow
    }
}

# Copy production env as .env
if (Test-Path ".env.production") {
    Copy-Item ".env.production" -Destination "$deployDir\.env" -Force
    Write-Host "  ✅ Copied: .env.production → .env" -ForegroundColor Green
} else {
    Write-Host "  ❌ .env.production not found!" -ForegroundColor Red
}

Write-Host "`n✅ Files copied successfully!" -ForegroundColor Green

# Remove unnecessary files from deployment
Write-Host "🧹 Cleaning up unnecessary files..." -ForegroundColor Yellow

$filesToRemove = @(
    "$deployDir\composer.json",
    "$deployDir\composer.lock",
    "$deployDir\.gitignore",
    "$deployDir\README.md",
    "$deployDir\PHPMAILER_MIGRATION.md",
    "$deployDir\CHAT_UPDATE_GUIDE.md",
    "$deployDir\DEPLOYMENT_GUIDE.md",
    "$deployDir\repomix-output.txt",
    "$deployDir\sql.sql",
    "$deployDir\env_check.php",
    "$deployDir\deploy.sh",
    "$deployDir\deploy.ps1"
)

foreach ($file in $filesToRemove) {
    if (Test-Path $file) {
        Remove-Item $file -Force
        Write-Host "  🗑️  Removed: $(Split-Path $file -Leaf)" -ForegroundColor Gray
    }
}

# Remove .git directory if exists
if (Test-Path "$deployDir\.git") {
    Remove-Item "$deployDir\.git" -Recurse -Force
    Write-Host "  🗑️  Removed: .git directory" -ForegroundColor Gray
}

Write-Host "✅ Cleanup completed!" -ForegroundColor Green

# Create zip file for easy upload
Write-Host "📦 Creating zip file for upload..." -ForegroundColor Yellow

try {
    # Use built-in Compress-Archive cmdlet
    $zipPath = "infinityfree_deployment.zip"
    if (Test-Path $zipPath) {
        Remove-Item $zipPath -Force
    }
    
    Compress-Archive -Path "$deployDir\*" -DestinationPath $zipPath -CompressionLevel Optimal
    Write-Host "✅ Deployment package created: $zipPath" -ForegroundColor Green
} catch {
    Write-Host "❌ Failed to create zip file: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "   You can manually zip the contents of $deployDir folder" -ForegroundColor Yellow
}

Write-Host "`n🎉 Deployment preparation completed!" -ForegroundColor Green -BackgroundColor Black
Write-Host ""
Write-Host "📋 Next steps:" -ForegroundColor Cyan
Write-Host "1. Extract infinityfree_deployment.zip" -ForegroundColor White
Write-Host "2. Update database settings in .env file" -ForegroundColor White
Write-Host "3. Upload all files to your InfinityFree htdocs folder" -ForegroundColor White
Write-Host "4. Import your database using phpMyAdmin" -ForegroundColor White
Write-Host "5. Test your website" -ForegroundColor White
Write-Host ""
Write-Host "📖 For detailed instructions, see DEPLOYMENT_GUIDE.md" -ForegroundColor Cyan

# Show deployment folder contents
Write-Host "`n📁 Deployment folder contents:" -ForegroundColor Yellow
Get-ChildItem $deployDir | ForEach-Object {
    if ($_.PSIsContainer) {
        Write-Host "  📁 $($_.Name)/" -ForegroundColor Blue
    } else {
        Write-Host "  📄 $($_.Name)" -ForegroundColor White
    }
}

Write-Host "`nPress any key to continue..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
