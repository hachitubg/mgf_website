<?php
require_once __DIR__ . '/../_auth.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;
$images = [];
$isEdit = false;

if ($id) {
    $isEdit = true;
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if (!$product) {
        header('Location: index.php');
        exit;
    }
    $imgStmt = $pdo->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, id ASC');
    $imgStmt->execute([$id]);
    $images = $imgStmt->fetchAll();
}

// Get product categories
$categoriesStmt = $pdo->prepare('SELECT * FROM categories WHERE type = ? AND is_active = 1 ORDER BY sort_order ASC, name ASC');
$categoriesStmt->execute(['product']);
$categories = $categoriesStmt->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Get ID from POST for edit mode
    $postId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $isEditMode = $postId > 0;
    
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== '' ? intval($_POST['category_id']) : null;
    $description = $_POST['description'] ?? '';

    // Server-side validation
    if (strlen($title) < 3 || strlen($title) > 255) {
        $errors[] = 'Tiêu đề phải từ 3 đến 255 ký tự';
    }
    
    if (empty($slug)) {
        $errors[] = 'Slug không được để trống';
    }
    
    if (!$category_id) {
        $errors[] = 'Vui lòng chọn danh mục sản phẩm';
    }
    
    // Validate images for new products only
    if (!$isEditMode) {
        if (empty($_FILES['images']) || empty($_FILES['images']['name'][0])) {
            $errors[] = 'Cần ít nhất một hình ảnh sản phẩm';
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    function slugify($s) {
        // Vietnamese character mapping
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
        
        // Convert to lowercase
        $s = mb_strtolower($s, 'UTF-8');
        
        // Replace Vietnamese characters
        $s = strtr($s, $vietnamese);
        
        // Replace spaces and special characters with dash
        $s = preg_replace('/[^a-z0-9]+/', '-', $s);
        
        // Remove leading/trailing dashes
        $s = trim($s, '-');
        
        // Remove consecutive dashes
        $s = preg_replace('/-+/', '-', $s);
        
        if (!$s) return 'p-' . time();
        return $s;
    }

    if ($isEditMode) {
        // Update existing product - need to fetch product data
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
        $stmt->execute([$postId]);
        $existingProduct = $stmt->fetch();
        
        if (!$existingProduct) {
            $errors[] = 'Sản phẩm không tồn tại';
            $_SESSION['form_errors'] = $errors;
            header('Location: index.php');
            exit;
        }
        
        // Check if slug is unique (excluding current product)
        $slugCheck = $pdo->prepare('SELECT id FROM products WHERE slug = ? AND id != ? LIMIT 1');
        $slugCheck->execute([$slug, $postId]);
        if ($slugCheck->fetch()) {
            $errors[] = 'Slug này đã tồn tại, vui lòng chọn slug khác';
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
        
        $upd = $pdo->prepare('UPDATE products SET title = ?, slug = ?, category_id = ?, description = ? WHERE id = ?');
        $upd->execute([$title, $slug, $category_id, $description, $postId]);
        $productId = $postId;
    } else {
        // Create new product - check if slug is unique
        $slugCheck = $pdo->prepare('SELECT id FROM products WHERE slug = ? LIMIT 1');
        $slugCheck->execute([$slug]);
        if ($slugCheck->fetch()) {
            $errors[] = 'Slug này đã tồn tại, vui lòng chọn slug khác';
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
        
        $ins = $pdo->prepare('INSERT INTO products (title, slug, category_id, description) VALUES (?, ?, ?, ?)');
        $ins->execute([$title, $slug, $category_id, $description]);
        $productId = $pdo->lastInsertId();
    }

    // Handle image uploads
    $uploadDir = rtrim(UPLOAD_DIR, '\\\/') . DIRECTORY_SEPARATOR . 'products';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    
    // Get current max sort_order
    $maxSort = $pdo->prepare('SELECT MAX(sort_order) as max_sort FROM product_images WHERE product_id = ?');
    $maxSort->execute([$productId]);
    $maxRow = $maxSort->fetch();
    $sort = ($maxRow && $maxRow['max_sort'] !== null) ? $maxRow['max_sort'] + 1 : 0;

    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        for ($i=0; $i<count($_FILES['images']['name']); $i++) {
            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
            $tmp = $_FILES['images']['tmp_name'][$i];
            if (!is_uploaded_file($tmp)) continue;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmp);
            finfo_close($finfo);
            if (!in_array($mime, $allowed)) continue;
            $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
            $safe = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = $uploadDir . DIRECTORY_SEPARATOR . $safe;
            if (move_uploaded_file($tmp, $dest)) {
                $insImg = $pdo->prepare('INSERT INTO product_images (product_id, image_path, sort_order) VALUES (?, ?, ?)');
                $insImg->execute([$productId, $safe, $sort]);
                $sort++;
            }
        }
    }

  // Process images that were marked for deletion in the form (deleted_images[])
  if ($isEditMode && !empty($_POST['deleted_images']) && is_array($_POST['deleted_images'])) {
    $delIds = array_map('intval', $_POST['deleted_images']);
    $select = $pdo->prepare('SELECT id, image_path, product_id FROM product_images WHERE id = ? LIMIT 1');
    $deleteStmt = $pdo->prepare('DELETE FROM product_images WHERE id = ?');
    foreach ($delIds as $delId) {
      $select->execute([$delId]);
      $row = $select->fetch();
      if ($row && intval($row['product_id']) === intval($productId)) {
        $file = $uploadDir . DIRECTORY_SEPARATOR . $row['image_path'];
        if (is_file($file)) @unlink($file);
        $deleteStmt->execute([$delId]);
      }
    }
  }

  header('Location: index.php');
  exit;
}

$pageTitle = $isEdit ? 'Sửa Sản Phẩm' : 'Thêm Sản Phẩm';

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
      <a href="index.php" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/></svg>
        Quay lại danh sách
      </a>
    </div>

    <form method="post" enctype="multipart/form-data" style="max: width 100%;" id="product-form">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <!-- Container for hidden inputs marking images to delete on save -->
      <div id="deleted-images-container"></div>
      
      <div class="form-row">
        <label>Tên Sản Phẩm <span class="required">*</span></label>
        <input type="text" name="title" id="title" required value="<?php echo htmlspecialchars($formData['title'] ?? $product['title'] ?? ''); ?>" minlength="3" maxlength="255">
        <span class="form-error">Tên sản phẩm bắt buộc (3-255 ký tự)</span>
      </div>

      <div class="form-row">
        <label>Slug (URL thân thiện) <span class="required">*</span></label>
        <input type="text" name="slug" id="slug" required value="<?php echo htmlspecialchars($formData['slug'] ?? $product['slug'] ?? ''); ?>">
        <p class="muted">Tự động tạo từ tên sản phẩm (có thể chỉnh sửa)</p>
      </div>

      <div class="form-row">
        <label>Danh Mục <span class="required">*</span></label>
        <div style="display:flex;gap:8px;align-items:flex-start">
          <select name="category_id" id="category_id" required style="flex:1">
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?php echo $cat['id']; ?>" <?php echo ($formData['category_id'] ?? $product['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <button type="button" class="btn" onclick="openQuickAddCategory()" title="Thêm danh mục mới">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/></svg>
          </button>
        </div>
        <span class="form-error">Vui lòng chọn danh mục</span>
      </div>

      <div class="form-row">
        <label>Mô Tả</label>
        <textarea id="description" name="description" rows="10"><?php echo htmlspecialchars($formData['description'] ?? $product['description'] ?? ''); ?></textarea>
      </div>

      <?php if ($isEdit && count($images) > 0): ?>
      <div class="form-section">
        <h3>Hình Ảnh Hiện Tại (<?php echo count($images); ?>)</h3>
        <div class="image-list" id="existing-images">
          <?php foreach ($images as $idx => $im): ?>
            <div class="image-list-item" data-image-id="<?php echo $im['id']; ?>" data-order="<?php echo $im['sort_order']; ?>">
              <div class="image-list-preview">
                <img src="<?php echo rtrim(UPLOAD_URL, '/'); ?>/products/<?php echo rawurlencode($im['image_path']); ?>" alt="">
              </div>
              <div class="image-list-info">
                <div class="image-list-controls">
                  <input type="number" 
                         class="image-sort-input" 
                         value="<?php echo $idx + 1; ?>" 
                         min="1" 
                         max="<?php echo count($images); ?>"
                         data-image-id="<?php echo $im['id']; ?>"
                         title="Thứ tự hiển thị">
                  <div class="image-sort-buttons">
                    <button type="button" class="btn-icon" onclick="moveImageUp(<?php echo $im['id']; ?>)" <?php if($idx === 0) echo 'disabled'; ?> title="Di chuyển lên">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="color:#1d1d1f"><path d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/></svg>
                    </button>
                    <button type="button" class="btn-icon" onclick="moveImageDown(<?php echo $im['id']; ?>)" <?php if($idx === count($images)-1) echo 'disabled'; ?> title="Di chuyển xuống">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="color:#1d1d1f"><path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>
                    </button>
                  </div>
                </div>
                <button type="button" class="btn-danger btn-small" onclick="deleteImage(<?php echo $im['id']; ?>)">
                  <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                  Xóa
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="form-section">
        <h3><?php echo $isEdit ? 'Thêm Hình Ảnh' : 'Hình Ảnh Sản Phẩm'; ?> <?php if(!$isEdit) echo '<span class="required">*</span>'; ?></h3>
        <div class="form-row">
          <input type="file" id="product-images" name="images[]" multiple accept="image/*" <?php if(!$isEdit) echo 'required'; ?>>
          <p class="muted">Chọn nhiều hình ảnh. Sử dụng nút lên/xuống để sắp xếp thứ tự.</p>
        </div>
        <div class="image-list" id="preview-container"></div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>
          <?php echo $isEdit ? 'Cập Nhật' : 'Lưu Sản Phẩm'; ?>
        </button>
        <a href="index.php" class="btn">Hủy</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('description');

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
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
    document.getElementById('product-form').addEventListener('submit', function(e) {
      var title = document.getElementById('title').value.trim();
      var fileInput = document.getElementById('product-images');
      var isEdit = <?php echo $isEdit ? 'true' : 'false'; ?>;

      // Check if images are still loading
      var loadingItems = document.querySelectorAll('.image-list-item.loading');
      if (loadingItems.length > 0) {
        e.preventDefault();
        alert('Vui lòng đợi hình ảnh tải xong (' + loadingItems.length + ' ảnh đang tải)');
        return false;
      }

      // Reset error states
      document.querySelectorAll('.has-error').forEach(function(el) {
        el.classList.remove('has-error');
      });

      var hasError = false;

      // Validate title
      if (title.length < 3) {
        document.getElementById('title').closest('.form-row').classList.add('has-error');
        hasError = true;
      }

      // Validate images for new products
      if (!isEdit && fileInput.files.length === 0) {
        fileInput.closest('.form-row').classList.add('has-error');
        alert('Vui lòng chọn ít nhất một hình ảnh');
        hasError = true;
      }

      if (hasError) {
        e.preventDefault();
        return false;
      }
    });

    // Mark image for deletion but don't call server yet; deletion happens on Save
    function deleteImage(imageId) {
      if (!confirm('Xóa hình ảnh này?')) return;

      // Add hidden input to indicate this image should be deleted on form submit
      var container = document.getElementById('deleted-images-container');
      if (!container) return alert('Không thể xóa hình ảnh (container không tồn tại)');
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'deleted_images[]';
      input.value = imageId;
      container.appendChild(input);

      // Remove the image element from the UI so user sees it as deleted
      var el = document.querySelector('.image-list-item[data-image-id="' + imageId + '"]');
      if (el) el.remove();
    }

    // Image reordering functions
    function moveImageUp(imageId) {
      var items = document.querySelectorAll('.image-list-item');
      var currentIndex = -1;
      
      items.forEach(function(item, idx) {
        if (parseInt(item.dataset.imageId) === imageId) {
          currentIndex = idx;
        }
      });
      
      if (currentIndex > 0) {
        updateImageOrder(imageId, currentIndex); // Move to position currentIndex (0-based, so it goes up)
      }
    }

    function moveImageDown(imageId) {
      var items = document.querySelectorAll('.image-list-item');
      var currentIndex = -1;
      
      items.forEach(function(item, idx) {
        if (parseInt(item.dataset.imageId) === imageId) {
          currentIndex = idx;
        }
      });
      
      if (currentIndex < items.length - 1 && currentIndex >= 0) {
        updateImageOrder(imageId, currentIndex + 2); // Move to position currentIndex + 2 (1-indexed)
      }
    }

    function updateImageOrder(imageId, newOrder) {
      var formData = new FormData();
      formData.append('image_id', imageId);
      formData.append('new_order', newOrder);
      
      fetch('update_image_order.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.message || 'Có lỗi xảy ra');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật thứ tự');
      });
    }

    // Handle manual order input
    document.addEventListener('DOMContentLoaded', function() {
      var orderInputs = document.querySelectorAll('.image-sort-input');
      orderInputs.forEach(function(input) {
        input.addEventListener('change', function() {
          var imageId = parseInt(this.dataset.imageId);
          var newOrder = parseInt(this.value);
          var maxOrder = orderInputs.length;
          
          if (newOrder < 1) {
            this.value = 1;
            newOrder = 1;
          } else if (newOrder > maxOrder) {
            this.value = maxOrder;
            newOrder = maxOrder;
          }
          
          updateImageOrder(imageId, newOrder);
        });
      });
    });

    // Simple image preview with list view and reorder buttons
    (function() {
      var fileInput = document.getElementById('product-images');
      var previewContainer = document.getElementById('preview-container');
      var files = [];
      var imageUrls = {}; // Cache for FileReader results

      if (!fileInput || !previewContainer) return;

      fileInput.addEventListener('change', function(e) {
        files = Array.from(e.target.files);
        renderPreviews();
      });

      function renderPreviews() {
        previewContainer.innerHTML = '';
        
        if (files.length === 0) return;
        
        // Show loading state
        if (files.length > 5) {
          var loadingMsg = document.createElement('p');
          loadingMsg.className = 'muted';
          loadingMsg.textContent = 'Đang tải ' + files.length + ' hình ảnh...';
          loadingMsg.id = 'loading-msg';
          previewContainer.appendChild(loadingMsg);
        }
        
        // Load images progressively to avoid blocking UI
        var loadQueue = [];
        files.forEach(function(file, index) {
          if (!file.type.match('image.*')) return;
          loadQueue.push({ file: file, index: index });
        });
        
        // Process queue with delay to prevent UI freeze
        function processQueue() {
          if (loadQueue.length === 0) {
            var loadingMsg = document.getElementById('loading-msg');
            if (loadingMsg) loadingMsg.remove();
            return;
          }
          
          var item = loadQueue.shift();
          var cacheKey = item.file.name + '_' + item.file.size + '_' + item.file.lastModified;
          
          if (imageUrls[cacheKey]) {
            createListItem(item.index, imageUrls[cacheKey], item.file.name);
            // Process next immediately if cached
            processQueue();
          } else {
            // Create placeholder first
            createListItemPlaceholder(item.index, item.file.name);
            
            var reader = new FileReader();
            reader.onload = function(e) {
              imageUrls[cacheKey] = e.target.result;
              // Replace placeholder with actual image
              updateListItem(item.index, e.target.result);
              // Small delay before next to prevent blocking
              setTimeout(processQueue, 10);
            };
            reader.readAsDataURL(item.file);
          }
        }
        
        processQueue();
        updateFileInput();
      }

      function createListItemPlaceholder(index, fileName) {
        var item = document.createElement('div');
        item.className = 'image-list-item loading';
        item.dataset.index = index;
        item.id = 'preview-item-' + index;
        
        var preview = document.createElement('div');
        preview.className = 'image-list-preview';
        preview.innerHTML = '<div class="image-loading">📷</div>';
        
        var info = document.createElement('div');
        info.className = 'image-list-info';
        info.innerHTML = '<div class="muted">Đang tải...</div>';
        
        item.appendChild(preview);
        item.appendChild(info);
        previewContainer.appendChild(item);
      }

      function updateListItem(index, imageSrc) {
        var item = document.getElementById('preview-item-' + index);
        if (item) {
          item.remove();
        }
        // Create the full list item with actual image
        createListItem(index, imageSrc, files[index].name);
      }

      function createListItem(index, imageSrc, fileName) {
        var item = document.createElement('div');
        item.className = 'image-list-item';
        item.dataset.index = index;
        item.id = 'preview-item-' + index;
        
        // Preview
        var preview = document.createElement('div');
        preview.className = 'image-list-preview';
        var img = document.createElement('img');
        img.src = imageSrc;
        preview.appendChild(img);
        
        // Info area
        var info = document.createElement('div');
        info.className = 'image-list-info';
        
        // Controls
        var controls = document.createElement('div');
        controls.className = 'image-list-controls';
        
        // Order input
        var orderInput = document.createElement('input');
        orderInput.type = 'number';
        orderInput.className = 'image-sort-input';
        orderInput.value = index + 1;
        orderInput.min = 1;
        orderInput.max = files.length;
        orderInput.title = 'Thứ tự hiển thị';
        orderInput.addEventListener('change', function() {
          moveToPosition(index, parseInt(this.value) - 1);
        });
        
        // Button group
        var btnGroup = document.createElement('div');
        btnGroup.className = 'image-sort-buttons';
        
        // Up button
        var upBtn = document.createElement('button');
        upBtn.type = 'button';
        upBtn.className = 'btn-icon';
        upBtn.title = 'Di chuyển lên';
        upBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/></svg>';
        if (index === 0) upBtn.disabled = true;
        upBtn.onclick = function() { moveUp(index); };
        
        // Down button
        var downBtn = document.createElement('button');
        downBtn.type = 'button';
        downBtn.className = 'btn-icon';
        downBtn.title = 'Di chuyển xuống';
        downBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>';
        if (index === files.length - 1) downBtn.disabled = true;
        downBtn.onclick = function() { moveDown(index); };
        
        btnGroup.appendChild(upBtn);
        btnGroup.appendChild(downBtn);
        
        controls.appendChild(orderInput);
        controls.appendChild(btnGroup);
        
        // Delete button
        var deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn-danger btn-small';
        deleteBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg> Xóa';
        deleteBtn.onclick = function() { removeFile(index); };
        
        info.appendChild(controls);
        info.appendChild(deleteBtn);
        
        item.appendChild(preview);
        item.appendChild(info);
        
        // Insert at correct position to maintain order
        var existingItems = previewContainer.querySelectorAll('.image-list-item');
        var inserted = false;
        
        // Remove loading message when inserting first real item
        var loadingMsg = document.getElementById('loading-msg');
        
        for (var i = 0; i < existingItems.length; i++) {
          var existingIndex = parseInt(existingItems[i].dataset.index);
          if (existingIndex > index) {
            previewContainer.insertBefore(item, existingItems[i]);
            inserted = true;
            break;
          }
        }
        
        if (!inserted) {
          // Append after loading message or at end
          if (loadingMsg) {
            previewContainer.insertBefore(item, loadingMsg);
          } else {
            previewContainer.appendChild(item);
          }
        }
      }

      function moveUp(index) {
        if (index > 0) {
          var temp = files[index];
          files[index] = files[index - 1];
          files[index - 1] = temp;
          renderPreviews();
        }
      }

      function moveDown(index) {
        if (index < files.length - 1) {
          var temp = files[index];
          files[index] = files[index + 1];
          files[index + 1] = temp;
          renderPreviews();
        }
      }

      function moveToPosition(fromIndex, toIndex) {
        if (toIndex < 0) toIndex = 0;
        if (toIndex >= files.length) toIndex = files.length - 1;
        if (fromIndex === toIndex) return;
        
        var item = files.splice(fromIndex, 1)[0];
        files.splice(toIndex, 0, item);
        renderPreviews();
      }

      function removeFile(index) {
        if (confirm('Xóa hình ảnh này?')) {
          files.splice(index, 1);
          renderPreviews();
        }
      }

      function updateFileInput() {
        var dt = new DataTransfer();
        files.forEach(function(f) { dt.items.add(f); });
        fileInput.files = dt.files;
      }
    })();

    // Quick add category
    function openQuickAddCategory() {
      var modal = document.getElementById('quick-add-category-modal');
      if (!modal) {
        // Create modal
        modal = document.createElement('div');
        modal.id = 'quick-add-category-modal';
        modal.innerHTML = `
          <div class="modal-overlay" onclick="closeQuickAddCategory()"></div>
          <div class="modal-content">
            <h3>Thêm Danh Mục Mới</h3>
            <form id="quick-category-form" onsubmit="saveQuickCategory(event)">
              <div class="form-row">
                <label>Tên danh mục <span class="required">*</span></label>
                <input type="text" id="quick-cat-name" required>
              </div>
              <div class="form-row">
                <label>Slug</label>
                <input type="text" id="quick-cat-slug" placeholder="Tự động tạo từ tên">
              </div>
              <div class="form-actions">
                <button type="submit" class="btn">Lưu</button>
                <button type="button" class="btn" onclick="closeQuickAddCategory()">Hủy</button>
              </div>
            </form>
          </div>
        `;
        document.body.appendChild(modal);
        
        // Auto-generate slug
        document.getElementById('quick-cat-name').addEventListener('input', function() {
          var slugInput = document.getElementById('quick-cat-slug');
          if (!slugInput.value || slugInput.dataset.auto !== 'false') {
            slugInput.value = slugify(this.value);
            slugInput.dataset.auto = 'true';
          }
        });
        
        document.getElementById('quick-cat-slug').addEventListener('input', function() {
          this.dataset.auto = 'false';
        });
      }
      modal.style.display = 'block';
      document.getElementById('quick-cat-name').focus();
    }

    function closeQuickAddCategory() {
      var modal = document.getElementById('quick-add-category-modal');
      if (modal) {
        modal.style.display = 'none';
        document.getElementById('quick-category-form').reset();
      }
    }

    function saveQuickCategory(e) {
      e.preventDefault();
      
      var name = document.getElementById('quick-cat-name').value.trim();
      var slug = document.getElementById('quick-cat-slug').value.trim() || slugify(name);
      
      if (!name) {
        alert('Vui lòng nhập tên danh mục');
        return;
      }
      
      // Send AJAX request
      var formData = new FormData();
      formData.append('name', name);
      formData.append('slug', slug);
      formData.append('type', 'product');
      formData.append('is_active', '1');
      formData.append('sort_order', '0');
      
      fetch('../categories/quick_add.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Add new option to select
          var select = document.getElementById('category_id');
          var option = document.createElement('option');
          option.value = data.category.id;
          option.text = data.category.name;
          option.selected = true;
          select.appendChild(option);
          
          closeQuickAddCategory();
          alert('Đã thêm danh mục mới!');
        } else {
          alert('Lỗi: ' + (data.message || 'Không thể thêm danh mục'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thêm danh mục');
      });
    }
  </script>
  
  <style>
    #quick-add-category-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 10000;
    }
    .modal-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0,0,0,0.5);
    }
    .modal-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      min-width: 400px;
      max-width: 90%;
    }
    .modal-content h3 {
      margin: 0 0 20px 0;
      color: #1d1d1f;
    }
  </style>
  
  <?php include __DIR__ . '/../_footer.php'; ?>
</body>
</html>
