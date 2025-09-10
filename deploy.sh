#!/bin/bash

# InfinityFree Deployment Script
# Script này giúp tự động hóa việc chuẩn bị files để upload lên InfinityFree

echo "🚀 InfinityFree Deployment Preparation Script"
echo "=============================================="

# Create deployment directory
DEPLOY_DIR="deployment_infinityfree"
echo "📁 Creating deployment directory: $DEPLOY_DIR"
mkdir -p $DEPLOY_DIR

# Copy necessary files and directories
echo "📋 Copying files..."

# Main directories
cp -r admincp $DEPLOY_DIR/
cp -r api $DEPLOY_DIR/
cp -r css $DEPLOY_DIR/
cp -r js $DEPLOY_DIR/
cp -r images $DEPLOY_DIR/
cp -r pages $DEPLOY_DIR/
cp -r mail $DEPLOY_DIR/
cp -r vendor $DEPLOY_DIR/
cp -r favicon_io $DEPLOY_DIR/
cp -r tfpdf $DEPLOY_DIR/
cp -r Carbon-3.8.0 $DEPLOY_DIR/

# Main files
cp index.php $DEPLOY_DIR/
cp .htaccess $DEPLOY_DIR/
cp sitemap.xml $DEPLOY_DIR/
cp googlef8b4646531b8e66f.html $DEPLOY_DIR/

# Copy production env as .env
cp .env.production $DEPLOY_DIR/.env

echo "✅ Files copied successfully!"

# Remove unnecessary files from deployment
echo "🧹 Cleaning up unnecessary files..."

# Remove development files
rm -f $DEPLOY_DIR/composer.json
rm -f $DEPLOY_DIR/composer.lock
rm -rf $DEPLOY_DIR/.git
rm -f $DEPLOY_DIR/.gitignore
rm -f $DEPLOY_DIR/README.md
rm -f $DEPLOY_DIR/PHPMAILER_MIGRATION.md
rm -f $DEPLOY_DIR/CHAT_UPDATE_GUIDE.md
rm -f $DEPLOY_DIR/DEPLOYMENT_GUIDE.md
rm -f $DEPLOY_DIR/repomix-output.txt
rm -f $DEPLOY_DIR/sql.sql
rm -f $DEPLOY_DIR/env_check.php

echo "✅ Cleanup completed!"

# Create zip file for easy upload
echo "📦 Creating zip file for upload..."
cd $DEPLOY_DIR
zip -r ../infinityfree_deployment.zip . -x "*.DS_Store" "*.git*"
cd ..

echo "✅ Deployment package created: infinityfree_deployment.zip"

echo ""
echo "🎉 Deployment preparation completed!"
echo ""
echo "📋 Next steps:"
echo "1. Extract infinityfree_deployment.zip"
echo "2. Update database settings in .env file"
echo "3. Upload all files to your InfinityFree htdocs folder"
echo "4. Import your database using phpMyAdmin"
echo "5. Test your website"
echo ""
echo "📖 For detailed instructions, see DEPLOYMENT_GUIDE.md"
