# 💰 Expense-Tracker

A simple and intuitive expense tracking application built with **PHP**, **HTML**, and **CSS**. Track your daily expenses, categorize spending, and manage your finances efficiently.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation & Setup](#installation--setup)
- [Database Configuration](#database-configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

- ✅ Add, edit, and delete expenses
- ✅ Categorize expenses (Food, Transport, Entertainment, etc.)
- ✅ View expense summary and totals
- ✅ Date-wise expense tracking
- ✅ Simple and clean user interface
- ✅ Responsive design with HTML & CSS

---

## 🛠 Tech Stack

- **Backend:** PHP
- **Frontend:** HTML, CSS
- **Database:** MySQL (via XAMPP)
- **Server:** Apache (via XAMPP)

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **XAMPP** (Apache + MySQL) - [Download here](https://www.apachefriends.org/)
- **Git** - [Download here](https://git-scm.com/)
- **Text Editor or IDE** (VS Code, Sublime Text, etc.)

---

## 🚀 Installation & Setup

### Step 1: Install XAMPP

1. Download **XAMPP** from [apachefriends.org](https://www.apachefriends.org/)
2. Install XAMPP on your system
3. Open **XAMPP Control Panel** and start:
   - **Apache** (web server)
   - **MySQL** (database server)

### Step 2: Clone the Repository

Open your terminal/command prompt and run:

```bash
git clone https://github.com/Jevxtn/Expense-Tracker.git
```

### Step 3: Move Project to XAMPP

Move the cloned folder to XAMPP's `htdocs` directory:

**On Windows:**
```
C:\xampp\htdocs\Expense-Tracker
```

**On macOS:**
```
/Applications/XAMPP/xamppfiles/htdocs/Expense-Tracker
```

**On Linux:**
```
/opt/lampp/htdocs/Expense-Tracker
```

### Step 4: Access the Application

Open your web browser and navigate to:

```
http://localhost/Expense-Tracker
```

---

## 🗄️ Database Configuration

### Step 1: Create the Database

1. Open **phpMyAdmin** in your browser:
   ```
   http://localhost/phpmyadmin
   ```

2. Click on **"New"** in the left sidebar

3. Enter database name: `expense_tracker`

4. Click **"Create"**

### Step 2: Create Database Tables

1. Select the `expense_tracker` database
2. Go to **"SQL"** tab
3. Copy and paste the following SQL script:

```sql
-- Create Users Table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Expenses Table
CREATE TABLE expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category VARCHAR(50) NOT NULL,
  amount DECIMAL(10, 2) NOT NULL,
  description VARCHAR(255),
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Categories Table (Optional)
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(50) UNIQUE NOT NULL,
  icon VARCHAR(50)
);
```

4. Click **"Execute"** to run the script

### Step 3: Update Database Configuration

Edit the `config.php` or database connection file in your project:

```php
<?php
// Database Configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$database = "expense_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

---

## 📖 Usage

### Adding an Expense

1. Log in to your account (or create a new one if needed)
2. Click **"Add Expense"**
3. Fill in:
   - **Category** (e.g., Food, Transport, etc.)
   - **Amount** (e.g., 50.00)
   - **Description** (optional, e.g., "Lunch at cafe")
   - **Date** (select the date of expense)
4. Click **"Save"**

### Viewing Expenses

- View all expenses on the dashboard
- Filter by category or date range
- See total spending overview

### Editing/Deleting Expenses

- Click **"Edit"** to modify an expense
- Click **"Delete"** to remove an expense

---

## 📁 Project Structure

```
Expense-Tracker/
├── README.md                 # Project documentation
├── config.php               # Database configuration
├── index.php                # Main dashboard
├── add_expense.php          # Add expense page
├── edit_expense.php         # Edit expense page
├── delete_expense.php       # Delete expense functionality
├── login.php                # User login
├── register.php             # User registration
├── logout.php               # User logout
├── css/
│   └── style.css           # Main stylesheet
├── js/
│   └── script.js           # JavaScript functionality
└── assets/                  # Images and icons (if any)
```

---

## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/YourFeature`)
3. Make your changes
4. Commit your changes (`git commit -m 'Add new feature'`)
5. Push to the branch (`git push origin feature/YourFeature`)
6. Open a **Pull Request**

---

## ⚠️ Troubleshooting

### Issue: "Connection refused" or "Cannot connect to MySQL"
- **Solution:** Make sure Apache and MySQL are running in XAMPP Control Panel

### Issue: "404 Not Found"
- **Solution:** Verify the project is in the correct `htdocs` folder and the URL is correct

### Issue: "Database does not exist"
- **Solution:** Make sure you've created the `expense_tracker` database in phpMyAdmin

---

## 📝 License

This project is open-source and available for personal and educational use.

---

## 👨‍💻 Author

**Jevxtn**

For questions or support, feel free to open an **Issue** in this repository.

---

**Happy Expense Tracking! 💳**
