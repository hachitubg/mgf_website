# 🌐 MGF Website - VPS Management Guide

Hướng dẫn quản lý website MGF trên VPS với Docker.

---

## � Quick Commands

### VPS - Deploy & Update
```bash
cd /home/mgf-website
git pull origin main
sudo docker-compose restart           # Restart nhanh
sudo docker-compose up -d --build    # Rebuild container
```

### Local - Pull & Run
```bash
cd /c/xampp/htdocs/mgf-website
git pull origin main
# Mở http://localhost/mgf-website
```

---

## 🐳 Docker Management

### Quản lý containers
```bash
sudo docker-compose ps              # Xem trạng thái
sudo docker-compose logs -f         # Xem logs realtime
sudo docker exec -it mgf_web bash   # Vào shell container
```

### Nginx (shared với halife.vn)
```bash
cd /var/www/halife-website
sudo nano nginx.conf                        # Sửa config
sudo docker exec halife-nginx nginx -t      # Test config
sudo docker exec halife-nginx nginx -s reload  # Reload
```

---

## 💾 Database Backup & Restore

### Backup trên VPS
```bash
cd /home/mgf-website

# Backup với timestamp
sudo docker exec mgf_mysql mysqldump -u root -pmgf_root_password_2024 mgf_website 2>/dev/null > backups/mgf_backup_$(date +%Y%m%d_%H%M%S).sql

# Backup và nén
sudo docker exec mgf_mysql mysqldump -u root -pmgf_root_password_2024 mgf_website 2>/dev/null | gzip > backups/mgf_backup_$(date +%Y%m%d_%H%M%S).sql.gz
```

### Download backup về Local (SCP)
```bash
# Trên máy Windows (Git Bash)
cd /c/xampp/htdocs/mgf-website
scp root@YOUR_VPS_IP:/home/mgf-website/backups/mgf_backup_*.sql ./backups/
```

### Fix lỗi collation (MySQL 8.0 → MariaDB 10.4)
```bash
# Mở file .sql bằng Notepad++ hoặc VS Code
# Ctrl+H (Find & Replace)
# Find:    utf8mb4_0900_ai_ci
# Replace: utf8mb4_unicode_ci
# Replace All → Save
```

### Restore Database
```bash
# Trên VPS
sudo docker exec -i mgf_mysql mysql -u root -pmgf_root_password_2024 mgf_website < backups/mgf_backup_20251105.sql

# Trên Local (XAMPP)
C:\xampp\mysql\bin\mysql -u root mgf_website < backups/mgf_backup_fixed.sql
```

### Tạo database Local (lần đầu)
```sql
-- Vào phpMyAdmin: http://localhost/phpmyadmin
CREATE DATABASE mgf_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Import file sql/schema.sql
```

---

## 🔐 Git - Personal Access Token

### Setup Git Authentication (VPS)
```bash
cd /home/mgf-website
git config --global credential.helper store
git push origin main
# Username: hachitubg
# Password: ghp_xxxxxxxxxxxx (Token từ GitHub)
```

**Tạo token:** https://github.com/settings/tokens → **Generate new token (classic)** → Chọn `repo`

---

## �️ Database Quick Queries

```bash
# Kết nối MySQL
sudo docker exec -it mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website
```

```sql
-- Xem banners
SELECT * FROM banners WHERE location_code = 'trang_chu';

-- Đếm sản phẩm
SELECT COUNT(*) FROM products;

-- Xem posts mới nhất
SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 5;
```

---

## 🔧 Troubleshooting

### Lỗi 413 (Upload file quá lớn)
```bash
# Rebuild container để apply PHP limits
sudo docker-compose down
sudo docker-compose up -d --build
```

### Lỗi DB Connection (Local)
- File `includes/config.php` tự động detect môi trường
- Local dùng `config.local.php` (DB_HOST=localhost)
- VPS dùng `config.docker.php` (DB_HOST=db)

### Fix permissions (Upload folder)
```bash
sudo docker exec mgf_web chown -R www-data:www-data /var/www/html/uploads
sudo docker exec mgf_web chmod -R 755 /var/www/html/uploads
```

---

## 📞 Links

- **Website:** https://mgf.com.vn
- **Admin:** https://mgf.com.vn/admin/login.php
- **GitHub:** https://github.com/hachitubg/mgf_website

---

**Last Updated:** November 5, 2025