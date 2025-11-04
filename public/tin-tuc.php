<?php
$page_title = "Tin tức & Sự kiện";
require_once __DIR__ . '/../includes/db.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Get category filter
$category_slug = $_GET['category'] ?? '';

// Build query
$where = "WHERE p.is_active = 1";
$params = [];

if ($category_slug) {
    $where .= " AND c.slug = ?";
    $params[] = $category_slug;
}

// Get total posts
$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM posts p 
                             LEFT JOIN categories c ON p.category_id = c.id 
                             $where");
$count_stmt->execute($params);
$total_posts = $count_stmt->fetchColumn();
$total_pages = ceil($total_posts / $per_page);

// Get posts
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                       FROM posts p 
                       LEFT JOIN categories c ON p.category_id = c.id
                       $where
                       ORDER BY p.created_at DESC 
                       LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$posts = $stmt->fetchAll();

// Get featured posts (top 5 most recent)
$featured_stmt = $pdo->query("SELECT p.*, c.name as category_name, c.slug as category_slug 
                              FROM posts p 
                              LEFT JOIN categories c ON p.category_id = c.id
                              WHERE p.is_active = 1
                              ORDER BY p.created_at DESC 
                              LIMIT 5");
$featured_posts = $featured_stmt->fetchAll();

// Get post categories
$cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'post' AND is_active = 1 ORDER BY sort_order ASC");
$categories = $cat_stmt->fetchAll();

// Get banner for this page
$banner_stmt = $pdo->query("SELECT * FROM banners 
                            WHERE location_code = 'tin_tuc' AND is_active = 1 
                            ORDER BY sort_order ASC, id DESC 
                            LIMIT 1");
$banner = $banner_stmt->fetch();

// Set banner image
$banner_image = $banner && $banner['image_path'] 
   ? '../uploads/banners/' . $banner['image_path']
   : 'https://www.greenfeed.com.vn/wp-content/uploads/2024/12/833356f8e36564addde08211c286f5ef.jpg';
?>
<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
 <meta content="text/html;charset=utf-8" http-equiv="content-type"/>

 <!-- Includes header.php -->
 <link href="02_css/style_tintuc.css" id="main-style-css" media="all" rel="stylesheet" type="text/css"/>
 <link href="02_css/post.css" id="page-style-css" media="all" rel="stylesheet" type="text/css"/>
 <?php include '01_includes/header.php'; ?>

 <body class="archive category category-tin-tuc-va-su-kien category-177 wp-theme-greenfeed loading-effect">

  <!-- Includes header1.php -->
  <?php include '01_includes/header_02.php'; ?>

  <!-- main -->
  <main class="site-main" id="dt-main-content" role="main">
   <!-- Keep original banner header -->
   <div class="header-background" style="background-image:url('<?= htmlspecialchars($banner_image) ?>')">
    <div class="container">
     <div class="dt-breadscrumb">
      <ul class="breadcrumb">
       <li>
        <a href="trang-chu">Trang chủ</a>
       </li>
       <li>
        <span class="active">Tin tức và sự kiện</span>
       </li>
      </ul>
     </div>
     <h1 class="header-title">Tin tức và sự kiện</h1>
    </div>
   </div>
   
   <!-- New styled content section -->
   <div class="container">
    <div class="archive-inner flex">
     <div class="archive-main">
      <div class="news-page-wrapper" style="padding: 0 0;">
      
      <!-- Tin nổi bật -->
      <div class="news-section">
       <h2 class="news-section-title">Tin nổi bật</h2>
       
       <div class="news-featured-grid">
        <?php 
        $featured_first = array_shift($featured_posts);
        if ($featured_first):
          $image_url = $featured_first['featured_image'] 
            ? '../' . $featured_first['featured_image']
            : '05_images/no-image.jpg';
        ?>
        <!-- Main Featured Article -->
        <article class="news-featured-main">
         <div class="news-card">
          <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($featured_first['slug']) ?>" class="news-card-image">
           <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($featured_first['title']) ?>" fetchpriority="high">
          </a>
          <div class="news-card-content">
           <h3 class="news-card-title">
            <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($featured_first['slug']) ?>">
             <?= htmlspecialchars($featured_first['title']) ?>
            </a>
           </h3>
           <?php if ($featured_first['excerpt']): ?>
           <p class="news-card-excerpt">
            <?= htmlspecialchars(mb_substr($featured_first['excerpt'], 0, 200, 'UTF-8')) ?>
           </p>
           <?php endif; ?>
           <div class="news-card-meta">
            <?php if ($featured_first['category_name']): ?>
            <span class="news-card-category"><?= htmlspecialchars($featured_first['category_name']) ?></span>
            <?php endif; ?>
            <span class="news-card-date">
             <img src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/date.svg" alt="date">
             <?= date('d-m-Y', strtotime($featured_first['created_at'])) ?>
            </span>
           </div>
          </div>
         </div>
        </article>
        <?php endif; ?>
        
        <!-- Side Featured Articles -->
        <div class="news-featured-side">
         <?php foreach (array_slice($featured_posts, 0, 4) as $post): 
           $image_url = $post['featured_image'] 
             ? '../' . $post['featured_image']
             : '05_images/no-image.jpg';
         ?>
         <article class="news-card">
          <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($post['slug']) ?>" class="news-card-image">
           <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
          </a>
          <div class="news-card-content">
           <h3 class="news-card-title">
            <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($post['slug']) ?>">
             <?= htmlspecialchars($post['title']) ?>
            </a>
           </h3>
           <div class="news-card-meta">
            <span class="news-card-date">
             <img src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/date.svg" alt="date">
             <?= date('d-m-Y', strtotime($post['created_at'])) ?>
            </span>
           </div>
          </div>
         </article>
         <?php endforeach; ?>
        </div>
       </div>
      </div>
      
      <!-- Danh mục bài viết -->
      <div class="news-section">
       <h2 class="news-section-title">Danh mục bài viết</h2>
       <div class="news-categories">
        <a href="tin-tuc" class="news-category-btn <?= empty($category_slug) ? 'active' : '' ?>">
         Tất cả
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="tin-tuc?category=<?= htmlspecialchars($cat['slug']) ?>" class="news-category-btn <?= $category_slug === $cat['slug'] ? 'active' : '' ?>">
         <?= htmlspecialchars($cat['name']) ?>
        </a>
        <?php endforeach; ?>
       </div>
      </div>
      
      <!-- Tin tức mới nhất -->
      <div class="news-section">
       <h2 class="news-section-title">Tin tức mới nhất</h2>
       
       <?php if (empty($posts)): ?>
        <p style="padding: 40px; text-align: center;">Không có bài viết nào.</p>
       <?php else: ?>
       <div class="news-grid">
        <?php foreach ($posts as $post): 
          $image_url = $post['featured_image'] 
            ? '../' . $post['featured_image']
            : '05_images/no-image.jpg';
          $short_excerpt = mb_substr(strip_tags($post['excerpt'] ?? ''), 0, 100, 'UTF-8');
          if (mb_strlen(strip_tags($post['excerpt'] ?? '')) > 100) {
            $short_excerpt .= '…';
          }
        ?>
        <article class="news-card">
         <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($post['slug']) ?>" class="news-card-image">
          <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
         </a>
         <div class="news-card-content">
          <div class="news-card-meta">
           <span class="news-card-date">
            <img src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/date.svg" alt="date">
            <?= date('d-m-Y', strtotime($post['created_at'])) ?>
           </span>
          </div>
          <h3 class="news-card-title">
           <a href="chi-tiet-tin-tuc?slug=<?= htmlspecialchars($post['slug']) ?>">
            <?= htmlspecialchars($post['title']) ?>
           </a>
          </h3>
          <?php if ($short_excerpt): ?>
          <p class="news-card-excerpt">
           <?= htmlspecialchars($short_excerpt) ?>
          </p>
          <?php endif; ?>
         </div>
        </article>
        <?php endforeach; ?>
       </div>
       <?php endif; ?>
       
       <!-- Pagination -->
       <?php if ($total_pages > 1): ?>
       <nav class="news-pagination" role="navigation">
        <?php if ($page > 1): ?>
         <a class="news-page-btn" href="?page=<?= $page - 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>">
          <img src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg" alt="Prev" style="transform: rotate(180deg);">
         </a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <?php if ($i == 1 || $i == $total_pages || ($i >= $page - 2 && $i <= $page + 2)): ?>
            <?php if ($i == $page): ?>
              <span class="news-page-btn active"><?= $i ?></span>
            <?php else: ?>
              <a class="news-page-btn" href="?page=<?= $i ?><?= $category_slug ? '&category=' . $category_slug : '' ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
            <span class="news-page-btn dots">…</span>
          <?php endif; ?>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
         <a class="news-page-btn" href="?page=<?= $page + 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>">
          <img src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg" alt="Next">
         </a>
        <?php endif; ?>
       </nav>
       <?php endif; ?>
      </div>
      
      </div><!-- /news-page-wrapper -->
     </div><!-- /archive-main -->
    </div><!-- /archive-inner -->
   </div><!-- /container -->

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
