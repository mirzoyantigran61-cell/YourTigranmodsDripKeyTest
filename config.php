<?php
// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'dripclient_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site
define('SITE_NAME', 'YourTigranmods — DRIP CLIENT KEYGEN');
define('KEY_PREFIX', 'CreatedYourTigranmods-');
define('KEY_LENGTH', 10);

// Admin credentials (email, username, password)
define('ADMIN_EMAIL', 'mirzoyantigran61@gmail.com');
define('ADMIN_USERNAME', 'YourTigranmods X Ankit');
define('ADMIN_PASSWORD', 'YourTigranmods Official X Ankit X Kaier');

// Start session
session_start();

// PDO connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed.");
}
?>
