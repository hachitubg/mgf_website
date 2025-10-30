<?php
require_once __DIR__ . '/../_auth.php';
require_once __DIR__ . '/../../includes/db.php';

// Handle search and filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Get categories for filter
$categoriesStmt = $pdo->prepare('SELECT * FROM categories WHERE type = ? ORDER BY name ASC');
$categoriesStmt->execute(['product']);
$categories = $categoriesStmt->fetchAll();

// Fetch products with image count
$sql = "SELECT p.*, COUNT(pi.id) AS images_count, c.name as category_name
        FROM products p
        LEFT JOIN product_images pi ON p.id = pi.product_id
        LEFT JOIN categories c ON p.category_id = c.id";

$where = [];
$params = [];

if ($search !== '') {
    $where[] = "(p.title LIKE :search OR p.description LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if ($categoryFilter > 0) {
    $where[] = "p.category_id = :category";
    $params[':category'] = $categoryFilter;
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " GROUP BY p.id
          ORDER BY p.display_order ASC, p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <?php include __DIR__ . '/../_head.php'; ?>
  <title>Quản Lý Sản Phẩm - Admin</title>
  <style>
    .product-row {
      cursor: move;
      transition: background-color 0.2s;
    }
    .product-row:hover {
      background-color: #f5f5f7;
    }
    .product-row.dragging {
      opacity: 0.5;
      background-color: #e8e8ed;
    }
    .drag-handle {
      cursor: grab;
      padding: 4px;
      display: inline-flex;
      align-items: center;
      color: #86868b;
    }
    .drag-handle:active {
      cursor: grabbing;
    }
    .order-number {
      font-weight: 600;
      color: #1d1d1f;
      min-width: 30px;
      text-align: center;
    }
    .save-order-btn {
      position: fixed;
      bottom: 24px;
      right: 24px;
      padding: 12px 24px;
      background: #0071e3;
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(0,113,227,0.3);
      cursor: pointer;
      display: none;
      z-index: 1000;
    }
    .save-order-btn:hover {
      background: #0077ed;
    }
    .save-order-btn.show {
      display: block;
      animation: slideUp 0.3s ease;
    }
    @keyframes slideUp {
      from { transform: translateY(100px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>
  <div class="admin-container">
  <h1>Quản Lý Sản Phẩm</h1>
  <?php include __DIR__ . '/../_nav.php'; ?>
  
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;gap:16px;flex-wrap:wrap">
    <a href="form.php" class="btn">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
      Thêm Sản Phẩm
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
      <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($search); ?>" style="flex:1;min-width:200px;padding:8px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px">
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
      <tr><th style="width:40px">Sắp xếp</th><th>Tên Sản Phẩm</th><th>Danh Mục</th><th>Giá</th><th>Khuyến Mãi</th><th>Hình</th><th>Ngày Tạo</th><th>Hành Động</th></tr>
    </thead>
    <tbody id="products-tbody">
    <?php foreach ($products as $index => $p): ?>
      <tr class="product-row" data-id="<?php echo $p['id']; ?>" draggable="true">
        <td class="order-number"><?php echo $index + 1; ?></td>
        <td>
          <span class="drag-handle">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
              <path d="M5 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm6 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM5 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm6 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM5 11a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm6 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
          </span>
        </td>
        <td><?php echo htmlspecialchars($p['title'] ?: '(Chưa có tên)'); ?></td>
        <td><?php echo $p['category_name'] ? htmlspecialchars($p['category_name']) : '<span class="muted">Chưa phân loại</span>'; ?></td>
        <td><?php echo number_format($p['price'], 0, ',', '.') . ' VNĐ'; ?></td>
        <td><?php echo isset($p['promo_price']) && $p['promo_price']!==null ? number_format($p['promo_price'], 0, ',', '.') . ' VNĐ' : '-'; ?></td>
        <td><?php echo $p['images_count']; ?></td>
        <td><?php echo date('d/m/Y H:i', strtotime($p['created_at'])); ?></td>
        <td>
          <a href="form.php?id=<?php echo $p['id']; ?>">Sửa</a>
          <a href="delete.php?id=<?php echo $p['id']; ?>" class="danger" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  
  <?php if (count($products) === 0): ?>
    <div style="text-align:center;padding:48px;color:#86868b">
      <?php if ($search): ?>
        <p>Không tìm thấy sản phẩm với từ khóa "<?php echo htmlspecialchars($search); ?>"</p>
        <a href="index.php" class="btn" style="margin-top:16px">Xem tất cả</a>
      <?php else: ?>
        <p>Chưa có sản phẩm nào. Hãy tạo sản phẩm đầu tiên!</p>
        <a href="form.php" class="btn" style="margin-top:16px">Thêm Sản Phẩm</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  
  <button class="save-order-btn" id="saveOrderBtn" onclick="saveOrder()">
    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle">
      <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
    </svg>
    Lưu Thứ Tự
  </button>
  
  </div>
  <?php include __DIR__ . '/../_footer.php'; ?>
  
  <script>
  let draggedElement = null;
  let hasChanges = false;
  
  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.product-row');
    const saveBtn = document.getElementById('saveOrderBtn');
    
    rows.forEach(row => {
      row.addEventListener('dragstart', handleDragStart);
      row.addEventListener('dragover', handleDragOver);
      row.addEventListener('drop', handleDrop);
      row.addEventListener('dragend', handleDragEnd);
    });
    
    function handleDragStart(e) {
      draggedElement = this;
      this.classList.add('dragging');
      e.dataTransfer.effectAllowed = 'move';
    }
    
    function handleDragOver(e) {
      if (e.preventDefault) {
        e.preventDefault();
      }
      e.dataTransfer.dropEffect = 'move';
      
      const afterElement = getDragAfterElement(e.currentTarget.parentNode, e.clientY);
      if (afterElement == null) {
        e.currentTarget.parentNode.appendChild(draggedElement);
      } else {
        e.currentTarget.parentNode.insertBefore(draggedElement, afterElement);
      }
      
      return false;
    }
    
    function handleDrop(e) {
      if (e.stopPropagation) {
        e.stopPropagation();
      }
      updateOrderNumbers();
      hasChanges = true;
      saveBtn.classList.add('show');
      return false;
    }
    
    function handleDragEnd(e) {
      this.classList.remove('dragging');
    }
    
    function getDragAfterElement(container, y) {
      const draggableElements = [...container.querySelectorAll('.product-row:not(.dragging)')];
      
      return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        
        if (offset < 0 && offset > closest.offset) {
          return { offset: offset, element: child };
        } else {
          return closest;
        }
      }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
    
    function updateOrderNumbers() {
      const rows = document.querySelectorAll('.product-row');
      rows.forEach((row, index) => {
        const orderCell = row.querySelector('.order-number');
        if (orderCell) {
          orderCell.textContent = index + 1;
        }
      });
    }
  });
  
  function saveOrder() {
    const rows = document.querySelectorAll('.product-row');
    const order = Array.from(rows).map(row => row.dataset.id);
    
    const saveBtn = document.getElementById('saveOrderBtn');
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle;animation:spin 1s linear infinite"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="2" fill="none" opacity="0.25"/><path d="M15 8a7 7 0 0 0-7-7" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/></svg>Đang lưu...';
    
    fetch('reorder.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ order: order })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>Đã lưu!';
        setTimeout(() => {
          saveBtn.classList.remove('show');
          saveBtn.disabled = false;
          saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>Lưu Thứ Tự';
          hasChanges = false;
        }, 2000);
      } else {
        alert('Lỗi: ' + data.message);
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>Lưu Thứ Tự';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Có lỗi xảy ra khi lưu thứ tự');
      saveBtn.disabled = false;
      saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right:8px;vertical-align:middle"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>Lưu Thứ Tự';
    });
  }
  </script>
  
  <style>
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  </style>
</body>
</html>