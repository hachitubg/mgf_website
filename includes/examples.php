<?php
/**
 * EXAMPLES - Cách sử dụng helpers.php
 * File này chứa các ví dụ về cách sử dụng các hàm helper
 */

require_once 'includes/db.php';
require_once 'includes/helpers.php';

// ============================================================================
// DANH MỤC (CATEGORIES)
// ============================================================================

// Lấy tất cả danh mục sản phẩm
$productCategories = getCategories($pdo, 'product');

// Lấy tất cả danh mục bài viết
$postCategories = getCategories($pdo, 'post');

// Lấy danh mục theo slug
$category = getCategoryBySlug($pdo, 'san-pham-moi');

// Hiển thị menu danh mục
echo displayCategoryNav($productCategories, '', '/products.php', 'product-categories');

// ============================================================================
// SẢN PHẨM (PRODUCTS)
// ============================================================================

// --- Lấy danh sách sản phẩm ---

// Lấy 12 sản phẩm mới nhất
$latestProducts = getLatestProducts($pdo, 12);

// Lấy sản phẩm theo danh mục
$categorySlug = $_GET['category'] ?? null;
if ($categorySlug) {
    $products = getProducts($pdo, [
        'category_slug' => $categorySlug,
        'limit' => 12
    ]);
} else {
    $products = getLatestProducts($pdo, 12);
}

// Lấy sản phẩm khuyến mãi
$promoProducts = getPromotionProducts($pdo, 8);

// Lấy sản phẩm với phân trang
$page = $_GET['page'] ?? 1;
$perPage = 12;
$totalProducts = countProducts($pdo);
$pagination = getPaginationData($page, $perPage, $totalProducts);

$products = getProducts($pdo, [
    'limit' => $perPage,
    'offset' => $pagination['offset']
]);

// --- Lấy chi tiết sản phẩm ---

// Lấy sản phẩm theo slug (cho trang chi tiết)
$productSlug = $_GET['slug'] ?? null;
$product = getProduct($pdo, $productSlug, true);

if (!$product) {
    header('HTTP/1.0 404 Not Found');
    echo "Không tìm thấy sản phẩm";
    exit;
}

// --- Hiển thị sản phẩm ---
?>

<!-- Danh sách sản phẩm dạng grid -->
<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <?php if (hasDiscount($product)): ?>
                <span class="discount-badge">-<?= getDiscountPercent($product['price'], $product['promo_price']) ?>%</span>
            <?php endif; ?>
            
            <a href="/mgf-website/product.php?slug=<?= urlencode($product['slug']) ?>">
                <img src="<?= getProductImageUrl($product['first_image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
            </a>
            
            <div class="product-info">
                <?php if (!empty($product['category_name'])): ?>
                    <span class="category"><?= htmlspecialchars($product['category_name']) ?></span>
                <?php endif; ?>
                
                <h3>
                    <a href="/mgf-website/product.php?slug=<?= urlencode($product['slug']) ?>">
                        <?= htmlspecialchars($product['title']) ?>
                    </a>
                </h3>
                
                <div class="price">
                    <?php if (hasDiscount($product)): ?>
                        <span class="old-price"><?= formatPrice($product['price']) ?></span>
                        <span class="new-price"><?= formatPrice($product['promo_price']) ?></span>
                    <?php else: ?>
                        <span class="current-price"><?= formatPrice($product['price']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Phân trang -->
<?= displayPagination($pagination['current_page'], $pagination['total_pages'], '/products.php') ?>

<!-- Trang chi tiết sản phẩm -->
<div class="product-detail">
    <div class="product-images">
        <div class="main-image">
            <img src="<?= getProductImageUrl($product['first_image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" id="main-img">
        </div>
        <div class="thumbnails">
            <?php foreach ($product['images'] as $img): ?>
                <img src="<?= getProductImageUrl($img['image_path']) ?>" 
                     alt="<?= htmlspecialchars($product['title']) ?>"
                     onclick="document.getElementById('main-img').src = this.src">
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="product-info">
        <?php if (!empty($product['category_name'])): ?>
            <a href="/mgf-website/products.php?category=<?= urlencode($product['category_slug']) ?>" class="category-link">
                <?= htmlspecialchars($product['category_name']) ?>
            </a>
        <?php endif; ?>
        
        <h1><?= htmlspecialchars($product['title']) ?></h1>
        
        <div class="price">
            <?php if (hasDiscount($product)): ?>
                <span class="old-price"><?= formatPrice($product['price']) ?></span>
                <span class="new-price"><?= formatPrice($product['promo_price']) ?></span>
                <span class="discount">Tiết kiệm <?= getDiscountPercent($product['price'], $product['promo_price']) ?>%</span>
            <?php else: ?>
                <span class="current-price"><?= formatPrice($product['price']) ?></span>
            <?php endif; ?>
        </div>
        
        <div class="description">
            <?= $product['description'] ?>
        </div>
        
        <button class="btn-add-to-cart">Thêm vào giỏ hàng</button>
    </div>
</div>

<?php
// ============================================================================
// BÀI VIẾT (POSTS)
// ============================================================================

// --- Lấy danh sách bài viết ---

// Lấy 10 bài viết mới nhất
$latestPosts = getLatestPosts($pdo, 10);

// Lấy bài viết theo danh mục
$categorySlug = $_GET['category'] ?? null;
if ($categorySlug) {
    $posts = getPosts($pdo, [
        'category_slug' => $categorySlug,
        'limit' => 10
    ]);
} else {
    $posts = getLatestPosts($pdo, 10);
}

// Lấy bài viết với phân trang
$page = $_GET['page'] ?? 1;
$perPage = 10;
$totalPosts = countPosts($pdo);
$pagination = getPaginationData($page, $perPage, $totalPosts);

$posts = getPosts($pdo, [
    'limit' => $perPage,
    'offset' => $pagination['offset']
]);

// --- Lấy chi tiết bài viết ---

$postSlug = $_GET['slug'] ?? null;
$post = getPost($pdo, $postSlug, true);

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    echo "Không tìm thấy bài viết";
    exit;
}

// --- Hiển thị bài viết ---
?>

<!-- Danh sách bài viết -->
<div class="post-list">
    <?php foreach ($posts as $post): ?>
        <article class="post-item">
            <?php if ($post['featured_image']): ?>
                <a href="/mgf-website/post.php?slug=<?= urlencode($post['slug']) ?>" class="post-thumbnail">
                    <img src="<?= getPostImageUrl($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                </a>
            <?php endif; ?>
            
            <div class="post-content">
                <?php if (!empty($post['category_name'])): ?>
                    <span class="category"><?= htmlspecialchars($post['category_name']) ?></span>
                <?php endif; ?>
                
                <h2>
                    <a href="/mgf-website/post.php?slug=<?= urlencode($post['slug']) ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                </h2>
                
                <div class="post-meta">
                    <span class="date"><?= formatDate($post['created_at'], 'd/m/Y') ?></span>
                </div>
                
                <?php if ($post['excerpt']): ?>
                    <p class="excerpt"><?= htmlspecialchars(getExcerpt($post['excerpt'], 150)) ?></p>
                <?php endif; ?>
                
                <a href="/mgf-website/post.php?slug=<?= urlencode($post['slug']) ?>" class="read-more">Đọc thêm →</a>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<!-- Phân trang -->
<?= displayPagination($pagination['current_page'], $pagination['total_pages'], '/posts.php') ?>

<!-- Trang chi tiết bài viết -->
<article class="post-detail">
    <?php if (!empty($post['category_name'])): ?>
        <a href="/mgf-website/posts.php?category=<?= urlencode($post['category_slug']) ?>" class="category-link">
            <?= htmlspecialchars($post['category_name']) ?>
        </a>
    <?php endif; ?>
    
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    
    <div class="post-meta">
        <span class="date"><?= formatDateTime($post['created_at'], 'd/m/Y H:i') ?></span>
    </div>
    
    <?php if ($post['featured_image']): ?>
        <div class="featured-image">
            <img src="<?= getPostImageUrl($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
        </div>
    <?php endif; ?>
    
    <div class="post-content">
        <?= $post['content'] ?>
    </div>
</article>

<?php
// ============================================================================
// BANNER
// ============================================================================

// Lấy banner slider trang chủ
$homeSliders = getBanners($pdo, 'home_slider');

// Hiển thị banner slider
echo displayBannerSlider($homeSliders, 'hero-slider');

// Hiển thị banner đơn
echo displayBanner($pdo, 'about_banner');

// Hiển thị banner promo
$promoBanners = getBanners($pdo, 'home_promo');
?>

<!-- Banner slider tùy chỉnh -->
<div class="hero-section">
    <?php 
    $sliders = getBanners($pdo, 'home_slider');
    foreach ($sliders as $banner): 
    ?>
        <div class="slide">
            <?php if (!empty($banner['link_url'])): ?>
                <a href="<?= htmlspecialchars($banner['link_url']) ?>">
                    <img src="<?= getBannerImageUrl($banner['image_path']) ?>" alt="<?= htmlspecialchars($banner['title'] ?? '') ?>">
                </a>
            <?php else: ?>
                <img src="<?= getBannerImageUrl($banner['image_path']) ?>" alt="<?= htmlspecialchars($banner['title'] ?? '') ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Sidebar banners -->
<aside class="sidebar">
    <?php 
    $sidebarAds = getBanners($pdo, 'sidebar_ads');
    foreach ($sidebarAds as $ad): 
    ?>
        <div class="sidebar-ad">
            <?php if (!empty($ad['link_url'])): ?>
                <a href="<?= htmlspecialchars($ad['link_url']) ?>">
                    <img src="<?= getBannerImageUrl($ad['image_path']) ?>" alt="<?= htmlspecialchars($ad['title'] ?? '') ?>">
                </a>
            <?php else: ?>
                <img src="<?= getBannerImageUrl($ad['image_path']) ?>" alt="<?= htmlspecialchars($ad['title'] ?? '') ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</aside>

<?php
// ============================================================================
// TRANG CHỦ - KẾT HỢP TẤT CẢ
// ============================================================================
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MGF Website - Trang Chủ</title>
</head>
<body>
    <!-- Hero Slider -->
    <section class="hero">
        <?= displayBannerSlider(getBanners($pdo, 'home_slider'), 'hero-slider') ?>
    </section>
    
    <!-- Danh mục sản phẩm -->
    <section class="categories">
        <h2>Danh Mục Sản Phẩm</h2>
        <?= displayCategoryNav(getCategories($pdo, 'product'), '', '/products.php') ?>
    </section>
    
    <!-- Sản phẩm khuyến mãi -->
    <section class="promotion-products">
        <h2>Khuyến Mãi Hot</h2>
        <div class="product-grid">
            <?php 
            $promoProducts = getPromotionProducts($pdo, 8);
            foreach ($promoProducts as $product): 
            ?>
                <div class="product-card">
                    <span class="discount-badge">-<?= getDiscountPercent($product['price'], $product['promo_price']) ?>%</span>
                    <a href="/mgf-website/product.php?slug=<?= urlencode($product['slug']) ?>">
                        <img src="<?= getProductImageUrl($product['first_image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                    </a>
                    <h3><?= htmlspecialchars($product['title']) ?></h3>
                    <div class="price">
                        <span class="old-price"><?= formatPrice($product['price']) ?></span>
                        <span class="new-price"><?= formatPrice($product['promo_price']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <!-- Sản phẩm mới -->
    <section class="new-products">
        <h2>Sản Phẩm Mới</h2>
        <div class="product-grid">
            <?php 
            $newProducts = getLatestProducts($pdo, 12);
            foreach ($newProducts as $product): 
            ?>
                <div class="product-card">
                    <?php if (hasDiscount($product)): ?>
                        <span class="discount-badge">-<?= getDiscountPercent($product['price'], $product['promo_price']) ?>%</span>
                    <?php endif; ?>
                    <a href="/mgf-website/product.php?slug=<?= urlencode($product['slug']) ?>">
                        <img src="<?= getProductImageUrl($product['first_image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                    </a>
                    <h3><?= htmlspecialchars($product['title']) ?></h3>
                    <div class="price">
                        <?php if (hasDiscount($product)): ?>
                            <span class="old-price"><?= formatPrice($product['price']) ?></span>
                            <span class="new-price"><?= formatPrice($product['promo_price']) ?></span>
                        <?php else: ?>
                            <span class="current-price"><?= formatPrice($product['price']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <!-- Banner promo -->
    <?= displayBannerSlider(getBanners($pdo, 'home_promo'), 'promo-banners') ?>
    
    <!-- Bài viết mới -->
    <section class="latest-posts">
        <h2>Tin Tức Mới Nhất</h2>
        <div class="post-grid">
            <?php 
            $latestPosts = getLatestPosts($pdo, 6);
            foreach ($latestPosts as $post): 
            ?>
                <article class="post-card">
                    <?php if ($post['featured_image']): ?>
                        <a href="/mgf-website/post.php?slug=<?= urlencode($post['slug']) ?>">
                            <img src="<?= getPostImageUrl($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                        </a>
                    <?php endif; ?>
                    <div class="post-info">
                        <?php if (!empty($post['category_name'])): ?>
                            <span class="category"><?= htmlspecialchars($post['category_name']) ?></span>
                        <?php endif; ?>
                        <h3>
                            <a href="/mgf-website/post.php?slug=<?= urlencode($post['slug']) ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h3>
                        <p class="date"><?= formatDate($post['created_at']) ?></p>
                        <?php if ($post['excerpt']): ?>
                            <p class="excerpt"><?= htmlspecialchars(getExcerpt($post['excerpt'], 100)) ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
