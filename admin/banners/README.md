# Hướng Dẫn Sử Dụng Module Banners

## 📋 Tổng Quan

Module Banners cho phép quản lý hình ảnh banner theo **vị trí hiển thị** (location). Mỗi vị trí có thể chứa nhiều banner với thứ tự sắp xếp riêng.

## 🎯 Các Vị Trí Banner (Location Codes)

Các vị trí banner được định nghĩa trong `admin/banners/config.php`:

| Location Code | Tên Hiển Thị | Mục Đích |
|--------------|--------------|----------|
| `home_slider` | Trang Chủ - Slider | Banner carousel trang chủ |
| `home_promo` | Trang Chủ - Khuyến Mãi | Banner khuyến mãi trang chủ |
| `about_banner` | Giới Thiệu - Banner | Banner trang giới thiệu |
| `products_top` | Sản Phẩm - Banner Trên | Banner đầu trang sản phẩm |
| `contact_banner` | Liên Hệ - Banner | Banner trang liên hệ |
| `sidebar_ads` | Sidebar - Quảng Cáo | Quảng cáo sidebar |

### Thêm Vị Trí Mới

Để thêm vị trí banner mới, chỉnh sửa file `admin/banners/config.php`:

```php
define('BANNER_LOCATIONS', [
    'home_slider' => 'Trang Chủ - Slider',
    'new_location' => 'Tên Vị Trí Mới',  // Thêm dòng này
    // ... các vị trí khác
]);
```

## 📊 Cấu Trúc Database

Table: `banners`

| Field | Type | Mô Tả |
|-------|------|-------|
| id | INT | ID tự động tăng |
| title | VARCHAR(255) | Tiêu đề banner |
| location_code | VARCHAR(50) | Mã vị trí (home_slider, about_banner...) |
| image_path | VARCHAR(255) | Đường dẫn file ảnh |
| link_url | VARCHAR(500) | URL khi click (nullable) |
| is_active | TINYINT(1) | Trạng thái hiển thị (1=hiện, 0=ẩn) |
| sort_order | INT | Thứ tự sắp xếp (0, 1, 2...) |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

## 🎨 Sử Dụng Trong Frontend

### 1. Import Helper Functions

```php
require_once 'includes/db.php';
require_once 'includes/banner_helper.php';
```

### 2. Lấy Banners Theo Vị Trí

```php
// Lấy banners của trang chủ slider
$homeSliders = getBannersByLocation($pdo, 'home_slider');

// Lấy banners khuyến mãi
$promoBanners = getBannersByLocation($pdo, 'home_promo');
```

### 3. Hiển Thị Banners

**Cách 1: Sử dụng function có sẵn**

```php
// Tự động tạo HTML slider
displayBannerSlider($homeSliders, 'my-slider-class');
```

**Cách 2: Tùy chỉnh HTML**

```php
<?php if (!empty($homeSliders)): ?>
<div class="banner-container">
  <?php foreach ($homeSliders as $banner): ?>
    <div class="banner-item">
      <?php if ($banner['link_url']): ?>
        <a href="<?= htmlspecialchars($banner['link_url']) ?>">
          <img src="<?= htmlspecialchars($banner['image_path']) ?>" 
               alt="<?= htmlspecialchars($banner['title']) ?>">
        </a>
      <?php else: ?>
        <img src="<?= htmlspecialchars($banner['image_path']) ?>" 
             alt="<?= htmlspecialchars($banner['title']) ?>">
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
```

### 4. Kiểm Tra Số Lượng Banner

```php
$count = getBannerCount($pdo, 'home_slider');
if ($count > 0) {
    echo "Có $count banner tại vị trí này";
}
```

## 🖼️ Ví Dụ Thực Tế

### Trang Chủ (index.php)

```php
<?php
require_once 'includes/db.php';
require_once 'includes/banner_helper.php';

$homeSliders = getBannersByLocation($pdo, 'home_slider');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
    <!-- Banner Slider -->
    <?php if (!empty($homeSliders)): ?>
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($homeSliders as $banner): ?>
            <div class="swiper-slide">
                <?php if ($banner['link_url']): ?>
                    <a href="<?= htmlspecialchars($banner['link_url']) ?>">
                        <img src="<?= htmlspecialchars($banner['image_path']) ?>" 
                             alt="<?= htmlspecialchars($banner['title']) ?>">
                    </a>
                <?php else: ?>
                    <img src="<?= htmlspecialchars($banner['image_path']) ?>" 
                         alt="<?= htmlspecialchars($banner['title']) ?>">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.swiper', {
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: '.swiper-pagination' },
        });
    </script>
</body>
</html>
```

### Sidebar Banner

```php
<?php
$sidebarAds = getBannersByLocation($pdo, 'sidebar_ads');
?>

<aside class="sidebar">
    <?php if (!empty($sidebarAds)): ?>
        <div class="sidebar-ads">
            <?php foreach ($sidebarAds as $ad): ?>
                <div class="ad-item">
                    <?php if ($ad['link_url']): ?>
                        <a href="<?= htmlspecialchars($ad['link_url']) ?>" target="_blank">
                            <img src="<?= htmlspecialchars($ad['image_path']) ?>" 
                                 alt="<?= htmlspecialchars($ad['title']) ?>">
                        </a>
                    <?php else: ?>
                        <img src="<?= htmlspecialchars($ad['image_path']) ?>" 
                             alt="<?= htmlspecialchars($ad['title']) ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</aside>
```

## 🎯 Quản Lý Banner Trong Admin

### Truy Cập

- **Danh sách**: `http://localhost/mgf-website/admin/banners/`
- **Thêm mới**: `http://localhost/mgf-website/admin/banners/form.php`
- **Sửa**: `http://localhost/mgf-website/admin/banners/form.php?id=123`

### Tính Năng

1. **Lọc theo vị trí**: Dropdown filter để xem banner theo từng location
2. **Sắp xếp thứ tự**: Mỗi banner có trường `sort_order` (số nhỏ hiển thị trước)
3. **Bật/Tắt hiển thị**: Checkbox `is_active`
4. **Upload ảnh**: Hỗ trợ JPEG, PNG, GIF, WebP
5. **Link URL**: Có thể thêm link khi click banner

### Kích Thước Ảnh Khuyến Nghị

| Vị Trí | Kích Thước | Tỷ Lệ |
|--------|-----------|-------|
| home_slider | 1920x600px | 16:5 |
| home_promo | 1200x400px | 3:1 |
| about_banner | 1920x400px | 4.8:1 |
| products_top | 1200x300px | 4:1 |
| sidebar_ads | 300x600px | 1:2 |

## 🔧 Cấu Hình

### Upload Directory

Banners được lưu tại: `uploads/banners/`

Đường dẫn được định nghĩa trong `includes/config.php`:
```php
define('UPLOAD_DIR', __DIR__ . '/../uploads');
```

### Allowed Image Types

```php
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
```

## 📝 Tips & Best Practices

1. **Đặt tên banner rõ ràng**: VD: "Banner Khuyến Mãi Tết 2025"
2. **Sử dụng sort_order hợp lý**: 0, 10, 20... để dễ chèn banner mới vào giữa
3. **Optimize ảnh trước khi upload**: Nén ảnh để tăng tốc load trang
4. **Sử dụng WebP format**: Kích thước nhỏ hơn JPEG/PNG
5. **Kiểm tra responsive**: Test banner trên mobile và desktop

## 🚀 Migration Database

Để tạo bảng banners, chạy SQL trong file `sql/schema.sql`:

```sql
CREATE TABLE IF NOT EXISTS banners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  location_code VARCHAR(50) NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  link_url VARCHAR(500),
  is_active TINYINT(1) DEFAULT 1,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_location (location_code, is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

**Cập nhật lần cuối**: <?= date('d/m/Y') ?>
