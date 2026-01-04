<?php
require_once 'config.php';

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    
    if ($password !== $confirm) {
        die("Passwords don't match.");
    }
    
    // Check if email/username exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->fetch()) {
        die("Email or username already taken.");
    }
    
    // Insert user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)");
    if ($stmt->execute([$email, $username, $hash])) {
        echo "Registration successful. You can now login.";
    } else {
        echo "Registration failed.";
    }
    
} elseif ($action === 'login') {
    $cred = trim($_POST['login_cred']);
    $password = $_POST['password'];
    
    // Find user by email or username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$cred, $cred]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: dashboard.php");
        exit;
    } else {
        die("Invalid credentials.");
    }
}
?>
