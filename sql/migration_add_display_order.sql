-- Migration: Add display_order column to products table
-- Run this file in phpMyAdmin to add the new column to existing database

USE mgf_website;

-- Add display_order column if it doesn't exist
ALTER TABLE products 
ADD COLUMN IF NOT EXISTS display_order INT DEFAULT 0 AFTER description;

-- Add index for better performance
ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_display_order (display_order);

-- Update existing products with sequential display_order based on created_at
SET @row_number = 0;
UPDATE products 
SET display_order = (@row_number:=@row_number + 1)
ORDER BY created_at ASC;

-- Verify the changes
SELECT id, title, display_order, created_at 
FROM products 
ORDER BY display_order ASC 
LIMIT 10;

/*
Notes:
- This migration adds a display_order column to products table
- Existing products will be ordered by their creation date
- You can now drag-and-drop products in admin panel to change their display order
- All product listings will now respect the display_order
*/
