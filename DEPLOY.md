# 🚀 Hướng Dẫn Deploy & Quản Lý MGF Website

## 1️⃣ Deploy Lần Đầu

### Bước 1: Chuẩn bị VPS
```bash
# Cài Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Cài Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### Bước 2: Clone code từ GitHub
```bash
cd /home
sudo git clone https://github.com/hachitubg/mgf_website.git mgf-website
cd mgf-website
```

### Bước 3: Deploy tự động
```bash
chmod +x deploy.sh
sudo ./deploy.sh
```

**Hoặc deploy thủ công:**
```bash
# Chuyển config
mv includes/config.php includes/config.local.php
mv includes/config.docker.php includes/config.php

# Tạo thư mục uploads
mkdir -p uploads/{products,posts,banners,content}
chmod -R 755 uploads

# Chạy Docker
sudo docker-compose up -d
```

### Bước 4: Kiểm tra
```bash
# Xem containers
sudo docker-compose ps

# Xem logs
sudo docker-compose logs -f
```

**Truy cập:**
- Website: `http://IP_VPS:9527`
- Admin: `http://IP_VPS:9527/admin/login.php` (admin/admin123)

---

## 2️⃣ Cập Nhật Source Code

### Cách 1: Pull từ GitHub (Khuyến nghị)
```bash
cd /home/mgf-website

# Pull code mới nhất
sudo git pull origin main

# Restart containers để apply thay đổi
sudo docker-compose restart
```

### Cách 2: Rebuild hoàn toàn (Nếu có thay đổi Dockerfile)
```bash
cd /home/mgf-website

# Pull code
sudo git pull origin main

# Rebuild và restart
sudo docker-compose down
sudo docker-compose up -d --build
```

### Cách 3: Upload file qua FTP/SFTP
```bash
# Sau khi upload file, restart containers
cd /home/mgf-website
sudo docker-compose restart
```

**Lưu ý:** 
- Nếu chỉ sửa PHP/CSS/JS → Chỉ cần `restart`
- Nếu sửa Dockerfile/docker-compose.yml → Cần `down` và `up --build`

---

## 3️⃣ Backup Database

### Backup thủ công
```bash
cd /home/mgf-website

# Backup với tên file có ngày giờ
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > backup_$(date +%Y%m%d_%H%M%S).sql

# Hoặc backup đơn giản
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > backup.sql
```

### Backup tự động hàng ngày
```bash
# Tạo thư mục backup
sudo mkdir -p /home/backups

# Tạo script backup
sudo nano /home/backup-db.sh
```

**Nội dung file backup-db.sh:**
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > /home/backups/db_$DATE.sql
# Xóa backup cũ hơn 7 ngày
find /home/backups/ -name "db_*.sql" -mtime +7 -delete
echo "Backup completed: db_$DATE.sql"
```

**Setup cron job:**
```bash
# Cho phép thực thi
sudo chmod +x /home/backup-db.sh

# Thêm vào crontab
sudo crontab -e

# Thêm dòng này (backup mỗi ngày lúc 2h sáng):
0 2 * * * /home/backup-db.sh >> /var/log/backup.log 2>&1
```

### Restore database từ backup
```bash
cd /home/mgf-website

# Restore từ file backup
sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website < backup_20241031_140000.sql

# Hoặc
sudo docker exec -i mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website < backup.sql
```

### Backup files uploads
```bash
# Backup thư mục uploads
cd /home/mgf-website
sudo tar -czf uploads_backup_$(date +%Y%m%d).tar.gz uploads/

# Restore uploads
sudo tar -xzf uploads_backup_20241031.tar.gz
```

---

## 📝 Lệnh Thường Dùng

```bash
# Xem trạng thái
sudo docker-compose ps

# Xem logs realtime
sudo docker-compose logs -f

# Restart website
sudo docker-compose restart

# Dừng website
sudo docker-compose stop

# Khởi động lại
sudo docker-compose start

# Xóa containers (dữ liệu DB vẫn giữ)
sudo docker-compose down

# Xem logs của web server
sudo docker-compose logs web

# Xem logs của database
sudo docker-compose logs db

# Vào container để debug
sudo docker exec -it mgf_web bash
sudo docker exec -it mgf_mysql bash
```

---

## 🔒 Bảo Mật Sau Deploy

```bash
# 1. Đổi mật khẩu database trong docker-compose.yml
sudo nano docker-compose.yml
# Sửa: MYSQL_ROOT_PASSWORD và MYSQL_PASSWORD
sudo docker-compose up -d --force-recreate

# 2. Đổi mật khẩu admin website
# Truy cập: http://IP:9527/admin/ và đổi password

# 3. Setup firewall
sudo ufw allow 22    # SSH
sudo ufw allow 80    # HTTP
sudo ufw allow 443   # HTTPS
sudo ufw deny 9527   # Đóng port Docker (chỉ cho Nginx)
sudo ufw enable
```

---

## 🐛 Xử Lý Lỗi

```bash
# Container không start
sudo docker-compose logs

# Port bị chiếm
sudo netstat -tulpn | grep 9527

# Permission denied cho uploads
sudo chmod -R 755 uploads
sudo chown -R www-data:www-data uploads

# Reset hoàn toàn
sudo docker-compose down
sudo docker-compose up -d --build

# Xóa toàn bộ (bao gồm database - NGUY HIỂM!)
sudo docker-compose down -v
```

---

## 📞 Hỗ Trợ

**Kiểm tra logs khi có lỗi:**
```bash
sudo docker-compose logs -f
```

**Website:** http://IP_VPS:9527  
**Admin:** http://IP_VPS:9527/admin/login.php
