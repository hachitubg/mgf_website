<?php
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
   <div class="header-background" style="background-image:url('https://www.greenfeed.com.vn/wp-content/uploads/2024/12/833356f8e36564addde08211c286f5ef.jpg')">
    <div class="container">
     <div class="dt-breadscrumb">
      <ul class="breadcrumb">
       <li>
        <a href="trang-chu.php">
         Trang chủ
        </a>
       </li>
       <li>
        <span class="active">
         Tin tức và sự kiện
        </span>
       </li>
      </ul>
     </div>
     <h1 class="header-title">
      Tin tức và sự kiện
     </h1>
    </div>
   </div>
   <div class="container">
    <div class="archive-inner flex">
     <div class="archive-main">
      
      <!-- Tin nổi bật -->
      <div class="category-section">
       <div class="category-section-title">
        Tin nổi bật
       </div>
       <div class="articles-popular">
        <?php foreach (array_slice($featured_posts, 0, 5) as $index => $post): 
          $image_url = $post['featured_image'] 
            ? '/uploads/posts/' . $post['featured_image']
            : '05_images/no-image.jpg';
        ?>
        <div class="news__item">
         <article class="article-item post_<?= $post['id'] ?>">
          <div class="article-box">
           <div class="article__image">
            <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($post['slug']) ?>">
             <img alt="<?= htmlspecialchars($post['title']) ?>" class="attachment-full size-full wp-post-image" decoding="async" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> src="<?= htmlspecialchars($image_url) ?>"/>
            </a>
           </div>
           <div class="article__info">
            <?php if ($index === 0): ?>
            <h3 class="article__title" title="<?= htmlspecialchars($post['title']) ?>">
             <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($post['slug']) ?>">
              <?= htmlspecialchars($post['title']) ?>
             </a>
            </h3>
            <?php if ($post['excerpt']): ?>
            <p class="expert">
             <span><?= htmlspecialchars(mb_substr($post['excerpt'], 0, 200, 'UTF-8')) ?></span>
            </p>
            <?php endif; ?>
            <?php endif; ?>
            
            <div class="article_meta">
             <?php if ($post['category_name']): ?>
             <div class="article_category">
              <?= htmlspecialchars($post['category_name']) ?>
             </div>
             <?php endif; ?>
             <span class="article_date">
              <img alt="date" height="60" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/date.svg" width="60"/>
              <?= date('d-m-Y', strtotime($post['created_at'])) ?>
             </span>
            </div>
            
            <?php if ($index > 0): ?>
            <h3 class="article__title" title="<?= htmlspecialchars($post['title']) ?>">
             <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($post['slug']) ?>">
              <?= htmlspecialchars($post['title']) ?>
             </a>
            </h3>
            <?php if ($post['category_name']): ?>
            <div class="article_category">
             <?= htmlspecialchars($post['category_name']) ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
           </div>
          </div>
         </article>
        </div>
        <?php endforeach; ?>
       </div>
      </div>
      
      <!-- Danh mục bài viết -->
      <div class="category-section">
       <div class="category-section-title">
        Danh mục bài viết
       </div>
       <div class="category-list">
        <a href="tin-tuc.php" class="<?= empty($category_slug) ? 'active' : '' ?>">
         Tất cả
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="tin-tuc.php?category=<?= htmlspecialchars($cat['slug']) ?>" class="<?= $category_slug === $cat['slug'] ? 'active' : '' ?>">
         <?= htmlspecialchars($cat['name']) ?>
        </a>
        <?php endforeach; ?>
       </div>
      </div>
      
      <!-- Tin tức mới nhất -->
      <div class="category-section">
       <div class="category-section-title">
        Tin tức mới nhất
       </div>
       <div class="articles-wrapper flex articles-page<?= $page ?>">
        <?php if (empty($posts)): ?>
        <p style="padding: 40px; text-align: center; width: 100%;">Không có bài viết nào.</p>
        <?php else: ?>
        <?php foreach ($posts as $post): 
          $image_url = $post['featured_image'] 
            ? '/uploads/posts/' . $post['featured_image']
            : '05_images/no-image.jpg';
          $short_excerpt = mb_substr(strip_tags($post['excerpt'] ?? ''), 0, 100, 'UTF-8');
          if (mb_strlen(strip_tags($post['excerpt'] ?? '')) > 100) {
            $short_excerpt .= '…';
          }
        ?>
        <article class="article-item post_<?= $post['id'] ?>">
         <div class="article-box">
          <div class="article__image">
           <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($post['slug']) ?>">
            <img alt="<?= htmlspecialchars($post['title']) ?>" class="attachment-dt-thumbnail-medium size-dt-thumbnail-medium wp-post-image" decoding="async" loading="lazy" src="<?= htmlspecialchars($image_url) ?>"/>
           </a>
          </div>
          <div class="article__info">
           <div class="article_meta">
            <span class="article_date">
             <?= date('d-m-Y', strtotime($post['created_at'])) ?>
            </span>
           </div>
           <a href="chi-tiet-tin-tuc.php?slug=<?= htmlspecialchars($post['slug']) ?>">
            <h2 class="article__title" title="<?= htmlspecialchars($post['title']) ?>">
             <span><?= htmlspecialchars($post['title']) ?></span>
            </h2>
            <?php if ($short_excerpt): ?>
            <p class="expert">
             <span><?= htmlspecialchars($short_excerpt) ?></span>
            </p>
            <?php endif; ?>
           </a>
          </div>
         </div>
        </article>
        <?php endforeach; ?>
        <?php endif; ?>
       </div>
       
       <!-- Pagination -->
       <?php if ($total_pages > 1): ?>
       <nav class="navigation paging-navigation" role="navigation">
        <div class="dt-pagination">
         <?php if ($page > 1): ?>
         <a class="prev page-numbers" href="?page=<?= $page - 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>">
          <img alt="Prev" height="28" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg" width="28" style="transform: rotate(180deg);"/>
         </a>
         <?php endif; ?>
         
         <?php for ($i = 1; $i <= $total_pages; $i++): ?>
           <?php if ($i == 1 || $i == $total_pages || ($i >= $page - 2 && $i <= $page + 2)): ?>
             <?php if ($i == $page): ?>
               <span aria-current="page" class="page-numbers current"><?= $i ?></span>
             <?php else: ?>
               <a class="page-numbers" href="?page=<?= $i ?><?= $category_slug ? '&category=' . $category_slug : '' ?>"><?= $i ?></a>
             <?php endif; ?>
           <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
             <span class="page-numbers dots">…</span>
           <?php endif; ?>
         <?php endfor; ?>
         
         <?php if ($page < $total_pages): ?>
         <a class="next page-numbers" href="?page=<?= $page + 1 ?><?= $category_slug ? '&category=' . $category_slug : '' ?>">
          <img alt="Next" height="28" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg" width="28"/>
         </a>
         <?php endif; ?>
        </div>
       </nav>
       <?php endif; ?>
      </div>
     </div>
    </div>
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
