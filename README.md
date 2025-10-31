# MGF Website

Website doanh nghiệp được xây dựng bằng PHP & MySQL

## 🚀 Deploy Nhanh

### Phương Pháp 1: Tự Động (Khuyến nghị)

Upload code lên VPS, sau đó chạy:

```bash
chmod +x deploy.sh
./deploy.sh
```

### Phương Pháp 2: Thủ Công

```bash
# 1. Chuyển config
mv includes/config.php includes/config.local.php
mv includes/config.docker.php includes/config.php

# 2. Tạo thư mục uploads
mkdir -p uploads/{products,posts,banners,content}
chmod -R 755 uploads

# 3. Chạy Docker
docker-compose up -d
```

## 📖 Tài Liệu

- **[DEPLOY-QUICK.md](DEPLOY-QUICK.md)** - Hướng dẫn deploy nhanh trong 5 phút
- **[DEPLOY.md](DEPLOY.md)** - Hướng dẫn chi tiết đầy đủ

## 🌐 Truy Cập

- **Website:** `http://IP_VPS:9527`
- **Admin:** `http://IP_VPS:9527/admin/login.php`
  - Username: `admin`
  - Password: `admin123`

## 💻 Yêu Cầu

- Docker
- Docker Compose
- VPS với ít nhất 1GB RAM

## 🔧 Công Nghệ

- PHP 8.1
- MySQL 8.0
- Apache
- Docker

## 📝 Cấu Trúc Dự Án

```
mgf-website/
├── admin/              # Quản trị
├── api/                # API endpoints
├── includes/           # Config & helpers
├── public/             # Giao diện người dùng
├── sql/                # Database schema
├── uploads/            # File tải lên
├── docker-compose.yml  # Docker config
├── Dockerfile          # Docker build
└── deploy.sh           # Script deploy
```

## 🔐 Bảo Mật

Sau khi deploy, nhớ:

1. Đổi mật khẩu admin
2. Đổi mật khẩu database trong `docker-compose.yml`
3. Cài SSL certificate nếu có domain

## 📞 Hỗ Trợ

Xem logs khi gặp lỗi:

```bash
docker-compose logs -f
```

---

**Chúc bạn deploy thành công! 🎉**
