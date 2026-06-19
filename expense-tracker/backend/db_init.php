<?php
// Include config
include 'config.php';

// Create tables
$tables = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS categories (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        name VARCHAR(50) NOT NULL,
        description TEXT,
        color VARCHAR(7) DEFAULT '#007BFF',
        icon VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS expenses (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        category_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        description VARCHAR(255),
        date DATE NOT NULL,
        payment_method VARCHAR(50),
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
        INDEX idx_user_date (user_id, date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS invoices (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        expense_id INT,
        file_name VARCHAR(255) NOT NULL,
        file_path VARCHAR(500) NOT NULL,
        file_size INT,
        file_type VARCHAR(50),
        invoice_number VARCHAR(50),
        vendor_name VARCHAR(100),
        invoice_date DATE,
        total_amount DECIMAL(10, 2),
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (expense_id) REFERENCES expenses(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS budgets (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        category_id INT,
        amount DECIMAL(10, 2) NOT NULL,
        month INT NOT NULL,
        year INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($tables as $table_sql) {
    if ($conn->query($table_sql) === TRUE) {
        echo "Table created/verified successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Insert default categories if none exist
$check_categories = $conn->query("SELECT COUNT(*) as count FROM categories LIMIT 1");
if ($check_categories === FALSE) {
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
}

echo "Database initialization complete!";
?>
