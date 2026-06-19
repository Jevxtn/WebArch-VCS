<?php
header('Content-Type: application/json');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic input validation
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// --- Brute-force / rate-limit protection via session ---
$attemptKey = 'login_attempts_' . md5($email);
$lockoutKey = 'login_lockout_'  . md5($email);

if (!empty($_SESSION[$lockoutKey]) && $_SESSION[$lockoutKey] > time()) {
    $wait = ceil(($_SESSION[$lockoutKey] - time()) / 60);
    echo json_encode(['success' => false, 'message' => "Too many failed attempts. Please wait {$wait} minute(s) and try again."]);
    exit;
}

// Get user
$stmt = $conn->prepare('SELECT id, username, email, password, full_name FROM users WHERE email = ?');
if (!$stmt) {
    error_log('Prepare fail (login): ' . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
    exit;
}
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Track attempts even for non-existent accounts to prevent enumeration
    $_SESSION[$attemptKey] = ($_SESSION[$attemptKey] ?? 0) + 1;
    if ($_SESSION[$attemptKey] >= 5) {
        $_SESSION[$lockoutKey] = time() + 15 * 60; // 15-minute lockout
        unset($_SESSION[$attemptKey]);
    }
    // Generic message to prevent user enumeration
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

$stmt->bind_result($userId, $username, $userEmail, $hashedPassword, $fullName);
if (!$stmt->fetch() || $hashedPassword === null) {
    error_log('Fetch fail (login): could not load user row for email ' . $email);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
    exit;
}

// Verify password
if (!password_verify($password, $hashedPassword)) {
    $_SESSION[$attemptKey] = ($_SESSION[$attemptKey] ?? 0) + 1;
    if ($_SESSION[$attemptKey] >= 5) {
        $_SESSION[$lockoutKey] = time() + 15 * 60;
        unset($_SESSION[$attemptKey]);
    }
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Successful login — clear attempt counters
unset($_SESSION[$attemptKey], $_SESSION[$lockoutKey]);

// Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Set session data
$_SESSION['user_id']   = $userId;
$_SESSION['username']  = $username;
$_SESSION['email']     = $userEmail;
$_SESSION['full_name'] = $fullName;
$_SESSION['logged_in'] = true;

echo json_encode(['success' => true, 'message' => 'Login successful!', 'redirect' => 'dashboard.html']);
?>
