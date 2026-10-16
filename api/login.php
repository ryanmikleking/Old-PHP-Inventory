<?php

require_once __DIR__. '/../config/database.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare(
    'SELECT * FROM users WHERE email = :email'
);

$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    echo json_encode([
        'success' => False,
        'message' => 'Email or password is incorrect',
    ]);

    exit;
}
echo json_encode([
    'success' => True,
    'message' => __DIR__,
]);