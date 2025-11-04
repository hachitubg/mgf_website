# Chỉ reset docker không rebuild
cd /home/mgf-website
git pull
docker-compose restart

#  FILE CONFIG NGINX của 2 con HALIFE và MGF
cd /var/www/halife-website
sudo nano nginx.conf

# Thao tác với file trên Ubuntu
Ctrl + O -> Save file 
Enter -> Chấp nhân save file
Ctrl + X -> Thoát file

# Rebuild container với Dockerfile mới
sudo docker-compose down
sudo docker-compose up -d --build


# Vào MySQL shell
sudo docker exec -it mgf_mysql mysql -u mgf_user -pmgf_password_2024 mgf_website

-- Xem tất cả bảng
SHOW TABLES;

-- Xem cấu trúc bảng banners
DESCRIBE banners;

-- Xem tất cả banners
SELECT * FROM banners;

-- Xem banners theo vị trí
SELECT * FROM banners WHERE location_code = 'trang_chu';

-- Đếm số banner
SELECT COUNT(*) FROM banners;

-- Xem banner mới nhất
SELECT * FROM banners ORDER BY created_at DESC LIMIT 5;

-- Xóa banner theo ID
DELETE FROM banners WHERE id = 1;

-- Cập nhật banner
UPDATE banners SET is_active = 1 WHERE id = 1;

-- Thoát MySQL
EXIT;


# Tạo thư mục backup (nếu chưa có)
mkdir -p /home/backups

# Backup database với tên file có ngày giờ
cd /home/mgf-website
sudo docker exec mgf_mysql mysqldump -u mgf_user -pmgf_password_2024 mgf_website > /home/backups/mgf_backup_$(date +%Y%m%d_%H%M%S).sql