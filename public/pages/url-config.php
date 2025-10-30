<?php
/**
 * Cấu hình URL mapping cho website
 * Định nghĩa các trang có sẵn và các trang sẽ ra mắt
 */

// Base URL của website
define('BASE_URL', '/mgf-website/public/pages/');

// Các trang đã có sẵn
$available_pages = [
    'trang-chu' => 'trang-chu.php',
    'danh-sach-san-pham' => 'danh-sach-san-pham.php',
    'chi-tiet-san-pham' => 'chi-tiet-san-pham.php',
    'danh-sach-tin-tuc' => 'danh-sach-tin-tuc.php',
    'chi-tiet-tin-tuc' => 'chi-tiet-tin-tuc.php',
    've-chung-toi' => 've-chung-toi.php',
];

// Các trang sẽ ra mắt (hiển thị popup thông báo)
$coming_soon_pages = [
    // Top bar menu
    'cong-dong' => 'Cộng đồng',
    'co-hoi-viec-lam' => 'Cơ hội việc làm',
    'tuyen-dung' => 'Tuyển dụng',
    
    // Main menu - Về chúng tôi
    'nguoi-sang-lap' => 'Người sáng lập',
    'gia-tri-doanh-nghiep' => 'Giá trị doanh nghiệp',
    'quy-mo-san-xuat' => 'Quy mô sản xuất',
    'giai-thuong-doi-tac' => 'Giải thưởng & Đối tác',
    
    // Main menu - Sản phẩm & phân phối
    'san-pham' => 'Sản phẩm',
    'phan-phoi' => 'Phân phối',
    'san-pham-va-phan-phoi' => 'Sản phẩm & phân phối',
    
    // Main menu - Phát triển bền vững
    'phat-trien-ben-vung' => 'Phát triển bền vững',
    
    // Main menu - Con người MGF
    'con-nguoi-mgf' => 'Con người MGF',
    'co-cau-doanh-nghiep' => 'Cơ cấu doanh nghiệp',
    'van-hoa-to-chuc' => 'Văn hóa tổ chức',
    
    // Main menu - Truyền thông
    'truyen-thong' => 'Truyền thông',
    'thong-cao-bao-chi' => 'Thông cáo báo chí',
    'thu-vien' => 'Thư viện',
    
    // Footer
    'privacy-policy' => 'Privacy Policy',
    'dieu-khoan-su-dung' => 'Điều khoản sử dụng',
];

/**
 * Hàm lấy URL cho một trang
 * @param string $page_slug - Slug của trang
 * @return string - URL đầy đủ
 */
function get_page_url($page_slug) {
    global $available_pages;
    
    if (isset($available_pages[$page_slug])) {
        return BASE_URL . $available_pages[$page_slug];
    }
    
    return '#';
}

/**
 * Kiểm tra xem trang có sẵn chưa
 * @param string $page_slug - Slug của trang
 * @return bool
 */
function is_page_available($page_slug) {
    global $available_pages;
    return isset($available_pages[$page_slug]);
}

/**
 * Lấy class và thuộc tính cho link
 * @param string $page_slug - Slug của trang
 * @return string - Class và attributes cho thẻ a
 */
function get_link_attributes($page_slug) {
    global $coming_soon_pages;
    
    if (isset($coming_soon_pages[$page_slug])) {
        return 'class="coming-soon-link" data-page-title="' . htmlspecialchars($coming_soon_pages[$page_slug]) . '"';
    }
    
    return '';
}
