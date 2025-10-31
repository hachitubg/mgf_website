<?php
/**
 * Helper function to generate clean URLs without .php extension
 */

function url($page, $params = []) {
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $cleanPage = str_replace('.php', '', $page);
    
    $url = $baseUrl . '/' . $cleanPage;
    
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    return $url;
}

// Quick helper functions for common pages
function home_url() {
    return url('trang-chu');
}

function about_url() {
    return url('ve-chung-toi');
}

function products_url($category = null) {
    return url('danh-sach-san-pham', $category ? ['category' => $category] : []);
}

function product_detail_url($slug) {
    return url('chi-tiet-san-pham', ['slug' => $slug]);
}

function posts_url($category = null) {
    return url('danh-sach-tin-tuc', $category ? ['category' => $category] : []);
}

function post_detail_url($slug) {
    return url('chi-tiet-tin-tuc', ['slug' => $slug]);
}

function contact_url() {
    return url('lien-he');
}
