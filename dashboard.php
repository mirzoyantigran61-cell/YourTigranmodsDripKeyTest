<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$is_admin = $_SESSION['is_admin'] ?? false;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?= SITE_NAME ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Courier New', monospace; }
        body { background: #0a0a0f; color: #00ffea; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-info { color: #9d4edd; }
        .generator { max-width: 600px; margin: 0 auto; background: rgba(16,16,32,0.9); border: 2px solid #3a0ca3; padding: 30px; border-radius: 15px; }
        .input-group { margin-bottom: 20px; }
        .input-group input { width: 100%; padding: 12px; background: #1a1a2e; border: 1px solid #4361ee; color: white; border-radius: 8px; }
        .button { padding: 12px 25px; background: linear-gradient(90deg, #7209b7, #3a0ca3); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        #result, #error { margin-top: 20px; padding: 15px; border-radius: 8px; }
        #result { background: rgba(0,255,234,0.1); border: 1px solid #00ffea; }
        #error { background: rgba(255,0,100,0.1); border: 1px solid #ff0064; color: #ff7bac; }
        .hidden { display: none; }
        .admin-link { margin-top: 20px; text-align: center; }
        .admin-link a { color: #ffaa00; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Generate Key</h1>
        <div class="user-info">
            Logged in as: <?= htmlspecialchars($_SESSION['username']) ?> 
            (<a href="logout.php" style="color:#ff0064;">Logout</a>)
        </div>
    </div>
    
    <div class="generator">
        <p>Enter your DRIP CLIENT User ID to generate key:</p>
        <div class="input-group">
            <input type="text" id="userID" placeholder="User ID (e.g., 123456789)" maxlength="32">
        </div>
        <button class="button" onclick="generateKey()"><i class="fas fa-key"></i> Generate Key</button>
        
        <div id="result" class="hidden">
            <p>Your key: <strong id="generatedKey"></strong></p>
            <button class="button" onclick="copyKey()"><i class="far fa-copy"></i> Copy</button>
        </div>
        <div id="error" class="hidden"></div>
        
        <?php if ($is_admin): ?>
        <div class="admin-link">
            <a href="admin.php">Go to Admin Panel</a>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        async function generateKey() {
            const userID = document.getElementById('userID').value.trim();
            const result = document.getElementById('result');
            const error = document.getElementById('error');
            
            result.classList.add('hidden');
            error.classList.add('hidden');
            
            if (!userID) {
                error.textContent = 'Enter User ID.';
                error.classList.remove('hidden');
                return;
            }
            
            const response = await fetch('generate_key.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userID: userID })
            });
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('generatedKey').textContent = data.key;
                result.classList.remove('hidden');
            } else {
                error.textContent = data.error;
                error.classList.remove('hidden');
            }
        }
        
        function copyKey() {
            const key = document.getElementById('generatedKey').textContent;
            navigator.clipboard.writeText(key);
            alert('Copied!');
        }
    </script>
</body>
</html>
