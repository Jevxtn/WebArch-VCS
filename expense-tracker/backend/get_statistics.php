<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';

$date_filter = '';
switch ($filter) {
    case 'week':
        $date_filter = "AND e.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case 'month':
        $date_filter = "AND YEAR(e.date) = YEAR(CURDATE()) AND MONTH(e.date) = MONTH(CURDATE())";
        break;
    case 'year':
        $date_filter = "AND YEAR(e.date) = YEAR(CURDATE())";
        break;
}

// Total spent
$query = "SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE user_id = ? $date_filter";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_result = $stmt->get_result()->fetch_assoc();

// By category
$query = "SELECT c.name, c.color, SUM(e.amount) as total FROM expenses e 
          LEFT JOIN categories c ON e.category_id = c.id 
          WHERE e.user_id = ? $date_filter 
          GROUP BY e.category_id ORDER BY total DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$category_result = $stmt->get_result();

$by_category = [];
while ($row = $category_result->fetch_assoc()) {
    $by_category[] = $row;
}

// Daily average
$query = "SELECT COUNT(DISTINCT DATE(e.date)) as days FROM expenses WHERE user_id = ? $date_filter";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$days_result = $stmt->get_result()->fetch_assoc();

$average = $days_result['days'] > 0 ? $total_result['total'] / $days_result['days'] : 0;

// Recent expenses
$query = "SELECT e.amount, e.description, e.date, c.name as category_name FROM expenses e 
          LEFT JOIN categories c ON e.category_id = c.id 
          WHERE e.user_id = ? $date_filter 
          ORDER BY e.date DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recent_result = $stmt->get_result();

$recent = [];
while ($row = $recent_result->fetch_assoc()) {
    $recent[] = $row;
}

echo json_encode([
    'success' => true,
    'total' => round($total_result['total'], 2),
    'daily_average' => round($average, 2),
    'by_category' => $by_category,
    'recent' => $recent
]);
?>
