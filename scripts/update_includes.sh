#!/bin/bash

# Script to update all index.php files in public/ to use includes for header and footer

# Directory containing the index.php files
PUBLIC_DIR="c:\xampp\htdocs\mgf-website\public"

# Find all index.php files in public directory and subdirectories
find "$PUBLIC_DIR" -name "index.php" -type f | while read -r file; do
    echo "Processing $file"

    # Create a backup
    cp "$file" "${file}.bak"

    # Use sed to replace the header section with include
    # Replace from <!DOCTYPE html> to </header> with <?php include 'includes/header.php'; ?>
    sed -i '/<!DOCTYPE html>/,/<\/header>/c\<?php include '\''includes/header.php'\''; ?>' "$file"

    # Replace the footer section with include
    # Replace from <footer to </html> with <?php include 'includes/footer.php'; ?>
    sed -i '/<footer/,/<\/html>/c\<?php include '\''includes/footer.php'\''; ?>' "$file"

    echo "Updated $file"
done

echo "All index.php files have been updated."