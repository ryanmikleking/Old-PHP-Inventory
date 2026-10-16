<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => "Method not allowed."
    ]);
    exit;
}
require_once __DIR__. '/../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = strtolower(trim($data['email'] ?? ''));
$password = $data['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

if (!is_string($password) || strlen($password) < 8) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Password must be at least 8 characters long.'
    ]);
    exit;
}

try {
    $check_user = $pdo->prepare(
        'SELECT 1 FROM users WHERE LOWER(email) = :email LIMIT 1'
    );

    $check_user->execute(['email' => $email]);

    if ($check_user->fetchColumn()) {
        http_response_code(409);
        echo json_encode([
            'success'=>false,
            'message'=>'An account with this email already exists.'
        ]);
        exit;
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $createUser = $pdo->prepare(
        'INSERT INTO users (email, password_hash, created_at)
        VALUES (:email, :password_hash, NOW())'
    );
    $createUser->execute([
        'email' => $email,
        'password_hash' => $passwordHash
    ]);
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'User created successfully.'
    ]);

} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'An account with this email already exists'
        ]);
        exit;
    }

    error_log('User creation failed: ' . $e->getMessage());

    http_response_code(500);
    echo json_encocde([
        'success' => false,
        'message' => 'Unable to create the account right now.' 
    ]);
}