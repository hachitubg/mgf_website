# ✅ Checklist Deploy MGF Website

## Trước Khi Deploy

- [ ] VPS đã cài Docker & Docker Compose
- [ ] Đã có tên miền (nếu cần)
- [ ] Đã backup dữ liệu cũ (nếu có)
- [ ] Kiểm tra port 9527 khả dụng

## Bước Deploy

- [ ] Upload code lên VPS vào `/home/mgf-website`
- [ ] Chuyển config: `mv includes/config.php includes/config.local.php`
- [ ] Chuyển config Docker: `mv includes/config.docker.php includes/config.php`
- [ ] Tạo thư mục uploads: `mkdir -p uploads/{products,posts,banners,content}`
- [ ] Set quyền: `chmod -R 755 uploads`
- [ ] Chạy Docker: `docker-compose up -d`
- [ ] Chờ 10-15 giây để DB khởi động

## Kiểm Tra Sau Deploy

- [ ] Truy cập `http://IP:9527` - Website hiển thị
- [ ] Truy cập `http://IP:9527/admin/login.php` - Admin login OK
- [ ] Đăng nhập admin (admin/admin123)
- [ ] Upload test 1 sản phẩm - OK
- [ ] Upload test 1 bài viết - OK
- [ ] Upload test 1 banner - OK
- [ ] Kiểm tra hình ảnh hiển thị đúng

## Cấu Hình Domain (Nếu Có)

- [ ] Trỏ domain về IP VPS tại inet.vn
- [ ] Cài Nginx reverse proxy
- [ ] Test domain: `http://yourdomain.com`
- [ ] Cài SSL: `certbot --nginx -d yourdomain.com`
- [ ] Test HTTPS: `https://yourdomain.com`

## Bảo Mật

- [ ] Đổi mật khẩu admin
- [ ] Đổi `MYSQL_ROOT_PASSWORD` trong docker-compose.yml
- [ ] Đổi `MYSQL_PASSWORD` trong docker-compose.yml
- [ ] Cập nhật lại container: `docker-compose up -d --force-recreate`
- [ ] Cài firewall (ufw)
- [ ] Chỉ mở port cần thiết: 22, 80, 443

## Backup & Monitoring

- [ ] Setup backup tự động database
- [ ] Setup backup tự động uploads
- [ ] Cài monitoring tool (optional)
- [ ] Test restore từ backup

## Tối Ưu (Optional)

- [ ] Cấu hình caching
- [ ] Tối ưu hình ảnh
- [ ] CDN cho static files
- [ ] Gzip compression
- [ ] HTTP/2

## Hoàn Thành

- [ ] Website chạy ổn định > 24h
- [ ] Đã test toàn bộ chức năng
- [ ] Đã có backup đầy đủ
- [ ] Ghi chép thông tin đăng nhập
- [ ] Giao website cho khách hàng

---

**Ghi Chú:**
- IP VPS: ___________________
- Domain: ___________________
- Port: 9527
- DB Password: ___________________
- Admin Password: ___________________
- Ngày deploy: ___________________
