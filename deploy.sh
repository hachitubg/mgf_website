#!/bin/bash
# MGF Website - Auto Deploy Script
# Chạy script này trên VPS để tự động deploy

set -e  # Exit on error

echo "=========================================="
echo "  MGF Website - Auto Deploy Script"
echo "=========================================="
echo ""

# Màu sắc cho output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Hàm hiển thị thông báo
success() {
    echo -e "${GREEN}✓ $1${NC}"
}

warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

error() {
    echo -e "${RED}✗ $1${NC}"
}

# Kiểm tra Docker
echo "Bước 1: Kiểm tra Docker..."
if ! command -v docker &> /dev/null; then
    error "Docker chưa được cài đặt!"
    echo "Cài đặt Docker bằng lệnh:"
    echo "curl -fsSL https://get.docker.com -o get-docker.sh && sudo sh get-docker.sh"
    exit 1
fi
success "Docker đã được cài đặt"

# Kiểm tra Docker Compose
if ! command -v docker-compose &> /dev/null; then
    error "Docker Compose chưa được cài đặt!"
    echo "Cài đặt Docker Compose bằng lệnh:"
    echo 'sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose'
    echo "sudo chmod +x /usr/local/bin/docker-compose"
    exit 1
fi
success "Docker Compose đã được cài đặt"

# Chuyển config sang Docker
echo ""
echo "Bước 2: Cấu hình cho Docker..."
if [ -f "includes/config.php" ] && [ ! -f "includes/config.local.php" ]; then
    mv includes/config.php includes/config.local.php
    success "Đã backup config cũ"
fi

if [ -f "includes/config.docker.php" ]; then
    cp includes/config.docker.php includes/config.php
    success "Đã chuyển sang config Docker"
else
    error "Không tìm thấy file config.docker.php"
    exit 1
fi

# Tạo thư mục uploads
echo ""
echo "Bước 3: Tạo thư mục uploads..."
mkdir -p uploads/products uploads/posts uploads/banners uploads/content
chmod -R 755 uploads
success "Đã tạo thư mục uploads"

# Kiểm tra port
echo ""
echo "Bước 4: Kiểm tra port 9527..."
if netstat -tuln | grep -q ':9527 '; then
    warning "Port 9527 đang được sử dụng!"
    echo "Bạn cần đổi port trong file docker-compose.yml"
    echo "Tìm dòng: ports: - \"9527:80\""
    echo "Đổi thành: ports: - \"9528:80\" (hoặc port khác)"
    read -p "Nhấn Enter để tiếp tục hoặc Ctrl+C để dừng lại..."
else
    success "Port 9527 khả dụng"
fi

# Dừng container cũ nếu có
echo ""
echo "Bước 5: Dừng container cũ (nếu có)..."
if docker-compose ps | grep -q "Up"; then
    docker-compose down
    success "Đã dừng container cũ"
else
    warning "Không có container nào đang chạy"
fi

# Build và chạy containers
echo ""
echo "Bước 6: Build và chạy Docker containers..."
docker-compose up -d --build

# Chờ database khởi động
echo ""
echo "Đang chờ database khởi động..."
sleep 10

# Kiểm tra trạng thái
echo ""
echo "Bước 7: Kiểm tra trạng thái..."
docker-compose ps

# Lấy IP của server
SERVER_IP=$(hostname -I | awk '{print $1}')

# Hiển thị kết quả
echo ""
echo "=========================================="
success "Deploy thành công!"
echo "=========================================="
echo ""
echo "🌐 Truy cập website tại:"
echo "   http://${SERVER_IP}:9527"
echo ""
echo "🔐 Đăng nhập admin:"
echo "   URL:      http://${SERVER_IP}:9527/admin/login.php"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo "📝 Các lệnh hữu ích:"
echo "   Xem logs:       docker-compose logs -f"
echo "   Khởi động lại:  docker-compose restart"
echo "   Dừng:           docker-compose stop"
echo "   Xóa containers: docker-compose down"
echo ""
warning "LƯU Ý BẢO MẬT:"
echo "   1. Đổi mật khẩu admin ngay sau khi đăng nhập"
echo "   2. Đổi mật khẩu database trong docker-compose.yml"
echo "   3. Cài SSL certificate nếu có domain"
echo ""
echo "📖 Xem hướng dẫn chi tiết tại DEPLOY-QUICK.md"
echo "=========================================="
