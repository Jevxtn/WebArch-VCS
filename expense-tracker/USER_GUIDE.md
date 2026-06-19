# ExpenseTracker User Guide

This guide explains daily usage of the application.

## 1. Getting Started

1. Open:

```
http://localhost/expense-tracker/
```

2. Create an account from the Sign Up page.
3. Login with your email and password.
4. After login, you are redirected to dashboard.html.

Password rules on registration:
- At least 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character

## 2. Dashboard

The dashboard shows:
- Total spent
- Daily average
- Transaction count
- Recent expenses
- Category chart

Use filter buttons to change period views (for example week or month depending on section).

## 3. Add Expense

Open Add Expense and provide:
- Category (required)
- Amount (required, must be > 0)
- Description (required)
- Date (required)
- Payment method (optional)
- Notes (optional)

Click Add Expense to save.

If successful, the app refreshes the expense list and statistics.

## 4. View and Delete Expenses

Open Expenses page:
- Use filters: all, today, week, month
- Review amount, category, date, and payment method

To delete:
1. Click the trash icon.
2. Confirm deletion.

Deletion is permanent.

## 5. Invoice Upload

Open Invoices page.

Supported files:
- PDF
- JPG/JPEG
- PNG

Limit:
- Max 5 MB per file

Optional metadata:
- Vendor name
- Invoice number
- Invoice date
- Total amount

After upload, invoice appears in the invoice list.

## 6. Analytics

Analytics uses your stored expenses to show:
- Category totals
- Daily average
- Recent items

Statistics endpoint supports filters:
- week
- month
- year

## 7. Session and Login Behavior

- The app uses server-side PHP sessions.
- If session is missing or expired, dashboard redirects to login.
- Repeated failed login attempts can trigger temporary lockout.

## 8. Practical Tips

- Log expenses daily.
- Use clear descriptions.
- Keep category selection consistent.
- Upload receipts soon after purchase.
- Review weekly trends to control spending.

## 9. Troubleshooting

Cannot login:
- Verify email/password.
- Wait and retry if too many failed attempts were made.

Dashboard keeps redirecting to login:
- Browser may be blocking cookies.
- Login again and retry.

Upload fails:
- Confirm file type and size limits.
- Check uploads folder permissions.

Form submit shows error:
- Make sure required fields are filled.
- Open app via http://localhost/expense-tracker/.
