<?php
// admin/dashboard.php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/../includes/db.php';

// Get some simple stats
$counts = [];
$tables = ['products','posts','banners','users'];
foreach ($tables as $t) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as c FROM `" . $t . "`");
        $row = $stmt->fetch();
        $counts[$t] = $row ? (int)$row['c'] : 0;
    } catch (Exception $e) {
        $counts[$t] = 0;
    }
}
?>
<!doctype html>
<html>
<head>
  <?php include __DIR__ . '/_head.php'; ?>
  <title>Bảng Điều Khiển - Admin</title>
</head>
<body>
  <div class="admin-container">
  <h1>Bảng Điều Khiển</h1>
  <?php include __DIR__ . '/_nav.php'; ?>

  <h2>Thống Kê</h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px">
    <div class="card"><strong>Sản Phẩm</strong><div style="font-size:32px;font-weight:600;margin-top:8px"><?php echo $counts['products']; ?></div></div>
    <div class="card"><strong>Bài Viết</strong><div style="font-size:32px;font-weight:600;margin-top:8px"><?php echo $counts['posts']; ?></div></div>
    <div class="card"><strong>Banner</strong><div style="font-size:32px;font-weight:600;margin-top:8px"><?php echo $counts['banners']; ?></div></div>
    <div class="card"><strong>Người Dùng</strong><div style="font-size:32px;font-weight:600;margin-top:8px"><?php echo $counts['users']; ?></div></div>
  </div>

  <section>
    <h3>Hành Động Nhanh</h3>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <a href="products/form.php" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
        Thêm Sản Phẩm
      </a>
      <a href="posts/form.php" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
        Thêm Bài Viết
      </a>
      <a href="banners/form.php" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
        Thêm Banner
      </a>
    </div>
  </section>
  </div>
  <?php include __DIR__ . '/_footer.php'; ?>

</body>
</html>