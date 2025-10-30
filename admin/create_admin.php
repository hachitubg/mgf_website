<?php
// Script để tạo lại tài khoản admin
require_once '../includes/db.php';

// Xóa user cũ nếu có
$pdo->exec("DELETE FROM users WHERE username = 'admin'");

// Tạo mật khẩu mới
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user mới
$stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->execute(['admin', $hash]);

echo "✅ Tạo tài khoản thành công!<br>";
echo "Username: <strong>admin</strong><br>";
echo "Password: <strong>admin123</strong><br>";
echo "<br><a href='login.php'>→ Đăng nhập ngay</a>";
