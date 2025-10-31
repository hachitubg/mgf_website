# 🌐 Hướng Dẫn Tích Hợp Tên Miền mgf.com.vn với HTTPS

## 📋 Thông Tin Tên Miền
- **Tên miền:** mgf.com.vn
- **Nhà cung cấp:** iNET.vn
- **Máy chủ DNS:** ns1.inet.vn, ns2.inet.vn, ns3.inet.vn

---

## 🎯 Bước 1: Trỏ Tên Miền Về VPS

### 1.1. Đăng Nhập Quản Lý Domain tại iNET

1. Truy cập: https://inet.vn
2. Đăng nhập với tài khoản của bạn
3. Vào **"Dịch vụ"** → **"Tên miền"**
4. Click vào tên miền **mgf.com.vn**

### 1.2. Cấu Hình DNS Records

Trong phần quản lý DNS của tên miền, thêm các bản ghi sau:

#### **Bản Ghi A (Bắt Buộc)**
```
Type: A
Host: @
Value: [IP_VPS_CUA_BAN]
TTL: 3600
```

#### **Bản Ghi A cho WWW (Khuyến nghị)**
```
Type: A
Host: www
Value: [IP_VPS_CUA_BAN]
TTL: 3600
```

#### **Hoặc dùng CNAME cho WWW**
```
Type: CNAME
Host: www
Value: mgf.com.vn
TTL: 3600
```

### 1.3. Lưu Cấu Hình

- Click **"Lưu"** hoặc **"Cập nhật"**
- DNS có thể mất từ **5-30 phút** để cập nhật toàn cầu

### 1.4. Kiểm Tra DNS Đã Trỏ Chưa

Trên máy tính của bạn, mở terminal và chạy:

```bash
# Windows
nslookup mgf.com.vn

# Linux/Mac
dig mgf.com.vn
```

Nếu trả về IP của VPS → DNS đã trỏ thành công! ✅

---

## 🚀 Bước 2: Cài Đặt Nginx Reverse Proxy trên VPS

### 2.1. SSH vào VPS

```bash
ssh root@[IP_VPS_CUA_BAN]
# hoặc
ssh user@[IP_VPS_CUA_BAN]
```

### 2.2. Cài Đặt Nginx

```bash
# Cập nhật hệ thống
sudo apt update

# Cài Nginx
sudo apt install nginx -y

# Kiểm tra Nginx đang chạy
sudo systemctl status nginx
```

### 2.3. Tạo File Cấu Hình cho mgf.com.vn

```bash
sudo nano /etc/nginx/sites-available/mgf.com.vn
```

**Nội dung file:**

```nginx
server {
    listen 80;
    listen [::]:80;
    
    server_name mgf.com.vn www.mgf.com.vn;
    
    # Logs
    access_log /var/log/nginx/mgf.com.vn.access.log;
    error_log /var/log/nginx/mgf.com.vn.error.log;
    
    # Reverse proxy đến Docker container
    location / {
        proxy_pass http://localhost:9527;
        proxy_http_version 1.1;
        
        # Headers
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Port $server_port;
        
        # Timeouts
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
        
        # Buffer
        proxy_buffering on;
        proxy_buffer_size 4k;
        proxy_buffers 8 4k;
    }
    
    # Tối ưu cho static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        proxy_pass http://localhost:9527;
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
```

### 2.4. Enable Site và Test

```bash
# Tạo symbolic link
sudo ln -s /etc/nginx/sites-available/mgf.com.vn /etc/nginx/sites-enabled/

# Xóa default site (nếu có)
sudo rm /etc/nginx/sites-enabled/default

# Test cấu hình
sudo nginx -t

# Nếu OK, reload Nginx
sudo systemctl reload nginx
```

### 2.5. Test Truy Cập HTTP

Mở trình duyệt và truy cập:
- http://mgf.com.vn
- http://www.mgf.com.vn

Nếu thấy website → Thành công! ✅

---

## 🔒 Bước 3: Cài Đặt SSL Certificate (HTTPS)

### 3.1. Cài Đặt Certbot

```bash
# Cài Certbot và plugin Nginx
sudo apt install certbot python3-certbot-nginx -y
```

### 3.2. Tạo SSL Certificate

```bash
# Chạy Certbot để tự động cấu hình SSL
sudo certbot --nginx -d mgf.com.vn -d www.mgf.com.vn
```

**Certbot sẽ hỏi:**

1. **Email:** Nhập email của bạn (để nhận thông báo gia hạn)
2. **Terms of Service:** Nhấn `Y` để đồng ý
3. **Share email:** Nhấn `N` (không bắt buộc)
4. **Redirect HTTP to HTTPS:** Nhấn `2` để tự động redirect

### 3.3. Certbot Sẽ Tự Động:

✅ Tạo SSL certificate miễn phí từ Let's Encrypt  
✅ Cấu hình Nginx để dùng SSL  
✅ Tự động redirect HTTP → HTTPS  
✅ Setup auto-renewal (tự động gia hạn)

### 3.4. Kiểm Tra SSL

Truy cập:
- https://mgf.com.vn
- https://www.mgf.com.vn

Thấy biểu tượng **ổ khóa xanh** → SSL thành công! 🔒✅

### 3.5. Test Auto-Renewal

```bash
# Test renewal process
sudo certbot renew --dry-run
```

Nếu không có lỗi → Auto-renewal hoạt động tốt! ✅

---

## ⚙️ Bước 4: Cấu Hình Nâng Cao

### 4.1. Bật HTTP/2 và Compression

Sửa file Nginx:

```bash
sudo nano /etc/nginx/sites-available/mgf.com.vn
```

Thêm vào phần `server` của HTTPS (port 443):

```nginx
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    
    # ... các config SSL của Certbot ...
    
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript 
               application/x-javascript application/xml+rss 
               application/json application/javascript;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    
    # ... rest of config ...
}
```

Reload Nginx:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

### 4.2. Cấu Hình Firewall

```bash
# Cho phép HTTP, HTTPS, SSH
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 22/tcp

# Đóng port Docker (chỉ cho phép qua Nginx)
sudo ufw deny 9527/tcp

# Enable firewall
sudo ufw enable

# Kiểm tra
sudo ufw status
```

---

## 🔧 Bước 5: Cập Nhật Cấu Hình Website

### 5.1. Cập Nhật BASE_URL trong Config

SSH vào VPS và sửa file config:

```bash
cd /home/mgf-website
sudo nano includes/config.php
```

**Sửa thành:**

```php
<?php
// includes/config.php - Production config

define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'mgf_website');
define('DB_USER', getenv('DB_USER') ?: 'mgf_user');
define('DB_PASS', getenv('DB_PASS') ?: 'mgf_password_2024');

// Base URL - để trống khi dùng domain chính
define('BASE_URL', '');

define('UPLOAD_DIR', __DIR__ . '/../uploads');
define('UPLOAD_URL', '/uploads');

date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
```

### 5.2. Xóa Cache Browser

Nhấn `Ctrl + Shift + R` (hoặc `Cmd + Shift + R` trên Mac) để hard refresh.

---

## ✅ Bước 6: Kiểm Tra Toàn Bộ Hệ Thống

### 6.1. Checklist Kiểm Tra

- [ ] http://mgf.com.vn tự động redirect sang https://mgf.com.vn
- [ ] http://www.mgf.com.vn tự động redirect sang https://www.mgf.com.vn
- [ ] https://mgf.com.vn hiển thị website đúng
- [ ] Biểu tượng ổ khóa xanh trên trình duyệt
- [ ] Trang admin: https://mgf.com.vn/admin/login.php
- [ ] Upload hình ảnh hoạt động
- [ ] Tất cả CSS, JS load đúng (không có mixed content warning)

### 6.2. Test SSL Grade

Truy cập: https://www.ssllabs.com/ssltest/

Nhập: `mgf.com.vn` → Chạy test

**Mục tiêu:** Đạt grade A hoặc A+ 🏆

### 6.3. Test Performance

Truy cập: https://pagespeed.web.dev/

Nhập: `https://mgf.com.vn` → Analyze

### 6.4. Kiểm Tra Logs

```bash
# Nginx access logs
sudo tail -f /var/log/nginx/mgf.com.vn.access.log

# Nginx error logs
sudo tail -f /var/log/nginx/mgf.com.vn.error.log

# Docker logs
cd /home/mgf-website
sudo docker-compose logs -f
```

---

## 🐛 Xử Lý Sự Cố

### **Lỗi: DNS chưa trỏ**
```bash
# Kiểm tra DNS
nslookup mgf.com.vn
dig mgf.com.vn

# Đợi DNS propagate (5-30 phút)
# Hoặc flush DNS cache:
# Windows: ipconfig /flushdns
# Linux: sudo systemd-resolve --flush-caches
```

### **Lỗi: 502 Bad Gateway**
```bash
# Kiểm tra Docker container
sudo docker-compose ps

# Nếu container down, restart
cd /home/mgf-website
sudo docker-compose restart
```

### **Lỗi: SSL Certificate không tạo được**
```bash
# Kiểm tra port 80 có mở không
sudo netstat -tulpn | grep :80

# Kiểm tra Nginx config
sudo nginx -t

# Thử lại với Certbot
sudo certbot --nginx -d mgf.com.vn -d www.mgf.com.vn --force-renewal
```

### **Lỗi: Mixed Content (HTTP trong trang HTTPS)**
- Kiểm tra `BASE_URL` trong `includes/config.php` phải là `''` hoặc `'https://mgf.com.vn'`
- Kiểm tra hardcoded links trong code

### **Lỗi: CSS/JS không load**
```bash
# Kiểm tra quyền files
cd /home/mgf-website
sudo chmod -R 755 public
sudo chown -R www-data:www-data uploads
```

---

## 📅 Bảo Trì Định Kỳ

### Auto-Renewal SSL (Tự động)
Certbot đã setup cronjob tự động gia hạn. Kiểm tra:
```bash
sudo systemctl status certbot.timer
```

### Backup Database
```bash
# Tạo script backup tự động
sudo nano /home/backup-db.sh
```

**Nội dung:**
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > /home/backups/db_$DATE.sql
# Xóa backup cũ hơn 7 ngày
find /home/backups/ -name "db_*.sql" -mtime +7 -delete
```

**Setup cron:**
```bash
chmod +x /home/backup-db.sh
crontab -e

# Thêm dòng: Backup mỗi ngày 2h sáng
0 2 * * * /home/backup-db.sh
```

---

## 🎉 Hoàn Thành!

Bây giờ website của bạn đã có:

✅ Tên miền chính thức: **mgf.com.vn**  
✅ HTTPS với SSL certificate miễn phí  
✅ Tự động redirect HTTP → HTTPS  
✅ Auto-renewal SSL  
✅ Reverse proxy với Nginx  
✅ Firewall bảo mật  
✅ Backup tự động  

**Truy cập website:**
- 🌐 https://mgf.com.vn
- 🔐 https://mgf.com.vn/admin/login.php

---

## 📞 Hỗ Trợ

Nếu gặp vấn đề:
1. Kiểm tra logs Nginx: `sudo tail -f /var/log/nginx/mgf.com.vn.error.log`
2. Kiểm tra logs Docker: `sudo docker-compose logs -f`
3. Test DNS: `nslookup mgf.com.vn`
4. Test SSL: https://www.ssllabs.com/ssltest/

**Chúc mừng bạn đã có website chính thức với HTTPS! 🎊**
