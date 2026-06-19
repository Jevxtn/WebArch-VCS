<?php
header('Content-Type: application/json');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$username         = trim($_POST['username']         ?? '');
$email            = trim($_POST['email']            ?? '');
$password         = $_POST['password']              ?? '';
$confirm_password = $_POST['confirm_password']      ?? '';
$full_name        = trim($_POST['full_name']        ?? '');
$phone            = trim($_POST['phone']            ?? '');

$errors = [];

if (empty($full_name))               $errors[] = 'Full name is required';
elseif (strlen($full_name) < 2)      $errors[] = 'Full name must be at least 2 characters';
elseif (strlen($full_name) > 100)    $errors[] = 'Full name is too long';

if (empty($username))                $errors[] = 'Username is required';
elseif (strlen($username) < 3)       $errors[] = 'Username must be at least 3 characters';
elseif (strlen($username) > 30)      $errors[] = 'Username cannot exceed 30 characters';
elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors[] = 'Username may only contain letters, numbers, and underscores';

if (empty($email))                   $errors[] = 'Email address is required';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format';
elseif (strlen($email) > 255)        $errors[] = 'Email address is too long';

if (empty($password))                $errors[] = 'Password is required';
elseif (strlen($password) < 8)       $errors[] = 'Password must be at least 8 characters';
elseif (strlen($password) > 128)     $errors[] = 'Password is too long';
elseif (!preg_match('/[A-Z]/', $password)) $errors[] = 'Password needs at least one uppercase letter (A-Z)';
elseif (!preg_match('/[a-z]/', $password)) $errors[] = 'Password needs at least one lowercase letter (a-z)';
elseif (!preg_match('/[0-9]/', $password)) $errors[] = 'Password needs at least one number (0-9)';
elseif (!preg_match('/[^A-Za-z0-9]/', $password)) $errors[] = 'Password needs at least one special character (e.g. !@#$%)';

if (empty($confirm_password))        $errors[] = 'Please confirm your password';
elseif ($password !== $confirm_password) $errors[] = 'Passwords do not match';

if (!empty($phone) && !preg_match('/^\+?[\d\s\-().]{7,20}$/', $phone))
    $errors[] = 'Invalid phone number format';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors) . '.']);
    exit;
}

$stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
if (!$stmt) { error_log('Prepare fail(username): '.$conn->error); echo json_encode(['success'=>false,'message'=>'Server error.']); exit; }
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) { echo json_encode(['success'=>false,'message'=>'Username already taken. Please choose another.']); exit; }
$stmt->close();

$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
if (!$stmt) { error_log('Prepare fail(email): '.$conn->error); echo json_encode(['success'=>false,'message'=>'Server error.']); exit; }
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) { echo json_encode(['success'=>false,'message'=>'An account with this email already exists.']); exit; }
$stmt->close();

$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$stmt = $conn->prepare('INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)');
if (!$stmt) { error_log('Prepare fail(insert): '.$conn->error); echo json_encode(['success'=>false,'message'=>'Server error.']); exit; }
$stmt->bind_param('sssss', $username, $email, $hashed, $full_name, $phone);
if (!$stmt->execute()) { error_log('Insert fail: '.$stmt->error); echo json_encode(['success'=>false,'message'=>'Could not create account.']); exit; }
$user_id = $stmt->insert_id;
$stmt->close();

$cats = [
    ['Food & Dining','#FF6B6B','utensils'],  ['Transportation','#4ECDC4','car'],
    ['Entertainment','#FFE66D','film'],       ['Utilities','#95E1D3','lightbulb'],
    ['Health & Medical','#FF6B9D','heart'],   ['Shopping','#C06C84','shopping-bag'],
    ['Education','#6C5B7B','book'],           ['Other','#A8DADC','tag']
];
$cs = $conn->prepare('INSERT INTO categories (user_id, name, color, icon) VALUES (?, ?, ?, ?)');
if ($cs) {
    foreach ($cats as [$n,$c,$i]) { $cs->bind_param('isss',$user_id,$n,$c,$i); $cs->execute(); }
    $cs->close();
}

echo json_encode(['success' => true, 'message' => 'Account created successfully! Redirecting to login.']);
?>
