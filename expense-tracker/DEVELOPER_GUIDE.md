# ExpenseTracker Developer Guide

This document describes architecture, backend behavior, database design, and API contracts based on the current code.

## 1. Architecture

Flow:

```
Browser UI (HTML/CSS/JS)
  -> fetch() calls
PHP endpoints in backend/
  -> MySQL via mysqli prepared statements
```

Main frontend modules:
- assets/js/auth.js: login and registration forms, client validation
- assets/js/dashboard.js: dashboard loading, stats, expenses, invoice upload
- assets/js/script.js: landing page nav and animation behavior

## 2. Backend Bootstrapping

backend/config.php is included by all endpoints and is responsible for:
- DB connection
- Database and table auto-create
- Legacy schema repair migrations
- Session cookie policy and session_start
- Localhost CORS handling for selected origins

Important: database creation is attempted automatically if missing.

## 3. Data Model

Tables in use:
- users
- categories
- expenses
- invoices
- budgets

Key relationships:
- categories.user_id -> users.id (cascade delete)
- expenses.user_id -> users.id (cascade delete)
- expenses.category_id -> categories.id (set null)
- invoices.user_id -> users.id (cascade delete)
- invoices.expense_id -> expenses.id (set null)

## 4. Authentication and Sessions

Registration (backend/register.php):
- Validates full_name, username, email, password, confirm_password, phone
- Enforces strong password policy
- Uses bcrypt with cost 12
- Inserts default categories for new users

Login (backend/login.php):
- Validates email/password
- Uses generic invalid-credentials response
- Tracks failed attempts in session
- Locks login after 5 failures for 15 minutes
- Calls session_regenerate_id(true) on success

Session check (backend/check_session.php):
- Returns 401 JSON when unauthenticated
- Returns user payload when authenticated

Logout (backend/logout.php):
- Clears session array
- Expires session cookie
- Destroys session

## 5. Endpoint Contracts

All responses are JSON.

### POST backend/register.php

Body (form-data):
- full_name
- username
- email
- password
- confirm_password
- phone (optional)

Success:

```json
{ "success": true, "message": "Account created successfully! Redirecting to login." }
```

### POST backend/login.php

Body (form-data):
- email
- password

Success:

```json
{ "success": true, "message": "Login successful!", "redirect": "dashboard.html" }
```

### POST backend/logout.php

Success:

```json
{ "success": true, "message": "Logged out successfully" }
```

### GET backend/check_session.php

Success:

```json
{
  "success": true,
  "user_id": 1,
  "username": "demo",
  "full_name": "Demo User",
  "email": "demo@example.com"
}
```

### GET backend/get_categories.php

Returns authenticated user categories.

### POST backend/add_expense.php

Body (form-data):
- category_id
- amount
- description
- date
- payment_method (optional)
- notes (optional)

Validation:
- amount must be > 0
- category_id required and must belong to current user
- description required

### GET backend/get_expenses.php

Query:
- filter=all|today|week|month|custom
- start_date and end_date when filter=custom (YYYY-MM-DD)

Returns expense rows joined with category name/color/icon.

### POST backend/delete_expense.php

Body:
- expense_id

Deletes only if the expense belongs to current user.

### GET backend/get_statistics.php

Query:
- filter=week|month|year

Returns:
- total
- daily_average
- count
- by_category[]
- recent[]

### POST backend/upload_invoice.php

Body (multipart/form-data):
- invoice_file (required)
- expense_id (optional)
- vendor_name (optional)
- invoice_number (optional)
- invoice_date (optional)
- total_amount (optional)

Constraints:
- allowed types: PDF, JPG, JPEG, PNG
- max size: 5 MB

### GET backend/get_invoices.php

Optional query:
- expense_id

Returns invoice metadata for authenticated user.

## 6. Frontend Notes

auth.js:
- Has dynamic backend URL helper for file:// and hosted paths
- Sends credentials: include for auth requests
- Real-time validation and password strength checklist

dashboard.js:
- Verifies session before loading dashboard
- Loads categories, expenses, statistics, invoices
- Uses Chart.js for category chart

## 7. Security Notes

- display_errors is disabled in config.php
- SQL statements are mostly prepared and parameterized
- Session cookie is HttpOnly and SameSite=Lax
- secure cookie flag is enabled only under HTTPS

Known caveat:
- get_expenses.php custom date filter still builds SQL fragment with validated date strings rather than fully bound placeholders. Input is validated, but parameter binding for date range would be cleaner.

## 8. Local Development

Recommended local URL:

```
http://localhost/expense-tracker/
```

Do not run pages from file:// if you expect backend fetch calls to work reliably.
