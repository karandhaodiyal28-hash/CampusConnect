<?php
session_start();
include 'includes/db_connect.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin/dashboard.php");
    } else {
        $error = "Invalid Credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Admin Login</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Admin Login</h2>
        <form method="POST">
            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
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
