<?php
session_start();
// Security Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db_connect.php';

// Action: Mark as Claimed
if (isset($_GET['mark_claimed'])) {
    $id = $_GET['mark_claimed'];
    $conn->query("UPDATE items SET status='Claimed' WHERE id=$id");
    header("Location: dashboard.php");
}

// Action: Delete Item
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM items WHERE id=$id");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="navbar">
        <div class="logo">Admin <span>Panel</span></div>
        <nav>
            <a href="export_data.php" style="background:#27ae60;">Download Backup (Excel)</a>
            <a href="../index.php">View Website</a>
            <a href="logout.php" style="background:#c0392b;">Logout</a>
        </nav>
    </div>

    <main>
        <h2>Manage Items</h2>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM items ORDER BY date_found DESC");
            while ($row = $result->fetch_assoc()) {
                $color = ($row['status'] == 'Available') ? 'green' : 'red';
                echo "<tr>";
                echo "<td>".$row['item_name']."</td>";
                echo "<td>".$row['category']."</td>";
                echo "<td style='color:$color; font-weight:bold;'>".$row['status']."</td>";
                echo "<td>".$row['date_found']."</td>";
                echo "<td>";
                if ($row['status'] == 'Available') {
                    echo "<a href='?mark_claimed=".$row['id']."' class='btn' style='background:blue; padding:5px;'>Mark Claimed</a> ";
                }
                echo "<a href='?delete=".$row['id']."' class='btn' style='background:red; padding:5px;' onclick='return confirm(\"Delete this item?\")'>Delete</a>";
                echo "</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
