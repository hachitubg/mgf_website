<?php
// Banner locations configuration
// Mỗi vị trí có code và tên hiển thị

define('BANNER_LOCATIONS', [
    'danh_sach_san_pham' => 'Sidebar - Danh Sách Sản Phẩm',
    'home_slider' => 'Trang Chủ - Slider',
    'home_promo' => 'Trang Chủ - Khuyến Mãi',
    'about_banner' => 'Giới Thiệu - Banner',
    'products_top' => 'Sản Phẩm - Banner Trên',
    'contact_banner' => 'Liên Hệ - Banner',
    'sidebar_ads' => 'Sidebar - Quảng Cáo',
]);

/**
 * Get location name by code
 */
function getBannerLocationName($code) {
    $locations = BANNER_LOCATIONS;
    return $locations[$code] ?? $code;
}

/**
 * Get all banner locations
 */
function getAllBannerLocations() {
    return BANNER_LOCATIONS;
}
