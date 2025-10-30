# Hướng dẫn tích hợp URL và Popup "Coming Soon"

## Tổng quan

Hệ thống đã được tích hợp với các URL mới và popup thông báo đẹp mắt cho các trang chưa phát triển.

## Cấu trúc file

### 1. File cấu hình
- **url-config.php**: Quản lý mapping URL và danh sách các trang có sẵn/chưa có
  - `$available_pages`: Danh sách các trang đã phát triển
  - `$coming_soon_pages`: Danh sách các trang sẽ ra mắt

### 2. File CSS
- **css/coming-soon-popup.css**: Style cho popup thông báo
  - Hiệu ứng fade in, slide up
  - Responsive design
  - Gradient màu đỏ theo thương hiệu Ba Huân

### 3. File JavaScript
- **js/coming-soon-popup.js**: Xử lý logic hiển thị popup
  - Tự động khởi tạo khi trang load
  - Xử lý các link có class `coming-soon-link`
  - Đóng popup bằng ESC, click overlay, hoặc nút đóng

## Các trang đã có sẵn

1. **trang-chu.php** - Trang chủ
2. **danh-sach-san-pham.php** - Danh sách sản phẩm
3. **chi-tiet-san-pham.php** - Chi tiết sản phẩm
4. **danh-sach-tin-tuc.php** - Danh sách tin tức
5. **chi-tiet-tin-tuc.php** - Chi tiết tin tức
6. **ve-chung-toi.php** - Về chúng tôi

## Các trang sẽ ra mắt (hiển thị popup)

### Từ menu chính:
- Người sáng lập
- Giá trị doanh nghiệp
- Quy mô sản xuất
- Giải thưởng & Đối tác
- Sản phẩm & phân phối (trang tổng hợp)
- Phân phối
- Phát triển bền vững
- Con người Ba Huân
- Cơ cấu doanh nghiệp
- Văn hóa tổ chức
- Tuyển dụng
- Cộng đồng
- Cơ hội việc làm

### Từ footer:
- Thư viện
- Privacy Policy
- Điều khoản sử dụng

## Cách sử dụng

### Thêm trang mới vào hệ thống

1. **Trang đã phát triển:**
```php
// Trong file url-config.php
$available_pages = [
    // ... các trang hiện có
    'slug-trang-moi' => 'ten-file.php',
];
```

2. **Trang chưa phát triển (hiển thị popup):**
```php
// Trong file url-config.php
$coming_soon_pages = [
    // ... các trang hiện có
    'slug-trang-moi' => 'Tên trang hiển thị trong popup',
];
```

### Cập nhật link trong HTML

**Link đến trang có sẵn:**
```html
<a href="trang-chu.php">Trang chủ</a>
```

**Link đến trang chưa có (hiển thị popup):**
```html
<a href="#" class="coming-soon-link" data-page-title="Tên trang">
    Link text
</a>
```

## Tùy chỉnh

### Thay đổi màu sắc popup
Chỉnh sửa file `css/coming-soon-popup.css`:
```css
.coming-soon-popup-header {
    background: linear-gradient(135deg, #0C7A07 0%, #cc0000 100%);
}
```

### Thay đổi icon popup
Chỉnh sửa file `js/coming-soon-popup.js`:
```javascript
<div class="coming-soon-icon">🚀</div>
```

### Thay đổi nội dung thông báo
Chỉnh sửa file `js/coming-soon-popup.js` trong hàm `createPopupHTML()`.

## URL Structure

### Trước khi tích hợp:
- `index.html` → Trang chủ
- `ve-chung-toi/nguoi-sang-lap/index.html` → Người sáng lập
- `san-pham-va-phan-phoi/san-pham/index.html` → Sản phẩm

### Sau khi tích hợp:
- `index.php` → Redirect đến `trang-chu.php`
- `trang-chu.php` → Trang chủ
- `danh-sach-san-pham.php` → Danh sách sản phẩm
- `ve-chung-toi.php` → Về chúng tôi
- `#` với class `coming-soon-link` → Hiển thị popup

## Kiểm tra

1. Truy cập trang: `http://localhost/mgf-website/public/pages/`
2. Click vào các link trong menu
3. Kiểm tra:
   - Link đến trang có sẵn → Chuyển trang bình thường
   - Link đến trang chưa có → Hiển thị popup thông báo
   - Popup có thể đóng bằng: nút X, nút "Đã hiểu", click ngoài popup, nhấn ESC

## Lưu ý khi deploy

1. **Cập nhật BASE_URL** trong `url-config.php` theo môi trường production
2. **Tối ưu hóa**: Minify CSS và JS files
3. **Cache**: Đảm bảo browser cache được cấu hình đúng cho static files
4. **SEO**: Các trang "coming soon" không được index bởi search engines

## Hỗ trợ

Nếu cần thêm trang mới hoặc thay đổi cấu hình, vui lòng cập nhật:
1. `url-config.php` - Thêm/xóa trang
2. `header.php` / `footer.php` - Cập nhật menu links
3. CSS/JS files - Tùy chỉnh giao diện popup

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** 2025-10-30
