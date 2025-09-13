# 📚 Yii2 Book Catalog

A simple application for managing a catalog of books and their authors, built on the **Yii2 framework**.

---

## ⚙️ System Requirements

```bash
PHP >= 8.0
Composer
Apache / Nginx / PHP built-in server
MySQL or MariaDB

🚀 Installation and Setup
1. Clone or Download the Project
git clone https://github.com/your-username/yii2-book-catalog.git
cd yii2-book-catalog

2. Install Dependencies
composer install

3. Database Setup
In file config/db
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=book_catalog_db', // Your database name
    'username' => 'root',       // Your database user
    'password' => 'password',   // Your database password
    'charset' => 'utf8',
];

4. Apply Migrations
./yii migrate

5. Create Uploads Directory
mkdir -p web/uploads/books

▶️ Running the Application
./yii serve


After running, the app will be available at:
👉 http://localhost:8080
