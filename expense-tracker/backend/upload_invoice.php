<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $expense_id = isset($_POST['expense_id']) ? (int)$_POST['expense_id'] : null;
    $vendor_name = trim($_POST['vendor_name'] ?? '');
    $invoice_number = trim($_POST['invoice_number'] ?? '');
    $invoice_date = $_POST['invoice_date'] ?? date('Y-m-d');
    $total_amount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;

    // Validation
    if (empty($_FILES['invoice_file']['name'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        exit;
    }

    $file = $_FILES['invoice_file'];
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Only PDF and image files are allowed']);
        exit;
    }

    if ($file['size'] > $max_size) {
        echo json_encode(['success' => false, 'message' => 'File size must not exceed 5MB']);
        exit;
    }

    // Create unique filename
    $upload_dir = '../uploads/invoices/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = 'invoice_' . $user_id . '_' . time() . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;

    if (!move_uploaded_file($file['tmp_name'], $file_path)) {
        echo json_encode(['success' => false, 'message' => 'Error uploading file']);
        exit;
    }

    // Insert invoice record
    $stmt = $conn->prepare("INSERT INTO invoices (user_id, expense_id, file_name, file_path, file_size, file_type, vendor_name, invoice_number, invoice_date, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $file_size = $file['size'];
    $file_type = $file['type'];
    
    $stmt->bind_param("iissiisssd", $user_id, $expense_id, $file_name, $file_path, $file_size, $file_type, $vendor_name, $invoice_number, $invoice_date, $total_amount);

    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id;
        echo json_encode(['success' => true, 'message' => 'Invoice uploaded successfully', 'invoice_id' => $invoice_id]);
    } else {
        unlink($file_path);
        echo json_encode(['success' => false, 'message' => 'Error saving invoice: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
