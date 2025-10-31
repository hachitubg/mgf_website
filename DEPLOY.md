# Hướng Dẫn Deploy MGF Website Lên VPS

## Bước 1: Chuẩn Bị VPS

Đảm bảo VPS đã cài đặt:
- Docker
- Docker Compose

Nếu chưa cài, chạy lệnh:
```bash
# Cài Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Cài Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

## Bước 2: Upload Code Lên VPS

### Cách 1: Dùng Git (Khuyến nghị)
```bash
# Trên VPS, tạo thư mục project
cd /home
sudo mkdir -p mgf-website
cd mgf-website

# Clone hoặc pull code từ Git
git clone https://github.com/hachitubg/mgf_website.git .
```

### Cách 2: Dùng FTP/SFTP
- Dùng FileZilla hoặc WinSCP
- Upload toàn bộ thư mục mgf-website lên VPS
- Đường dẫn khuyến nghị: `/home/mgf-website`

## Bước 3: Cấu Hình

### 3.1. Đổi tên file config
```bash
cd /home/mgf-website
mv includes/config.php includes/config.local.php
mv includes/config.docker.php includes/config.php
```

### 3.2. Tạo thư mục uploads và set quyền
```bash
mkdir -p uploads/products uploads/posts uploads/banners
chmod -R 755 uploads
```

### 3.3. Đổi port nếu cần (nếu port 8080 đã bị sử dụng)
Mở file `docker-compose.yml`, tìm dòng:
```yaml
ports:
  - "8080:80"
```

Đổi thành port khác, ví dụ:
```yaml
ports:
  - "9528:80"  # hoặc 9529, 9530...
```

### 3.4. Đổi mật khẩu database (Khuyến nghị cho production)
Trong `docker-compose.yml`, đổi các giá trị:
- `MYSQL_ROOT_PASSWORD`
- `MYSQL_PASSWORD`

Và cập nhật lại trong phần `environment` của service `web`.

## Bước 4: Chạy Docker

```bash
cd /home/mgf-website

# Build và chạy containers
sudo docker-compose up -d

# Xem logs để kiểm tra
sudo docker-compose logs -f
```

## Bước 5: Kiểm Tra

Truy cập: `http://IP_VPS:9527`

- Trang chủ: `http://IP_VPS:9527/public/pages/`
- Admin: `http://IP_VPS:9527/admin/login.php`
  - Username: `admin`
  - Password: `admin123`

## Bước 6: Cấu Hình Tên Miền (Domain từ inet.vn)

### 6.1. Trỏ domain về VPS
Vào quản lý domain tại inet.vn:
- Tạo bản ghi A: `@` hoặc `www` -> IP VPS của bạn
- Hoặc subdomain: `mgf` -> IP VPS

### 6.2. Cài Nginx Reverse Proxy (Khuyến nghị)

Tạo file cấu hình Nginx:
```bash
sudo nano /etc/nginx/sites-available/mgf.yourdomain.com
```

Nội dung:
```nginx
server {
    listen 80;
    server_name mgf.yourdomain.com;  # Đổi thành domain của bạn

    location / {
        proxy_pass http://localhost:9527;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable site và reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/mgf.yourdomain.com /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 6.3. Cài SSL (HTTPS) miễn phí với Let's Encrypt
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d mgf.yourdomain.com
```

## Các Lệnh Quản Lý

```bash
# Xem trạng thái containers
sudo docker-compose ps

# Dừng containers
sudo docker-compose stop

# Khởi động lại
sudo docker-compose restart

# Xem logs
sudo docker-compose logs -f web
sudo docker-compose logs -f db

# Xóa và build lại (khi có thay đổi code)
sudo docker-compose down
sudo docker-compose up -d --build

# Backup database
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > backup.sql

# Restore database
sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website < backup.sql
```

## Lưu Ý Bảo Mật

1. **Đổi mật khẩu admin** ngay sau khi deploy
2. **Đổi mật khẩu database** trong docker-compose.yml
3. **Cài SSL certificate** cho domain
4. **Giới hạn truy cập admin** bằng IP nếu cần
5. **Backup database** thường xuyên

## Troubleshooting

### Container không start
```bash
sudo docker-compose logs
```

### Port bị chiếm
```bash
# Kiểm tra port nào đang dùng
sudo netstat -tulpn | grep 9527

# Đổi port trong docker-compose.yml
```

### Permission denied cho uploads
```bash
sudo chmod -R 755 uploads
sudo chown -R www-data:www-data uploads
```

### Database không kết nối được
```bash
# Vào container web và test
sudo docker exec -it mgf_web bash
ping db
```

## Hỗ Trợ

Nếu gặp vấn đề, kiểm tra logs:
```bash
sudo docker-compose logs -f
```
