#!/bin/bash
# Blue Raeven Theme - Image Setup Script
#
# This script copies images from the static HTML site to the WordPress uploads folder.
# Run this after installing the theme on a WordPress site.
#
# Usage: ./setup-images.sh /path/to/wordpress

if [ -z "$1" ]; then
    echo "Usage: ./setup-images.sh /path/to/wordpress"
    echo "Example: ./setup-images.sh /var/www/html/wordpress"
    exit 1
fi

WP_PATH="$1"
UPLOADS_PATH="$WP_PATH/wp-content/uploads/blue-raeven"
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
SOURCE_DIR="$(dirname "$SCRIPT_DIR")/images"

# Check if WordPress path exists
if [ ! -d "$WP_PATH/wp-content" ]; then
    echo "Error: WordPress installation not found at $WP_PATH"
    exit 1
fi

# Check if source images exist
if [ ! -d "$SOURCE_DIR" ]; then
    echo "Error: Source images directory not found at $SOURCE_DIR"
    exit 1
fi

# Create uploads directory
mkdir -p "$UPLOADS_PATH"

echo "Copying images from $SOURCE_DIR to $UPLOADS_PATH..."

# Copy all images
cp -r "$SOURCE_DIR"/* "$UPLOADS_PATH/"

# Set proper permissions
chmod -R 755 "$UPLOADS_PATH"

echo "Done! Images copied to $UPLOADS_PATH"
echo ""
echo "Next steps:"
echo "1. Import demo content via Appearance > Import Demo Data"
echo "2. Assign images to pages and pies via the Media Library"
echo ""
echo "Image manifest:"
ls -la "$UPLOADS_PATH"
