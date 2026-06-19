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
$query = "SELECT COALESCE(SUM(e.amount), 0) as total FROM expenses e WHERE e.user_id = ? $date_filter";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_value);
$stmt->fetch();
$stmt->close();
$total_result = ['total' => (float)$total_value];

// By category
$query = "SELECT c.name, c.color, SUM(e.amount) as total FROM expenses e 
          LEFT JOIN categories c ON e.category_id = c.id 
          WHERE e.user_id = ? $date_filter 
          GROUP BY e.category_id ORDER BY total DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$by_category = [];
$stmt->bind_result($cat_name, $cat_color, $cat_total);
while ($stmt->fetch()) {
    $by_category[] = [
        'name' => $cat_name ?: 'Uncategorized',
        'color' => $cat_color ?: '#64748b',
        'total' => (float)$cat_total,
    ];
}
$stmt->close();

// Transaction count
$query = "SELECT COUNT(*) as count FROM expenses e WHERE e.user_id = ? $date_filter";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($count_value);
$stmt->fetch();
$stmt->close();
$count_result = ['count' => (int)$count_value];

// Daily average
$query = "SELECT COUNT(DISTINCT DATE(e.date)) as days FROM expenses e WHERE e.user_id = ? $date_filter";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($days_value);
$stmt->fetch();
$stmt->close();
$days_result = ['days' => (int)$days_value];

$average = $days_result['days'] > 0 ? $total_result['total'] / $days_result['days'] : 0;

// Recent expenses
$query = "SELECT e.amount, e.description, e.date, c.name as category_name FROM expenses e 
          LEFT JOIN categories c ON e.category_id = c.id 
          WHERE e.user_id = ? $date_filter 
          ORDER BY e.date DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$recent = [];
$stmt->bind_result($recent_amount, $recent_description, $recent_date, $recent_category_name);
while ($stmt->fetch()) {
    $recent[] = [
        'amount' => (float)$recent_amount,
        'description' => $recent_description,
        'date' => $recent_date,
        'category_name' => $recent_category_name,
    ];
}
$stmt->close();

echo json_encode([
    'success'       => true,
    'total'         => round($total_result['total'], 2),
    'daily_average' => round($average, 2),
    'count'         => (int)$count_result['count'],
    'by_category'   => $by_category,
    'recent'        => $recent
]);
?>
