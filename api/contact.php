<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Vui lòng nhập họ tên';
}

if (empty($email)) {
    $errors[] = 'Vui lòng nhập email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

if (empty($phone)) {
    $errors[] = 'Vui lòng nhập số điện thoại';
}

if (empty($message)) {
    $errors[] = 'Vui lòng nhập nội dung tin nhắn';
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng kiểm tra lại thông tin',
        'errors' => $errors
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $subject, $message]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
    ]);
}
