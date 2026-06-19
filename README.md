# 💰 Expense-Tracker

A web application for tracking personal expenses, managing invoice files, and viewing category-based spending statistics. Built with **PHP**, **HTML**, **CSS**, and **vanilla JavaScript**.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation & Setup](#installation--setup)
- [Database Configuration](#database-configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [API Reference](#api-reference)
- [🌍 Deployment Guide](#-deployment-guide)
- [Deployment Recommendations](#deployment-recommendations)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

- ✅ User registration and login with server-side sessions
- ✅ Password hashing with bcrypt
- ✅ Login rate-limit lockout after repeated failures
- ✅ Add and delete expenses
- ✅ Category-based organization with default categories per user
- ✅ Filter expenses by date (today, week, month, custom range)
- ✅ Invoice upload (PDF/JPG/PNG, up to 5 MB)
- ✅ Dashboard cards and charts (Chart.js) for totals, averages, and category spend
- ✅ Responsive design with HTML & CSS

---

## 🛠 Tech Stack

- **Backend:** PHP (JSON APIs)
- **Frontend:** HTML, CSS, vanilla JavaScript
- **Database:** MySQL (auto-created by backend on first run)
- **Charts:** Chart.js
- **Server:** Apache (via XAMPP)

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **XAMPP** (Apache + MySQL + PHP 7.4+) - [Download here](https://www.apachefriends.org/)
- **Git** - [Download here](https://git-scm.com/)
- **Modern browser** (Chrome, Edge, Firefox)

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
git clone https://github.com/Jevxtn/WebArch-VCS.git
```

### Step 3: Place the Project in XAMPP

Copy the `expense-tracker` folder into XAMPP's `htdocs` directory:

**On Windows:**
```
C:\xampp\htdocs\expense-tracker
```

**On macOS:**
```
/Applications/XAMPP/xamppfiles/htdocs/expense-tracker
```

**On Linux:**
```
/opt/lampp/htdocs/expense-tracker
```

### Step 4: Initialize the Database

Open the following URL in your browser to auto-create the database and all tables:

```
http://localhost/expense-tracker/backend/db_init.php
```

You should see a message ending with `Database initialization complete!`

### Step 5: Access the Application

Open your web browser and navigate to:

```
http://localhost/expense-tracker/
```

Register a new account, then log in to start tracking expenses.

---

## 🗄️ Database Configuration

The database and all tables are created automatically on first run — no manual SQL is required.

If you need to change the database credentials, edit `backend/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // Default XAMPP password is empty
define('DB_NAME', 'expense_tracker');
```

### Database Schema

The backend manages five tables automatically:

| Table | Description |
|---|---|
| `users` | Registered user accounts |
| `categories` | Per-user expense categories (with color and icon) |
| `expenses` | Individual expense records |
| `invoices` | Uploaded invoice files linked to expenses |
| `budgets` | Monthly budget limits per category |

---

## 📖 Usage

### Adding an Expense

1. Log in to your account
2. Click **"Add Expense"**
3. Fill in:
   - **Category** (e.g., Food, Transport, etc.)
   - **Amount** (e.g., 50.00)
   - **Description** (optional)
   - **Date** (select the date of the expense)
4. Click **"Save"**

### Viewing Expenses

- View all expenses on the dashboard
- Filter by: **today**, **this week**, **this month**, or a **custom date range**
- See total and average spending on dashboard cards

### Deleting Expenses

- Click **"Delete"** next to any expense to remove it

### Uploading Invoices

- Attach a PDF, JPG, or PNG invoice file (up to 5 MB) when adding an expense
- Uploaded invoices are stored in `uploads/invoices/`

### Dashboard Charts

- Category spend breakdown (pie/bar chart via Chart.js)
- Spending over time (week, month, or year view)

---

## 📁 Project Structure

```
expense-tracker/
├── index.html                  # Landing / main page
├── login.html                  # Login page
├── register.html               # Registration page
├── dashboard.html              # Dashboard with charts
├── assets/
│   ├── css/
│   │   └── style.css           # Main stylesheet
│   └── js/
│       ├── auth.js             # Auth form logic
│       ├── script.js           # Expense list and CRUD
│       └── dashboard.js        # Dashboard charts and stats
├── backend/
│   ├── config.php              # DB connection and table setup
│   ├── db_init.php             # One-time database initializer
│   ├── register.php            # User registration API
│   ├── login.php               # User login API
│   ├── logout.php              # Session logout API
│   ├── check_session.php       # Session check API
│   ├── add_expense.php         # Add expense API
│   ├── get_expenses.php        # List expenses API (with filters)
│   ├── delete_expense.php      # Delete expense API
│   ├── get_categories.php      # List categories API
│   ├── get_statistics.php      # Dashboard statistics API
│   ├── upload_invoice.php      # Invoice upload API
│   └── get_invoices.php        # List invoices API
└── uploads/
    └── invoices/               # Uploaded invoice files
```

---

## 🔌 API Reference

### Authentication

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `backend/register.php` | Register a new user |
| `POST` | `backend/login.php` | Log in and start a session |
| `POST` | `backend/logout.php` | End the current session |
| `GET` | `backend/check_session.php` | Check if user is authenticated |

### Expenses

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `backend/add_expense.php` | Add a new expense |
| `GET` | `backend/get_expenses.php?filter=all\|today\|week\|month\|custom` | List expenses with optional filter |
| `POST` | `backend/delete_expense.php` | Delete an expense |

### Dashboard

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `backend/get_categories.php` | List expense categories |
| `GET` | `backend/get_statistics.php?filter=week\|month\|year` | Spending statistics |

### Invoices

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `backend/upload_invoice.php` | Upload an invoice file |
| `GET` | `backend/get_invoices.php` | List uploaded invoices |

---

## 🔒 Security Notes

- Passwords are stored with **bcrypt** hashing
- Session IDs are regenerated on successful login (session fixation mitigation)
- Session cookie is set with **HttpOnly** and **SameSite=Lax**
- All data endpoints require an authenticated PHP session
- Uploads are restricted to PDF/JPG/PNG, max 5 MB
- Generic login error messages prevent user enumeration
- Rate-limit lockout after repeated failed login attempts

---

## 🌍 Deployment Guide

### 🖥️ **Deployment Option 1: Windows Server (On-Premise)**

#### **Best For:** Small teams, local deployment, testing environment

**Requirements:**
- Windows Server 2016 or later
- IIS (Internet Information Services) or Apache
- PHP 7.4+
- MySQL 5.7+

**Steps:**

1. **Install IIS (Internet Information Services):**
   - Go to Control Panel → Programs → Turn Windows features on or off
   - Check **Internet Information Services**
   - Install required roles (CGI, Static Content, etc.)

2. **Install PHP:**
   - Download PHP from [php.net](https://www.php.net/downloads)
   - Extract to `C:\PHP`
   - Add PHP to System Environment Variables

3. **Install MySQL:**
   - Download MySQL Server from [mysql.com](https://www.mysql.com/downloads/)
   - Run installer and follow setup wizard
   - Note down root username and password

4. **Configure IIS for PHP:**
   - Open IIS Manager
   - Add PHP as a CGI application
   - Create a new website pointing to your project folder

5. **Deploy Your Project:**
   ```
   C:\inetpub\wwwroot\expense-tracker
   ```

6. **Update `backend/config.php` with server credentials:**
   ```php
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password');
   ```

7. **Initialize the database** by visiting:
   ```
   http://your-windows-server-ip/expense-tracker/backend/db_init.php
   ```

8. **Access Your Application:**
   ```
   http://your-windows-server-ip/expense-tracker
   ```

**Advantages:** ✅ Full control, secure on private network, no monthly fees
**Disadvantages:** ❌ Requires server maintenance, limited scalability

---

### 🐧 **Deployment Option 2: Linux Server (On-Premise or VPS)**

#### **Best For:** Developers, Linux enthusiasts, cost-effective hosting

**Requirements:**
- Ubuntu 20.04 LTS or CentOS 7+
- Apache 2.4+
- PHP 7.4+
- MySQL 5.7+ or MariaDB

**Steps:**

1. **Update System Packages:**
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

2. **Install Apache:**
   ```bash
   sudo apt install apache2 -y
   sudo systemctl start apache2
   sudo systemctl enable apache2
   ```

3. **Install PHP and Extensions:**
   ```bash
   sudo apt install php php-mysql php-mbstring php-xml -y
   ```

4. **Install MySQL:**
   ```bash
   sudo apt install mysql-server -y
   sudo mysql_secure_installation
   ```

5. **Clone and Place the Project:**
   ```bash
   cd /var/www/html
   sudo git clone https://github.com/Jevxtn/WebArch-VCS.git
   sudo cp -r WebArch-VCS/expense-tracker /var/www/html/expense-tracker
   sudo chown -R www-data:www-data /var/www/html/expense-tracker
   sudo chmod -R 755 /var/www/html/expense-tracker
   ```

6. **Configure Apache Virtual Host:**
   ```bash
   sudo nano /etc/apache2/sites-available/expense-tracker.conf
   ```

   Add:
   ```apache
   <VirtualHost *:80>
       ServerName your-domain.com
       DocumentRoot /var/www/html/expense-tracker

       <Directory /var/www/html/expense-tracker>
           AllowOverride All
           Require all granted
       </Directory>

       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
   </VirtualHost>
   ```

7. **Enable Site and Mod Rewrite:**
   ```bash
   sudo a2ensite expense-tracker.conf
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

8. **Update `backend/config.php`:**
   ```php
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password');
   ```

9. **Initialize the database:**
   ```
   http://your-domain.com/backend/db_init.php
   ```

10. **Access Your Application:**
    ```
    http://your-domain.com
    ```

**Advantages:** ✅ Cost-effective, highly customizable, excellent for production
**Disadvantages:** ❌ Requires Linux knowledge, server management responsibility

---

### ☁️ **Deployment Option 3: Cloud Platforms**

#### **Option A: AWS (EC2) - Professional Production**

**Best For:** Large-scale applications, enterprise use

**Quick Setup:**

1. **Create EC2 Instance:**
   - Go to AWS Console → EC2 → Launch Instance
   - Select Ubuntu 20.04 LTS, choose t2.micro (free tier eligible)
   - Configure security groups (allow HTTP, HTTPS, SSH)

2. **Connect to Instance:**
   ```bash
   ssh -i your-key.pem ubuntu@your-ec2-ip
   ```

3. **Follow Linux Server Setup (Option 2 above)**

4. **Set Up RDS for MySQL (optional):**
   - Go to AWS RDS → Create Database → MySQL
   - Update `backend/config.php` with the RDS endpoint

**Advantages:** ✅ Highly scalable, professional grade, reliable
**Disadvantages:** ❌ Steeper learning curve, can be expensive

---

#### **Option B: DigitalOcean Droplets (Affordable Recommendation)**

**Best For:** Small to medium projects, developers, good value

**Steps:**

1. **Create DigitalOcean Account:** [digitalocean.com](https://www.digitalocean.com)

2. **Create Droplet:**
   - Choose Ubuntu 20.04
   - Select $6/month plan
   - Choose the closest region

3. **Connect via SSH:**
   ```bash
   ssh root@your-droplet-ip
   ```

4. **Follow Linux Server Setup (Option 2 above)**

5. **Access Your App:**
   ```
   http://your-droplet-ip
   ```

**Advantages:** ✅ Affordable ($6/month), easy setup, good documentation
**Disadvantages:** ❌ Requires basic server knowledge

---

#### **Option C: InfinityFree / 000webhost (Completely Free)**

**Best For:** Learning, portfolio projects, no budget

**Steps:**

1. **Create Account:** Go to [infinityfree.net](https://infinityfree.net) or [000webhost.com](https://www.000webhost.com)
2. **Upload project files** via File Manager or FTP
3. **Create a MySQL database** using the hosting control panel (cPanel)
4. **Update `backend/config.php`** with the provided credentials
5. **Initialize the database** by visiting `backend/db_init.php` in your browser
6. **Access Application:**
   ```
   http://your-subdomain.infinityfree.com
   ```

**Advantages:** ✅ Completely free, no credit card needed
**Disadvantages:** ❌ Limited resources, slow performance, unreliable uptime

---

## 🏆 Deployment Recommendations

| **Scenario** | **Best Option** | **Reason** |
|---|---|---|
| **Learning & Development** | Windows/Linux Local (XAMPP) | Full control, no costs |
| **Small Business** | Linux VPS (DigitalOcean) | Affordable, reliable, scalable |
| **Personal Project** | InfinityFree | Free, good for portfolio |
| **Enterprise/Production** | AWS EC2 + RDS | Scalable, secure, professional |

### **⭐ RECOMMENDED FOR THIS PROJECT: DigitalOcean ($6/month)**

**Why?**
- ✅ **Perfect balance:** Affordable yet professional
- ✅ **Easy setup:** Simple droplet creation and management
- ✅ **Full control:** Not limited like free hosting
- ✅ **Good performance:** Suitable for an expense tracker application
- ✅ **Scalability:** Can upgrade as your app grows
- ✅ **24/7 uptime:** Reliable for personal/small business use

---

## ⚠️ Troubleshooting

### Issue: "Connection refused" or "Cannot connect to MySQL"
- **Solution:** Make sure Apache and MySQL are running in XAMPP Control Panel
- Verify credentials in `backend/config.php`

### Issue: "404 Not Found"
- **Solution:** Verify the project folder is named `expense-tracker` (lowercase) under `htdocs`

### Issue: Database not initialized
- **Solution:** Visit `http://localhost/expense-tracker/backend/db_init.php` in your browser

### Issue: Login keeps failing
- Use the exact email and password you registered with
- After repeated failures, wait for the lockout period to end

### Issue: Upload fails
- File must be PDF, JPG, or PNG
- File must be 5 MB or smaller
- Ensure `uploads/invoices/` is writable by the web server

### Issue: Permission Denied on Linux
- **Solution:** Run `sudo chown -R www-data:www-data /var/www/html/expense-tracker`

### Issue: Unexpected JSON/Network errors
- Open the app via `http://localhost/expense-tracker/` — not via `file://`
- Check Apache and PHP error logs

---

## 📚 Documentation

Additional documentation is available in the `expense-tracker/` folder:

- [`QUICK_START.md`](expense-tracker/QUICK_START.md) — Minimal steps to get running
- [`SETUP.md`](expense-tracker/SETUP.md) — Full local installation guide
- [`USER_GUIDE.md`](expense-tracker/USER_GUIDE.md) — How to use the application
- [`DEVELOPER_GUIDE.md`](expense-tracker/DEVELOPER_GUIDE.md) — API and internals reference
- [`CHANGELOG.md`](expense-tracker/CHANGELOG.md) — Version history

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

## 📝 License

This project is open-source and available for personal and educational use.

---

## 👨‍💻 Author

**Jevxtn**

For questions or support, feel free to open an **Issue** in this repository.

---

**Happy Expense Tracking! 💳**
