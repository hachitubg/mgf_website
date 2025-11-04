<?php
// Banner locations configuration
// Mỗi vị trí có code và tên hiển thị

define('BANNER_LOCATIONS', [
    'trang_chu' => 'Trang Chủ - Slider',
    'gioi_thieu' => 'Giới Thiệu - Banner',
    'san_pham' => 'Sản Phẩm - Banner',
    'tin_tuc' => 'Tin Tức - Banner',
    'banner_khac' => 'Các Banner khác',
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
