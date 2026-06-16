<?php
header('Content-Type: application/json');
include 'config.php';

session_destroy();
echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
?>
