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
$stmt = $pdo->prepare("SELECT p.*, pi.image_path, c.name as category_name 
                       FROM products p 
                       LEFT JOIN product_images pi ON p.id = pi.product_id 
                            AND pi.sort_order = (SELECT MIN(sort_order) FROM product_images WHERE product_id = p.id)
                       LEFT JOIN categories c ON c.id = p.category_id
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
        <section class="related-products-section" style="padding: 60px 0; background: #f8f9fa;">
            <div class="container">
                <div class="section-title-wrapper text-center" style="margin-bottom: 40px;">
                    <h3 class="section-title" style="font-size: 32px; font-weight: 700; color: #054326; margin-bottom: 10px;">Sản phẩm liên quan</h3>
                    <p style="color: #666; font-size: 16px;">Khám phá thêm các sản phẩm tương tự</p>
                </div>
                
                <div class="related-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                    <?php foreach ($related_products as $rel_product): 
                        $rel_image = $rel_product['image_path'] 
                            ? '../uploads/products/' . $rel_product['image_path']
                            : '05_images/no-image.jpg';
                        
                        // Clean description: remove HTML tags properly
                        $clean_desc = strip_tags($rel_product['description'] ?? '');
                        // Remove any remaining HTML entities
                        $clean_desc = html_entity_decode($clean_desc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        // Remove extra whitespace
                        $clean_desc = preg_replace('/\s+/', ' ', $clean_desc);
                        $clean_desc = trim($clean_desc);
                        
                        $short_desc = mb_substr($clean_desc, 0, 80, 'UTF-8');
                        if (mb_strlen($clean_desc) > 80) {
                            $short_desc .= '...';
                        }
                    ?>
                    <div class="related-product-card" style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                        <a href="chi-tiet-san-pham?slug=<?= htmlspecialchars($rel_product['slug']) ?>" style="text-decoration: none; color: inherit; display: block;">
                            <div class="product-card-image" style="position: relative; aspect-ratio: 4/3; overflow: hidden; background: #f5f5f5;">
                                <img src="<?= htmlspecialchars($rel_image) ?>" 
                                     alt="<?= htmlspecialchars($rel_product['title']) ?>"
                                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                     loading="lazy"/>
                            </div>
                            <div class="product-card-content" style="padding: 20px;">
                                <h4 class="product-card-title" style="font-size: 18px; font-weight: 700; color: #054326; margin-bottom: 10px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 50px;">
                                    <?= htmlspecialchars($rel_product['title']) ?>
                                </h4>
                                <?php if ($rel_product['category_name']): ?>
                                <div class="product-category-badge" style="display: inline-block; margin-bottom: 10px; padding: 4px 12px; background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%); color: #fff; border-radius: 15px; font-size: 11px; font-weight: 600; width: fit-content; max-width: 100%;">
                                    <?= htmlspecialchars($rel_product['category_name']) ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($short_desc): ?>
                                <p class="product-card-desc" style="font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 63px;">
                                    <?= htmlspecialchars($short_desc) ?>
                                </p>
                                <?php endif; ?>
                                <div class="product-card-action" style="padding-top: 12px; border-top: 1px solid #f0f0f0;">
                                    <span style="color: #2eb058; font-weight: 600; font-size: 14px;">
                                        Xem chi tiết 
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align: middle; margin-left: 4px;">
                                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <style>
            .related-product-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            }
            .related-product-card:hover .product-card-image img {
                transform: scale(1.1);
            }
            
            @media (max-width: 768px) {
                .related-products-section {
                    padding: 40px 0 !important;
                }
                .related-products-grid {
                    grid-template-columns: 1fr !important;
                    gap: 16px !important;
                }
                .related-product-card {
                    display: flex !important;
                    flex-direction: row !important;
                    align-items: stretch;
                }
                .related-product-card a {
                    display: flex !important;
                    width: 100%;
                }
                .related-product-card .product-card-image {
                    flex: 0 0 120px !important;
                    aspect-ratio: 1/1 !important;
                    min-height: 120px;
                }
                .related-product-card .product-card-content {
                    flex: 1;
                    padding: 12px !important;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
                .related-product-card .product-card-title {
                    font-size: 15px !important;
                    min-height: auto !important;
                    -webkit-line-clamp: 2 !important;
                    margin-bottom: 6px !important;
                }
                .related-product-card .product-card-desc {
                    font-size: 12px !important;
                    min-height: auto !important;
                    -webkit-line-clamp: 2 !important;
                    margin-bottom: 8px !important;
                    line-height: 1.4 !important;
                }
                .related-product-card .product-card-action {
                    padding-top: 8px !important;
                }
                .related-product-card .product-card-action span {
                    font-size: 13px !important;
                }
                .related-product-card .product-category-badge {
                    padding: 3px 8px !important;
                    font-size: 10px !important;
                    margin-bottom: 6px !important;
                    width: fit-content !important;
                    max-width: 100% !important;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            }
            
            @media (min-width: 769px) and (max-width: 1024px) {
                .related-products-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
            
            @media (min-width: 1025px) and (max-width: 1280px) {
                .related-products-grid {
                    grid-template-columns: repeat(3, 1fr) !important;
                }
            }
        </style>
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
    </script>
    <script id="sanpham-js" src="03_js/sanpham.js" type="text/javascript"></script>

    <div class="loading">
        <div class="overlay"></div>
        <div class="loader"></div>
    </div>
</body>
</html>
