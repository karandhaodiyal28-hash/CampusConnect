<?php
session_start();
include 'includes/db_connect.php';

// Already logged in? Go straight to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin/dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // Prepared statement — prevents SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Supports hashed passwords; falls back to legacy plaintext and upgrades the hash
        $valid = password_verify($pass, $row['password']);
        if (!$valid && hash_equals($row['password'], $pass)) {
            $valid = true;
            $newHash = password_hash($pass, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
            $up->bind_param("si", $newHash, $row['id']);
            $up->execute();
        }
        if ($valid) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin/dashboard.php");
            exit();
        }
    }
    $error = "Invalid Credentials!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Admin Login | CampusConnect</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Admin Login</h2>
        <form method="POST">
            <?php if (isset($error)) echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; ?>
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit" name="login" class="btn" style="width:100%;">Login</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
