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
 
 <style>
  /* Page entrance animation */
  @keyframes fadeInUp {
   from {
    opacity: 0;
    transform: translateY(30px);
   }
   to {
    opacity: 1;
    transform: translateY(0);
   }
  }
  
  @keyframes fadeIn {
   from { opacity: 0; }
   to { opacity: 1; }
  }
  
  @keyframes slideInLeft {
   from {
    opacity: 0;
    transform: translateX(-30px);
   }
   to {
    opacity: 1;
    transform: translateX(0);
   }
  }
  
  @keyframes slideInRight {
   from {
    opacity: 0;
    transform: translateX(30px);
   }
   to {
    opacity: 1;
    transform: translateX(0);
   }
  }
  
  /* Main content animation */
  .single-inner article {
   animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .sidebar-area {
   animation: slideInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .dt-breadscrumb {
   animation: fadeIn 0.6s ease-out;
  }
  
  /* Post title animation */
  .post-title {
   animation: fadeInUp 0.8s ease-out;
   animation-delay: 0.2s;
   animation-fill-mode: both;
  }
  
  /* Featured image hover effect */
  .post-featured img {
   transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease;
   cursor: pointer;
  }
  
  .post-featured img:hover {
   transform: scale(1.02);
   box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  }
  
  /* Content fade-in sections */
  .post-expert,
  .post-content {
   animation: fadeInUp 0.8s ease-out;
   animation-delay: 0.4s;
   animation-fill-mode: both;
  }
  
  /* Share buttons hover effects */
  .share-post__item {
   position: relative;
   transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
   padding: 8px;
   border-radius: 50%;
  }
  
  .share-post__item::before {
   content: '';
   position: absolute;
   top: 50%;
   left: 50%;
   width: 0;
   height: 0;
   border-radius: 50%;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   opacity: 0.2;
   transform: translate(-50%, -50%);
   transition: width 0.4s ease, height 0.4s ease;
   z-index: -1;
  }
  
  .share-post__item:hover::before {
   width: 100%;
   height: 100%;
  }
  
  .share-post__item:hover {
   transform: translateY(-3px) scale(1.1);
  }
  
  .share-post__item img {
   transition: transform 0.3s ease;
  }
  
  .share-post__item:hover img {
   transform: rotate(15deg);
  }
  
  /* Sidebar widgets animation */
  .widget {
   transition: all 0.3s ease;
   border-radius: 8px;
   padding: 20px;
   background: #fff;
  }
  
  .widget:hover {
   box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
   transform: translateY(-4px);
  }
  
  .widget-title {
   position: relative;
   display: inline-block;
   padding-bottom: 10px;
  }
  
  .widget-title::after {
   content: '';
   position: absolute;
   bottom: 0;
   left: 0;
   width: 50px;
   height: 3px;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   border-radius: 2px;
   transition: width 0.4s ease;
  }
  
  .widget:hover .widget-title::after {
   width: 100%;
  }
  
  /* Sidebar post items hover */
  .sidebar-post__item {
   transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
   padding: 10px;
   border-radius: 8px;
   margin-bottom: 15px;
  }
  
  .sidebar-post__item:hover {
   background: linear-gradient(135deg, rgba(166, 203, 93, 0.05) 0%, rgba(46, 176, 88, 0.05) 100%);
   transform: translateX(8px);
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }
  
  .sidebar-post__item-image {
   overflow: hidden;
   border-radius: 6px;
  }
  
  .sidebar-post__item-image img {
   transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .sidebar-post__item:hover .sidebar-post__item-image img {
   transform: scale(1.15);
  }
  
  .sidebar-post__title a {
   position: relative;
   transition: color 0.3s ease;
  }
  
  .sidebar-post__item:hover .sidebar-post__title a {
   color: #2eb058;
  }
  
  /* Category links hover */
  .sidebar-category__link {
   position: relative;
   transition: all 0.3s ease;
   display: block;
   padding: 10px 15px;
   border-radius: 6px;
   overflow: hidden;
  }
  
  .sidebar-category__link::before {
   content: '';
   position: absolute;
   left: 0;
   top: 0;
   width: 0;
   height: 100%;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   z-index: -1;
  }
  
  .sidebar-category__link:hover::before {
   width: 100%;
  }
  
  .sidebar-category__link:hover {
   color: #fff;
   transform: translateX(5px);
  }
  
  /* Related posts carousel animations */
  .related-posts {
   animation: fadeInUp 1s ease-out;
   animation-delay: 0.6s;
   animation-fill-mode: both;
  }
  
  .related__item .article-item {
   transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   border-radius: 12px;
   overflow: hidden;
  }
  
  .related__item .article-item:hover {
   transform: translateY(-12px);
   box-shadow: 0 16px 32px rgba(0, 0, 0, 0.15);
  }
  
  .related__item .article__image {
   position: relative;
   overflow: hidden;
  }
  
  .related__item .article__image img {
   transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .related__item .article-item:hover .article__image img {
   transform: scale(1.15) rotate(2deg);
  }
  
  .related__item .article__image::after {
   content: '';
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.3) 100%);
   opacity: 0;
   transition: opacity 0.4s ease;
  }
  
  .related__item .article-item:hover .article__image::after {
   opacity: 1;
  }
  
  .related__item .article__title a {
   position: relative;
   transition: color 0.3s ease;
  }
  
  .related__item .article-item:hover .article__title a {
   color: #2eb058;
  }
  
  /* Carousel navigation hover */
  .owl-nav button {
   transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
  }
  
  .owl-nav button:hover {
   transform: scale(1.2) !important;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%) !important;
  }
  
  .owl-nav button:hover img {
   filter: brightness(0) invert(1);
  }
  
  /* Dots animation */
  .owl-dots button {
   transition: all 0.3s ease !important;
  }
  
  .owl-dots button:hover,
  .owl-dots button.active {
   transform: scale(1.3) !important;
  }
  
  /* Tag/Category badge hover */
  .post-tags a {
   position: relative;
   transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
   display: inline-block;
   padding: 8px 16px;
   border-radius: 20px;
   overflow: hidden;
  }
  
  .post-tags a::before {
   content: '';
   position: absolute;
   top: 0;
   left: -100%;
   width: 100%;
   height: 100%;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   z-index: -1;
  }
  
  .post-tags a:hover::before {
   left: 0;
  }
  
  .post-tags a:hover {
   color: #fff;
   transform: translateY(-2px);
   box-shadow: 0 4px 12px rgba(46, 176, 88, 0.3);
  }
  
  /* Breadcrumb hover */
  .breadcrumb a {
   position: relative;
   transition: color 0.3s ease;
  }
  
  .breadcrumb a::after {
   content: '';
   position: absolute;
   bottom: -2px;
   left: 0;
   width: 0;
   height: 2px;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   transition: width 0.3s ease;
  }
  
  .breadcrumb a:hover::after {
   width: 100%;
  }
  
  .breadcrumb a:hover {
   color: #2eb058;
  }
  
  /* Article meta date hover */
  .article_date {
   transition: all 0.3s ease;
  }
  
  .article_date:hover {
   color: #2eb058;
  }
  
  .article_date:hover img {
   animation: pulse 0.6s ease-in-out;
  }
  
  @keyframes pulse {
   0%, 100% { transform: scale(1); }
   50% { transform: scale(1.2); }
  }
  
  /* Content links hover */
  .post-content a {
   position: relative;
   color: #2eb058;
   transition: all 0.3s ease;
  }
  
  .post-content a:hover {
   color: #054326;
   text-decoration: none;
  }
  
  .post-content a::after {
   content: '';
   position: absolute;
   bottom: 0;
   left: 0;
   width: 0;
   height: 2px;
   background: linear-gradient(135deg, #a6cb5d 0%, #2eb058 100%);
   transition: width 0.3s ease;
  }
  
  .post-content a:hover::after {
   width: 100%;
  }
  
  /* Mobile optimizations */
  @media (max-width: 768px) {
   .single-inner article,
   .sidebar-area {
    animation: fadeInUp 0.6s ease-out;
   }
   
   .sidebar-post__item:hover {
    transform: translateX(4px);
   }
   
   .related__item .article-item:hover {
    transform: translateY(-6px);
   }
  }
 </style>

 <body class="wp-singular post-template-default single single-post wp-theme-greenfeed loading-effect fade-in">

  <!-- Includes header1.php -->
  <?php include '01_includes/header_02.php'; ?>

  <!-- main -->
    <main class="site-main" id="dt-main-content" role="main">
   <div class="container">
    <div class="dt-breadscrumb">
     <ul class="breadcrumb">
      <li>
       <a href="trang-chu.php">
        Trang chủ
       </a>
      </li>
      <li>
       <a href="tin-tuc.php">
        Tin tức
       </a>
      </li>
      <?php if ($post['category_name']): ?>
      <li>
       <a href="tin-tuc.php?category=<?= htmlspecialchars($post['category_slug']) ?>">
        <?= htmlspecialchars($post['category_name']) ?>
       </a>
      </li>
      <?php endif; ?>
      <li>
       <span class="active"><?= htmlspecialchars(mb_substr($post['title'], 0, 50)) ?>...</span>
      </li>
     </ul>
    </div>
    <div class="single-inner flex">
     <article class="post-<?= $post['id'] ?> post type-post" id="post-<?= $post['id'] ?>">
      <div class="post-header">
       <div class="post-title-wrapper">
        <h1 class="post-title">
         <?= htmlspecialchars($post['title']) ?>
        </h1>
       </div>
      </div>
      <div class="post-details">
       <div class="article_meta">
        <div class="article_meta__left">
         <span class="article_date">
          <img alt="date" height="18" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/calendar-outline.svg" width="18"/>
          <?= date('d-m-Y', strtotime($post['created_at'])) ?>
         </span>
        </div>
        <div class="share-post flex">
         <span class="share-post__label">
          Chia sẻ:
         </span>
         <a class="share-post__item flex link-copy" onclick="copyToClipboard(window.location.href)" title="Sao chép liên kết">
          <img alt="Sao chép liên kết" height="18" src="https://www.greenfeed.com.vn/wp-content/uploads/2021/08/link-copy.svg" width="18"/>
          <span class="copied-link" style="display:none;">Đã sao chép!</span>
         </a>
         <script>
          function copyToClipboard(value) {
            navigator.clipboard.writeText(value).then(function() {
              var copiedLink = document.querySelector('.copied-link');
              copiedLink.style.display = 'inline';
              setTimeout(function() {
                copiedLink.style.display = 'none';
              }, 2000);
            });
          }
         </script>
         <a class="share-post__item flex chia-se-len-facebook" href="https://www.facebook.com/share.php?u=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" rel="noopener" target="_blank" title="Chia sẻ lên Facebook">
          <img alt="Chia sẻ lên Facebook" height="18" src="https://www.greenfeed.com.vn/wp-content/uploads/2021/08/fb-black.svg" width="18"/>
         </a>
        </div>
       </div>
       
       <?php if ($post['featured_image']): ?>
       <div class="post-featured">
        <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; height: auto; border-radius: 8px; margin: 20px 0;"/>
       </div>
       <?php endif; ?>
       
       <?php if ($post['excerpt']): ?>
       <div class="post-featured">
        <div class="post-expert">
         <p><?= htmlspecialchars($post['excerpt']) ?></p>
        </div>
       </div>
       <?php endif; ?>
       
       <div class="post-content-wrapper">
        <div class="post-content">
         <?= $post['content'] ?>
        </div>
       </div>
       
       <?php if ($post['category_name']): ?>
       <div class="post-tags dragscroll">
        <strong>Danh mục:</strong>
        <a href="tin-tuc.php?category=<?= htmlspecialchars($post['category_slug']) ?>" title="<?= htmlspecialchars($post['category_name']) ?>">
         <?= htmlspecialchars($post['category_name']) ?>
        </a>
       </div>
       <?php endif; ?>
      </div>
     </article>
     
     <!-- Sidebar -->
     <div class="sidebar-area single-sidebar" id="dt-sidebar">
      
      <!-- Categories Widget -->
      <?php if (!empty($categories)): ?>
      <div class="widget category_posts" id="category_posts-2">
       <span class="widget-title">
        Danh mục bài viết
       </span>
       <ul class="sidebar-category__list">
        <li class="sidebar-category__item">
         <a class="sidebar-category__link" href="tin-tuc.php">
          Tất cả
         </a>
        </li>
        <?php foreach ($categories as $cat): ?>
        <li class="sidebar-category__item">
         <a class="sidebar-category__link" href="tin-tuc.php?category=<?= htmlspecialchars($cat['slug']) ?>">
          <?= htmlspecialchars($cat['name']) ?>
         </a>
        </li>
        <?php endforeach; ?>
       </ul>
      </div>
      <?php endif; ?>
      
      <!-- Recent Posts Widget -->
      <?php if (!empty($recent_posts)): ?>
      <div class="widget interested_posts" id="interested_posts-2">
       <span class="widget-title">
        Có thể bạn quan tâm
       </span>
       <div class="interested-post">
        <?php foreach ($recent_posts as $rec_post): 
          $rec_image = $rec_post['featured_image'] 
            ? '../uploads/posts/' . $rec_post['featured_image']
            : '05_images/no-image.jpg';
        ?>
        <div class="interested-post__item sidebar-post__item flex">
         <div class="sidebar-post__item-image">
          <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rec_post['slug']) ?>">
           <img alt="<?= htmlspecialchars($rec_post['title']) ?>" class="attachment-dt-thumbnail-small size-dt-thumbnail-small wp-post-image" decoding="async" loading="lazy" src="<?= htmlspecialchars($rec_image) ?>"/>
          </a>
         </div>
         <div class="sidebar-post__item-info">
          <h3 class="sidebar-post__title">
           <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rec_post['slug']) ?>">
            <?= htmlspecialchars($rec_post['title']) ?>
           </a>
          </h3>
          <span class="sidebar-post__date">
           <?= date('d-m-Y', strtotime($rec_post['created_at'])) ?>
          </span>
         </div>
        </div>
        <?php endforeach; ?>
       </div>
      </div>
      <?php endif; ?>
     </div>

    </div>
    
    <!-- Related Posts -->
    <?php if (!empty($related_posts)): ?>
    <div class="related-posts">
     <span class="related-posts__title">
      Các bài viết khác
     </span>
     <div class="related-carousel owl-carousel owl-theme carousel--style1">
      <?php foreach ($related_posts as $index => $rel_post): 
        $rel_image = $rel_post['featured_image'] 
          ? '../uploads/posts/' . $rel_post['featured_image']
          : '05_images/no-image.jpg';
      ?>
      <div class="related__item" data-slide-index="<?= $index ?>">
       <article class="article-item post_<?= $rel_post['id'] ?>">
        <div class="article-box">
         <div class="article__image">
          <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rel_post['slug']) ?>">
           <img alt="<?= htmlspecialchars($rel_post['title']) ?>" class="attachment-full size-full wp-post-image" decoding="async" loading="lazy" src="<?= htmlspecialchars($rel_image) ?>"/>
          </a>
         </div>
         <div class="article__info">
          <div class="article_meta">
           <span class="article_date">
            <img alt="date" height="60" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/date.svg" width="60"/>
            <?= date('d-m-Y', strtotime($rel_post['created_at'])) ?>
           </span>
          </div>
          <h3 class="article__title" title="<?= htmlspecialchars($rel_post['title']) ?>">
           <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($rel_post['slug']) ?>">
            <?= htmlspecialchars($rel_post['title']) ?>
           </a>
          </h3>
          <?php if ($rel_post['category_name']): ?>
          <div class="article_category">
           <?= htmlspecialchars($rel_post['category_name']) ?>
          </div>
          <?php endif; ?>
         </div>
        </div>
       </article>
      </div>
      <?php endforeach; ?>
     </div>
     <script>
      jQuery(document).ready(function ($) {
        if(!window.matchMedia("(max-width: 767px)").matches) {
          var el = jQuery('.related-carousel');
          el.owlCarousel({
            nav: true,
            navText: ["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/next-arrow.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/next-arrow.svg' alt='Next'></div>"],
            dots: true,
            loop: false,
            margin: 30,
            smartSpeed: 450,
            responsive: {
              0: {items: 1},
              768: {items: 2},
              992: {items: 3},
              1200: {items: 4}
            }
          });
        }
      });
     </script>
    </div>
    <?php endif; ?>
   </div>

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
