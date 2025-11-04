#!/bin/bash

echo "🔧 Fixing MGF Network Connection..."
echo "=================================="

# Bước 1: Dừng containers
echo "📦 Stopping MGF containers..."
sudo docker-compose down

# Bước 2: Kiểm tra và tạo halife_network nếu chưa có
echo "🌐 Checking halife_network..."
if ! sudo docker network ls | grep -q "halife_network"; then
    echo "⚠️  halife_network không tồn tại, tạo mới..."
    sudo docker network create halife_network
else
    echo "✅ halife_network đã tồn tại"
fi

# Bước 3: Khởi động lại với network mới
echo "🚀 Starting containers with new network config..."
sudo docker-compose up -d

# Bước 4: Đợi containers khởi động
echo "⏳ Waiting for containers to start..."
sleep 5

# Bước 5: Kiểm tra kết nối
echo ""
echo "🔍 Checking connection..."
MGF_IP=$(sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' mgf_web | head -1)
echo "MGF Web IP: $MGF_IP"

# Bước 6: Test từ nginx
echo ""
echo "🧪 Testing from nginx container..."
if sudo docker exec halife-nginx curl -f -s -o /dev/null -w "%{http_code}" http://mgf_web > /dev/null 2>&1; then
    echo "✅ Connection successful!"
else
    echo "⚠️  Testing by IP: http://$MGF_IP"
    sudo docker exec halife-nginx curl -I http://$MGF_IP 2>&1 | head -5
fi

# Bước 7: Hiển thị status
echo ""
echo "📊 Container Status:"
sudo docker-compose ps

echo ""
echo "✨ Done! Nginx config cần update upstream:"
echo "   upstream mgf_backend {"
echo "       server mgf_web:80;  # Dùng tên container thay vì IP"
echo "   }"
