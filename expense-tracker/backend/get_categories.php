<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, name, color, icon FROM categories WHERE user_id = ? ORDER BY name");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$categories = [];
$stmt->bind_result($id, $name, $color, $icon);
while ($stmt->fetch()) {
    $categories[] = [
        'id' => (int)$id,
        'name' => $name,
        'color' => $color,
        'icon' => $icon,
    ];
}

echo json_encode(['success' => true, 'categories' => $categories]);
?>
