<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // all, today, week, month

$date_filter = '';
switch ($filter) {
    case 'today':
        $date_filter = "AND e.date = CURDATE()";
        break;
    case 'week':
        $date_filter = "AND e.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case 'month':
        $date_filter = "AND YEAR(e.date) = YEAR(CURDATE()) AND MONTH(e.date) = MONTH(CURDATE())";
        break;
    case 'custom':
        // Validate and sanitize dates before embedding in query
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : date('Y-m-t');
        // Reject anything that isn't a valid YYYY-MM-DD date
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date) || !strtotime($start_date)) $start_date = date('Y-m-01');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)   || !strtotime($end_date))   $end_date   = date('Y-m-t');
        $date_filter = "AND e.date BETWEEN '$start_date' AND '$end_date'";
        break;
}

$query = "SELECT e.id, e.category_id, e.amount, e.description, e.date, e.payment_method, e.notes, c.name as category_name, c.color, c.icon 
          FROM expenses e 
          LEFT JOIN categories c ON e.category_id = c.id 
          WHERE e.user_id = ? $date_filter 
          ORDER BY e.date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$expenses = [];
$stmt->bind_result(
    $id,
    $category_id,
    $amount,
    $description,
    $date,
    $payment_method,
    $notes,
    $category_name,
    $color,
    $icon
);

while ($stmt->fetch()) {
    $expenses[] = [
        'id' => (int)$id,
        'category_id' => $category_id !== null ? (int)$category_id : null,
        'amount' => (float)$amount,
        'description' => $description,
        'date' => $date,
        'payment_method' => $payment_method,
        'notes' => $notes,
        'category_name' => $category_name,
        'color' => $color,
        'icon' => $icon,
    ];
}

echo json_encode(['success' => true, 'expenses' => $expenses]);
?>
