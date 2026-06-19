<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$expense_id = isset($_GET['expense_id']) ? (int)$_GET['expense_id'] : null;

if ($expense_id) {
    $query = "SELECT id, file_name, file_path, vendor_name, invoice_number, invoice_date, total_amount, uploaded_at FROM invoices WHERE user_id = ? AND expense_id = ? ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $expense_id);
} else {
    $query = "SELECT id, file_name, file_path, vendor_name, invoice_number, invoice_date, total_amount, uploaded_at FROM invoices WHERE user_id = ? ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();

$invoices = [];
$stmt->bind_result($id, $file_name, $file_path, $vendor_name, $invoice_number, $invoice_date, $total_amount, $uploaded_at);
while ($stmt->fetch()) {
    $invoices[] = [
        'id' => (int)$id,
        'file_name' => $file_name,
        'file_path' => $file_path,
        'vendor_name' => $vendor_name,
        'invoice_number' => $invoice_number,
        'invoice_date' => $invoice_date,
        'total_amount' => $total_amount !== null ? (float)$total_amount : null,
        'uploaded_at' => $uploaded_at,
    ];
}

echo json_encode(['success' => true, 'invoices' => $invoices]);
?>
