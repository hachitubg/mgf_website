#!/bin/bash
# Import demo data vào database MGF

echo "=========================================="
echo "  Import Demo Data - MGF Website"
echo "=========================================="
echo ""

# Màu sắc
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

# Import demo data
echo "Đang import dữ liệu mẫu..."

docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 --default-character-set=utf8mb4 mgf_website < sql/demo_data_mgf.sql

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Import dữ liệu thành công!${NC}"
    echo ""
    echo "Kiểm tra dữ liệu:"
    docker exec mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website -e "SELECT COUNT(*) as 'Tổng danh mục' FROM categories; SELECT COUNT(*) as 'Tổng sản phẩm' FROM products; SELECT COUNT(*) as 'Tổng bài viết' FROM posts;"
else
    echo -e "${RED}✗ Lỗi khi import dữ liệu${NC}"
    exit 1
fi

echo ""
echo "=========================================="
echo "Hoàn thành!"
echo "Truy cập: http://YOUR_IP:9527"
echo "=========================================="
