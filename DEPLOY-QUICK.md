# 🚀 Hướng Dẫn Deploy Nhanh - MGF Website

## ⚡ Deploy Trong 5 Phút

### Bước 1: Upload Code Lên VPS
```bash
# SSH vào VPS
ssh user@your-vps-ip

# Tạo thư mục project
cd /home
sudo mkdir -p mgf-website
cd mgf-website

# Clone code từ Git (nếu có)
git clone https://github.com/hachitubg/mgf_website.git .

# HOẶC upload qua FTP/SFTP vào thư mục /home/mgf-website
```

### Bước 2: Chuyển Config sang Docker
```bash
cd /home/mgf-website
mv includes/config.php includes/config.local.php
mv includes/config.docker.php includes/config.php
```

### Bước 3: Tạo Thư Mục Uploads
```bash
mkdir -p uploads/products uploads/posts uploads/banners uploads/content
chmod -R 755 uploads
```

### Bước 4: Chạy Docker
```bash
sudo docker-compose up -d
```

### Bước 5: Truy Cập Website
```
http://IP_VPS:9527
```

**Quản trị:** `http://IP_VPS:9527/admin/login.php`
- Username: `admin`
- Password: `admin123`

---

## 🌐 Cấu Hình Domain (Nếu Có)

### Trỏ Domain Tại inet.vn:
1. Vào quản lý DNS tại inet.vn
2. Tạo bản ghi A:
   - Host: `@` hoặc `subdomain`
   - Value: `IP_VPS_của_bạn`
   - TTL: 3600

### Cài Nginx Reverse Proxy:
```bash
# Cài Nginx nếu chưa có
sudo apt update
sudo apt install nginx -y

# Tạo file cấu hình
sudo nano /etc/nginx/sites-available/mgf.yourdomain.com
```

**Nội dung file:**
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;

    location / {
        proxy_pass http://localhost:9527;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

**Enable và reload:**
```bash
sudo ln -s /etc/nginx/sites-available/mgf.yourdomain.com /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Cài SSL Miễn Phí:
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 🔧 Quản Lý Docker

### Xem Log:
```bash
sudo docker-compose logs -f
sudo docker-compose logs -f web
sudo docker-compose logs -f db
```

### Khởi động lại:
```bash
sudo docker-compose restart
```

### Dừng:
```bash
sudo docker-compose stop
```

### Xóa và build lại:
```bash
sudo docker-compose down
sudo docker-compose up -d --build
```

### Xem trạng thái:
```bash
sudo docker-compose ps
```

---

## 💾 Backup Database

### Backup:
```bash
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore:
```bash
sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website < backup_20241031.sql
```

---

## 🔒 Bảo Mật Sau Deploy

1. **Đổi mật khẩu admin:**
   - Vào `http://IP:9527/admin/`
   - Đổi password ngay

2. **Đổi mật khẩu database:**
   - Sửa trong `docker-compose.yml`:
     ```yaml
     MYSQL_ROOT_PASSWORD: your_strong_password_here
     MYSQL_PASSWORD: your_db_password_here
     ```
   - Chạy lại: `sudo docker-compose up -d --force-recreate`

3. **Cài Firewall:**
   ```bash
   sudo ufw allow 80
   sudo ufw allow 443
   sudo ufw allow 22
   sudo ufw allow 9527  # Nếu không dùng Nginx
   sudo ufw enable
   ```

---

## 🐛 Xử Lý Lỗi

### Lỗi: Port 9527 đã được sử dụng
```bash
# Kiểm tra port
sudo netstat -tulpn | grep 9527

# Đổi port trong docker-compose.yml:
ports:
  - "9528:80"  # Đổi 9527 -> 9528
```

### Lỗi: Database không kết nối
```bash
# Xem log database
sudo docker-compose logs db

# Vào container kiểm tra
sudo docker exec -it mgf_mysql bash
mysql -u mgf_user -p
```

### Lỗi: Permission denied cho uploads
```bash
sudo chmod -R 755 uploads
sudo chown -R www-data:www-data uploads
```

### Lỗi: Container không start
```bash
# Xem logs chi tiết
sudo docker-compose logs

# Xóa và build lại
sudo docker-compose down
sudo docker-compose up -d --build
```

---

## 📞 Hỗ Trợ

Nếu gặp vấn đề, kiểm tra:
1. Log container: `sudo docker-compose logs -f`
2. Trạng thái: `sudo docker-compose ps`
3. Kết nối DB: `sudo docker exec -it mgf_mysql mysql -u mgf_user -p`

---

**Chúc bạn deploy thành công! 🎉**
