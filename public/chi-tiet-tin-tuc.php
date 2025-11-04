<?php
require_once __DIR__ . '/../includes/db.php';

// Get slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: tin-tuc.php');
    exit;
}

// Get post
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                       FROM posts p 
                       LEFT JOIN categories c ON p.category_id = c.id
                       WHERE p.slug = ? AND p.is_active = 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: tin-tuc.php');
    exit;
}

// Set page title based on post title
$page_title = $post['title'];

// Get related posts (same category)
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                       FROM posts p 
                       LEFT JOIN categories c ON p.category_id = c.id
                       WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1
                       ORDER BY RAND() 
                       LIMIT 5");
$stmt->execute([$post['category_id'], $post['id']]);
$related_posts = $stmt->fetchAll();

// Get categories for sidebar
$cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'post' AND is_active = 1 ORDER BY sort_order ASC");
$categories = $cat_stmt->fetchAll();

// Get recent posts for sidebar
$recent_stmt = $pdo->query("SELECT p.*, c.name as category_name 
                            FROM posts p 
                            LEFT JOIN categories c ON p.category_id = c.id
                            WHERE p.is_active = 1 AND p.id != {$post['id']}
                            ORDER BY p.created_at DESC 
                            LIMIT 5");
$recent_posts = $recent_stmt->fetchAll();

$image_url = $post['featured_image'] 
    ? '../uploads/posts/' . $post['featured_image']
    : '05_images/no-image.jpg';
?>
<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
 <meta content="text/html;charset=utf-8" http-equiv="content-type"/>
 <title><?= htmlspecialchars($post['title']) ?> - MGF Việt Nam</title>
 <meta name="description" content="<?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content']), 0, 160)) ?>">

 <!-- Includes header.php -->
 <link href="02_css/style_chitiet_tintuc.css" id="main-style-css" media="all" rel="stylesheet" type="text/css"/>
 <link href="02_css/detail_post.css" id="page-style-css" media="all" rel="stylesheet" type="text/css"/>
 <?php include '01_includes/header.php'; ?>

 <body class="wp-singular post-template-default single single-post wp-theme-greenfeed loading-effect fade-in">

  <!-- Includes header1.php -->
  <?php include '01_includes/header_02.php'; ?>

  <!-- main -->
    <main class="site-main" id="dt-main-content" role="main">
   
   <!-- Post Detail Wrapper -->
   <div class="post-detail-wrapper">
    
    <!-- Breadcrumb -->
    <div class="post-breadcrumb">
     <a href="trang-chu.php">Trang chủ</a>
     <span>/</span>
     <a href="tin-tuc.php">Tin tức</a>
     <?php if ($post['category_name']): ?>
     <span>/</span>
     <a href="tin-tuc.php?category=<?= htmlspecialchars($post['category_slug']) ?>">
      <?= htmlspecialchars($post['category_name']) ?>
     </a>
     <?php endif; ?>
    </div>
    
    <!-- 2-Column Layout -->
    <div class="post-detail-layout">
     
     <!-- Main Content -->
     <article class="post-main-content">
      
      <!-- Post Header -->
      <div class="post-detail-header">
       <h1 class="post-detail-title"><?= htmlspecialchars($post['title']) ?></h1>
       
       <div class="post-detail-meta">
        <span class="post-meta-date">
         <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M12.667 2.667H3.333C2.597 2.667 2 3.264 2 4v9.333c0 .737.597 1.334 1.333 1.334h9.334c.736 0 1.333-.597 1.333-1.334V4c0-.736-.597-1.333-1.333-1.333z" stroke="currentColor" stroke-width="1.5"/>
          <path d="M10.667 1.333v2.667M5.333 1.333v2.667M2 6.667h12" stroke="currentColor" stroke-width="1.5"/>
         </svg>
         <?= date('d/m/Y', strtotime($post['created_at'])) ?>
        </span>
        
        <div class="post-share">
         <span>Chia sẻ:</span>
         <button class="share-btn" onclick="copyToClipboard(window.location.href)" title="Sao chép liên kết">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
           <path d="M10 6L6 10M13.657 2.343a2 2 0 10-2.828 2.828l-6.485 6.486a2 2 0 102.828 2.828l6.485-6.486a2 2 0 000-2.828z" stroke="currentColor" stroke-width="1.5"/>
          </svg>
          <span class="copied-msg" style="display:none;">Đã sao chép!</span>
         </button>
         <a class="share-btn share-facebook" href="https://www.facebook.com/share.php?u=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" title="Chia sẻ Facebook">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
           <path d="M12 1H10c-1.1 0-2 .9-2 2v2H6v3h2v7h3V8h2l1-3h-3V3c0-.6.4-1 1-1h1V1z" fill="currentColor"/>
          </svg>
         </a>
        </div>
        
        <script>
         function copyToClipboard(value) {
           navigator.clipboard.writeText(value).then(function() {
             var msg = document.querySelector('.copied-msg');
             msg.style.display = 'inline';
             setTimeout(function() { msg.style.display = 'none'; }, 2000);
           });
         }
        </script>
       </div>
      </div>
      
      <!-- Featured Image -->
      <?php if ($post['featured_image']): ?>
      <div class="post-featured-image">
       <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>"/>
      </div>
      <?php endif; ?>
      
      <!-- Excerpt -->
      <?php if ($post['excerpt']): ?>
      <div class="post-excerpt">
       <p><?= htmlspecialchars($post['excerpt']) ?></p>
      </div>
      <?php endif; ?>
      
      <!-- Content -->
      <div class="post-content-text">
       <?= $post['content'] ?>
      </div>
      
      <!-- Category Tag -->
      <?php if ($post['category_name']): ?>
      <div class="post-category-tag">
       <strong>Danh mục:</strong>
       <a href="tin-tuc.php?category=<?= htmlspecialchars($post['category_slug']) ?>" class="category-badge">
        <?= htmlspecialchars($post['category_name']) ?>
       </a>
      </div>
      <?php endif; ?>
      
     </article>
     
     <!-- Sidebar -->
     <aside class="post-sidebar">
      
      <!-- Categories Widget -->
      <?php if (!empty($categories)): ?>
      <div class="sidebar-widget">
       <h3 class="sidebar-widget-title">Danh mục bài viết</h3>
       <ul class="sidebar-category-list">
        <li><a href="tin-tuc.php" class="sidebar-category-link">Tất cả</a></li>
        <?php foreach ($categories as $cat): ?>
        <li>
         <a href="tin-tuc.php?category=<?= htmlspecialchars($cat['slug']) ?>" class="sidebar-category-link">
          <?= htmlspecialchars($cat['name']) ?>
         </a>
        </li>
        <?php endforeach; ?>
       </ul>
      </div>
      <?php endif; ?>
      
      <!-- Recent Posts Widget -->
      <?php if (!empty($recent_posts)): ?>
      <div class="sidebar-widget">
       <h3 class="sidebar-widget-title">Có thể bạn quan tâm</h3>
       <div class="sidebar-posts-list">
        <?php foreach ($recent_posts as $rec_post): 
          $rec_image = $rec_post['featured_image'] 
            ? '../uploads/posts/' . $rec_post['featured_image']
            : '05_images/no-image.jpg';
        ?>
        <div class="sidebar-post-item">
         <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rec_post['slug']) ?>" class="sidebar-post-thumb">
          <img src="<?= htmlspecialchars($rec_image) ?>" alt="<?= htmlspecialchars($rec_post['title']) ?>"/>
         </a>
         <div class="sidebar-post-info">
          <h4 class="sidebar-post-title">
           <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rec_post['slug']) ?>">
            <?= htmlspecialchars($rec_post['title']) ?>
           </a>
          </h4>
          <span class="sidebar-post-date">
           <?= date('d/m/Y', strtotime($rec_post['created_at'])) ?>
          </span>
         </div>
        </div>
        <?php endforeach; ?>
       </div>
      </div>
      <?php endif; ?>
      
     </aside>
     
    </div>
    
   </div>
   
   <!-- Related Posts Section -->
   <?php if (!empty($related_posts)): ?>
   <div class="related-posts-section">
    <div class="post-detail-wrapper">
     <h2 class="related-posts-title">Các bài viết khác</h2>
     <div class="related-posts-grid">
      <?php foreach ($related_posts as $rel_post): 
        $rel_image = $rel_post['featured_image'] 
          ? '../uploads/posts/' . $rel_post['featured_image']
          : '05_images/no-image.jpg';
      ?>
      <article class="related-post-card">
       <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rel_post['slug']) ?>" class="related-post-image">
        <img src="<?= htmlspecialchars($rel_image) ?>" alt="<?= htmlspecialchars($rel_post['title']) ?>"/>
       </a>
       <div class="related-post-content">
        <span class="related-post-date">
         <?= date('d/m/Y', strtotime($rel_post['created_at'])) ?>
        </span>
        <h3 class="related-post-title">
         <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rel_post['slug']) ?>">
          <?= htmlspecialchars($rel_post['title']) ?>
         </a>
        </h3>
        <?php if ($rel_post['category_name']): ?>
        <span class="related-post-category"><?= htmlspecialchars($rel_post['category_name']) ?></span>
        <?php endif; ?>
       </div>
      </article>
      <?php endforeach; ?>
     </div>
    </div>
   </div>
   <?php endif; ?>

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
