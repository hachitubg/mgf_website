<?php
$page_title = "Sản phẩm và dịch vụ";
require_once __DIR__ . '/../includes/db.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Get category filter
$category_slug = $_GET['category'] ?? '';

// Build query
$where = "WHERE 1=1";
$params = [];

if ($category_slug) {
    $where .= " AND c.slug = ?";
    $params[] = $category_slug;
}

// Get total products
$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id 
                             $where");
$count_stmt->execute($params);
$total_products = $count_stmt->fetchColumn();
$total_pages = ceil($total_products / $per_page);

// Get products
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug,
                       pi.image_path
                       FROM products p 
                       LEFT JOIN categories c ON p.category_id = c.id
                       LEFT JOIN product_images pi ON p.id = pi.product_id 
                            AND pi.sort_order = (SELECT MIN(sort_order) FROM product_images WHERE product_id = p.id)
                       $where
                       ORDER BY p.display_order ASC, p.id DESC 
                       LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get product categories
$cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'product' AND is_active = 1 ORDER BY sort_order ASC");
$categories = $cat_stmt->fetchAll();

// Get banner for this page
$banner_stmt = $pdo->query("SELECT * FROM banners 
                            WHERE location_code = 'san_pham' AND is_active = 1 
                            ORDER BY sort_order ASC, id DESC 
                            LIMIT 1");
$banner = $banner_stmt->fetch();

// Set banner image
$banner_image = $banner && $banner['image_path'] 
   ? '../uploads/banners/' . $banner['image_path']
   : 'https://www.greenfeed.com.vn/wp-content/uploads/2024/12/Image-e1741807224867.jpg';

// Get current category info
$current_category = null;
if ($category_slug) {
    foreach ($categories as $cat) {
        if ($cat['slug'] === $category_slug) {
            $current_category = $cat;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
 <meta content="text/html;charset=utf-8" http-equiv="content-type"/>
 <title><?= $current_category ? htmlspecialchars($current_category['name']) . ' - ' : '' ?>Sản phẩm và dịch vụ - MGF Việt Nam</title>

 <!-- Includes header.php -->
 <link href="02_css/style_sanpham.css" id="main-style-css" media="all" rel="stylesheet" type="text/css"/>
 <link href="02_css/product.css" id="page-style-css" media="all" rel="stylesheet" type="text/css"/>
 <?php include '01_includes/header.php'; ?>

 <body class="wp-singular page-template page-template-page-templates page-template-san-pham wp-theme-greenfeed loading-effect">
  
  <!-- Includes header1.php -->
  <?php include '01_includes/header_02.php'; ?>

  <!-- main -->
  <main class="site-main" id="dt-main-content" role="main">
    <div class="header-background" style="background-image:url('<?= htmlspecialchars($banner_image) ?>')">
        <div class="container">
            <div class="dt-breadscrumb">
                <ul class="breadcrumb">
                    <li>
                        <a href="trang-chu">
                            Trang chủ
                        </a>
                    </li>
                    <?php if ($current_category): ?>
                    <li>
                        <a href="san-pham">
                            Sản phẩm và dịch vụ
                        </a>
                    </li>
                    <li>
                        <span class="active">
                            <?= htmlspecialchars($current_category['name']) ?>
                        </span>
                    </li>
                    <?php else: ?>
                    <li>
                        <span class="active">
                            Sản phẩm và dịch vụ
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <h1 class="header-title">
                <?= $current_category ? htmlspecialchars($current_category['name']) : 'Sản phẩm và dịch vụ' ?>
            </h1>
        </div>
    </div>

    <!-- Category Filter Section -->
    <section class="category-filter-section" style="padding: 40px 0; background: #f8f9fa;">
        <div class="container">
            <div class="category-filter">
                <!-- Desktop View -->
                <div class="category-filter-desktop" style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <a href="san-pham" 
                       class="category-filter-item <?= empty($category_slug) ? 'active' : '' ?>"
                       style="padding: 10px 24px; background: <?= empty($category_slug) ? 'linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%)' : '#fff' ?>; color: <?= empty($category_slug) ? '#fff' : '#054326' ?>; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border: 2px solid <?= empty($category_slug) ? 'transparent' : '#e0e0e0' ?>; display: inline-block; white-space: nowrap;">
                        Tất cả sản phẩm
                    </a>
                    <?php foreach ($categories as $cat): ?>
                    <a href="san-pham?category=<?= htmlspecialchars($cat['slug']) ?>" 
                       class="category-filter-item <?= $category_slug === $cat['slug'] ? 'active' : '' ?>"
                       style="padding: 10px 24px; background: <?= $category_slug === $cat['slug'] ? 'linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%)' : '#fff' ?>; color: <?= $category_slug === $cat['slug'] ? '#fff' : '#054326' ?>; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border: 2px solid <?= $category_slug === $cat['slug'] ? 'transparent' : '#e0e0e0' ?>; display: inline-block; white-space: nowrap;">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile View - Dropdown -->
                <div class="category-filter-mobile" style="display: none; position: relative;">
                    <button class="category-dropdown-toggle" style="width: 100%; padding: 12px 16px; background: #fff; border: 2px solid #e0e0e0; border-radius: 8px; color: #054326; font-weight: 600; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: all 0.3s ease;">
                        <span class="selected-category">
                            <?= $current_category ? htmlspecialchars($current_category['name']) : 'Tất cả sản phẩm' ?>
                        </span>
                        <svg class="dropdown-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" style="transition: transform 0.3s ease;">
                            <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="category-dropdown-menu" style="display: none; position: absolute; top: 100%; left: 0; right: 0; margin-top: 8px; background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); max-height: 300px; overflow-y: auto; z-index: 100;">
                        <a href="san-pham" 
                           class="category-dropdown-item <?= empty($category_slug) ? 'active' : '' ?>"
                           style="display: block; padding: 12px 16px; color: <?= empty($category_slug) ? '#2eb058' : '#054326' ?>; font-weight: <?= empty($category_slug) ? '600' : '500' ?>; font-size: 14px; text-decoration: none; border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease;">
                            Tất cả sản phẩm
                            <?php if (empty($category_slug)): ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="float: right; margin-top: 2px;">
                                <path d="M13 4L6 11L3 8" stroke="#2eb058" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php endif; ?>
                        </a>
                        <?php foreach ($categories as $cat): ?>
                        <a href="san-pham?category=<?= htmlspecialchars($cat['slug']) ?>" 
                           class="category-dropdown-item <?= $category_slug === $cat['slug'] ? 'active' : '' ?>"
                           style="display: block; padding: 12px 16px; color: <?= $category_slug === $cat['slug'] ? '#2eb058' : '#054326' ?>; font-weight: <?= $category_slug === $cat['slug'] ? '600' : '500' ?>; font-size: 14px; text-decoration: none; border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease;">
                            <?= htmlspecialchars($cat['name']) ?>
                            <?php if ($category_slug === $cat['slug']): ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="float: right; margin-top: 2px;">
                                <path d="M13 4L6 11L3 8" stroke="#2eb058" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .category-filter-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 176, 88, 0.2);
            border-color: #2eb058 !important;
        }
        .category-filter-item.active {
            box-shadow: 0 4px 16px rgba(46, 176, 88, 0.3);
        }
        
        .category-dropdown-item:hover {
            background: #f8f9fa;
        }
        .category-dropdown-item:last-child {
            border-bottom: none;
        }
        
        .category-dropdown-toggle:hover {
            border-color: #2eb058;
            box-shadow: 0 2px 8px rgba(46, 176, 88, 0.1);
        }
        
        .category-dropdown-toggle.active .dropdown-icon {
            transform: rotate(180deg);
        }
        
        @media (max-width: 768px) {
            .category-filter-section {
                padding: 20px 0 !important;
            }
            .category-filter-desktop {
                display: none !important;
            }
            .category-filter-mobile {
                display: block !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile dropdown toggle
            const dropdownToggle = document.querySelector('.category-dropdown-toggle');
            const dropdownMenu = document.querySelector('.category-dropdown-menu');
            const dropdownIcon = document.querySelector('.dropdown-icon');
            
            if (dropdownToggle && dropdownMenu) {
                // Toggle dropdown
                dropdownToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = dropdownMenu.style.display === 'block';
                    
                    if (isOpen) {
                        dropdownMenu.style.display = 'none';
                        dropdownToggle.classList.remove('active');
                    } else {
                        dropdownMenu.style.display = 'block';
                        dropdownToggle.classList.add('active');
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.style.display = 'none';
                        dropdownToggle.classList.remove('active');
                    }
                });
            }
        });
    </script>

    <!-- Products Grid Section -->
    <section class="products-grid-section" style="padding: 60px 0; background: #fff;">
        <div class="container">
            <?php if (empty($products)): ?>
            <div style="text-align: center; padding: 60px 20px;">
                <img src="05_images/no-products.svg" alt="Không có sản phẩm" style="max-width: 200px; margin-bottom: 20px; opacity: 0.6;" onerror="this.style.display='none'"/>
                <h3 style="color: #666; font-size: 20px; margin-bottom: 10px;">Không có sản phẩm nào</h3>
                <p style="color: #999;">Vui lòng chọn danh mục khác hoặc quay lại sau.</p>
                <a href="san-pham" class="btn btn--primary" style="margin-top: 20px; display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%); color: #fff; text-decoration: none; border-radius: 25px;">
                    Xem tất cả sản phẩm
                </a>
            </div>
            <?php else: ?>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php foreach ($products as $product): 
                    $image_url = $product['image_path'] 
                        ? '../uploads/products/' . $product['image_path']
                        : '05_images/no-image.jpg';
                    
                    // Clean description: remove HTML tags properly
                    $clean_desc = strip_tags($product['description'] ?? '');
                    // Remove any remaining HTML entities
                    $clean_desc = html_entity_decode($clean_desc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $short_desc = mb_substr($clean_desc, 0, 80, 'UTF-8');
                    if (mb_strlen($clean_desc) > 80) {
                        $short_desc .= '...';
                    }
                ?>
                <div class="product-card" style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                    <a href="chi-tiet-san-pham?slug=<?= htmlspecialchars($product['slug']) ?>" style="text-decoration: none; color: inherit; display: block;">
                        <div class="product-card-image" style="position: relative; aspect-ratio: 4/3; overflow: hidden; background: #f5f5f5;">
                            <img src="<?= htmlspecialchars($image_url) ?>" 
                                 alt="<?= htmlspecialchars($product['title']) ?>"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                 loading="lazy"/>
                        </div>
                        <div class="product-card-content" style="padding: 20px;">
                            <h3 class="product-card-title" style="font-size: 18px; font-weight: 700; color: #054326; margin-bottom: 10px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 50px;">
                                <?= htmlspecialchars($product['title']) ?>
                            </h3>
                            <?php if ($product['category_name']): ?>
                            <div class="product-category-badge" style="display: inline-block; margin-bottom: 10px; padding: 4px 12px; background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%); color: #fff; border-radius: 15px; font-size: 11px; font-weight: 600; width: fit-content; max-width: 100%;">
                                <?= htmlspecialchars($product['category_name']) ?>
                            </div>
                            <?php endif; ?>
                            <?php if ($short_desc): ?>
                            <p class="product-card-desc" style="font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 63px;">
                                <?= htmlspecialchars($short_desc) ?>
                            </p>
                            <?php endif; ?>
                            <?php if ($product['price'] > 0): ?>
                            <div class="product-card-price" style="margin-bottom: 16px;">
                                <?php if ($product['promo_price'] > 0 && $product['promo_price'] < $product['price']): ?>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 22px; font-weight: 700; color: #2eb058;">
                                        <?= number_format($product['promo_price'], 0, ',', '.') ?>đ
                                    </span>
                                    <span style="font-size: 15px; color: #999; text-decoration: line-through;">
                                        <?= number_format($product['price'], 0, ',', '.') ?>đ
                                    </span>
                                </div>
                                <?php else: ?>
                                <span style="font-size: 22px; font-weight: 700; color: #2eb058;">
                                    <?= number_format($product['price'], 0, ',', '.') ?>đ
                                </span>
                                <?php endif; ?>
                            </div>
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

            <style>
                .product-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
                }
                .product-card:hover .product-card-image img {
                    transform: scale(1.1);
                }
                
                @media (max-width: 768px) {
                    .products-grid {
                        grid-template-columns: 1fr !important;
                        gap: 16px !important;
                    }
                    .product-card {
                        display: flex !important;
                        flex-direction: row !important;
                        align-items: stretch;
                    }
                    .product-card a {
                        display: flex !important;
                        width: 100%;
                    }
                    .product-card-image {
                        flex: 0 0 120px !important;
                        aspect-ratio: 1/1 !important;
                        min-height: 120px;
                    }
                    .product-card-content {
                        flex: 1;
                        padding: 12px !important;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }
                    .product-card-title {
                        font-size: 15px !important;
                        min-height: auto !important;
                        -webkit-line-clamp: 2 !important;
                        margin-bottom: 6px !important;
                    }
                    .product-card-desc {
                        font-size: 12px !important;
                        min-height: auto !important;
                        -webkit-line-clamp: 2 !important;
                        margin-bottom: 8px !important;
                        line-height: 1.4 !important;
                    }
                    .product-card-price {
                        margin-bottom: 8px !important;
                    }
                    .product-card-price span:first-child {
                        font-size: 16px !important;
                    }
                    .product-card-price span:last-child {
                        font-size: 12px !important;
                    }
                    .product-card-action {
                        padding-top: 8px !important;
                    }
                    .product-card-action span {
                        font-size: 13px !important;
                    }
                    .product-category-badge {
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
                    .products-grid {
                        grid-template-columns: repeat(2, 1fr) !important;
                    }
                }
            </style>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <nav class="pagination-nav" style="margin-top: 40px;">
                <div class="dt-pagination" style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <?php if ($page > 1): ?>
                    <a class="prev page-numbers" href="?page=<?= $page - 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 1px solid #e0e0e0; color: #054326; text-decoration: none; transition: all 0.3s ease;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12 16L6 10L12 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == 1 || $i == $total_pages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                            <?php if ($i == $page): ?>
                                <span class="page-numbers current" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 20px; background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%); color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(46,176,88,0.3);">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a class="page-numbers" href="?page=<?= $i ?><?= $category_slug ? '&category=' . $category_slug : '' ?>" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 20px; background: #fff; border: 1px solid #e0e0e0; color: #054326; text-decoration: none; transition: all 0.3s ease; font-weight: 500;">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                            <span class="page-numbers dots" style="color: #999;">…</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <a class="next page-numbers" href="?page=<?= $page + 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 1px solid #e0e0e0; color: #054326; text-decoration: none; transition: all 0.3s ease;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M8 16L14 10L8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </nav>

            <style>
                .page-numbers:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    border-color: #2eb058 !important;
                }
                .prev.page-numbers:hover,
                .next.page-numbers:hover {
                    background: #2eb058 !important;
                    color: #fff !important;
                    border-color: #2eb058 !important;
                }
            </style>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

  </main>

    <!-- footer -->
    <?php include '01_includes/footer.php'; ?>
    <script id="trangchu-js" src="03_js/trangchu.js" type="text/javascript"></script>

   <div class="loading">
    <div class="overlay">
    </div>
    <div class="loader">
    </div>
   </div>
  </link>
 </body>

</html>
