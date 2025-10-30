<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Sai username hoặc password';
    }
}
?>
<!doctype html>
<html>
<head>
  <?php include __DIR__ . '/_head.php'; ?>
  <title>Đăng Nhập - Admin</title>
</head>
<body>
  <div class="admin-container" style="max-width:400px">
  <h2>Đăng Nhập Quản Trị</h2>
  <?php if ($error) echo '<p style="color:#ff3b30;background:#fee;padding:12px;border-radius:8px;border:1px solid #fcc">' . htmlspecialchars($error) . '</p>'; ?>
  <form method="post">
    <div class="form-row">
      <label>Tên Đăng Nhập</label>
      <input name="username" required>
    </div>
    <div class="form-row">
      <label>Mật Khẩu</label>
      <input name="password" type="password" required>
    </div>
    <div class="form-row">
      <button type="submit" class="btn" style="width:100%">Đăng Nhập</button>
    </div>
    <p class="muted" style="text-align:center">Mặc định: admin / admin123</p>
  </form>
  </div>
  <?php include __DIR__ . '/_footer.php'; ?>
</body>
</html>
