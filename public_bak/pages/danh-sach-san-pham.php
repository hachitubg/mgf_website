<?php 
include __DIR__ . '/header.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

// Lấy banners cho danh sách sản phẩm
$banners = getBanners($pdo, 'danh_sach_san_pham');

// Lấy category từ URL (nếu có)
$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';

// Lấy tất cả danh mục sản phẩm
$categories = getCategories($pdo, 'product', true);

// Lấy sản phẩm theo category (nếu có chọn)
if (!empty($selectedCategory)) {
    $products = getProducts($pdo, [
        'category_slug' => $selectedCategory,
        'limit' => 100,
        'with_images' => true,
        'with_category' => true
    ]);
} else {
    // Lấy tất cả sản phẩm, nhóm theo category
    $products = getProducts($pdo, [
        'limit' => 100,
        'with_images' => true,
        'with_category' => true
    ]);
}

// Nhóm sản phẩm theo category_id
$productsByCategory = [];
foreach ($products as $product) {
    $catId = $product['category_id'] ?? 0;
    if (!isset($productsByCategory[$catId])) {
        $productsByCategory[$catId] = [
            'name' => $product['category_name'] ?? 'Chưa phân loại',
            'slug' => $product['category_slug'] ?? '',
            'products' => []
        ];
    }
    $productsByCategory[$catId]['products'][] = $product;
}
?>

<main class="site-main clr" id="main" role="main">
     <div class="elementor elementor-22" data-elementor-id="22" data-elementor-type="wp-page">
      <?php if (!empty($banners)): ?>
      <section class="elementor-section elementor-top-section elementor-element elementor-element-fd29468 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="fd29468">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-53a6830" data-element_type="column" data-id="53a6830">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-4575d4f elementor-pagination-position-inside elementor-skin-carousel elementor-pagination-type-bullets elementor-widget elementor-widget-media-carousel" data-element_type="widget" data-id="4575d4f" data-settings='{"slides_per_view":"1","slides_per_view_tablet":"1","slides_to_scroll":"1","slides_to_scroll_tablet":"1","skin":"carousel","effect":"slide","pagination":"bullets","speed":500,"autoplay":"yes","autoplay_speed":5000,"loop":"yes","pause_on_hover":"yes","pause_on_interaction":"yes","space_between":{"unit":"px","size":10,"sizes":[]},"space_between_tablet":{"unit":"px","size":10,"sizes":[]},"space_between_mobile":{"unit":"px","size":10,"sizes":[]}}' data-widget_type="media-carousel.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-carousel.min.css" rel="stylesheet"/>
            <div class="elementor-swiper">
             <div class="elementor-main-swiper swiper-container">
              <div class="swiper-wrapper">
               <?php foreach ($banners as $banner): 
                  $imagePath = '/' . htmlspecialchars($banner['image_path']);
                  $title = htmlspecialchars($banner['title'] ?? 'Banner');
                  $linkUrl = $banner['link_url'] ?? '';
               ?>
               <div class="swiper-slide">
                <?php if (!empty($linkUrl)): ?>
                <a href="<?= htmlspecialchars($linkUrl) ?>">
                 <div aria-label="<?= $title ?>" class="elementor-carousel-image" role="img" style="background-image: url(<?= $imagePath ?>)">
                 </div>
                </a>
                <?php else: ?>
                <div aria-label="<?= $title ?>" class="elementor-carousel-image" role="img" style="background-image: url(<?= $imagePath ?>)">
                </div>
                <?php endif; ?>
               </div>
               <?php endforeach; ?>
              </div>
              <div class="swiper-pagination">
              </div>
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </section>
      <?php endif; ?>
      <section class="elementor-section elementor-top-section elementor-element elementor-element-fe341e7 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="fe341e7">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d987411" data-element_type="column" data-id="d987411">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-0b0feed elementor-widget elementor-widget-shortcode" data-element_type="widget" data-id="0b0feed" data-widget_type="shortcode.default">
           <div class="elementor-widget-container">
            <div class="elementor-shortcode">
             <span class="oceanwp-breadcrumb">
              <nav aria-label="Breadcrumbs" class="site-breadcrumbs clr position-" itemprop="breadcrumb">
               <ol class="trail-items" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <meta content="2" name="numberOfItems">
                 <meta content="Ascending" name="itemListOrder">
                  <li class="trail-item trail-begin" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                   <a aria-label="Trang chủ" href="trang-chu" itemprop="item" itemtype="https://schema.org/Thing" rel="home">
                    <span itemprop="name">
                     <span class="breadcrumb-home-a">
                      Trang chủ
                     </span>
                    </span>
                   </a>
                   <span class="breadcrumb-sep-a">
                    /
                   </span>
                   <meta content="1" itemprop="position"/>
                  </li>
                  <li class="trail-item trail-end" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                   <a href="danh-sach-san-pham?" itemprop="item" itemtype="https://schema.org/Thing">
                    <span itemprop="name">
                     Sản phẩm 
                    </span>
                   </a>
                   <meta content="2" itemprop="position"/>
                  </li>
                 </meta>
                </meta>
               </ol>
              </nav>
             </span>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </section>
      <section class="elementor-section elementor-top-section elementor-element elementor-element-82c8755 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="82c8755">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-62c8aa7" data-element_type="column" data-id="62c8aa7">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-ff70623 elementor-widget elementor-widget-heading" data-element_type="widget" data-id="ff70623" data-widget_type="heading.default">
           <div class="elementor-widget-container">
            <h1 class="elementor-heading-title elementor-size-default">
             Danh mục sản phẩm
            </h1>
           </div>
          </div>
          <div class="elementor-element elementor-element-0e8ec52 elementor-nav-menu--dropdown-none menu-product-cat elementor-widget elementor-widget-nav-menu" data-element_type="widget" data-id="0e8ec52" data-settings='{"layout":"vertical","submenu_icon":{"value":"&lt;i class=\"fas fa-caret-down\"&gt;&lt;/i&gt;","library":"fa-solid"}}' data-widget_type="nav-menu.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-nav-menu.min.css" rel="stylesheet"/>
            <nav class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-vertical e--pointer-none">
             <ul class="elementor-nav-menu sm-vertical" id="menu-1-0e8ec52">
              <li class="menu-item <?= empty($selectedCategory) ? 'current-menu-item elementor-item-active' : '' ?>">
               <a aria-current="page" class="elementor-item <?= empty($selectedCategory) ? 'elementor-item-active' : '' ?>" href="danh-sach-san-pham?">
                TẤT CẢ
               </a>
              </li>
              <?php foreach ($categories as $cat): ?>
              <li class="menu-item <?= $selectedCategory === $cat['slug'] ? 'current-menu-item' : '' ?>">
               <a class="elementor-item <?= $selectedCategory === $cat['slug'] ? 'elementor-item-active' : '' ?>" href="danh-sach-san-pham??category=<?= urlencode($cat['slug']) ?>">
                <?= htmlspecialchars($cat['name']) ?>
               </a>
              </li>
              <?php endforeach; ?>
             </ul>
            </nav>
            <nav aria-hidden="true" class="elementor-nav-menu--dropdown elementor-nav-menu__container">
             <ul class="elementor-nav-menu sm-vertical" id="menu-2-0e8ec52">
              <li class="menu-item <?= empty($selectedCategory) ? 'current-menu-item elementor-item-active' : '' ?>">
               <a aria-current="page" class="elementor-item <?= empty($selectedCategory) ? 'elementor-item-active' : '' ?>" href="danh-sach-san-pham?" tabindex="-1">
                TẤT CẢ
               </a>
              </li>
              <?php foreach ($categories as $cat): ?>
              <li class="menu-item <?= $selectedCategory === $cat['slug'] ? 'current-menu-item' : '' ?>">
               <a class="elementor-item <?= $selectedCategory === $cat['slug'] ? 'elementor-item-active' : '' ?>" href="danh-sach-san-pham??category=<?= urlencode($cat['slug']) ?>" tabindex="-1">
                <?= htmlspecialchars($cat['name']) ?>
               </a>
              </li>
              <?php endforeach; ?>
             </ul>
            </nav>
           </div>
          </div>
         </div>
        </div>
        <div class="elementor-column elementor-col-66 elementor-top-column elementor-element elementor-element-9b99f0d" data-element_type="column" data-id="9b99f0d">
         <div class="elementor-widget-wrap elementor-element-populated">
          
          <?php if (!empty($selectedCategory)): 
            // Hiển thị sản phẩm của category được chọn
            $currentCategory = null;
            foreach ($categories as $cat) {
              if ($cat['slug'] === $selectedCategory) {
                $currentCategory = $cat;
                break;
              }
            }
            
            if ($currentCategory && !empty($products)):
          ?>
          
          <!-- Hiển thị category đã chọn -->
          <div class="elementor-element elementor-element-f3b42e0 elementor-widget elementor-widget-el_heading_url" data-element_type="widget" data-id="f3b42e0" data-widget_type="el_heading_url.default">
           <div class="elementor-widget-container">
            <h2 class="elementor-heading-title w-heading-url elementor-size-default">
             <?= strtoupper(htmlspecialchars($currentCategory['name'])) ?>
            </h2>
           </div>
          </div>
          <div class="elementor-element elementor-grid-5 elementor-grid-tablet-3 elementor-grid-mobile-2 elementor-products-grid elementor-wc-products elementor-widget elementor-widget-woocommerce-products" data-element_type="widget" data-widget_type="woocommerce-products.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-woocommerce.min.css" rel="stylesheet"/>
            <div class="woocommerce columns-5">
             <ul class="products elementor-grid oceanwp-row clr grid">
              <?php foreach ($products as $product): 
                $imageUrl = !empty($product['first_image']) ? getProductImageUrl($product['first_image']) : '/uploads/no-image.png';
                $productUrl = 'chi-tiet-san-pham.php?slug=' . urlencode($product['slug']);
                $allImages = !empty($product['images']) ? $product['images'] : [];
                $isOnSale = hasDiscount($product); // Kiểm tra có giảm giá không
              ?>
              <li class="entry has-media col span_1_of_5 owp-content-center owp-thumbs-layout-horizontal owp-btn-normal owp-tabs-layout-horizontal product type-product">
               <div class="product-inner clr">
                <div class="woo-entry-image-swap woo-entry-image clr" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                 <a class="woocommerce-LoopProduct-link" href="<?= $productUrl ?>">
                  <?php if (!empty($allImages)): ?>
                  <div class="product-images" data-image-count="<?= count($allImages) ?>" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                   <?php foreach ($allImages as $index => $img): ?>
                   <div class="product-image-item <?= $index === 0 ? 'active' : '' ?>">
                    <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= getProductImageUrl($img['image_path']) ?>" width="300"/>
                   </div>
                   <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                  <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= $imageUrl ?>" width="300"/>
                  <?php endif; ?>
                 </a>
                </div>
                <ul class="woo-entry-inner clr">
                 <li class="image-wrap">
                  <div class="woo-entry-image-swap woo-entry-image clr" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                   <a class="woocommerce-LoopProduct-link" href="<?= $productUrl ?>">
                    <?php if (!empty($allImages)): ?>
                    <div class="product-images" data-image-count="<?= count($allImages) ?>" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                     <?php foreach ($allImages as $index => $img): ?>
                     <div class="product-image-item <?= $index === 0 ? 'active' : '' ?>">
                      <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= getProductImageUrl($img['image_path']) ?>" width="300"/>
                     </div>
                     <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= $imageUrl ?>" width="300"/>
                    <?php endif; ?>
                   </a>
                  </div>
                 </li>
                 <li class="title">
                  <h2>
                   <a href="<?= $productUrl ?>">
                    <?= htmlspecialchars($product['title']) ?>
                   </a>
                  </h2>
                 </li>
                </ul>
               </div>
              </li>
              <?php endforeach; ?>
             </ul>
            </div>
           </div>
          </div>
          
          <?php elseif ($currentCategory): ?>
          <div class="elementor-element elementor-widget">
           <div class="elementor-widget-container">
            <p style="text-align:center;padding:40px 0;color:#666;">Chưa có sản phẩm trong danh mục này.</p>
           </div>
          </div>
          <?php endif; ?>
          
          <?php else: 
            // Hiển thị tất cả sản phẩm nhóm theo category
            foreach ($productsByCategory as $catId => $categoryData): 
              if (empty($categoryData['products'])) continue;
              
              // Chỉ hiển thị 5 sản phẩm đầu tiên của mỗi category
              $displayProducts = array_slice($categoryData['products'], 0, 5);
          ?>
          
          <div class="elementor-element elementor-widget elementor-widget-el_heading_url" data-element_type="widget" data-widget_type="el_heading_url.default">
           <div class="elementor-widget-container">
            <h2 class="elementor-heading-title w-heading-url elementor-size-default">
             <?= strtoupper(htmlspecialchars($categoryData['name'])) ?>
             <span class="w-separator">
             </span>
             <?php if (!empty($categoryData['slug'])): ?>
             <a href="danh-sach-san-pham??category=<?= urlencode($categoryData['slug']) ?>">
              <span class="w-title-readmore">
               Xem thêm
               <i class="eicon-angle-right">
               </i>
              </span>
             </a>
             <?php endif; ?>
            </h2>
           </div>
          </div>
          <div class="elementor-element elementor-grid-5 elementor-grid-tablet-3 elementor-grid-mobile-2 elementor-products-grid elementor-wc-products elementor-widget elementor-widget-woocommerce-products" data-element_type="widget" data-widget_type="woocommerce-products.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-woocommerce.min.css" rel="stylesheet"/>
            <div class="woocommerce columns-5">
             <ul class="products elementor-grid oceanwp-row clr grid">
              <?php foreach ($displayProducts as $product): 
                $imageUrl = !empty($product['first_image']) ? getProductImageUrl($product['first_image']) : '/uploads/no-image.png';
                $productUrl = 'chi-tiet-san-pham.php?slug=' . urlencode($product['slug']);
                $allImages = !empty($product['images']) ? $product['images'] : [];
                $isOnSale = hasDiscount($product); // Kiểm tra có giảm giá không
              ?>
              <li class="entry has-media col span_1_of_5 owp-content-center owp-thumbs-layout-horizontal owp-btn-normal owp-tabs-layout-horizontal product type-product">
               <div class="product-inner clr">
                <div class="woo-entry-image-swap woo-entry-image clr" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                 <a class="woocommerce-LoopProduct-link" href="<?= $productUrl ?>">
                  <?php if (!empty($allImages)): ?>
                  <div class="product-images" data-image-count="<?= count($allImages) ?>" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                   <?php foreach ($allImages as $index => $img): ?>
                   <div class="product-image-item <?= $index === 0 ? 'active' : '' ?>">
                    <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= getProductImageUrl($img['image_path']) ?>" width="300"/>
                   </div>
                   <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                  <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= $imageUrl ?>" width="300"/>
                  <?php endif; ?>
                 </a>
                </div>
                <ul class="woo-entry-inner clr">
                 <li class="image-wrap">
                  <div class="woo-entry-image-swap woo-entry-image clr" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                   <a class="woocommerce-LoopProduct-link" href="<?= $productUrl ?>">
                    <?php if (!empty($allImages)): ?>
                    <div class="product-images" data-image-count="<?= count($allImages) ?>" <?= $isOnSale ? 'data-sale="true"' : '' ?>>
                     <?php foreach ($allImages as $index => $img): ?>
                     <div class="product-image-item <?= $index === 0 ? 'active' : '' ?>">
                      <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= getProductImageUrl($img['image_path']) ?>" width="300"/>
                     </div>
                     <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <img alt="<?= htmlspecialchars($product['title']) ?>" class="woo-entry-image-main" decoding="async" height="300" itemprop="image" src="<?= $imageUrl ?>" width="300"/>
                    <?php endif; ?>
                   </a>
                  </div>
                 </li>
                 <li class="title">
                  <h2>
                   <a href="<?= $productUrl ?>">
                    <?= htmlspecialchars($product['title']) ?>
                   </a>
                  </h2>
                 </li>
                </ul>
               </div>
              </li>
              <?php endforeach; ?>
             </ul>
            </div>
           </div>
          </div>
          
          <?php endforeach; endif; ?>
         </div>
        </div>
       </div>
      </section>
     </div>
    </main>
   </div>
  </div>

<script src="js/product-image-slider.js"></script>
<?php include __DIR__ . '/footer.php'; ?>