<?php
session_start();
require_once '../../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Get search query and filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Get categories for filter
$categoriesStmt = $pdo->prepare('SELECT * FROM categories WHERE type = ? ORDER BY name ASC');
$categoriesStmt->execute(['post']);
$categories = $categoriesStmt->fetchAll();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;

// Build query
$query = "SELECT p.*, c.name as category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (p.title LIKE :search OR p.content LIKE :search)";
    $params[':search'] = "%$search%";
}

if ($categoryFilter > 0) {
    $query .= " AND p.category_id = :category";
    $params[':category'] = $categoryFilter;
}

$query .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

// Get total count for pagination
$countQuery = "SELECT COUNT(*) FROM posts p WHERE 1=1";
if ($search) {
    $countQuery .= " AND (p.title LIKE :search OR p.content LIKE :search)";
}
if ($categoryFilter > 0) {
    $countQuery .= " AND p.category_id = :category";
}
$countStmt = $pdo->prepare($countQuery);
if ($search) {
    $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
if ($categoryFilter > 0) {
    $countStmt->bindValue(':category', $categoryFilter, PDO::PARAM_INT);
}
$countStmt->execute();
$totalPosts = $countStmt->fetchColumn();
$totalPages = ceil($totalPosts / $perPage);
?>
<!doctype html>
<html>
<head>
  <?php include __DIR__ . '/../_head.php'; ?>
  <title>Quản Lý Bài Viết - Admin</title>
</head>
<body>
  <div class="admin-container">
  <h1>Quản Lý Bài Viết</h1>
  <?php include __DIR__ . '/../_nav.php'; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <p style="color:#34c759;background:#d9f7e5;padding:12px;border-radius:8px;border:1px solid #a3e9c4"><?= htmlspecialchars($_SESSION['success']) ?></p>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <p style="color:#ff3b30;background:#fee;padding:12px;border-radius:8px;border:1px solid #fcc"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
  
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;gap:16px;flex-wrap:wrap">
    <a href="form.php" class="btn">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
      Thêm Bài Viết
    </a>
    
    <form method="get" style="display:flex;gap:8px;flex:1;max-width:600px;flex-wrap:wrap">
      <select name="category" style="padding:8px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px">
        <option value="">Tất cả danh mục</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $categoryFilter == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="<?= htmlspecialchars($search) ?>" style="flex:1;min-width:200px;padding:8px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px">
      <button type="submit" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
        Tìm
      </button>
      <?php if ($search || $categoryFilter): ?>
        <a href="index.php" class="btn">Xóa</a>
      <?php endif; ?>
    </form>
  </div>

  <table>
    <thead>
      <tr><th>Ảnh</th><th>Tiêu Đề</th><th>Danh Mục</th><th>Slug</th><th>Trạng Thái</th><th>Ngày Tạo</th><th>Hành Động</th></tr>
    </thead>
    <tbody>
    <?php if (empty($posts)): ?>
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:#86868b">Không tìm thấy bài viết nào.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($posts as $post): ?>
      <tr>
        <td>
          <?php if ($post['featured_image']): ?>
            <img src="../../<?= htmlspecialchars($post['featured_image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:4px">
          <?php else: ?>
            <div style="width:60px;height:60px;background:#f5f5f7;border-radius:4px;display:flex;align-items:center;justify-content:center">
              <svg width="24" height="24" viewBox="0 0 16 16" fill="#86868b"><path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/><path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/></svg>
            </div>
          <?php endif; ?>
        </td>
        <td>
          <strong><?= htmlspecialchars($post['title']) ?></strong>
          <?php if ($post['excerpt']): ?>
            <div class="muted" style="font-size:13px;margin-top:4px;color:#86868b">
              <?= htmlspecialchars(mb_substr($post['excerpt'], 0, 100)) ?>...
            </div>
          <?php endif; ?>
        </td>
        <td><?= $post['category_name'] ? htmlspecialchars($post['category_name']) : '<span class="muted">Chưa phân loại</span>' ?></td>
        <td><code style="font-size:12px;color:#06c"><?= htmlspecialchars($post['slug']) ?></code></td>
        <td>
          <?php if ($post['is_active']): ?>
            <span style="background:#d9f7e5;color:#34c759;padding:4px 8px;border-radius:4px;font-size:12px;font-weight:500">Hiển thị</span>
          <?php else: ?>
            <span style="background:#f5f5f7;color:#86868b;padding:4px 8px;border-radius:4px;font-size:12px;font-weight:500">Ẩn</span>
          <?php endif; ?>
        </td>
        <td class="muted"><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></td>
        <td>
          <a href="form.php?id=<?= $post['id'] ?>">Sửa</a> |
          <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')" style="color:#ff3b30">Xóa</a>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>  </table>

  <?php if ($totalPages > 1): ?>
    <div style="display:flex;justify-content:center;align-items:center;gap:16px;margin-top:24px">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="btn">← Trước</a>
      <?php endif; ?>
      
      <span class="muted">Trang <?= $page ?> / <?= $totalPages ?></span>
      
      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="btn">Sau →</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  </div>
  <?php include __DIR__ . '/../_footer.php'; ?>
</body>
</html>
