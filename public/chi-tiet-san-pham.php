<?php
require_once __DIR__ . '/../includes/db.php';

// Lấy slug từ URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: trang-chu.php');
    exit;
}

// Lấy thông tin sản phẩm
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                       FROM products p 
                       LEFT JOIN categories c ON p.category_id = c.id
                       WHERE p.slug = ?");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: san-pham.php');
    exit;
}

// Set page title based on product name
$page_title = $product['title'];

// Lấy danh sách hình ảnh của sản phẩm
$stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC");
$stmt->execute([$product['id']]);
$images = $stmt->fetchAll();

// Lấy sản phẩm liên quan (cùng danh mục)
$stmt = $pdo->prepare("SELECT p.*, pi.image_path 
                       FROM products p 
                       LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
                       WHERE p.category_id = ? AND p.id != ? 
                       ORDER BY RAND() 
                       LIMIT 6");
$stmt->execute([$product['category_id'], $product['id']]);
$related_products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="content-type"/>
    <title><?= htmlspecialchars($product['title']) ?> - MGF Việt Nam</title>
    <meta name="description" content="<?= htmlspecialchars(mb_substr(strip_tags($product['description']), 0, 160)) ?>">
    
    <link href="02_css/style_sanpham.css" id="main-style-css" media="all" rel="stylesheet" type="text/css"/>
    <link href="02_css/product.css" id="page-style-css" media="all" rel="stylesheet" type="text/css"/>
    <link href="02_css/product-detail.css" id="detail-style-css" media="all" rel="stylesheet" type="text/css"/>
    <?php include '01_includes/header.php'; ?>
</head>

<body class="wp-singular single-product wp-theme-greenfeed loading-effect">
    
    <?php include '01_includes/header_02.php'; ?>

    <main class="site-main" id="dt-main-content" role="main">
        <!-- Breadcrumb -->
        <div class="header-background" style="background-image:url('https://www.greenfeed.com.vn/wp-content/uploads/2024/12/Image-e1741807224867.jpg')">
            <div class="container">
                <div class="dt-breadscrumb">
                    <ul class="breadcrumb">
                        <li><a href="trang-chu">Trang chủ</a></li>
                        <li><a href="san-pham">Sản phẩm</a></li>
                        <?php if ($product['category_name']): ?>
                        <li><a href="san-pham?category=<?= htmlspecialchars($product['category_slug']) ?>">
                            <?= htmlspecialchars($product['category_name']) ?>
                        </a></li>
                        <?php endif; ?>
                        <li><span class="active"><?= htmlspecialchars($product['title']) ?></span></li>
                    </ul>
                </div>
                <h1 class="header-title"><?= htmlspecialchars($product['title']) ?></h1>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <section class="product-detail-section">
            <div class="container">
                <div class="product-detail-wrapper">
                    <!-- Album ảnh -->
                    <div class="product-gallery">
                        <div class="main-image">
                            <?php 
                            $main_image = !empty($images) ? '../uploads/products/' . $images[0]['image_path'] : '05_images/no-image.jpg';
                            ?>
                            <img id="mainProductImage" src="<?= htmlspecialchars($main_image) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                        </div>
                        
                        <?php if (count($images) > 1): ?>
                        <div class="thumbnail-images">
                            <?php foreach ($images as $index => $image): ?>
                            <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" onclick="changeMainImage('<?= htmlspecialchars('../uploads/products/' . $image['image_path']) ?>', this)">
                                <img src="<?= htmlspecialchars('../uploads/products/' . $image['image_path']) ?>" alt="<?= htmlspecialchars($product['title']) ?> - Ảnh <?= $index + 1 ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="product-info">
                        <div class="product-meta">
                            <?php if ($product['category_name']): ?>
                            <span class="product-category"><?= htmlspecialchars($product['category_name']) ?></span>
                            <?php endif; ?>
                        </div>

                        <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>

                        <?php if ($product['price'] > 0): ?>
                        <div class="product-price-section">
                            <?php if ($product['promo_price'] > 0 && $product['promo_price'] < $product['price']): ?>
                                <div class="price-wrapper">
                                    <span class="price-current"><?= number_format($product['promo_price'], 0, ',', '.') ?>đ</span>
                                    <span class="price-original"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                                    <span class="price-discount">
                                        -<?= round((($product['price'] - $product['promo_price']) / $product['price']) * 100) ?>%
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="price-wrapper">
                                    <span class="price-current"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="product-description">
                            <h3>Mô tả sản phẩm</h3>
                            <div class="description-content">
                                <?= $product['description'] ?>
                            </div>
                        </div>

                        <div class="product-actions">
                            <a href="lien-he?product=<?= urlencode($product['title']) ?>" class="btn btn--primary">
                                Liên hệ đặt hàng
                                <img alt="arr" height="60" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/long-arr-next.svg" width="60"/>
                            </a>
                            <a href="tel:1900633627" class="btn btn--outline">
                                Hotline: 1900 633 627
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sản phẩm liên quan -->
        <?php if (!empty($related_products)): ?>
        <section class="related-products-section">
            <div class="container">
                <div class="section-title-wrapper text-center">
                    <h3 class="section-title">Sản phẩm liên quan</h3>
                </div>
                
                <div class="related-products-carousel owl-carousel owl-theme">
                    <?php foreach ($related_products as $rel_product): 
                        $rel_image = $rel_product['image_path'] 
                            ? '../uploads/products/' . $rel_product['image_path']
                            : '05_images/no-image.jpg';
                        $short_desc = mb_substr(strip_tags($rel_product['description'] ?? ''), 0, 100, 'UTF-8');
                        if (mb_strlen(strip_tags($rel_product['description'] ?? '')) > 100) {
                            $short_desc .= '...';
                        }
                    ?>
                    <div class="related-product-item">
                        <a href="chi-tiet-san-pham?slug=<?= htmlspecialchars($rel_product['slug']) ?>" class="product-link">
                            <div class="product-image">
                                <img src="<?= htmlspecialchars($rel_image) ?>" alt="<?= htmlspecialchars($rel_product['title']) ?>">
                            </div>
                            <div class="product-content">
                                <h4 class="product-title"><?= htmlspecialchars($rel_product['title']) ?></h4>
                                <p class="product-excerpt"><?= htmlspecialchars($short_desc) ?></p>
                                <?php if ($rel_product['price'] > 0): ?>
                                <div class="product-price">
                                    <?php if ($rel_product['promo_price'] > 0 && $rel_product['promo_price'] < $rel_product['price']): ?>
                                        <span class="price-promo"><?= number_format($rel_product['promo_price'], 0, ',', '.') ?>đ</span>
                                        <span class="price-old"><?= number_format($rel_product['price'], 0, ',', '.') ?>đ</span>
                                    <?php else: ?>
                                        <span class="price"><?= number_format($rel_product['price'], 0, ',', '.') ?>đ</span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php include '01_includes/footer.php'; ?>
    
    <script>
        function changeMainImage(imageSrc, thumbnail) {
            document.getElementById('mainProductImage').src = imageSrc;
            
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(function(thumb) {
                thumb.classList.remove('active');
            });
            
            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
        }

        // Initialize related products carousel
        $(document).ready(function() {
            $('.related-products-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: [
                    '<svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M25 30L15 20L25 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    '<svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M15 30L25 20L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                ],
                responsive: {
                    0: {
                        items: 1,
                        margin: 20,
                        nav: false
                    },
                    480: {
                        items: 2,
                        margin: 20,
                        nav: false
                    },
                    768: {
                        items: 3,
                        margin: 25,
                        nav: true
                    },
                    1024: {
                        items: 4,
                        margin: 30,
                        nav: true
                    }
                }
            });
        });
    </script>
    <script id="sanpham-js" src="03_js/sanpham.js" type="text/javascript"></script>

    <div class="loading">
        <div class="overlay"></div>
        <div class="loader"></div>
    </div>
</body>
</html>
