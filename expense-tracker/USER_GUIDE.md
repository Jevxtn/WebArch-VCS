# ExpenseTracker - Complete User Guide

## 🎯 Table of Contents
1. [Getting Started](#getting-started)
2. [Dashboard Overview](#dashboard-overview)
3. [Managing Expenses](#managing-expenses)
4. [Invoice Management](#invoice-management)
5. [Analytics & Reports](#analytics--reports)
6. [Best Practices](#best-practices)

---

## Getting Started

### Account Creation

**Step 1: Register**
- Visit `http://localhost/expense-tracker/`
- Click "Sign Up" button
- Fill in all required fields:
  - **Full Name**: Your complete name
  - **Username**: Unique login identifier (3+ characters)
  - **Email**: Valid email address
  - **Password**: At least 6 characters
  - **Phone**: Optional, for reference

**Step 2: Login**
- Enter your email address
- Enter your password
- Click "Login"
- You'll be redirected to your dashboard

**Security Tips:**
- Use a strong password (mix of letters, numbers, symbols)
- Never share your login credentials
- Clear browser data after using on shared computers
- Logout when finished

---

## Dashboard Overview

### Main Dashboard

The dashboard provides a quick overview of your financial status:

**Statistics Cards:**
- **Total Spent**: Complete spending for selected period
- **Daily Average**: Average daily spending calculation
- **Transactions**: Number of expenses logged

**Spending Chart:**
- Visual representation of spending by category
- Color-coded for easy identification
- Interactive legend for filtering

**Recent Expenses:**
- Last 5 expenses logged
- Quick view of recent activity
- Click "Expenses" to see full list

### Navigation Sidebar

Access different sections:
- 🏠 **Dashboard**: Overview and statistics
- 📋 **Expenses**: View all your expenses
- ➕ **Add Expense**: Log a new expense
- 📄 **Invoices**: Upload and manage invoices
- 📊 **Analytics**: Detailed reports and charts

### Time Filters

View data for different periods:
- **This Month**: Current calendar month (Default)
- **This Week**: Last 7 days
- **This Year**: Current year
- **Custom Date Range**: (In analytics section)

---

## Managing Expenses

### Adding an Expense

**Process:**
1. Click "Add Expense" in sidebar
2. Fill in the form:

   **Category** (Required)
   - Food & Dining
   - Transportation
   - Entertainment
   - Utilities
   - Health & Medical
   - Shopping
   - Education
   - Other

   **Amount** (Required)
   - Enter in dollars
   - Must be greater than 0
   - Example: 25.50

   **Description** (Required)
   - Brief description of expense
   - Example: "Lunch at restaurant"
   - 255 characters max

   **Date** (Required)
   - Select date of expense
   - Defaults to today
   - Can be past or future

   **Payment Method** (Optional)
   - Cash
   - Credit Card
   - Debit Card
   - Online
   - Other

   **Notes** (Optional)
   - Additional details
   - Unlimited text
   - Example: "With John and Sarah"

3. Click "Add Expense"
4. See success notification
5. Expense appears in all views

### Viewing Expenses

**All Expenses View:**
1. Click "Expenses" in sidebar
2. Use filters:
   - **All**: All expenses ever logged
   - **Today**: Only today's expenses
   - **Week**: Last 7 days
   - **Month**: Current month

**Expense Details Shown:**
- Amount (in red)
- Description
- Category with color indicator
- Date
- Payment method
- Action buttons

### Deleting an Expense

**To Delete:**
1. Find the expense in the list
2. Click trash icon on the right
3. Confirm deletion in popup
4. Expense removed immediately
5. Statistics update automatically

**Caution:**
- Deletion is permanent
- Cannot be undone
- Associated invoices remain

---

## Invoice Management

### Uploading an Invoice

**File Requirements:**
- Format: PDF, JPG, PNG only
- Size: Maximum 5MB
- Clean, legible document

**Upload Process:**

**Method 1 - Drag & Drop:**
1. Go to "Invoices" section
2. Drag file to upload area
3. Or click "Upload Invoice" area to browse

**Method 2 - Form Upload:**
1. Click in the upload area
2. Select file from computer
3. Fill optional details:
   - **Vendor Name**: Store/Company name
   - **Invoice Number**: Invoice reference number
   - **Invoice Date**: Date on invoice
   - **Amount**: Total invoice amount

4. Click "Upload Invoice"

**Form Fields Explained:**
- **Vendor Name**: Where you made the purchase
- **Invoice Number**: Reference ID from vendor
- **Invoice Date**: Date printed on invoice
- **Amount**: Total cost on invoice

### Managing Invoices

**View Uploaded Invoices:**
1. Go to "Invoices" section
2. Scroll to "Uploaded Invoices"
3. See all uploaded files

**Download Invoice:**
- Click download button next to invoice
- File saved to your computer
- Use for records or accounting

**Invoice Information:**
- Vendor name
- Invoice number
- Upload date
- Total amount

### Organization Tips

- Upload invoices immediately
- Fill in all details accurately
- Use consistent naming
- Keep backups of important invoices

---

## Analytics & Reports

### Analytics Dashboard

**Spending Distribution Chart:**
- Bar chart showing spending by category
- Vertical axis: Amount in dollars
- Horizontal axis: Categories
- Compare spending across categories

**Category Breakdown:**
- Percentage breakdown per category
- Visual progress bars
- Total amount per category
- Sorted by highest spending

**Key Metrics:**
- **Total Spent**: Sum of all expenses
- **Daily Average**: Total ÷ Number of days
- **Category Count**: Number of categories used
- **Number of Transactions**: Total expenses

### Using Filters

Time Period Options:
- **This Month**: Current month data
- **This Week**: Last 7 days data
- **This Year**: Year-to-date data

Charts update automatically when filter changes.

### Analyzing Your Spending

**Questions to Ask:**
1. Which category has highest spending?
2. How does this month compare to last month?
3. What's my daily spending average?
4. Are there unnecessary categories?
5. Can I reduce spending in any area?

**Budget Planning:**
- Set realistic budgets per category
- Track against budgets
- Identify trends
- Adjust spending habits accordingly

---

## Best Practices

### Daily Habits

✅ **Do:**
- Log expenses daily
- Be specific with descriptions
- Use correct categories
- Upload invoices promptly
- Review statistics weekly

❌ **Don't:**
- Wait to log expenses (memory fades)
- Use vague descriptions
- Miscategorize intentionally
- Ignore spending patterns
- Forget to logout

### Data Organization

**Categories:**
- Use provided categories appropriately
- Consistent categorization helps analytics
- Review category usage monthly
- Don't use "Other" excessively

**Descriptions:**
- Be specific: "Starbucks coffee" not "Food"
- Include key details: "Shell gas - $45"
- Mention companions if shared: "Dinner with Mom"

**Dates:**
- Use actual expense date
- Not the date you're logging
- Important for accurate reports

### Security

**Protect Your Account:**
- Use strong, unique password
- Never share credentials
- Logout on shared computers
- Keep email updated
- Report suspicious activity

**Data Safety:**
- Backup invoices externally
- Regular record review
- Export important data
- Keep receipts
- Document large expenses

### Performance

**For Best Experience:**
- Clear browser cache monthly
- Use modern browser (Chrome, Firefox, Safari)
- Keep JavaScript enabled
- Use broadband connection
- Close unused browser tabs

---

## Keyboard Shortcuts

| Action | Shortcut |
|--------|----------|
| Focus amount field | Click Amount input |
| Navigate form | Tab key |
| Submit form | Enter or Click button |
| Close menu (mobile) | Tap outside menu |

---

## Common Questions

**Q: Can I edit an expense?**
A: Currently, delete and re-add. Full edit feature coming soon.

**Q: How long are invoices stored?**
A: Indefinitely, unless deleted. Store backups separately.

**Q: Can I export data?**
A: Not in current version. Export feature planned.

**Q: Is my data secure?**
A: Yes, passwords are encrypted and data is user-specific.

**Q: Can I share expenses with others?**
A: Not currently. Collaboration features coming soon.

**Q: What if I forget my password?**
A: Currently no password reset. Contact admin or create new account.

---

## Tips for Effective Expense Tracking

1. **Consistency**: Log expenses daily
2. **Accuracy**: Enter exact amounts
3. **Organization**: Use proper categories
4. **Documentation**: Keep invoices
5. **Review**: Check reports weekly
6. **Adjustment**: Modify budgets based on data
7. **Backup**: Save important data
8. **Security**: Keep password safe

---

## Troubleshooting

**Problem: Cannot login**
- Verify email is correct
- Check password (case-sensitive)
- Ensure account is registered
- Clear browser cookies

**Problem: Expense not saving**
- Check internet connection
- Verify all required fields filled
- Check browser console for errors
- Try refreshing page

**Problem: Charts not showing**
- Refresh page
- Ensure JavaScript enabled
- Try different browser
- Check if data exists

**Problem: File upload fails**
- Check file type (PDF, JPG, PNG only)
- Verify file size < 5MB
- Ensure stable internet
- Try different file

---

## Contact & Support

For issues or questions:
1. Check browser console (F12)
2. Review troubleshooting section
3. Check README.md for detailed help
4. Restart application and try again

---

**Happy Tracking! 💰📊**
