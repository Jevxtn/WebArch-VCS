<?php
header('Content-Type: application/json');
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $description = trim($_POST['description'] ?? '');
    $date = $_POST['date'] ?? date('Y-m-d');
    $payment_method = trim($_POST['payment_method'] ?? 'cash');
    $notes = trim($_POST['notes'] ?? '');

    // Validation
    $errors = [];
    if ($amount <= 0) $errors[] = 'Amount must be greater than 0';
    if (empty($category_id)) $errors[] = 'Category is required';
    if (empty($description)) $errors[] = 'Description is required';

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    // Verify category belongs to user
    $stmt = $conn->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $category_id, $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid category']);
        exit;
    }

    // Insert expense
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, category_id, amount, description, date, payment_method, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidssss", $user_id, $category_id, $amount, $description, $date, $payment_method, $notes);

    if ($stmt->execute()) {
        $expense_id = $stmt->insert_id;
        echo json_encode(['success' => true, 'message' => 'Expense added successfully', 'expense_id' => $expense_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding expense: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
