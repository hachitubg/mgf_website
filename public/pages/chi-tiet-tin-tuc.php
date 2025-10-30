<?php 
// Kết nối database và lấy dữ liệu
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

// Lấy slug từ URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: danh-sach-tin-tuc.php');
    exit;
}

// Lấy bài viết theo slug
$post = getPost($pdo, $slug, true);

if (!$post) {
    header('Location: danh-sach-tin-tuc.php');
    exit;
}

// Hình ảnh mặc định
$defaultImage = 'https://placehold.co/1200x600/f0f0f0/999999/png?text=No+Image';
$featuredImage = !empty($post['featured_image']) ? getPostImageUrl($post['featured_image']) : $defaultImage;

// Lấy bài viết liên quan (cùng category, loại trừ bài hiện tại)
$relatedPosts = [];
if ($post['category_id']) {
    $relatedPosts = getPosts($pdo, [
        'category_id' => $post['category_id'],
        'limit' => 3,
        'with_category' => true
    ]);
    
    // Loại bỏ bài viết hiện tại khỏi danh sách
    $relatedPosts = array_filter($relatedPosts, function($p) use ($post) {
        return $p['id'] != $post['id'];
    });
    $relatedPosts = array_slice($relatedPosts, 0, 3);
}

// Lấy thêm bài viết đề xuất (mới nhất)
$suggestedPosts = getPosts($pdo, [
    'limit' => 3,
    'order_by' => 'created_at',
    'order_dir' => 'DESC',
    'with_category' => true
]);

include __DIR__ . '/header.php'; 
?>

<main class="site-main clr" id="main" role="main">
  <!-- Hero Section with Featured Image -->
  <section class="post-detail-hero" style="background-image: url('<?php echo $featuredImage; ?>');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="container-modern">
        <!-- Breadcrumb -->
        <nav class="modern-breadcrumb">
          <a href="trang-chu.php">Trang chủ</a>
          <span class="separator">/</span>
          <a href="danh-sach-tin-tuc.php">Tin tức & Sự kiện</a>
          <?php if (!empty($post['category_name'])): ?>
            <span class="separator">/</span>
            <a href="danh-sach-tin-tuc.php?category=<?php echo urlencode($post['category_slug']); ?>">
              <?php echo htmlspecialchars($post['category_name']); ?>
            </a>
          <?php endif; ?>
        </nav>
        
        <!-- Post Meta -->
        <div class="post-meta-hero">
          <?php if (!empty($post['category_name'])): ?>
            <span class="post-category-badge"><?php echo htmlspecialchars($post['category_name']); ?></span>
          <?php endif; ?>
          <span class="post-date-hero">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M6 1.5V3.75M12 1.5V3.75M3 7.5H15M4.5 3H13.5C14.3284 3 15 3.67157 15 4.5V13.5C15 14.3284 14.3284 15 13.5 15H4.5C3.67157 15 3 14.3284 3 13.5V4.5C3 3.67157 3.67157 3 4.5 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php echo formatDate($post['created_at'], 'd/m/Y'); ?>
          </span>
        </div>
        
        <!-- Post Title -->
        <h1 class="post-title-hero"><?php echo htmlspecialchars($post['title']); ?></h1>
        
        <!-- Excerpt if available -->
        <?php if (!empty($post['excerpt'])): ?>
          <p class="post-excerpt-hero"><?php echo htmlspecialchars($post['excerpt']); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <div class="post-detail-container">
    <div class="container-modern">
      <div class="post-detail-grid">
        
        <!-- Main Content Column -->
        <div class="post-content-main">
          <article class="post-content-article">
            <?php echo $post['content']; ?>
          </article>
          
          <!-- Share Buttons -->
          <div class="post-share-section">
            <h3>Chia sẻ bài viết</h3>
            <div class="share-buttons">
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                 target="_blank" 
                 class="share-btn facebook">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
              </a>
              <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                 target="_blank" 
                 class="share-btn twitter">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                Twitter
              </a>
              <a href="#" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!'); return false;" 
                 class="share-btn copy">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Copy link
              </a>
            </div>
          </div>
        </div>
        
        <!-- Sidebar -->
        <aside class="post-sidebar">
          <?php if (!empty($relatedPosts)): ?>
          <div class="sidebar-section">
            <h3 class="sidebar-title">Bài viết liên quan</h3>
            <div class="related-posts-list">
              <?php foreach ($relatedPosts as $relatedPost): ?>
                <?php 
                  $relatedUrl = 'chi-tiet-tin-tuc.php?slug=' . urlencode($relatedPost['slug']);
                  $relatedImage = !empty($relatedPost['featured_image']) ? getPostImageUrl($relatedPost['featured_image']) : $defaultImage;
                  $relatedDate = formatDate($relatedPost['created_at'], 'd.m.Y');
                ?>
                <a href="<?php echo htmlspecialchars($relatedUrl); ?>" class="related-post-item">
                  <div class="related-post-image">
                    <img src="<?php echo $relatedImage; ?>" alt="<?php echo htmlspecialchars($relatedPost['title']); ?>" loading="lazy">
                  </div>
                  <div class="related-post-content">
                    <span class="related-post-date"><?php echo $relatedDate; ?></span>
                    <h4 class="related-post-title"><?php echo htmlspecialchars($relatedPost['title']); ?></h4>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>
        </aside>
        
      </div>
    </div>
  </div>

  <!-- Suggested Posts Section -->
  <?php if (!empty($suggestedPosts)): ?>
  <section class="suggested-posts-section">
    <div class="container-modern">
      <h2 class="section-title-center">Đề xuất cho bạn</h2>
      <div class="suggested-posts-grid">
        <?php foreach ($suggestedPosts as $suggested): ?>
          <?php 
            $suggestedUrl = 'chi-tiet-tin-tuc.php?slug=' . urlencode($suggested['slug']);
            $suggestedImage = !empty($suggested['featured_image']) ? getPostImageUrl($suggested['featured_image']) : $defaultImage;
            $suggestedDate = formatDate($suggested['created_at'], 'd.m.Y');
          ?>
          <article class="modern-post-card">
            <a href="<?php echo htmlspecialchars($suggestedUrl); ?>" class="modern-post-link">
              <div class="modern-post-image">
                <img src="<?php echo $suggestedImage; ?>" alt="<?php echo htmlspecialchars($suggested['title']); ?>" loading="lazy">
                <div class="modern-post-overlay">
                  <span class="read-more-btn">Xem chi tiết →</span>
                </div>
              </div>
              <div class="modern-post-content">
                <?php if (!empty($suggested['category_name'])): ?>
                  <span class="modern-post-category"><?php echo htmlspecialchars($suggested['category_name']); ?></span>
                <?php endif; ?>
                <h3 class="modern-post-title"><?php echo htmlspecialchars($suggested['title']); ?></h3>
                <div class="modern-post-meta">
                  <span class="modern-post-date">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M5.33333 1.33334V3.33334M10.6667 1.33334V3.33334M2.66667 6.66668H13.3333M4 2.66668H12C12.7364 2.66668 13.3333 3.26363 13.3333 4.00001V12C13.3333 12.7364 12.7364 13.3333 12 13.3333H4C3.26362 13.3333 2.66667 12.7364 2.66667 12V4.00001C2.66667 3.26363 3.26362 2.66668 4 2.66668Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php echo $suggestedDate; ?>
                  </span>
                </div>
              </div>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>