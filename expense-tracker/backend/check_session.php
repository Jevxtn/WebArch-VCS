<?php
header('Content-Type: application/json');
include 'config.php';

if (isset($_SESSION['user_id']) && $_SESSION['logged_in'] === true) {
    echo json_encode([
        'success'   => true,
        'user_id'   => $_SESSION['user_id'],
        'username'  => $_SESSION['username'],
        'full_name' => $_SESSION['full_name'] ?? '',
        'email'     => $_SESSION['email']     ?? '',
    ]);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
}
?>
