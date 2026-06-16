# 💰 Expense-Tracker

A simple and intuitive expense tracking application built with **PHP**, **HTML**, and **CSS**. Track your daily expenses, categorize spending, and manage your finances efficiently.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation & Setup](#installation--setup)
- [Database Configuration](#database-configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [🌍 Deployment Guide](#-deployment-guide)
- [Deployment Recommendations](#deployment-recommendations)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

- ✅ Add, edit, and delete expenses
- ✅ Categorize expenses (Food, Transport, Entertainment, etc.)
- ✅ View expense summary and totals
- ✅ Date-wise expense tracking
- ✅ Simple and clean user interface
- ✅ Responsive design with HTML & CSS

---

## 🛠 Tech Stack

- **Backend:** PHP
- **Frontend:** HTML, CSS
- **Database:** MySQL (via XAMPP)
- **Server:** Apache (via XAMPP)

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **XAMPP** (Apache + MySQL) - [Download here](https://www.apachefriends.org/)
- **Git** - [Download here](https://git-scm.com/)
- **Text Editor or IDE** (VS Code, Sublime Text, etc.)

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
git clone https://github.com/Jevxtn/Expense-Tracker.git
```

### Step 3: Move Project to XAMPP

Move the cloned folder to XAMPP's `htdocs` directory:

**On Windows:**
```
C:\xampp\htdocs\Expense-Tracker
```

**On macOS:**
```
/Applications/XAMPP/xamppfiles/htdocs/Expense-Tracker
```

**On Linux:**
```
/opt/lampp/htdocs/Expense-Tracker
```

### Step 4: Access the Application

Open your web browser and navigate to:

```
http://localhost/Expense-Tracker
```

---

## 🗄️ Database Configuration

### Step 1: Create the Database

1. Open **phpMyAdmin** in your browser:
   ```
   http://localhost/phpmyadmin
   ```

2. Click on **"New"** in the left sidebar

3. Enter database name: `expense_tracker`

4. Click **"Create"**

### Step 2: Create Database Tables

1. Select the `expense_tracker` database
2. Go to **"SQL"** tab
3. Copy and paste the following SQL script:

```sql
-- Create Users Table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Expenses Table
CREATE TABLE expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category VARCHAR(50) NOT NULL,
  amount DECIMAL(10, 2) NOT NULL,
  description VARCHAR(255),
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Categories Table (Optional)
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(50) UNIQUE NOT NULL,
  icon VARCHAR(50)
);
```

4. Click **"Execute"** to run the script

### Step 3: Update Database Configuration

Edit the `config.php` or database connection file in your project:

```php
<?php
// Database Configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$database = "expense_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

---

## 📖 Usage

### Adding an Expense

1. Log in to your account (or create a new one if needed)
2. Click **"Add Expense"**
3. Fill in:
   - **Category** (e.g., Food, Transport, etc.)
   - **Amount** (e.g., 50.00)
   - **Description** (optional, e.g., "Lunch at cafe")
   - **Date** (select the date of expense)
4. Click **"Save"**

### Viewing Expenses

- View all expenses on the dashboard
- Filter by category or date range
- See total spending overview

### Editing/Deleting Expenses

- Click **"Edit"** to modify an expense
- Click **"Delete"** to remove an expense

---

## 📁 Project Structure

```
Expense-Tracker/
├── README.md                 # Project documentation
├── config.php               # Database configuration
├── index.php                # Main dashboard
├── add_expense.php          # Add expense page
├── edit_expense.php         # Edit expense page
├── delete_expense.php       # Delete expense functionality
├── login.php                # User login
├── register.php             # User registration
├── logout.php               # User logout
├── css/
│   └── style.css           # Main stylesheet
├── js/
│   └── script.js           # JavaScript functionality
└── assets/                  # Images and icons (if any)
```

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
   C:\inetpub\wwwroot\Expense-Tracker
   ```

6. **Create Database:**
   - Open MySQL Workbench or Command Line
   - Run the SQL script provided in Database Configuration section

7. **Update config.php with server credentials:**
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "your_password";
   $database = "expense_tracker";
   ```

8. **Access Your Application:**
   ```
   http://your-windows-server-ip/Expense-Tracker
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

5. **Clone Your Project:**
   ```bash
   cd /var/www/html
   sudo git clone https://github.com/Jevxtn/Expense-Tracker.git
   sudo chown -R www-data:www-data /var/www/html/Expense-Tracker
   sudo chmod -R 755 /var/www/html/Expense-Tracker
   ```

6. **Create Database:**
   ```bash
   sudo mysql -u root -p
   ```
   Then paste the SQL script from Database Configuration section

7. **Configure Apache Virtual Host:**
   ```bash
   sudo nano /etc/apache2/sites-available/expense-tracker.conf
   ```

   Add:
   ```apache
   <VirtualHost *:80>
       ServerName your-domain.com
       ServerAdmin admin@your-domain.com
       DocumentRoot /var/www/html/Expense-Tracker
       
       <Directory /var/www/html/Expense-Tracker>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
   </VirtualHost>
   ```

8. **Enable Site and Mod Rewrite:**
   ```bash
   sudo a2ensite expense-tracker.conf
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

9. **Update config.php:**
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "your_password";
   $database = "expense_tracker";
   ```

10. **Access Your Application:**
    ```
    http://your-domain.com
    ```

**Advantages:** ✅ Cost-effective, highly customizable, excellent for production
**Disadvantages:** ❌ Requires Linux knowledge, server management responsibility

---

### ☁️ **Deployment Option 3: Cloud Platforms**

#### **Option A: Heroku (Easiest for Beginners)**

**Best For:** Rapid deployment, prototyping, small projects

**Steps:**

1. **Create Heroku Account:**
   - Go to [heroku.com](https://www.heroku.com) and sign up

2. **Install Heroku CLI:**
   ```bash
   # Windows
   choco install heroku-cli
   
   # macOS
   brew tap heroku/brew && brew install heroku
   
   # Linux
   curl https://cli-assets.heroku.com/install.sh | sh
   ```

3. **Login to Heroku:**
   ```bash
   heroku login
   ```

4. **Create Heroku App:**
   ```bash
   heroku create expense-tracker-app
   ```

5. **Add ClearDB MySQL (Free tier):**
   ```bash
   heroku addons:create cleardb:ignite
   ```

6. **Get Database URL:**
   ```bash
   heroku config:get CLEARDB_DATABASE_URL
   ```

7. **Update config.php for Heroku:**
   ```php
   <?php
   if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
       $url = parse_url($_ENV['CLEARDB_DATABASE_URL']);
       $servername = $url['host'];
       $username = $url['user'];
       $password = $url['pass'];
       $database = substr($url['path'], 1);
   } else {
       $servername = "localhost";
       $username = "root";
       $password = "";
       $database = "expense_tracker";
   }
   
   $conn = new mysqli($servername, $username, $password, $database);
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

8. **Create Procfile:**
   ```bash
   echo "web: vendor/bin/heroku-php-apache2" > Procfile
   ```

9. **Deploy:**
   ```bash
   git add .
   git commit -m "Prepare for Heroku deployment"
   git push heroku main
   ```

10. **Run Database Setup:**
    ```bash
    heroku run mysql -u [username] -p [password] < database.sql
    ```

**Advantages:** ✅ Easy deployment, free tier available, automatic scaling
**Disadvantages:** ❌ Limited free resources, can be expensive at scale

---

#### **Option B: AWS (EC2) - Professional Production**

**Best For:** Large-scale applications, enterprise use

**Quick Setup:**

1. **Create EC2 Instance:**
   - Go to AWS Console → EC2
   - Click "Launch Instance"
   - Select Ubuntu 20.04 LTS
   - Choose t2.micro (free tier eligible)
   - Configure security groups (allow HTTP, HTTPS, SSH)

2. **Connect to Instance:**
   ```bash
   ssh -i your-key.pem ubuntu@your-ec2-ip
   ```

3. **Follow Linux Server Setup (Option 2 above)**

4. **Set Up RDS for MySQL:**
   - Go to AWS RDS → Create Database
   - Choose MySQL
   - Configure endpoint, username, password
   - Update config.php with RDS endpoint

5. **Use Elastic IP (Optional):**
   - Attach Elastic IP to your EC2 instance for static IP

**Advantages:** ✅ Highly scalable, professional grade, reliable
**Disadvantages:** ❌ Steeper learning curve, can be expensive

---

#### **Option C: InfinityFree / 000webhost (Completely Free)**

**Best For:** Learning, portfolio projects, no budget

**Steps:**

1. **Create Account:** Go to [infinityfree.net](https://infinityfree.net) or [000webhost.com](https://www.000webhost.com)

2. **Create Free Hosting Account**

3. **Upload Files:**
   - Use File Manager or FTP
   - Upload all project files

4. **Create Database:**
   - Use hosting control panel (cPanel)
   - Create MySQL database

5. **Update config.php with provided credentials**

6. **Access Application:** 
   ```
   http://your-subdomain.infinityfree.com
   ```

**Advantages:** ✅ Completely free, no credit card needed
**Disadvantages:** ❌ Limited resources, slow performance, unreliable uptime

---

#### **Option D: DigitalOcean Droplets (Affordable Recommendation)**

**Best For:** Small to medium projects, developers, good value

**Steps:**

1. **Create DigitalOcean Account:** [digitalocean.com](https://www.digitalocean.com)

2. **Create Droplet:**
   - Choose Ubuntu 20.04
   - Select $6/month plan (good value)
   - Choose closest region

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

## 🏆 Deployment Recommendations

| **Scenario** | **Best Option** | **Reason** |
|---|---|---|
| **Learning & Development** | Windows/Linux Local | Full control, no costs |
| **Small Business** | Linux VPS (DigitalOcean) | Affordable, reliable, scalable |
| **Prototype/MVP** | Heroku | Quick deployment, minimal setup |
| **Personal Project** | InfinityFree | Free, good for portfolio |
| **Enterprise/Production** | AWS EC2 + RDS | Scalable, secure, professional |
| **Team Project** | DigitalOcean App Platform | Easy collaboration, affordable |

### **⭐ RECOMMENDED FOR THIS PROJECT: DigitalOcean ($6/month)**

**Why?**
- ✅ **Perfect balance:** Affordable yet professional
- ✅ **Easy setup:** Simple droplet creation and management
- ✅ **Full control:** Not limited like free hosting
- ✅ **Good performance:** Suitable for expense tracker application
- ✅ **Scalability:** Can upgrade as your app grows
- ✅ **24/7 uptime:** Reliable for personal/small business use

**Quick Start:**
```bash
# After creating DigitalOcean droplet
ssh root@your-ip
apt update && apt upgrade -y
# Follow Linux deployment steps above
```

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

## ⚠️ Troubleshooting

### Issue: "Connection refused" or "Cannot connect to MySQL"
- **Solution:** Make sure Apache and MySQL are running in XAMPP Control Panel

### Issue: "404 Not Found"
- **Solution:** Verify the project is in the correct `htdocs` folder and the URL is correct

### Issue: "Database does not exist"
- **Solution:** Make sure you've created the `expense_tracker` database in phpMyAdmin

### Issue: Permission Denied on Linux
- **Solution:** Run `sudo chown -R www-data:www-data /var/www/html/Expense-Tracker`

### Issue: PHP Files Not Executing
- **Solution:** Ensure PHP is properly installed and Apache mod_php is enabled

---

## 📝 License

This project is open-source and available for personal and educational use.

---

## 👨‍💻 Author

**Jevxtn**

For questions or support, feel free to open an **Issue** in this repository.

---

**Happy Expense Tracking! 💳**
