Yii2 Book Catalog
A simple application for managing a catalog of books and their authors, built on the Yii2 framework.

System Requirements
PHP >= 8.0

Composer

Web server (Apache, Nginx) or PHP's built-in server

MySQL or MariaDB database

Installation and Setup
1. Clone or Download the Project
   Clone or download the project files into your local directory.

2. Install Dependencies
   Open a terminal in the project's root folder and run the following command to install all required PHP packages via Composer.

composer install

3. Database Setup
   Create a new, empty database in your MySQL server (e.g., named book_catalog_db).

Open the config/db.php file.

Enter your connection details for the newly created database:

<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=book_catalog_db', // Your database name
    'username' => 'root',       // Your database user
    'password' => 'password',   // Your database password
    'charset' => 'utf8',
];

4. Apply Migrations
To create all the necessary tables in the database, run the following command in the project's root folder:

./yii migrate

When prompted for confirmation, type yes and press Enter.

5. Create Uploads Directory
For book images to work correctly, create the necessary folders in the web directory:

mkdir -p web/uploads/books

Ensure that your web server has write permissions for this directory.

Running the Application
The easiest way to run the project is to use the built-in Yii2 web server. Run the command in the project's root folder:

./yii serve

After this, the application will be available in your browser at http://localhost:8080.