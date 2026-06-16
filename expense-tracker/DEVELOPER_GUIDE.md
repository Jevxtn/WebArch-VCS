# ExpenseTracker - Developer Documentation

## 🔧 Technical Reference Guide

### Project Architecture

```
Frontend (Browser)
    ↓
JavaScript (fetch API)
    ↓
PHP Backend API
    ↓
MySQL Database
```

### Tech Stack Details

**Frontend:**
- HTML5 semantic markup
- CSS3 with CSS Grid & Flexbox
- Vanilla JavaScript (ES6+)
- Chart.js for data visualization
- Font Awesome icons

**Backend:**
- PHP 7.4+ (OOP ready)
- MySQLi for database operations
- Prepared statements for security
- JSON for API responses

**Database:**
- MySQL 5.7+
- InnoDB storage engine
- UTF-8 encoding
- Normalized schema

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Bcrypt hashed
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

**Key Fields:**
- `id`: Unique identifier
- `username`: Case-sensitive unique username
- `email`: Unique email for login
- `password`: Bcrypt hashed (PASSWORD_BCRYPT)

**Indexes:** username, email

### Categories Table

```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#007BFF',  -- Hex color
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
```

**Relationships:**
- One user → Many categories
- Deleted user → Cascading deletion

### Expenses Table

```sql
CREATE TABLE expenses (
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
)
```

**Key Points:**
- `amount`: DECIMAL for financial accuracy
- `date`: DATE format for range queries
- Indexed by user_id and date for fast queries

### Invoices Table

```sql
CREATE TABLE invoices (
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
)
```

**File Storage:**
- `file_path`: Relative path to stored file
- `file_size`: Size in bytes
- `file_type`: MIME type for validation

---

## API Endpoints

### Authentication APIs

**POST /backend/register.php**
```
Request:
{
    "full_name": "John Doe",
    "username": "johndoe",
    "email": "john@example.com",
    "phone": "123-456-7890",
    "password": "secure_password",
    "confirm_password": "secure_password"
}

Response Success:
{
    "success": true,
    "message": "Registration successful! Please login."
}

Response Error:
{
    "success": false,
    "message": "Error message here"
}
```

**POST /backend/login.php**
```
Request:
{
    "email": "john@example.com",
    "password": "secure_password"
}

Response Success:
{
    "success": true,
    "message": "Login successful!",
    "redirect": "dashboard.html"
}

Response Error:
{
    "success": false,
    "message": "Invalid email or password"
}
```

### Expense APIs

**POST /backend/add_expense.php**
```
Request:
{
    "category_id": "1",
    "amount": "25.50",
    "description": "Lunch at restaurant",
    "date": "2024-01-15",
    "payment_method": "credit_card",
    "notes": "With team"
}

Response:
{
    "success": true,
    "message": "Expense added successfully",
    "expense_id": 123
}
```

**GET /backend/get_expenses.php?filter=month**
```
Response:
{
    "success": true,
    "expenses": [
        {
            "id": 1,
            "amount": "25.50",
            "description": "Lunch",
            "date": "2024-01-15",
            "category_name": "Food & Dining",
            "color": "#FF6B6B",
            ...
        }
    ]
}
```

**POST /backend/delete_expense.php**
```
Request:
{
    "expense_id": "123"
}

Response:
{
    "success": true,
    "message": "Expense deleted successfully"
}
```

### Invoice APIs

**POST /backend/upload_invoice.php**
```
Request: (multipart/form-data)
- invoice_file: File object
- vendor_name: "Store Name"
- invoice_number: "INV-001"
- invoice_date: "2024-01-15"
- total_amount: "100.00"

Response:
{
    "success": true,
    "message": "Invoice uploaded successfully",
    "invoice_id": 45
}
```

### Statistics API

**GET /backend/get_statistics.php?filter=month**
```
Response:
{
    "success": true,
    "total": 1250.50,
    "daily_average": 41.68,
    "by_category": [
        {
            "name": "Food & Dining",
            "color": "#FF6B6B",
            "total": "450.00"
        }
    ],
    "recent": [
        {
            "amount": "25.50",
            "description": "Lunch",
            "date": "2024-01-15",
            "category_name": "Food & Dining"
        }
    ]
}
```

---

## PHP Backend Structure

### config.php

Database configuration and session initialization:
```php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'expense_tracker');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Error handling
session_start();
```

**Modifications:**
- Change credentials for different environments
- Add error logging
- Implement connection pooling

### Authentication Flow

**Registration:**
1. Validate input (client & server)
2. Check duplicate username/email
3. Hash password with Bcrypt
4. Insert user record
5. Create default categories
6. Return success/error

**Login:**
1. Retrieve user by email
2. Verify password
3. Set session variables
4. Return redirect to dashboard

**Session Management:**
```php
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['logged_in'] = true;
```

### Request Validation

All endpoints validate:
1. **Session**: User must be logged in
2. **Input**: Required fields checked
3. **Type**: Data types validated
4. **Range**: Values within acceptable range
5. **Ownership**: User can only access own data

---

## JavaScript Architecture

### auth.js

Handles authentication forms:
```javascript
// Register
handleRegister(e) → fetch register.php → redirect/error

// Login  
handleLogin(e) → fetch login.php → localStorage → redirect
```

### dashboard.js

Main application logic:
```javascript
// Navigation
handleNavClick() → show/hide pages

// Data Loading
loadExpenses() → fetch API → render DOM
loadStatistics() → fetch API → update charts

// User Actions
handleAddExpense() → validate → fetch → reload data
handleDeleteExpense() → confirm → fetch → reload data
handleUploadInvoice() → validate file → fetch → reload data
```

### script.js

Homepage animations:
```javascript
// Scroll effects
setupScrollEffects() → observe elements → animate on view

// Navigation
setupNavigation() → mobile menu toggle
```

---

## Frontend Components

### Forms

**Validation:**
- Required field checks
- Email format validation
- Number range validation
- File type/size validation

**State Management:**
- Form data via FormData API
- Success/error messages
- Loading states

### Charts

**Chart.js Implementation:**
```javascript
new Chart(ctx, {
    type: 'doughnut',  // pie, bar, line, etc.
    data: {
        labels: [...],
        datasets: [{
            data: [...],
            backgroundColor: [...]
        }]
    },
    options: {
        responsive: true,
        plugins: { ... }
    }
});
```

**Updates:**
- Destroy old instance
- Create new with updated data
- Smooth transitions

---

## Security Implementation

### Password Security

**Hashing:**
```php
$hashed = password_hash($password, PASSWORD_BCRYPT);
password_verify($input, $hashed);
```

**Requirements:**
- Minimum 6 characters
- Bcrypt algorithm
- Salted hashing

### SQL Injection Prevention

**Prepared Statements:**
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
```

**Never use:**
```php
// WRONG - SQL Injection vulnerable
$result = $conn->query("SELECT * FROM users WHERE email = '$email'");
```

### File Upload Security

**Validation:**
```php
$allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
$max_size = 5 * 1024 * 1024;

// Check MIME type
if (!in_array($file['type'], $allowed_types)) {
    // Reject
}

// Check size
if ($file['size'] > $max_size) {
    // Reject
}
```

**Storage:**
- Outside web root recommended
- Rename files to random names
- Store path in database only

### Session Security

**Best Practices:**
```php
session_start();
session_regenerate_id(true);  // Change ID after login
```

**Verification:**
```php
if (!isset($_SESSION['user_id'])) {
    // Redirect to login
}
```

---

## Performance Optimization

### Database Queries

**Indexing:**
```sql
CREATE INDEX idx_user_date ON expenses(user_id, date);
CREATE INDEX idx_category ON expenses(category_id);
```

**Query Optimization:**
```php
// GOOD - Single query with JOIN
SELECT e.*, c.name FROM expenses e
JOIN categories c ON e.category_id = c.id
WHERE e.user_id = ? LIMIT 10;

// AVOID - Multiple queries
foreach ($expenses as $exp) {
    $cat = query("SELECT * FROM categories WHERE id = {$exp['category_id']}");
}
```

### Frontend Optimization

**Asset Loading:**
- CSS in head
- JS before closing body
- Minify in production

**Caching:**
```javascript
// Cache API responses
const cache = {};

async function getCachedData(key, fetchFn) {
    if (cache[key]) return cache[key];
    const data = await fetchFn();
    cache[key] = data;
    return data;
}
```

---

## Extending the Application

### Adding a New Feature

**Example: Monthly Budget**

1. **Database:**
```sql
CREATE TABLE budgets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    month INT,
    year INT,
    amount DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

2. **Backend API:**
```php
// POST /backend/set_budget.php
$budget = $_POST['budget'];
INSERT INTO budgets ... WHERE user_id = ?;
```

3. **Frontend Form:**
```html
<input type="number" id="budget" name="budget">
<button onclick="setBudget()">Set Budget</button>
```

4. **Dashboard Widget:**
```javascript
async function loadBudget() {
    const response = await fetch('backend/get_budget.php');
    // Display progress bar
}
```

### Adding a New API Endpoint

**Template:**
```php
<?php
header('Content-Type: application/json');
include 'config.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// Get method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
    exit;
}

// Get input
$data = $_POST;

// Validate
if (empty($data['required_field'])) {
    echo json_encode(['success' => false, 'message' => 'Missing field']);
    exit;
}

// Process
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO table (user_id, field) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $data['field']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Success']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error']);
}
?>
```

---

## Debugging Tips

### Browser Console

```javascript
// Check API response
fetch('backend/api.php')
    .then(r => r.json())
    .then(d => console.log(d));
```

### PHP Debugging

```php
// Log to file
error_log("Debug message", 3, "/path/to/file.log");

// Return debug info
var_dump($variable);
die();
```

### Database Queries

```
// phpMyAdmin
- Check query execution
- Review explain plans
- Monitor query performance
```

---

## Deployment Checklist

- [ ] Update database credentials
- [ ] Set production error logging
- [ ] Enable HTTPS
- [ ] Implement rate limiting
- [ ] Set secure headers
- [ ] Minify CSS/JS
- [ ] Add backup system
- [ ] Configure firewall
- [ ] Update dependencies
- [ ] Test all features
- [ ] Document customizations

---

## Future Enhancements

**Planned Features:**
- [ ] Recurring expenses
- [ ] Budget tracking
- [ ] Email notifications
- [ ] Multi-currency support
- [ ] Data export (CSV/PDF)
- [ ] Advanced filters
- [ ] Spending goals
- [ ] Mobile app
- [ ] Dark/Light theme toggle
- [ ] Multi-language support

---

## Resources

- [PHP Documentation](https://www.php.net/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Chart.js Docs](https://www.chartjs.org/docs/latest/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [XAMPP Documentation](https://www.apachefriends.org/)

---

**Happy Coding! 🚀**
