<?php 
include __DIR__ . '/header.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

// Lấy slug từ URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: danh-sach-san-pham.php');
    exit;
}

// Lấy thông tin sản phẩm theo slug
$products = getProducts($pdo, [
    'slug' => $slug,
    'with_images' => true,
    'with_category' => true,
    'limit' => 1
]);

if (empty($products)) {
    header('Location: danh-sach-san-pham.php');
    exit;
}

$product = $products[0];
$productImages = !empty($product['images']) ? $product['images'] : [];
$firstImage = !empty($product['first_image']) ? getProductImageUrl($product['first_image']) : '/mgf-website/uploads/no-image.png';
$categoryName = $product['category_name'] ?? 'Chưa phân loại';
$categorySlug = $product['category_slug'] ?? '';

// Lấy sản phẩm cùng danh mục (không bao gồm sản phẩm hiện tại)
$relatedProducts = [];
if (!empty($product['category_id'])) {
    $allCategoryProducts = getProducts($pdo, [
        'category_id' => $product['category_id'],
        'with_images' => true,
        'limit' => 9
    ]);
    
    // Loại bỏ sản phẩm hiện tại
    foreach ($allCategoryProducts as $p) {
        if ($p['id'] !== $product['id']) {
            $relatedProducts[] = $p;
        }
    }
    $relatedProducts = array_slice($relatedProducts, 0, 8); // Giới hạn 8 sản phẩm
}

// Lấy sản phẩm khác (từ các category khác)
$otherProducts = getProducts($pdo, [
    'exclude_category_id' => $product['category_id'] ?? null,
    'with_images' => true,
    'limit' => 8
]);
?>

<link rel="stylesheet" href="css/chi-tiet-san-pham.css">

<main class="site-main clr" id="main" role="main">
     <div class="woocommerce-notices-wrapper">
     </div>
     <div class="elementor elementor-2330 elementor-location-single product" data-elementor-id="2330" data-elementor-type="product">
      
      <!-- Breadcrumb Section -->
      <section class="elementor-section elementor-top-section elementor-element elementor-element-75e47b3 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="75e47b3">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-dc8ab64" data-element_type="column" data-id="dc8ab64">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-064d5cb elementor-widget elementor-widget-shortcode" data-element_type="widget" data-id="064d5cb" data-widget_type="shortcode.default">
           <div class="elementor-widget-container">
            <div class="elementor-shortcode">
             <div class="w-custom-breadcrum">
              <a href="trang-chu.php">Trang chủ</a>
              /
              <a href="danh-sach-san-pham.php">Sản phẩm và phân phối</a>
              /
              <?php if (!empty($categorySlug)): ?>
              <a href="danh-sach-san-pham.php?category=<?= urlencode($categorySlug) ?>">
               <?= htmlspecialchars($categoryName) ?>
              </a>
              /
              <?php endif; ?>
              <span class="w-custom-breadcrum-title">
               <?= htmlspecialchars($product['title']) ?>
              </span>
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </section>
      
      <!-- Product Detail Section -->
      <section class="elementor-section elementor-top-section elementor-element elementor-element-e2ba1f6 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="e2ba1f6">
       <div class="elementor-container elementor-column-gap-no">
        
        <!-- Product Images Column -->
        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7737a89" data-element_type="column" data-id="7737a89">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-887c739 yes elementor-widget elementor-widget-woocommerce-product-images" data-element_type="widget" data-id="887c739" data-widget_type="woocommerce-product-images.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-woocommerce.min.css" rel="stylesheet"/>
            <link href="css/chi-tiet-san-pham.css" rel="stylesheet"/>
            
            <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
             <div class="woocommerce-product-gallery__wrapper">
              
              <?php if (!empty($productImages)): ?>
              
              <!-- Main Image Display -->
              <div class="woocommerce-product-gallery__image-main">
               <?php 
                 $firstImg = $productImages[0];
                 $firstImgUrl = getProductImageUrl($firstImg['image_path']);
               ?>
               <a href="<?= $firstImgUrl ?>">
                <img alt="<?= htmlspecialchars($product['title']) ?>" class="wp-post-image" decoding="async" src="<?= $firstImgUrl ?>" title="<?= htmlspecialchars($product['title']) ?>"/>
               </a>
              </div>
              
              <!-- Thumbnails Gallery -->
              <div class="woocommerce-product-gallery__thumbnails">
               <?php foreach ($productImages as $index => $img): 
                 $imgUrl = getProductImageUrl($img['image_path']);
               ?>
               <div class="woocommerce-product-gallery__thumbnail <?= $index === 0 ? 'active' : '' ?>" 
                    data-image="<?= $imgUrl ?>" 
                    data-alt="<?= htmlspecialchars($product['title']) ?>">
                <img alt="<?= htmlspecialchars($product['title']) ?>" decoding="async" src="<?= $imgUrl ?>"/>
               </div>
               <?php endforeach; ?>
              </div>
              
              <?php else: ?>
              
              <!-- Single Image -->
              <div class="woocommerce-product-gallery__image-main">
               <a href="<?= $firstImage ?>">
                <img alt="<?= htmlspecialchars($product['title']) ?>" class="wp-post-image" decoding="async" src="<?= $firstImage ?>" title="<?= htmlspecialchars($product['title']) ?>"/>
               </a>
              </div>
              
              <?php endif; ?>
              
             </div>
            </div>
            
            <script src="js/product-detail-gallery.js"></script>
           </div>
          </div>
         </div>
        </div>
        
        <!-- Product Info Column -->
        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-9557877 w-column-product-content" data-element_type="column" data-id="9557877">
         <div class="elementor-widget-wrap elementor-element-populated">
          
          <!-- Product Title -->
          <div class="elementor-element elementor-element-02633e1 elementor-widget elementor-widget-woocommerce-product-title elementor-page-title elementor-widget-heading" data-element_type="widget" data-id="02633e1" data-widget_type="woocommerce-product-title.default">
           <div class="elementor-widget-container">
            <h1 class="product_title entry-title elementor-heading-title elementor-size-default">
             <?= htmlspecialchars($product['title']) ?>
            </h1>
           </div>
          </div>
          
          <!-- Category -->
          <div class="elementor-element elementor-element-1c42acf elementor-widget elementor-widget-heading" data-element_type="widget" data-id="1c42acf" data-widget_type="heading.default">
           <div class="elementor-widget-container">
            <span class="elementor-heading-title elementor-size-default">
             Dòng sản phẩm:
             <?php if (!empty($categorySlug)): ?>
             <a href="danh-sach-san-pham.php?category=<?= urlencode($categorySlug) ?>" rel="tag">
              <?= htmlspecialchars($categoryName) ?>
             </a>
             <?php else: ?>
              <?= htmlspecialchars($categoryName) ?>
             <?php endif; ?>
            </span>
           </div>
          </div>
          
          <!-- Price -->
          <?php if (!empty($product['price']) && $product['price'] > 0): ?>
          <div class="elementor-element elementor-widget elementor-widget-heading" data-element_type="widget" data-widget_type="heading.default">
           <div class="elementor-widget-container">
            <div class="product-price">
             <?php if (!empty($product['promo_price']) && $product['promo_price'] > 0): ?>
              <span class="promo-price"><?= number_format($product['promo_price'], 0, ',', '.') ?>₫</span>
              <span class="regular-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
             <?php else: ?>
              <span class="current-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
             <?php endif; ?>
            </div>
           </div>
          </div>
          <?php endif; ?>
          
          <!-- Add to Cart (placeholder) -->
          <div class="elementor-element elementor-element-69bd243 elementor-widget" data-element_type="widget" data-id="69bd243">
           <div class="elementor-widget-container">
            <!-- Form đặt hàng có thể thêm sau nếu cần -->
           </div>
          </div>
          
          <!-- Description Title -->
          <div class="elementor-element elementor-element-96caf90 elementor-widget elementor-widget-heading" data-element_type="widget" data-id="96caf90" data-widget_type="heading.default">
           <div class="elementor-widget-container">
            <span class="elementor-heading-title elementor-size-default">
             Mô tả
            </span>
           </div>
          </div>
          
          <!-- Product Description -->
          <div class="elementor-element elementor-element-9efc36b w-product-description elementor-widget elementor-widget-woocommerce-product-content" data-element_type="widget" data-id="9efc36b" data-widget_type="woocommerce-product-content.default">
           <div class="elementor-widget-container">
            <?php if (!empty($product['description'])): ?>
             <?= $product['description'] ?>
            <?php else: ?>
             <p>Chưa có mô tả sản phẩm.</p>
            <?php endif; ?>
           </div>
          </div>
          
         </div>
        </div>
       </div>
      </section>
      
      <!-- Related Products Section -->
      <?php if (!empty($relatedProducts)): ?>
      <section class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default product-grid-section" data-element_type="section">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element" data-element_type="column">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-widget elementor-widget-shortcode" data-element_type="widget" data-widget_type="shortcode.default">
           <div class="elementor-widget-container">
            <div class="elementor-shortcode">
             <div class="mgf-product-grid-wrapper">
              <h2 class="mgf-product-grid-title">Sản phẩm cùng danh mục</h2>
              <div class="mgf-product-grid">
               <?php foreach ($relatedProducts as $rp): 
                 $rpImg = !empty($rp['first_image']) ? getProductImageUrl($rp['first_image']) : '/mgf-website/uploads/no-image.png';
                 $rpUrl = 'chi-tiet-san-pham.php?slug=' . urlencode($rp['slug']);
                 $rpAllImages = !empty($rp['images']) ? $rp['images'] : [];
                 $rpIsOnSale = hasDiscount($rp);
               ?>
               <div class="mgf-product-card">
                <a href="<?= $rpUrl ?>" target="_blank">
                 <div class="mgf-img-box">
                  <?php if (!empty($rpAllImages)): ?>
                  <div class="mgf-img-slider" data-image-count="<?= count($rpAllImages) ?>" <?= $rpIsOnSale ? 'data-sale="true"' : '' ?>>
                   <?php foreach ($rpAllImages as $index => $img): ?>
                   <div class="mgf-img-slide <?= $index === 0 ? 'active' : '' ?>">
                    <img alt="<?= htmlspecialchars($rp['title']) ?>" src="<?= getProductImageUrl($img['image_path']) ?>" />
                   </div>
                   <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                  <img class="mgf-img-single" alt="<?= htmlspecialchars($rp['title']) ?>" src="<?= $rpImg ?>" />
                  <?php endif; ?>
                 </div>
                 <h3 class="mgf-product-title"><?= htmlspecialchars($rp['title']) ?></h3>
                </a>
               </div>
               <?php endforeach; ?>
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
      
      <!-- Other Products Section -->
      <?php if (!empty($otherProducts)): ?>
      <section class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default product-grid-section" data-element_type="section">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element" data-element_type="column">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-widget elementor-widget-shortcode" data-element_type="widget" data-widget_type="shortcode.default">
           <div class="elementor-widget-container">
            <div class="elementor-shortcode">
             <div class="mgf-product-grid-wrapper">
              <h2 class="mgf-product-grid-title">Sản phẩm khác</h2>
              <div class="mgf-product-grid">
               <?php foreach ($otherProducts as $op): 
                 $opImg = !empty($op['first_image']) ? getProductImageUrl($op['first_image']) : '/mgf-website/uploads/no-image.png';
                 $opUrl = 'chi-tiet-san-pham.php?slug=' . urlencode($op['slug']);
                 $opAllImages = !empty($op['images']) ? $op['images'] : [];
                 $opIsOnSale = hasDiscount($op);
               ?>
               <div class="mgf-product-card">
                <a href="<?= $opUrl ?>" target="_blank">
                 <div class="mgf-img-box">
                  <?php if (!empty($opAllImages)): ?>
                  <div class="mgf-img-slider" data-image-count="<?= count($opAllImages) ?>" <?= $opIsOnSale ? 'data-sale="true"' : '' ?>>
                   <?php foreach ($opAllImages as $index => $img): ?>
                   <div class="mgf-img-slide <?= $index === 0 ? 'active' : '' ?>">
                    <img alt="<?= htmlspecialchars($op['title']) ?>" src="<?= getProductImageUrl($img['image_path']) ?>" />
                   </div>
                   <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                  <img class="mgf-img-single" alt="<?= htmlspecialchars($op['title']) ?>" src="<?= $opImg ?>" />
                  <?php endif; ?>
                 </div>
                 <h3 class="mgf-product-title"><?= htmlspecialchars($op['title']) ?></h3>
                </a>
               </div>
               <?php endforeach; ?>
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
      
     </div>
    </main>

<script src="js/product-image-slider.js"></script>
<script src="js/product-slider.js"></script>
<?php include __DIR__ . '/footer.php'; ?>
