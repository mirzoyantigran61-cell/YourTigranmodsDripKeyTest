<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    die("Access denied.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #4361ee; text-align: left; }
        th { background: #1a1a2e; }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    <p>Logged in as: <?= $_SESSION['username'] ?> | <a href="dashboard.php">Back to Dashboard</a></p>
    
    <h2>All Keys</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID (External)</th>
            <th>Generated Key</th>
            <th>Created At</th>
            <th>Status</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM `keys` ORDER BY created_at DESC");
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['user_id_external']) ?></td>
            <td><?= htmlspecialchars($row['generated_key']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
