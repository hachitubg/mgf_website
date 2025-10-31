<?php 
// Kết nối database và lấy dữ liệu
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

// Lấy tất cả danh mục tin tức
$postCategories = getCategories($pdo, 'post', true);

// Lấy category hiện tại (nếu có)
$currentCategorySlug = $_GET['category'] ?? '';
$currentCategory = null;
if ($currentCategorySlug) {
    $currentCategory = getCategoryBySlug($pdo, $currentCategorySlug);
}

// Hình ảnh mặc định khi không có featured image
$defaultImage = 'https://placehold.co/800x500/f0f0f0/999999/png?text=No+Image';

// Pagination
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 6;

// Lấy tổng số bài viết
if ($currentCategory) {
    $totalPosts = countPosts($pdo, $currentCategory['id'], true);
} else {
    $totalPosts = countPosts($pdo, null, true);
}

$pagination = getPaginationData($currentPage, $perPage, $totalPosts);

// Lấy danh sách bài viết
$postsOptions = [
    'limit' => $perPage,
    'offset' => $pagination['offset'],
    'order_by' => 'created_at',
    'order_dir' => 'DESC',
    'with_category' => true
];

if ($currentCategory) {
    $postsOptions['category_id'] = $currentCategory['id'];
}

$posts = getPosts($pdo, $postsOptions);

include __DIR__ . '/header.php'; 
?>

<main class="site-main clr" id="main" role="main">
     <div class="elementor elementor-3482 elementor-location-archive" data-elementor-id="3482" data-elementor-type="archive">
      <section class="elementor-section elementor-top-section elementor-element elementor-element-8b7852c w-cat-tab elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="8b7852c">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-42a7530" data-element_type="column" data-id="42a7530">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-b9a0a36 elementor-widget elementor-widget-shortcode" data-element_type="widget" data-id="b9a0a36" data-widget_type="shortcode.default">
           <div class="elementor-widget-container">
            <div class="elementor-shortcode">
             <span class="oceanwp-breadcrumb">
              <nav aria-label="Breadcrumbs" class="site-breadcrumbs clr position-" itemprop="breadcrumb">
               <ol class="trail-items" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <meta content="2" name="numberOfItems"/>
                <meta content="Ascending" name="itemListOrder"/>
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
                 <a href="danh-sach-tin-tuc?" itemprop="item" itemtype="https://schema.org/Thing">
                  <span itemprop="name">
                   Tin tức &amp; Sự kiện
                  </span>
                 </a>
                 <meta content="2" itemprop="position"/>
                </li>
               </ol>
              </nav>
             </span>
            </div>
           </div>
          </div>
          <div class="elementor-element elementor-element-9854bca elementor-nav-menu__align-center elementor-nav-menu--dropdown-none w-truyen-thong-nav elementor-widget elementor-widget-nav-menu" data-element_type="widget" data-id="9854bca" data-settings='{"layout":"horizontal","submenu_icon":{"value":"&lt;i class=\"fas fa-caret-down\"&gt;&lt;/i&gt;","library":"fa-solid"}}' data-widget_type="nav-menu.default">
           <div class="elementor-widget-container">
            <link href="../wp-content/plugins/elementor-pro/assets/css/widget-nav-menu.min.css" rel="stylesheet"/>
            <nav class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-none">
             <ul class="elementor-nav-menu modern-tabs" id="menu-1-9854bca">
              <!-- Tab "Tất cả" -->
              <li class="menu-item menu-item-type-taxonomy menu-item-object-category <?php echo empty($currentCategorySlug) ? 'current-menu-item' : ''; ?>">
                <a class="elementor-item <?php echo empty($currentCategorySlug) ? 'elementor-item-active' : ''; ?>" 
                   href="danh-sach-tin-tuc?"
                   <?php echo empty($currentCategorySlug) ? 'aria-current="page"' : ''; ?>>
                  <span>Tất cả</span>
                </a>
              </li>
              
              <?php if (!empty($postCategories)): ?>
                <?php foreach ($postCategories as $category): ?>
                  <?php 
                    $isActive = ($currentCategorySlug === $category['slug']) ? 'current-menu-item' : '';
                    $categoryUrl = 'danh-sach-tin-tuc.php?category=' . urlencode($category['slug']);
                  ?>
                  <li class="menu-item menu-item-type-taxonomy menu-item-object-category <?php echo $isActive; ?>">
                    <a class="elementor-item <?php echo $isActive ? 'elementor-item-active' : ''; ?>" 
                       href="<?php echo htmlspecialchars($categoryUrl); ?>"
                       <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                      <span><?php echo htmlspecialchars($category['name']); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
             </ul>
            </nav>
            <nav aria-hidden="true" class="elementor-nav-menu--dropdown elementor-nav-menu__container">
             <ul class="elementor-nav-menu" id="menu-2-9854bca">
              <?php if (!empty($postCategories)): ?>
                <?php foreach ($postCategories as $category): ?>
                  <?php 
                    $isActive = ($currentCategorySlug === $category['slug']) ? 'current-menu-item' : '';
                    $categoryUrl = 'danh-sach-tin-tuc.php?category=' . urlencode($category['slug']);
                  ?>
                  <li class="menu-item menu-item-type-taxonomy menu-item-object-category <?php echo $isActive; ?>">
                    <a class="elementor-item <?php echo $isActive ? 'elementor-item-active' : ''; ?>" 
                       href="<?php echo htmlspecialchars($categoryUrl); ?>" 
                       tabindex="-1"
                       <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                      <span><?php echo htmlspecialchars($category['name']); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
             </ul>
            </nav>
           </div>
          </div>
         </div>
        </div>
       </div>
      </section>
      <section class="elementor-section elementor-top-section elementor-element elementor-element-e452ba3 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-element_type="section" data-id="e452ba3">
       <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a2e765b" data-element_type="column" data-id="a2e765b">
         <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-a19db71 elementor-widget elementor-widget-el_activities" data-element_type="widget" data-id="a19db71" data-widget_type="el_activities.default">
           <div class="elementor-widget-container">
            <div class="wehomo-activities" id="wehomo-activities">
             <div class="wehomo-loading">
              <div class="loadingio-spinner-ripple-6uy7mubs9hx">
               <div class="ldio-vqwiuf1ka5q">
                <div>
                </div>
                <div>
                </div>
               </div>
              </div>
             </div>
             <div class="elementor-element elementor-grid-3 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-posts--thumbnail-top elementor-widget elementor-widget-posts" data-id="1" id="w-posts-by-category">
              <div class="modern-posts-grid">
               
               <?php if (!empty($posts)): ?>
                 <?php foreach ($posts as $post): ?>
                   <?php 
                     $postUrl = 'chi-tiet-tin-tuc.php?slug=' . urlencode($post['slug']);
                     $postImage = !empty($post['featured_image']) ? getPostImageUrl($post['featured_image']) : $defaultImage;
                     $postDate = formatDate($post['created_at'], 'd.m.Y');
                     $excerpt = !empty($post['excerpt']) ? $post['excerpt'] : '';
                   ?>
                   <article class="modern-post-card" data-id="<?php echo $post['id']; ?>">
                    <a href="<?php echo htmlspecialchars($postUrl); ?>" class="modern-post-link">
                      <div class="modern-post-image">
                        <img src="<?php echo $postImage; ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>"
                             loading="lazy" />
                        <div class="modern-post-overlay">
                          <span class="read-more-btn">Xem chi tiết →</span>
                        </div>
                      </div>
                      <div class="modern-post-content">
                        <?php if (!empty($post['category_name'])): ?>
                          <span class="modern-post-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                        <?php endif; ?>
                        <h3 class="modern-post-title">
                          <?php echo htmlspecialchars($post['title']); ?>
                        </h3>
                        <?php if (!empty($excerpt)): ?>
                          <p class="modern-post-excerpt">
                            <?php echo htmlspecialchars(getExcerpt($excerpt, 120)); ?>
                          </p>
                        <?php endif; ?>
                        <div class="modern-post-meta">
                          <span class="modern-post-date">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                              <path d="M5.33333 1.33334V3.33334M10.6667 1.33334V3.33334M2.66667 6.66668H13.3333M4 2.66668H12C12.7364 2.66668 13.3333 3.26363 13.3333 4.00001V12C13.3333 12.7364 12.7364 13.3333 12 13.3333H4C3.26362 13.3333 2.66667 12.7364 2.66667 12V4.00001C2.66667 3.26363 3.26362 2.66668 4 2.66668Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php echo $postDate; ?>
                          </span>
                        </div>
                      </div>
                    </a>
                   </article>
                 <?php endforeach; ?>
                 
               <?php else: ?>
                 <div class="modern-no-posts">
                   <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                     <path d="M40 73.3333C58.4095 73.3333 73.3333 58.4095 73.3333 40C73.3333 21.5905 58.4095 6.66666 40 6.66666C21.5905 6.66666 6.66666 21.5905 6.66666 40C6.66666 58.4095 21.5905 73.3333 40 73.3333Z" stroke="#E0E0E0" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M30 30L50 50M50 30L30 50" stroke="#E0E0E0" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>
                   <h3>Không có bài viết nào</h3>
                   <p>Hiện tại chưa có bài viết trong danh mục này. Vui lòng quay lại sau!</p>
                 </div>
               <?php endif; ?>
               
              </div>
              
              <?php if ($pagination['total_pages'] > 1): ?>
              <div class="modern-pagination">
                
                <?php 
                // Tính toán các trang để hiển thị
                $start = max(1, $currentPage - 2);
                $end = min($pagination['total_pages'], $currentPage + 2);
                
                // Build base URL
                $baseUrl = 'danh-sach-tin-tuc.php';
                if ($currentCategorySlug) {
                    $baseUrl .= '?category=' . urlencode($currentCategorySlug);
                }
                ?>
                
                <?php if ($pagination['has_prev']): ?>
                  <?php 
                    $prevPageUrl = $baseUrl;
                    if ($currentPage > 2) {
                      $prevPageUrl .= (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . ($currentPage - 1);
                    }
                  ?>
                  <a class="pagination-btn prev-btn" href="<?php echo htmlspecialchars($prevPageUrl); ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Trước
                  </a>
                <?php endif; ?>
                
                <div class="pagination-numbers">
                  <?php if ($start > 1): ?>
                    <?php 
                      $firstPageUrl = $baseUrl;
                    ?>
                    <a class="pagination-number" href="<?php echo htmlspecialchars($firstPageUrl); ?>">1</a>
                    <?php if ($start > 2): ?>
                      <span class="pagination-dots">...</span>
                    <?php endif; ?>
                  <?php endif; ?>
                  
                  <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php 
                      $pageUrl = $baseUrl;
                      if ($i > 1) {
                        $pageUrl .= (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . $i;
                      }
                    ?>
                    
                    <?php if ($i === $currentPage): ?>
                      <span class="pagination-number active"><?php echo $i; ?></span>
                    <?php else: ?>
                      <a class="pagination-number" href="<?php echo htmlspecialchars($pageUrl); ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                  <?php endfor; ?>
                  
                  <?php if ($end < $pagination['total_pages']): ?>
                    <?php if ($end < $pagination['total_pages'] - 1): ?>
                      <span class="pagination-dots">...</span>
                    <?php endif; ?>
                    <?php 
                      $lastPageUrl = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . $pagination['total_pages'];
                    ?>
                    <a class="pagination-number" href="<?php echo htmlspecialchars($lastPageUrl); ?>"><?php echo $pagination['total_pages']; ?></a>
                  <?php endif; ?>
                </div>
                
                <?php if ($pagination['has_next']): ?>
                  <?php 
                    $nextPageUrl = $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . 'page=' . ($currentPage + 1);
                  ?>
                  <a class="pagination-btn next-btn" href="<?php echo htmlspecialchars($nextPageUrl); ?>">
                    Sau
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </a>
                <?php endif; ?>
                
              </div>
              <?php endif; ?>
              
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </section>
     </div>
    </main>

<?php include __DIR__ . '/footer.php'; ?>