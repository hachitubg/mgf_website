# 🌐 MGF Website - Hướng Dẫn Quản Lý VPS

Tài liệu hướng dẫn deploy và quản lý website MGF trên VPS với Docker.

---

## 📑 Mục Lục

- [Docker Management](#-docker-management)
- [Nginx Configuration](#-nginx-configuration)
- [Database Operations](#-database-operations)
- [Backup & Restore](#-backup--restore)
- [Git Integration](#-git-integration)
- [Useful Commands](#-useful-commands)

---

## 🐳 Docker Management

### Cập nhật code và restart (không rebuild)

```bash
cd /home/mgf-website
git pull origin main
sudo docker-compose restart
```

### Rebuild container hoàn toàn

```bash
cd /home/mgf-website
sudo docker-compose down
sudo docker-compose up -d --build
```

### Kiểm tra trạng thái containers

```bash
sudo docker-compose ps
sudo docker-compose logs -f
```

---

## ⚙️ Nginx Configuration

### Vị trí file config

```bash
cd /var/www/halife-website
sudo nano nginx.conf
```

### Các thao tác với Nano Editor

| Phím tắt | Chức năng |
|----------|-----------|
| `Ctrl + O` | Lưu file |
| `Enter` | Xác nhận lưu |
| `Ctrl + X` | Thoát editor |
| `Ctrl + K` | Xóa dòng hiện tại |
| `Ctrl + W` | Tìm kiếm |

### Reload Nginx sau khi sửa config

```bash
# Test config
sudo docker exec halife-nginx nginx -t

# Reload Nginx
sudo docker exec halife-nginx nginx -s reload

# Hoặc restart container
sudo docker restart halife-nginx
```

---

## 🗄️ Database Operations

### Kết nối MySQL

```bash
sudo docker exec -it mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website
```

### Các câu lệnh SQL thường dùng

#### Xem thông tin database

```sql
-- Liệt kê tất cả bảng
SHOW TABLES;

-- Xem cấu trúc bảng
DESCRIBE banners;
DESCRIBE products;
DESCRIBE categories;
```

#### Quản lý Banners

```sql
-- Xem tất cả banners
SELECT * FROM banners;

-- Xem banners theo vị trí
SELECT * FROM banners WHERE location_code = 'trang_chu';

-- Đếm số lượng banner
SELECT COUNT(*) as total FROM banners;

-- Xem banner mới nhất
SELECT * FROM banners ORDER BY created_at DESC LIMIT 5;

-- Xóa banner theo ID
DELETE FROM banners WHERE id = 1;

-- Cập nhật trạng thái banner
UPDATE banners SET is_active = 1 WHERE id = 1;

-- Cập nhật thứ tự hiển thị
UPDATE banners SET sort_order = 1 WHERE id = 5;
```

#### Quản lý Products

```sql
-- Xem sản phẩm
SELECT id, title, category_id, price, display_order 
FROM products 
ORDER BY display_order 
LIMIT 10;

-- Đếm sản phẩm theo danh mục
SELECT c.name, COUNT(p.id) as total_products
FROM categories c
LEFT JOIN products p ON c.id = p.category_id
WHERE c.type = 'product'
GROUP BY c.id;
```

#### Thoát MySQL

```sql
EXIT;
```

---

## 💾 Backup & Restore

### Backup Database

#### Tạo thư mục backup

```bash
mkdir -p /home/backups
```

#### Backup với timestamp

```bash
cd /home/mgf-website
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > /home/backups/mgf_backup_$(date +%Y%m%d_%H%M%S).sql
```

#### Backup đơn giản

```bash
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > /home/backups/mgf_backup_latest.sql
```

#### Backup và nén

```bash
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website | gzip > /home/backups/mgf_backup_$(date +%Y%m%d).sql.gz
```

### Restore Database

```bash
# Restore từ file SQL
sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website < /home/backups/mgf_backup_20251105.sql

# Restore từ file đã nén
gunzip < /home/backups/mgf_backup_20251105.sql.gz | sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website
```

### Xem danh sách backup

```bash
ls -lh /home/backups/
```

---

## 🔐 Git Integration

### Bước 1️⃣: Tạo Personal Access Token

1. Đăng nhập GitHub → https://github.com/settings/tokens
2. Click **"Generate new token"** → **"Generate new token (classic)"**
3. **Tên token:** `MGF VPS Token`
4. **Quyền:** Chọn `repo` (full control of private repositories)
5. Click **"Generate token"**
6. **Copy token** ngay! (Chỉ hiển thị 1 lần)
   - Format: `ghp_xxxxxxxxxxxxxxxxxxxx`

### Bước 2️⃣: Config Git trên VPS

```bash
# Di chuyển vào thư mục project
cd /home/mgf-website

# Xóa credential cũ (nếu có)
git config --unset credential.helper

# Lưu credential để không phải nhập lại
git config --global credential.helper store

# Kiểm tra config
git config --list
```

### Bước 3️⃣: Push code lên GitHub

```bash
git push origin main
```

**Khi được hỏi:**
- **Username:** `tuxidenbg123@gmail.com` hoặc `hachitubg`
- **Password:** Paste **token** (không phải password GitHub!)

Lần sau push sẽ không cần nhập lại!

### Pull code mới từ GitHub

```bash
cd /home/mgf-website
git pull origin main
sudo docker-compose restart
```

---

## 📝 Useful Commands

### Quản lý Docker

```bash
# Xem tất cả containers
sudo docker ps -a

# Xem logs realtime
sudo docker-compose logs -f web

# Vào shell container
sudo docker exec -it mgf_web bash

# Xem resource usage
sudo docker stats
```

### Kiểm tra hệ thống

```bash
# Kiểm tra disk space
df -h

# Kiểm tra memory
free -h

# Kiểm tra CPU
top

# Kiểm tra port đang mở
sudo netstat -tulpn | grep :80
sudo netstat -tulpn | grep :443
```

### Quản lý files

```bash
# Xem dung lượng thư mục
du -sh /home/mgf-website/

# Tìm file lớn
find /home/mgf-website -type f -size +10M -exec ls -lh {} \;

# Copy file
cp source.txt destination.txt

# Di chuyển file
mv old_name.txt new_name.txt
```

---

## 🆘 Troubleshooting

### Website không hoạt động

```bash
# Kiểm tra containers
sudo docker-compose ps

# Restart containers
sudo docker-compose restart

# Xem logs
sudo docker-compose logs -f
```

### Upload file bị lỗi 413

```bash
# Kiểm tra PHP upload limit
sudo docker exec mgf_web php -i | grep upload_max_filesize

# Rebuild nếu cần
sudo docker-compose down
sudo docker-compose up -d --build
```

### Lỗi permission

```bash
# Fix quyền uploads
sudo docker exec mgf_web chown -R www-data:www-data /var/www/html/uploads
sudo docker exec mgf_web chmod -R 755 /var/www/html/uploads
```

---

## 📞 Support

**Repository:** https://github.com/hachitubg/mgf_website  
**Admin Panel:** https://mgf.com.vn/admin/login.php  
**Website:** https://mgf.com.vn

---

**📅 Last Updated:** November 5, 2025  
**👨‍💻 Maintainer:** MGF Development Team