<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$expense_id = isset($_GET['expense_id']) ? (int)$_GET['expense_id'] : null;

$query = "SELECT id, file_name, file_path, vendor_name, invoice_number, invoice_date, total_amount, uploaded_at FROM invoices WHERE user_id = ?";

if ($expense_id) {
    $query .= " AND expense_id = $expense_id";
}

$query .= " ORDER BY uploaded_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$invoices = [];
while ($row = $result->fetch_assoc()) {
    $invoices[] = $row;
}

echo json_encode(['success' => true, 'invoices' => $invoices]);
?>
