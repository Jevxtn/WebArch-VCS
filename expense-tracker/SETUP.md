# ExpenseTracker Setup Guide

This guide walks through local installation on XAMPP.

## 1. Prerequisites

- Windows with XAMPP installed
- Apache and MySQL modules available
- Browser (Chrome, Edge, Firefox)

## 2. Place Project Files

1. Open your XAMPP htdocs directory.
2. Create folder expense-tracker if it does not already exist.
3. Put all project files inside expense-tracker.

Expected path:

```
C:\xampp\htdocs\expense-tracker
```

## 3. Start XAMPP Services

1. Open XAMPP Control Panel.
2. Start Apache.
3. Start MySQL.

## 4. Initialize Database

Open in browser:

```
http://localhost/expense-tracker/backend/db_init.php
```

You should see database/table initialization output ending with:

```
Database initialization complete!
```

## 5. Launch Application

Open:

```
http://localhost/expense-tracker/
```

Register a new user account, then login.

## 6. Folder Permissions

Invoice uploads are written to uploads/invoices.

If upload fails on Windows:
1. Right-click uploads folder.
2. Open Properties > Security.
3. Ensure your user and web server process can write files.

## 7. Optional Configuration

Database settings are in backend/config.php:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'expense_tracker');
```

## 8. Verification Checklist

- Apache is running
- MySQL is running
- db_init.php completed successfully
- register and login flows work
- dashboard loads without redirect loops
- expense creation works
- invoice upload works

## 9. Common Problems

MySQL connection error:
- Confirm MySQL is started.
- Verify backend/config.php credentials.

Redirected to login from dashboard:
- Session is not active or expired.
- Check browser cookies and backend/check_session.php response.

JSON parse/network error from frontend:
- Open app via http://localhost/expense-tracker/ instead of file://.
- Check Apache/PHP logs for fatal errors.

Upload error:
- Use only PDF/JPG/PNG.
- Keep file size at or below 5 MB.
- Verify write permissions for uploads/invoices.
