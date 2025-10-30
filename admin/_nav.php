<?php
// admin/_nav.php
require_once __DIR__ . '/../includes/config.php';
?>
<div class="admin-header">
  <div class="admin-logo">
    <img src="<?php echo rtrim(BASE_URL, '/'); ?>/public/images/logo-GMF.png" alt="MGF Logo">
    <span>MGF Admin</span>
  </div>
</div>
<nav class="admin-nav">
  <a href="/mgf-website/admin/dashboard.php" class="nav-link">
    <i class="fas fa-home"></i>
    <span>Trang Chủ</span>
  </a>
  <a href="/mgf-website/admin/products/index.php" class="nav-link">
    <i class="fas fa-box"></i>
    <span>Sản Phẩm</span>
  </a>
  <a href="/mgf-website/admin/posts/index.php" class="nav-link">
    <i class="fas fa-newspaper"></i>
    <span>Bài Viết</span>
  </a>
  <a href="/mgf-website/admin/categories/index.php" class="nav-link">
    <i class="fas fa-folder"></i>
    <span>Danh Mục</span>
  </a>
  <a href="/mgf-website/admin/banners/index.php" class="nav-link">
    <i class="fas fa-images"></i>
    <span>Banner</span>
  </a>
  <a href="/mgf-website/admin/logout.php" class="nav-link logout">
    <i class="fas fa-sign-out-alt"></i>
    <span>Đăng Xuất</span>
  </a>
</nav>
