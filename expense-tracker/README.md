# ExpenseTracker

ExpenseTracker is a web application for tracking personal expenses, managing invoice files, and viewing category-based spending statistics.

## Overview

- Frontend: HTML, CSS, vanilla JavaScript
- Backend: PHP with JSON APIs
- Database: MySQL (auto-created from backend)
- Charts: Chart.js on dashboard

## Features

- User registration and login with server-side sessions
- Password hashing with bcrypt
- Login rate-limit lockout after repeated failures
- Expense create/list/delete flow
- Category-based organization with default categories per user
- Invoice upload (PDF/JPG/PNG) up to 5 MB
- Dashboard cards and charts for totals, averages, and category spend

## Project Structure

```
expense-tracker/
  index.html
  login.html
  register.html
  dashboard.html
  assets/
    css/style.css
    js/script.js
    js/auth.js
    js/dashboard.js
  backend/
    config.php
    db_init.php
    register.php
    login.php
    logout.php
    check_session.php
    add_expense.php
    get_expenses.php
    delete_expense.php
    get_categories.php
    get_statistics.php
    upload_invoice.php
    get_invoices.php
  uploads/
    invoices/
```

## Requirements

- XAMPP (Apache + MySQL + PHP 7.4+)
- MySQL 5.7+ or MariaDB equivalent
- Modern browser

## Docker Deployment

You can run the full stack (Apache/PHP + MySQL) with Docker Compose from the repository root.

1. Build and start containers:

```bash
docker compose up -d --build
```

2. Open the app:

```text
http://localhost:8080
```

Database UI (phpMyAdmin):

```text
http://localhost:8081
```

phpMyAdmin login:
- Server: `db`
- Username: `root`
- Password: `root`

3. Stop containers:

```bash
docker compose down
```

4. Stop and remove database volume (fresh reset):

```bash
docker compose down -v
```

Notes:
- The backend reads DB settings from environment variables in `docker-compose.yml`.
- Uploaded invoices are stored in the container at `uploads/invoices/`.
- DB data is persisted in the named volume `db_data`.
- phpMyAdmin runs as a separate container for browser-based database management.

## Setup

1. Copy this project to htdocs as expense-tracker.
2. Start Apache and MySQL in XAMPP.
3. Open:

```
http://localhost/expense-tracker/backend/db_init.php
```

4. Open the app:

```
http://localhost/expense-tracker/
```

For full setup details, read SETUP.md.

## Default Credentials

No default user is seeded. Create an account from register.html.

## API Summary

Authentication:
- POST backend/register.php
- POST backend/login.php
- POST backend/logout.php
- GET backend/check_session.php

Expenses:
- POST backend/add_expense.php
- GET backend/get_expenses.php?filter=all|today|week|month|custom
- POST backend/delete_expense.php

Dashboard data:
- GET backend/get_categories.php
- GET backend/get_statistics.php?filter=week|month|year

Invoices:
- POST backend/upload_invoice.php
- GET backend/get_invoices.php

## Security Notes

- Passwords are stored with bcrypt.
- Session IDs are regenerated on successful login.
- Session cookie is configured with HttpOnly and SameSite=Lax.
- Most data endpoints require authenticated PHP session.
- Uploads are restricted by type and file size.

## Troubleshooting

Database connection problems:
- Ensure MySQL is running in XAMPP.
- Verify credentials in backend/config.php.

Login keeps failing:
- Use the registered email/password pair.
- After repeated failures, wait for lockout period to end.

Upload fails:
- File must be PDF/JPG/PNG.
- File must be <= 5 MB.
- Ensure uploads/invoices is writable.

Unexpected JSON/Network issues:
- Open app via http://localhost/expense-tracker/ (not file://).
- Check PHP and Apache logs.

## Documentation

- QUICK_START.md
- SETUP.md
- USER_GUIDE.md
- DEVELOPER_GUIDE.md
- CHANGELOG.md
