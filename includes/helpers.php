<?php
/**
 * MGF Website - Complete Helper Functions
 * File này chứa tất cả các hàm helper để lấy và hiển thị dữ liệu
 * Sử dụng: require_once 'includes/helpers.php';
 */

// ============================================================================
// CATEGORY FUNCTIONS
// ============================================================================

/**
 * Get all active categories by type
 */
function getCategories($pdo, $type = 'product', $activeOnly = true) {
    $sql = 'SELECT * FROM categories WHERE type = ?';
    $params = [$type];
    
    if ($activeOnly) {
        $sql .= ' AND is_active = 1';
    }
    
    $sql .= ' ORDER BY sort_order ASC, name ASC';
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get single category by ID
 */
function getCategoryById($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get category by slug
 */
function getCategoryBySlug($pdo, $slug) {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ? LIMIT 1');
    $stmt->execute([$slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Display category navigation
 */
function displayCategoryNav($categories, $activeSlug = '', $baseUrl = '', $cssClass = 'category-nav') {
    if (empty($categories)) return '';
    
    $html = '<nav class="' . htmlspecialchars($cssClass) . '">';
    $html .= '<ul>';
    
    // All items link
    $allActive = empty($activeSlug) ? ' class="active"' : '';
    $html .= '<li' . $allActive . '><a href="' . htmlspecialchars($baseUrl) . '">Tất cả</a></li>';
    
    foreach ($categories as $cat) {
        $active = ($cat['slug'] === $activeSlug) ? ' class="active"' : '';
        $url = $baseUrl . '?category=' . urlencode($cat['slug']);
        $html .= '<li' . $active . '>';
        $html .= '<a href="' . htmlspecialchars($url) . '">';
        $html .= htmlspecialchars($cat['name']);
        $html .= '</a></li>';
    }
    
    $html .= '</ul>';
    $html .= '</nav>';
    
    return $html;
}

// ============================================================================
// PRODUCT FUNCTIONS
// ============================================================================

/**
 * Get products with optional filters
 */
function getProducts($pdo, $options = []) {
    $defaults = [
        'category_id' => null,
        'category_slug' => null,
        'slug' => null,
        'exclude_category_id' => null,
        'limit' => 0,
        'offset' => 0,
        'order_by' => 'display_order',
        'order_dir' => 'ASC',
        'with_images' => true,
        'with_category' => true
    ];
    
    $options = array_merge($defaults, $options);
    
    $sql = 'SELECT p.*';
    
    if ($options['with_category']) {
        $sql .= ', c.name as category_name, c.slug as category_slug';
    }
    
    $sql .= ' FROM products p';
    
    if ($options['with_category']) {
        $sql .= ' LEFT JOIN categories c ON p.category_id = c.id';
    }
    
    $where = [];
    $params = [];
    
    if ($options['slug']) {
        $where[] = 'p.slug = ?';
        $params[] = $options['slug'];
    }
    
    if ($options['category_id']) {
        $where[] = 'p.category_id = ?';
        $params[] = $options['category_id'];
    } elseif ($options['category_slug']) {
        $sql .= ' LEFT JOIN categories c2 ON p.category_id = c2.id';
        $where[] = 'c2.slug = ?';
        $params[] = $options['category_slug'];
    }
    
    if ($options['exclude_category_id']) {
        $where[] = '(p.category_id IS NULL OR p.category_id != ?)';
        $params[] = $options['exclude_category_id'];
    }
    
    if (!empty($where)) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    
    $allowedOrderBy = ['display_order', 'created_at', 'price', 'title', 'id'];
    $orderBy = in_array($options['order_by'], $allowedOrderBy) ? $options['order_by'] : 'display_order';
    $orderDir = strtoupper($options['order_dir']) === 'DESC' ? 'DESC' : 'ASC';
    
    // Always sort by display_order first, then by the specified order
    if ($orderBy !== 'display_order') {
        $sql .= ' ORDER BY p.display_order ASC, p.' . $orderBy . ' ' . $orderDir;
    } else {
        $sql .= ' ORDER BY p.display_order ASC, p.created_at DESC';
    }
    
    if ($options['limit'] > 0) {
        $sql .= ' LIMIT ' . (int)$options['limit'];
        if ($options['offset'] > 0) {
            $sql .= ' OFFSET ' . (int)$options['offset'];
        }
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get images if requested
    if ($options['with_images'] && !empty($products)) {
        $productIds = array_column($products, 'id');
        $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
        $imgStmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id IN ($placeholders) ORDER BY sort_order ASC");
        $imgStmt->execute($productIds);
        $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Group images by product_id
        $imagesByProduct = [];
        foreach ($images as $img) {
            $imagesByProduct[$img['product_id']][] = $img;
        }
        
        // Attach images to products
        foreach ($products as &$product) {
            $product['images'] = $imagesByProduct[$product['id']] ?? [];
            $product['first_image'] = !empty($product['images']) ? $product['images'][0]['image_path'] : null;
        }
    }
    
    return $products;
}

/**
 * Get single product by ID or slug
 */
function getProduct($pdo, $identifier, $bySlug = false) {
    if ($bySlug) {
        $sql = 'SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = ? LIMIT 1';
    } else {
        $sql = 'SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ? LIMIT 1';
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$identifier]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) return null;
    
    // Get images
    $imgStmt = $pdo->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC');
    $imgStmt->execute([$product['id']]);
    $product['images'] = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
    $product['first_image'] = !empty($product['images']) ? $product['images'][0]['image_path'] : null;
    
    return $product;
}

/**
 * Get products by category
 */
function getProductsByCategory($pdo, $categoryId, $limit = 0) {
    return getProducts($pdo, [
        'category_id' => $categoryId,
        'limit' => $limit
    ]);
}

/**
 * Get latest products
 */
function getLatestProducts($pdo, $limit = 10) {
    return getProducts($pdo, [
        'limit' => $limit,
        'order_by' => 'display_order',
        'order_dir' => 'ASC'
    ]);
}

/**
 * Get products on promotion
 */
function getPromotionProducts($pdo, $limit = 0) {
    $sql = 'SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.promo_price IS NOT NULL AND p.promo_price > 0 
            ORDER BY p.display_order ASC, p.created_at DESC';
    
    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int)$limit;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get images
    if (!empty($products)) {
        $productIds = array_column($products, 'id');
        $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
        $imgStmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id IN ($placeholders) ORDER BY sort_order ASC");
        $imgStmt->execute($productIds);
        $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $imagesByProduct = [];
        foreach ($images as $img) {
            $imagesByProduct[$img['product_id']][] = $img;
        }
        
        foreach ($products as &$product) {
            $product['images'] = $imagesByProduct[$product['id']] ?? [];
            $product['first_image'] = !empty($product['images']) ? $product['images'][0]['image_path'] : null;
        }
    }
    
    return $products;
}

/**
 * Count products (with optional category filter)
 */
function countProducts($pdo, $categoryId = null) {
    if ($categoryId) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM products WHERE category_id = ?');
        $stmt->execute([$categoryId]);
    } else {
        $stmt = $pdo->query('SELECT COUNT(*) FROM products');
    }
    return (int)$stmt->fetchColumn();
}

/**
 * Format product price
 */
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . ' ₫';
}

/**
 * Calculate discount percentage
 */
function getDiscountPercent($price, $promoPrice) {
    if (!$promoPrice || $promoPrice >= $price) return 0;
    return round((($price - $promoPrice) / $price) * 100);
}

// ============================================================================
// POST FUNCTIONS
// ============================================================================

/**
 * Get posts with optional filters
 */
function getPosts($pdo, $options = []) {
    $defaults = [
        'category_id' => null,
        'category_slug' => null,
        'active_only' => true,
        'limit' => 0,
        'offset' => 0,
        'order_by' => 'created_at',
        'order_dir' => 'DESC',
        'with_category' => true
    ];
    
    $options = array_merge($defaults, $options);
    
    $sql = 'SELECT p.*';
    
    if ($options['with_category']) {
        $sql .= ', c.name as category_name, c.slug as category_slug';
    }
    
    $sql .= ' FROM posts p';
    
    if ($options['with_category']) {
        $sql .= ' LEFT JOIN categories c ON p.category_id = c.id';
    }
    
    $where = [];
    $params = [];
    
    if ($options['active_only']) {
        $where[] = 'p.is_active = 1';
    }
    
    if ($options['category_id']) {
        $where[] = 'p.category_id = ?';
        $params[] = $options['category_id'];
    } elseif ($options['category_slug']) {
        if (!$options['with_category']) {
            $sql .= ' LEFT JOIN categories c2 ON p.category_id = c2.id';
            $where[] = 'c2.slug = ?';
        } else {
            $where[] = 'c.slug = ?';
        }
        $params[] = $options['category_slug'];
    }
    
    if (!empty($where)) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    
    $allowedOrderBy = ['created_at', 'updated_at', 'title', 'id'];
    $orderBy = in_array($options['order_by'], $allowedOrderBy) ? $options['order_by'] : 'created_at';
    $orderDir = strtoupper($options['order_dir']) === 'ASC' ? 'ASC' : 'DESC';
    
    $sql .= ' ORDER BY p.' . $orderBy . ' ' . $orderDir;
    
    if ($options['limit'] > 0) {
        $sql .= ' LIMIT ' . (int)$options['limit'];
        if ($options['offset'] > 0) {
            $sql .= ' OFFSET ' . (int)$options['offset'];
        }
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get single post by ID or slug
 */
function getPost($pdo, $identifier, $bySlug = false) {
    if ($bySlug) {
        $sql = 'SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = ? AND p.is_active = 1 LIMIT 1';
    } else {
        $sql = 'SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ? AND p.is_active = 1 LIMIT 1';
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$identifier]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get posts by category
 */
function getPostsByCategory($pdo, $categoryId, $limit = 0) {
    return getPosts($pdo, [
        'category_id' => $categoryId,
        'limit' => $limit
    ]);
}

/**
 * Get latest posts
 */
function getLatestPosts($pdo, $limit = 10) {
    return getPosts($pdo, [
        'limit' => $limit,
        'order_by' => 'created_at',
        'order_dir' => 'DESC'
    ]);
}

/**
 * Count posts (with optional category filter)
 */
function countPosts($pdo, $categoryId = null, $activeOnly = true) {
    $sql = 'SELECT COUNT(*) FROM posts';
    $where = [];
    $params = [];
    
    if ($activeOnly) {
        $where[] = 'is_active = 1';
    }
    
    if ($categoryId) {
        $where[] = 'category_id = ?';
        $params[] = $categoryId;
    }
    
    if (!empty($where)) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

/**
 * Format post excerpt (limit characters)
 */
function getExcerpt($text, $limit = 150) {
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . '...';
}

/**
 * Format date Vietnamese style
 */
function formatDate($dateString, $format = 'd/m/Y') {
    return date($format, strtotime($dateString));
}

function formatDateTime($dateString, $format = 'd/m/Y H:i') {
    return date($format, strtotime($dateString));
}

// ============================================================================
// BANNER FUNCTIONS
// ============================================================================

/**
 * Get banners by location
 */
function getBanners($pdo, $locationCode, $activeOnly = true) {
    $sql = 'SELECT * FROM banners WHERE location_code = ?';
    $params = [$locationCode];
    
    if ($activeOnly) {
        $sql .= ' AND is_active = 1';
    }
    
    $sql .= ' ORDER BY sort_order ASC';
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Display banner slider/carousel
 */
function displayBannerSlider($banners, $cssClass = 'banner-slider', $showLinks = true) {
    if (empty($banners)) return '';
    
    $html = '<div class="' . htmlspecialchars($cssClass) . '">';
    
    foreach ($banners as $banner) {
        $imagePath = getBannerImageUrl($banner['image_path']);
        
        if ($showLinks && !empty($banner['link_url'])) {
            $html .= '<a href="' . htmlspecialchars($banner['link_url']) . '" class="banner-item">';
            $html .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($banner['title'] ?? 'Banner') . '">';
            $html .= '</a>';
        } else {
            $html .= '<div class="banner-item">';
            $html .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($banner['title'] ?? 'Banner') . '">';
            $html .= '</div>';
        }
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Display single banner
 */
function displayBanner($pdo, $locationCode, $index = 0) {
    $banners = getBanners($pdo, $locationCode);
    
    if (empty($banners) || !isset($banners[$index])) return '';
    
    $banner = $banners[$index];
    $imagePath = getBannerImageUrl($banner['image_path']);
    
    $html = '<div class="banner">';
    
    if (!empty($banner['link_url'])) {
        $html .= '<a href="' . htmlspecialchars($banner['link_url']) . '">';
        $html .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($banner['title'] ?? 'Banner') . '">';
        $html .= '</a>';
    } else {
        $html .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($banner['title'] ?? 'Banner') . '">';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Count banners by location
 */
function countBanners($pdo, $locationCode, $activeOnly = true) {
    $sql = 'SELECT COUNT(*) FROM banners WHERE location_code = ?';
    $params = [$locationCode];
    
    if ($activeOnly) {
        $sql .= ' AND is_active = 1';
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

// ============================================================================
// PAGINATION HELPERS
// ============================================================================

/**
 * Generate pagination HTML
 */
function displayPagination($currentPage, $totalPages, $baseUrl, $cssClass = 'pagination') {
    if ($totalPages <= 1) return '';
    
    $html = '<div class="' . htmlspecialchars($cssClass) . '">';
    
    // Previous button
    if ($currentPage > 1) {
        $prevUrl = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . ($currentPage - 1);
        $html .= '<a href="' . htmlspecialchars($prevUrl) . '" class="page-link prev">« Trước</a>';
    }
    
    // Page numbers
    $start = max(1, $currentPage - 2);
    $end = min($totalPages, $currentPage + 2);
    
    if ($start > 1) {
        $url = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=1';
        $html .= '<a href="' . htmlspecialchars($url) . '" class="page-link">1</a>';
        if ($start > 2) {
            $html .= '<span class="page-dots">...</span>';
        }
    }
    
    for ($i = $start; $i <= $end; $i++) {
        if ($i === $currentPage) {
            $html .= '<span class="page-link active">' . $i . '</span>';
        } else {
            $url = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . $i;
            $html .= '<a href="' . htmlspecialchars($url) . '" class="page-link">' . $i . '</a>';
        }
    }
    
    if ($end < $totalPages) {
        if ($end < $totalPages - 1) {
            $html .= '<span class="page-dots">...</span>';
        }
        $url = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . $totalPages;
        $html .= '<a href="' . htmlspecialchars($url) . '" class="page-link">' . $totalPages . '</a>';
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $nextUrl = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . ($currentPage + 1);
        $html .= '<a href="' . htmlspecialchars($nextUrl) . '" class="page-link next">Sau »</a>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Calculate pagination values
 */
function getPaginationData($page, $perPage, $totalItems) {
    $page = max(1, (int)$page);
    $totalPages = ceil($totalItems / $perPage);
    $offset = ($page - 1) * $perPage;
    
    return [
        'current_page' => $page,
        'per_page' => $perPage,
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
        'offset' => $offset,
        'has_prev' => $page > 1,
        'has_next' => $page < $totalPages
    ];
}

// ============================================================================
// IMAGE HELPERS
// ============================================================================

/**
 * Get product image URL
 */
function getProductImageUrl($imagePath) {
    if (empty($imagePath)) return UPLOAD_URL . '/no-image.png';
    return UPLOAD_URL . '/products/' . htmlspecialchars($imagePath);
}

/**
 * Get post image URL
 */
function getPostImageUrl($imagePath) {
    if (empty($imagePath)) return UPLOAD_URL . '/no-image.png';
    // Remove leading path if it's already included
    $imagePath = str_replace('uploads/posts/', '', $imagePath);
    return UPLOAD_URL . '/posts/' . htmlspecialchars($imagePath);
}

/**
 * Get banner image URL
 */
function getBannerImageUrl($imagePath) {
    if (empty($imagePath)) return '';
    return UPLOAD_URL . '/banners/' . htmlspecialchars($imagePath);
}

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Truncate text with HTML support
 */
function truncateHtml($text, $limit = 100, $ellipsis = '...') {
    if (mb_strlen(strip_tags($text)) <= $limit) return $text;
    
    $text = strip_tags($text);
    if (mb_strlen($text) <= $limit) return $text;
    
    return mb_substr($text, 0, $limit) . $ellipsis;
}

/**
 * Check if product has discount
 */
function hasDiscount($product) {
    return !empty($product['promo_price']) && $product['promo_price'] > 0 && $product['promo_price'] < $product['price'];
}

/**
 * Get current category from URL
 */
function getCurrentCategory($pdo, $type = 'product') {
    if (empty($_GET['category'])) return null;
    
    $slug = $_GET['category'];
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ? AND type = ? LIMIT 1');
    $stmt->execute([$slug, $type]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
