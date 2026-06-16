# ExpenseTracker - Dynamic Expense Management System

A modern, responsive web application for tracking daily expenses with user registration, expense logging, and invoice management. Built with HTML5, CSS3, JavaScript, PHP, and MySQL.

## 🚀 Features

- **User Authentication**: Secure registration and login system with password hashing
- **Daily Expense Logging**: Easy-to-use interface for logging daily expenses
- **Categorization**: Pre-built expense categories with color coding
- **Invoice Upload**: Upload and organize invoices (PDF, JPG, PNG)
- **Analytics & Reports**: Visual insights into spending patterns with charts
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Modern UI**: Technology-focused dark theme with gradient accents
- **Real-time Statistics**: Daily average, total spent, and category breakdown

## 📋 Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Charts**: Chart.js
- **Icons**: Font Awesome 6
- **Server**: XAMPP (Apache + MySQL)

## 📦 Project Structure

```
expense-tracker/
├── index.html              # Landing page
├── login.html              # Login page
├── register.html           # Registration page
├── dashboard.html          # Main dashboard
├── assets/
│   ├── css/
│   │   └── style.css       # Main stylesheet
│   └── js/
│       ├── script.js       # General site scripts
│       ├── auth.js         # Authentication logic
│       └── dashboard.js    # Dashboard functionality
├── backend/
│   ├── config.php          # Database configuration
│   ├── db_init.php         # Database initialization
│   ├── register.php        # User registration
│   ├── login.php           # User login
│   ├── logout.php          # User logout
│   ├── add_expense.php     # Add new expense
│   ├── get_expenses.php    # Fetch expenses
│   ├── delete_expense.php  # Delete expense
│   ├── upload_invoice.php  # Upload invoice
│   ├── get_invoices.php    # Fetch invoices
│   ├── get_categories.php  # Fetch categories
│   └── get_statistics.php  # Get statistics
├── uploads/
│   └── invoices/           # Uploaded invoice files
└── README.md               # This file
```

## 🔧 Installation & Setup

### Prerequisites

- **XAMPP** (Apache + MySQL + PHP)
- **Web Browser** (Chrome, Firefox, Safari, Edge)
- **Text Editor** (VS Code recommended)

### Step 1: Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP on your system
3. Start Apache and MySQL services from XAMPP Control Panel

### Step 2: Place Project Files

1. Locate your XAMPP installation directory:
   - **Windows**: `C:\xampp\htdocs\`
   - **Mac**: `/Applications/XAMPP/htdocs/`
   - **Linux**: `/opt/lampp/htdocs/`

2. Create a folder named `expense-tracker` inside `htdocs`

3. Copy all project files into this folder

### Step 3: Initialize Database

1. Open your browser and navigate to:
   ```
   http://localhost/phpmyadmin/
   ```

2. Open terminal/command prompt and navigate to your XAMPP htdocs folder:
   ```bash
   cd /path/to/xampp/htdocs/expense-tracker
   ```

3. Run the database initialization:
   ```
   http://localhost/expense-tracker/backend/db_init.php
   ```

4. You should see: "Database initialization complete!"

### Step 4: Access the Application

Open your browser and navigate to:
```
http://localhost/expense-tracker/
```

## 📝 Usage Guide

### Registration

1. Click "Sign Up" on the landing page
2. Fill in your details:
   - Full Name
   - Username
   - Email
   - Phone (optional)
   - Password
3. Click "Create Account"
4. You'll be redirected to login page

### Login

1. Enter your email and password
2. Click "Login"
3. You'll be taken to the dashboard

### Adding Expenses

1. Go to "Add Expense" section
2. Select a category
3. Enter amount and description
4. Choose date and payment method
5. Add notes if needed
6. Click "Add Expense"

### Uploading Invoices

1. Go to "Invoices" section
2. Drag and drop or click to upload a file
3. Fill in vendor details (optional)
4. Click "Upload Invoice"
5. View and manage uploaded invoices

### Viewing Analytics

1. Go to "Analytics" section
2. View spending distribution charts
3. See category breakdown with percentages
4. Use filters to view by week, month, or year

### Managing Expenses

1. View all expenses in "Expenses" section
2. Use filters (All, Today, Week, Month)
3. Delete expenses with trash icon
4. Update statistics in real-time

## 🔐 Security Features

- **Password Hashing**: Bcrypt algorithm for secure password storage
- **Session Management**: Secure PHP sessions
- **Input Validation**: All user inputs validated on client and server
- **File Upload Restrictions**: Only PDF and image files allowed
- **File Size Limit**: 5MB per invoice
- **User-specific Data**: Users can only access their own data

## 🗄️ Database Schema

### Users Table
- id, username, email, password, full_name, phone, created_at, updated_at

### Expenses Table
- id, user_id, category_id, amount, description, date, payment_method, notes, created_at, updated_at

### Categories Table
- id, user_id, name, description, color, icon, created_at

### Invoices Table
- id, user_id, expense_id, file_name, file_path, file_size, file_type, vendor_name, invoice_number, invoice_date, total_amount, uploaded_at

### Budgets Table
- id, user_id, category_id, amount, month, year, created_at

## 🎨 Design Features

- **Modern Dark Theme**: Easy on the eyes, professional appearance
- **Gradient Accents**: Purple, blue, and pink gradients
- **Responsive Layout**: Grid and flexbox for all screen sizes
- **Smooth Animations**: Fade-in, slide-in, and hover effects
- **Icon Integration**: Font Awesome icons throughout
- **Chart Visualization**: Interactive charts with Chart.js

## 📱 Browser Compatibility

- Chrome (Latest)
- Firefox (Latest)
- Safari (Latest)
- Edge (Latest)

## ⚙️ Configuration

Edit `backend/config.php` to change database settings:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Default XAMPP has no password
define('DB_NAME', 'expense_tracker');
```

## 🐛 Troubleshooting

### Database Connection Error

**Issue**: "Connection failed"

**Solution**:
1. Ensure MySQL is running in XAMPP Control Panel
2. Check database credentials in `backend/config.php`
3. Verify `expense_tracker` database exists in phpMyAdmin

### Files Not Uploading

**Issue**: "Error uploading file"

**Solution**:
1. Ensure `uploads/invoices/` folder exists and is writable
2. Check file size (max 5MB)
3. Ensure file type is PDF or image (JPG, PNG)

### Login Issues

**Issue**: "Invalid email or password"

**Solution**:
1. Verify email is correct
2. Check capslock on password
3. Ensure user is registered (sign up first)
4. Clear browser cookies

### Page Not Loading

**Issue**: 404 error

**Solution**:
1. Verify XAMPP Apache is running
2. Check file paths in project structure
3. Ensure files are in correct `htdocs` folder
4. Try clearing browser cache

## 📚 API Endpoints

### Authentication
- `POST /backend/register.php` - User registration
- `POST /backend/login.php` - User login
- `POST /backend/logout.php` - User logout

### Expenses
- `POST /backend/add_expense.php` - Add new expense
- `GET /backend/get_expenses.php` - Fetch expenses
- `POST /backend/delete_expense.php` - Delete expense

### Invoices
- `POST /backend/upload_invoice.php` - Upload invoice
- `GET /backend/get_invoices.php` - Fetch invoices

### Data
- `GET /backend/get_categories.php` - Fetch categories
- `GET /backend/get_statistics.php` - Get statistics

## 🤝 Contributing

Feel free to fork, modify, and improve this project!

## 📄 License

This project is open source and available for personal and commercial use.

## ✨ Future Enhancements

- Email notifications
- Budget alerts
- Recurring expenses
- Multi-currency support
- Export to CSV/PDF
- Expense sharing
- Mobile app version
- Cloud sync

## 🎓 Learning Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [JavaScript ES6](https://developer.mozilla.org/en-US/docs/Learn/JavaScript)
- [CSS Grid & Flexbox](https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout)

## 💬 Support

For issues and questions, please refer to the troubleshooting section or check the browser console for error messages.

---

**Created with ❤️ - Modern Expense Tracking Made Simple**
