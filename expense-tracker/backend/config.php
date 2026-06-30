<?php
// ── Database Configuration ──────────────────────────────────────────
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USERNAME') ?: (getenv('DB_USER') ?: 'root');
$dbPass = getenv('DB_PASSWORD') ?: (getenv('DB_PASS') ?: '');
$dbName = getenv('DB_DATABASE') ?: (getenv('DB_NAME') ?: 'expense_tracker');

define('DB_HOST', $dbHost);
define('DB_USER', $dbUser);
define('DB_PASS', $dbPass);
define('DB_NAME', $dbName);

// Never expose PHP errors to the client
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Keep mysqli from throwing uncaught exceptions that would break JSON responses.
mysqli_report(MYSQLI_REPORT_OFF);

// Local-dev CORS support for cases where auth pages are served from another localhost origin.
$allowed_origins = [
    'http://localhost',
    'http://127.0.0.1',
    'http://localhost:5500',
    'http://127.0.0.1:5500',
];

if (!empty($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins, true)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Vary: Origin');
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ── Connection ───────────────────────────────────────────────────────
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    error_log('DB connection failed: ' . $conn->connect_error);
    die(json_encode(['success' => false, 'message' => 'Database connection error. Please try again later.']));
}

// Create database if it doesn't exist yet
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    error_log('Error creating database: ' . $conn->error);
    die(json_encode(['success' => false, 'message' => 'Database setup error. Please try again later.']));
}

$conn->select_db(DB_NAME);
$conn->set_charset("utf8mb4");

// ── Auto-create tables on first run ──────────────────────────────────
$setup_queries = [
    "CREATE TABLE IF NOT EXISTS users (
        id          INT PRIMARY KEY AUTO_INCREMENT,
        username    VARCHAR(50)  UNIQUE NOT NULL,
        email       VARCHAR(255) UNIQUE NOT NULL,
        password    VARCHAR(255) NOT NULL,
        full_name   VARCHAR(100) NOT NULL,
        phone       VARCHAR(20),
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS categories (
        id          INT PRIMARY KEY AUTO_INCREMENT,
        user_id     INT NOT NULL,
        name        VARCHAR(50) NOT NULL,
        description TEXT,
        color       VARCHAR(7) DEFAULT '#6366f1',
        icon        VARCHAR(50),
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS expenses (
        id             INT PRIMARY KEY AUTO_INCREMENT,
        user_id        INT NOT NULL,
        category_id    INT,
        amount         DECIMAL(10,2) NOT NULL,
        description    VARCHAR(255),
        date           DATE NOT NULL,
        payment_method VARCHAR(50),
        notes          TEXT,
        created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)     REFERENCES users(id)      ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
        INDEX idx_user_date (user_id, date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS invoices (
        id             INT PRIMARY KEY AUTO_INCREMENT,
        user_id        INT NOT NULL,
        expense_id     INT,
        file_name      VARCHAR(255) NOT NULL,
        file_path      VARCHAR(500) NOT NULL,
        file_size      INT,
        file_type      VARCHAR(50),
        invoice_number VARCHAR(50),
        vendor_name    VARCHAR(100),
        invoice_date   DATE,
        total_amount   DECIMAL(10,2),
        uploaded_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
        FOREIGN KEY (expense_id) REFERENCES expenses(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS budgets (
        id          INT PRIMARY KEY AUTO_INCREMENT,
        user_id     INT NOT NULL,
        category_id INT,
        amount      DECIMAL(10,2) NOT NULL,
        month       INT NOT NULL,
        year        INT NOT NULL,
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)     REFERENCES users(id)      ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($setup_queries as $q) {
    if (!$conn->query($q)) {
        error_log('Table setup error: ' . $conn->error . ' | Query: ' . $q);
    }
}

// ── Legacy Schema Repair ────────────────────────────────────────────
function column_exists(mysqli $conn, string $table, string $column): bool {
    $sql = "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = ? AND table_name = ? AND column_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log('Schema check prepare failed: ' . $conn->error);
        return false;
    }
    $db = DB_NAME;
    $stmt->bind_param('sss', $db, $table, $column);
    if (!$stmt->execute()) {
        error_log('Schema check execute failed: ' . $stmt->error);
        $stmt->close();
        return false;
    }
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return ((int)$count) > 0;
}

function index_exists(mysqli $conn, string $table, string $index): bool {
    $sql = "SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log('Index check prepare failed: ' . $conn->error);
        return false;
    }
    $db = DB_NAME;
    $stmt->bind_param('sss', $db, $table, $index);
    if (!$stmt->execute()) {
        error_log('Index check execute failed: ' . $stmt->error);
        $stmt->close();
        return false;
    }
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return ((int)$count) > 0;
}

function run_migration(mysqli $conn, string $sql): void {
    if (!$conn->query($sql)) {
        error_log('Schema migration failed: ' . $conn->error . ' | SQL: ' . $sql);
    }
}

// users table compatibility
if (!column_exists($conn, 'users', 'email')) {
    run_migration($conn, "ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL AFTER username");
}
if (!column_exists($conn, 'users', 'full_name')) {
    run_migration($conn, "ALTER TABLE users ADD COLUMN full_name VARCHAR(100) NULL AFTER password");
}
if (!column_exists($conn, 'users', 'phone')) {
    run_migration($conn, "ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL AFTER full_name");
}
if (!column_exists($conn, 'users', 'updated_at')) {
    run_migration($conn, "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
}

// Backfill required users values so NOT NULL + unique constraints can be applied safely.
run_migration($conn, "UPDATE users SET email = CONCAT('user', id, '@local.expensetracker') WHERE email IS NULL OR email = ''");
run_migration($conn, "UPDATE users SET full_name = username WHERE full_name IS NULL OR full_name = ''");
run_migration($conn, "ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NOT NULL");
run_migration($conn, "ALTER TABLE users MODIFY COLUMN full_name VARCHAR(100) NOT NULL");
if (!index_exists($conn, 'users', 'users_email_unique')) {
    run_migration($conn, "ALTER TABLE users ADD UNIQUE KEY users_email_unique (email)");
}

// categories table compatibility
if (!column_exists($conn, 'categories', 'color')) {
    run_migration($conn, "ALTER TABLE categories ADD COLUMN color VARCHAR(7) DEFAULT '#6366f1' AFTER description");
}
if (!column_exists($conn, 'categories', 'icon')) {
    run_migration($conn, "ALTER TABLE categories ADD COLUMN icon VARCHAR(50) NULL AFTER color");
}

// expenses table compatibility
if (!column_exists($conn, 'expenses', 'date')) {
    run_migration($conn, "ALTER TABLE expenses ADD COLUMN date DATE NULL AFTER description");
}
if (!column_exists($conn, 'expenses', 'updated_at')) {
    run_migration($conn, "ALTER TABLE expenses ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
}

// Backfill missing dates from created_at where available, then enforce NOT NULL.
run_migration($conn, "UPDATE expenses SET date = DATE(created_at) WHERE (date IS NULL OR date = '0000-00-00') AND created_at IS NOT NULL");
run_migration($conn, "UPDATE expenses SET date = CURDATE() WHERE date IS NULL OR date = '0000-00-00'");
run_migration($conn, "ALTER TABLE expenses MODIFY COLUMN date DATE NOT NULL");

// ── Session ──────────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') ||
        (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
    );

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
?>
