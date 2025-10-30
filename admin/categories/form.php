<?php
require_once __DIR__ . '/../_auth.php';
require_once __DIR__ . '/../../includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = $_GET['type'] ?? 'product';
if (!in_array($type, ['product', 'post'])) {
    $type = 'product';
}

$category = null;
$isEdit = false;

if ($id) {
    $isEdit = true;
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $category = $stmt->fetch();
    if (!$category) {
        header('Location: index.php?type=' . $type);
        exit;
    }
    $type = $category['type']; // Use category's type in edit mode
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    $postId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $isEditMode = $postId > 0;
    
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $type = $_POST['type'] ?? 'product';
    $description = trim($_POST['description'] ?? '');
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Auto-assign sort_order for new categories
    if (!$isEditMode) {
        $maxOrderStmt = $pdo->prepare('SELECT COALESCE(MAX(sort_order), -1) + 1 FROM categories WHERE type = ?');
        $maxOrderStmt->execute([$type]);
        $sort_order = $maxOrderStmt->fetchColumn();
    } else {
        $sort_order = $category['sort_order']; // Keep existing order when editing
    }

    // Validation
    if (strlen($name) < 2 || strlen($name) > 255) {
        $errors[] = 'Tên danh mục phải từ 2 đến 255 ký tự';
    }
    
    if (empty($slug)) {
        $errors[] = 'Slug không được để trống';
    }
    
    if (!in_array($type, ['product', 'post'])) {
        $errors[] = 'Loại danh mục không hợp lệ';
    }
    
    // Check unique slug
    if ($isEditMode) {
        $slugCheck = $pdo->prepare('SELECT id FROM categories WHERE slug = ? AND id != ? LIMIT 1');
        $slugCheck->execute([$slug, $postId]);
    } else {
        $slugCheck = $pdo->prepare('SELECT id FROM categories WHERE slug = ? LIMIT 1');
        $slugCheck->execute([$slug]);
    }
    
    if ($slugCheck->fetch()) {
        $errors[] = 'Slug này đã tồn tại, vui lòng chọn slug khác';
    }
    
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($isEditMode) {
        $upd = $pdo->prepare('UPDATE categories SET name = ?, slug = ?, type = ?, description = ?, is_active = ?, sort_order = ? WHERE id = ?');
        $upd->execute([$name, $slug, $type, $description, $is_active, $sort_order, $postId]);
    } else {
        $ins = $pdo->prepare('INSERT INTO categories (name, slug, type, description, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
        $ins->execute([$name, $slug, $type, $description, $is_active, $sort_order]);
    }

    header('Location: index.php?type=' . $type);
    exit;
}

function slugify($s) {
    $vietnamese = [
        'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
        'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
        'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
        'đ' => 'd',
        'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
        'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
        'ì' => 'i', 'í' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
        'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
        'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
        'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
        'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
        'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
        'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
    ];
    $s = mb_strtolower($s, 'UTF-8');
    $s = strtr($s, $vietnamese);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    $s = trim($s, '-');
    $s = preg_replace('/-+/', '-', $s);
    if (!$s) return 'cat-' . time();
    return $s;
}

$pageTitle = $isEdit ? 'Sửa Danh Mục' : 'Thêm Danh Mục';

// Retrieve and clear form errors/data from session
$formErrors = $_SESSION['form_errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_data']);
?>
<!doctype html>
<html>
<head>
  <?php include __DIR__ . '/../_head.php'; ?>
  <title><?php echo $pageTitle; ?></title>
</head>
<body>
  <div class="admin-container">
    <h1><?php echo $pageTitle; ?></h1>
    <?php include __DIR__ . '/../_nav.php'; ?>
    
    <?php if (!empty($formErrors)): ?>
    <div style="background:#fee;border:1px solid #f33;border-radius:8px;padding:16px;margin-bottom:24px">
      <strong style="color:#c00">Vui lòng sửa các lỗi sau:</strong>
      <ul style="margin:8px 0 0 20px;color:#c00">
        <?php foreach ($formErrors as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    
    <div style="margin-bottom:24px">
      <a href="index.php?type=<?php echo $type; ?>" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/></svg>
        Quay lại danh sách
      </a>
    </div>

    <form method="post" style="max-width:800px" id="category-form">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      
      <div class="form-row">
        <label>Loại Danh Mục <span class="required">*</span></label>
        <select name="type" required <?php echo $isEdit ? 'disabled' : ''; ?>>
          <option value="product" <?php echo ($formData['type'] ?? $category['type'] ?? $type) === 'product' ? 'selected' : ''; ?>>Sản Phẩm</option>
          <option value="post" <?php echo ($formData['type'] ?? $category['type'] ?? $type) === 'post' ? 'selected' : ''; ?>>Bài Viết</option>
        </select>
        <?php if ($isEdit): ?>
          <input type="hidden" name="type" value="<?php echo $category['type']; ?>">
          <p class="muted">Không thể thay đổi loại danh mục khi đã tạo</p>
        <?php endif; ?>
      </div>

      <div class="form-row">
        <label>Tên Danh Mục <span class="required">*</span></label>
        <input type="text" name="name" id="name" required value="<?php echo htmlspecialchars($formData['name'] ?? $category['name'] ?? ''); ?>" minlength="2" maxlength="255">
        <span class="form-error">Tên danh mục bắt buộc (2-255 ký tự)</span>
      </div>

      <div class="form-row">
        <label>Slug (URL thân thiện) <span class="required">*</span></label>
        <input type="text" name="slug" id="slug" required value="<?php echo htmlspecialchars($formData['slug'] ?? $category['slug'] ?? ''); ?>">
        <p class="muted">Tự động tạo từ tên danh mục (có thể chỉnh sửa)</p>
      </div>

      <div class="form-row">
        <label>Mô Tả</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($formData['description'] ?? $category['description'] ?? ''); ?></textarea>
      </div>

      <div class="form-row">
        <label class="checkbox-label">
          <input type="checkbox" name="is_active" value="1" <?php echo ($formData['is_active'] ?? $category['is_active'] ?? 1) ? 'checked' : ''; ?>>
          <span>Kích hoạt danh mục</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>
          <?php echo $isEdit ? 'Cập Nhật' : 'Lưu Danh Mục'; ?>
        </button>
        <a href="index.php?type=<?php echo $type; ?>" class="btn">Hủy</a>
      </div>
    </form>
  </div>

  <script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
      var slugInput = document.getElementById('slug');
      if (!slugInput.value || slugInput.dataset.auto !== 'false') {
        slugInput.value = slugify(this.value);
        slugInput.dataset.auto = 'true';
      }
    });

    document.getElementById('slug').addEventListener('input', function() {
      this.dataset.auto = 'false';
    });

    function slugify(text) {
      text = text.toLowerCase();
      var vn = {'à':'a','á':'a','ạ':'a','ả':'a','ã':'a','ă':'a','ằ':'a','ắ':'a','ặ':'a','ẳ':'a','ẵ':'a','â':'a','ầ':'a','ấ':'a','ậ':'a','ẩ':'a','ẫ':'a','è':'e','é':'e','ẹ':'e','ẻ':'e','ẽ':'e','ê':'e','ề':'e','ế':'e','ệ':'e','ể':'e','ễ':'e','ì':'i','í':'i','ị':'i','ỉ':'i','ĩ':'i','ò':'o','ó':'o','ọ':'o','ỏ':'o','õ':'o','ô':'o','ồ':'o','ố':'o','ộ':'o','ổ':'o','ỗ':'o','ơ':'o','ờ':'o','ớ':'o','ợ':'o','ở':'o','ỡ':'o','ù':'u','ú':'u','ụ':'u','ủ':'u','ũ':'u','ư':'u','ừ':'u','ứ':'u','ự':'u','ử':'u','ữ':'u','ỳ':'y','ý':'y','ỵ':'y','ỷ':'y','ỹ':'y','đ':'d'};
      for (var k in vn) text = text.replace(new RegExp(k, 'g'), vn[k]);
      return text.replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').trim().replace(/^-+|-+$/g, '');
    }

    // Form validation
    document.getElementById('category-form').addEventListener('submit', function(e) {
      var name = document.getElementById('name').value.trim();
      
      document.querySelectorAll('.has-error').forEach(function(el) {
        el.classList.remove('has-error');
      });

      var hasError = false;

      if (name.length < 2) {
        document.getElementById('name').closest('.form-row').classList.add('has-error');
        hasError = true;
      }

      if (hasError) {
        e.preventDefault();
        return false;
      }
    });
  </script>
  <?php include __DIR__ . '/../_footer.php'; ?>
</body>
</html>
