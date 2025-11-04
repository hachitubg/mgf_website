# 🔧 Fix Lỗi Upload Banner: 413 Request Entity Too Large

## ❌ Lỗi
```
413 Request Entity Too Large
```

Lỗi này xảy ra khi upload file banner lớn (>1MB) do giới hạn của Nginx và PHP.

---

## ✅ Giải pháp

### Bước 1️⃣: Cập nhật code mới nhất

```bash
# SSH vào VPS
ssh user@IP_VPS

# Vào thư mục project
cd /home/mgf-website

# Pull code mới (đã có cấu hình PHP upload limit)
sudo git pull origin main
```

### Bước 2️⃣: Rebuild Docker container

```bash
# Rebuild với Dockerfile mới
sudo docker-compose down
sudo docker-compose up -d --build

# Chờ 10 giây để container khởi động
sleep 10

# Kiểm tra container đang chạy
sudo docker-compose ps
```

### Bước 3️⃣: Cấu hình Nginx (Reverse Proxy)

**Mở file cấu hình Nginx:**
```bash
sudo nano /etc/nginx/sites-available/mgf.com.vn
```

**Thêm dòng này vào trong block `server {}` (ngay sau `server_name`):**
```nginx
server {
    listen 80;
    server_name mgf.com.vn www.mgf.com.vn;
    
    # ⭐ THÊM DÒNG NÀY - Tăng giới hạn upload lên 50MB
    client_max_body_size 50M;
    
    location / {
        proxy_pass http://localhost:9527;
        proxy_http_version 1.1;
        
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        # ⭐ Tăng timeout cho upload file lớn
        proxy_connect_timeout 300s;
        proxy_send_timeout 300s;
        proxy_read_timeout 300s;
    }
}
```

**Test và reload Nginx:**
```bash
# Test cấu hình
sudo nginx -t

# Nếu OK → Reload
sudo systemctl reload nginx
```

### Bước 4️⃣: Cấu hình cho HTTPS (nếu dùng SSL)

```bash
sudo nano /etc/nginx/sites-available/mgf.com.vn
```

**Thêm cùng cấu hình vào block HTTPS (port 443):**
```nginx
server {
    listen 443 ssl http2;
    server_name mgf.com.vn www.mgf.com.vn;
    
    # ⭐ THÊM DÒNG NÀY
    client_max_body_size 50M;
    
    ssl_certificate /etc/letsencrypt/live/mgf.com.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/mgf.com.vn/privkey.pem;
    
    location / {
        proxy_pass http://localhost:9527;
        # ... rest of config ...
        
        # ⭐ Timeout
        proxy_connect_timeout 300s;
        proxy_send_timeout 300s;
        proxy_read_timeout 300s;
    }
}
```

**Reload lại:**
```bash
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🧪 Test Upload

1. Truy cập: `https://mgf.com.vn/admin/banners/form.php`
2. Upload file banner (có thể lên đến 50MB)
3. Nếu thành công → Hoàn tất! 🎉

---

## 📊 Giới hạn hiện tại

Sau khi cấu hình:
- **Nginx:** 50MB
- **PHP upload_max_filesize:** 50MB
- **PHP post_max_size:** 50MB
- **PHP memory_limit:** 256MB
- **PHP max_execution_time:** 300 giây (5 phút)

---

## 🐛 Troubleshooting

### Vẫn bị lỗi 413?

**1. Kiểm tra Nginx đã reload chưa:**
```bash
sudo systemctl status nginx
sudo nginx -t
```

**2. Kiểm tra PHP config trong Docker:**
```bash
sudo docker exec mgf_web php -i | grep upload_max_filesize
sudo docker exec mgf_web php -i | grep post_max_size
```

Kết quả phải là: `50M`

**3. Restart lại toàn bộ:**
```bash
sudo docker-compose restart
sudo systemctl restart nginx
```

### Muốn tăng lên 100MB?

**Sửa trong Dockerfile (dòng 9-12):**
```dockerfile
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini
```

**Sửa trong Nginx:**
```nginx
client_max_body_size 100M;
```

Rồi rebuild:
```bash
sudo docker-compose down
sudo docker-compose up -d --build
sudo systemctl reload nginx
```

---

## ✅ Checklist

- [ ] Pull code mới từ GitHub
- [ ] Rebuild Docker container
- [ ] Sửa Nginx config (HTTP)
- [ ] Sửa Nginx config (HTTPS nếu có)
- [ ] Test Nginx config (`nginx -t`)
- [ ] Reload Nginx
- [ ] Test upload banner thành công

---

**Ngày tạo:** 05/11/2025  
**Áp dụng cho:** MGF Website v2.0
