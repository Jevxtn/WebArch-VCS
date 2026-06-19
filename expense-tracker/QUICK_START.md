# ExpenseTracker Quick Start

Use this when you just need the app running quickly.

## 1. Start Services

Open XAMPP Control Panel and start:
- Apache
- MySQL

## 2. Place Project

Copy project folder to:

```
C:\xampp\htdocs\expense-tracker
```

## 3. Initialize Database

Open:

```
http://localhost/expense-tracker/backend/db_init.php
```

Wait for the completion message.

## 4. Open App

```
http://localhost/expense-tracker/
```

## 5. Create Account

1. Open Sign Up.
2. Register with email/password.
3. Login and open dashboard.

## 6. Smoke Test

1. Add one expense.
2. Confirm it appears in Expenses list.
3. Upload one invoice file.
4. Confirm dashboard statistics change.

## Quick Troubleshooting

App not loading:
- Check Apache status.
- Verify folder path under htdocs.

Login/session issues:
- Ensure cookies are enabled.
- Re-login and retry dashboard.

Upload rejected:
- Use PDF/JPG/PNG.
- Keep file <= 5 MB.

Need more detail:
- SETUP.md for installation
- USER_GUIDE.md for usage
- DEVELOPER_GUIDE.md for API and internals
