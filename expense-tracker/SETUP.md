# SETUP GUIDE - ExpenseTracker

## Quick Start Guide

### Prerequisites
- XAMPP with PHP 7.4+ and MySQL 5.7+
- Modern web browser
- Text editor (optional)

### Installation Steps

#### 1. Install XAMPP
- Download from: https://www.apachefriends.org/
- Install on your system
- Remember the installation path

#### 2. Copy Project to XAMPP
- Navigate to `xampp/htdocs/`
- Create folder `expense-tracker`
- Copy all project files here

#### 3. Start Services
- Open XAMPP Control Panel
- Click "Start" for Apache
- Click "Start" for MySQL

#### 4. Initialize Database
- Open browser
- Go to: `http://localhost/expense-tracker/backend/db_init.php`
- Should see success message

#### 5. Open Application
- Navigate to: `http://localhost/expense-tracker/`
- You'll see the landing page

#### 6. Register Account
- Click "Sign Up"
- Fill in your details
- Click "Create Account"

#### 7. Login
- Click "Login"
- Enter your credentials
- Start tracking expenses!

### File Permissions

Ensure the uploads folder is writable:

**Windows (XAMPP)**:
1. Right-click `uploads` folder
2. Properties → Security
3. Grant "Full Control" to your user

**Mac/Linux**:
```bash
chmod -R 755 uploads/
chmod -R 755 uploads/invoices/
```

### Accessing phpMyAdmin

To manage database directly:
- Go to: `http://localhost/phpmyadmin/`
- Username: `root`
- Password: (leave empty - default)

### Troubleshooting

**Cannot connect to database:**
- Ensure MySQL is running
- Check `backend/config.php` settings
- Verify database name: `expense_tracker`

**Cannot upload files:**
- Ensure `uploads/invoices/` folder exists
- Check folder permissions
- File must be PDF or image (max 5MB)

**Page shows blank:**
- Check browser console (F12) for errors
- Ensure Apache is running
- Clear browser cache (Ctrl+Shift+Delete)

### Default Credentials

After setup, create your own account. Initial admin setup is not configured (follow registration for new account).

### Important Notes

- Change database password in production
- Use HTTPS in production
- Implement rate limiting for production
- Regular backup of database recommended
- Keep PHP and MySQL updated

### Need Help?

1. Check browser console (F12 → Console)
2. Review error logs in XAMPP
3. Check phpMyAdmin for database issues
4. Verify file paths and permissions

---

**You're all set! Start using ExpenseTracker! 🚀**
