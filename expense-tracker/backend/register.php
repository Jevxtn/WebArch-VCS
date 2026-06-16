<?php
header('Content-Type: application/json');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Validation
    $errors = [];

    if (empty($username)) $errors[] = 'Username is required';
    if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format';
    if (empty($password)) $errors[] = 'Password is required';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match';
    if (empty($full_name)) $errors[] = 'Full name is required';

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $full_name, $phone);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        
        // Create default categories for user
        $default_categories = [
            ['name' => 'Food & Dining', 'color' => '#FF6B6B', 'icon' => 'utensils'],
            ['name' => 'Transportation', 'color' => '#4ECDC4', 'icon' => 'car'],
            ['name' => 'Entertainment', 'color' => '#FFE66D', 'icon' => 'film'],
            ['name' => 'Utilities', 'color' => '#95E1D3', 'icon' => 'lightbulb'],
            ['name' => 'Health & Medical', 'color' => '#FF6B9D', 'icon' => 'heart'],
            ['name' => 'Shopping', 'color' => '#C06C84', 'icon' => 'shopping-bag'],
            ['name' => 'Education', 'color' => '#6C5B7B', 'icon' => 'book'],
            ['name' => 'Other', 'color' => '#A8DADC', 'icon' => 'tag']
        ];

        foreach ($default_categories as $category) {
            $cat_stmt = $conn->prepare("INSERT INTO categories (user_id, name, color, icon) VALUES (?, ?, ?, ?)");
            $cat_stmt->bind_param("isss", $user_id, $category['name'], $category['color'], $category['icon']);
            $cat_stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Registration successful! Please login.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating account: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
