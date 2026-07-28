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
    $id = (int)$_GET['mark_claimed'];
    $stmt = $conn->prepare("UPDATE items SET status='Claimed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Action: Delete Item (also removes its image file)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("SELECT item_image FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($row = $stmt->get_result()->fetch_assoc()) {
        $img = '../uploads/items/' . basename($row['item_image']);
        if (is_file($img)) {
            unlink($img);
        }
    }

    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Admin Dashboard | CampusConnect</title>
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
                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_found']) . "</td>";
                echo "<td>";
                if ($row['status'] == 'Available') {
                    echo "<a href='?mark_claimed=" . (int)$row['id'] . "' class='btn' style='background:blue; padding:5px;'>Mark Claimed</a> ";
                }
                echo "<a href='?delete=" . (int)$row['id'] . "' class='btn' style='background:red; padding:5px;' onclick='return confirm(\"Delete this item?\")'>Delete</a>";
                echo "</td></tr>";
            }
            ?>
        </table>

        <h2 style="margin-top:40px;">Recent Claims</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Claimer Name</th>
                <th>Student ID</th>
                <th>Mobile</th>
                <th>ID Card Proof</th>
            </tr>
            <?php
            $claims = $conn->query("SELECT c.*, i.item_name FROM claims c LEFT JOIN items i ON c.item_id = i.id ORDER BY c.id DESC");
            if ($claims && $claims->num_rows > 0) {
                while ($c = $claims->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($c['item_name'] ?? 'Deleted item') . "</td>";
                    echo "<td>" . htmlspecialchars($c['claimer_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($c['student_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($c['mobile']) . "</td>";
                    echo "<td><a href='../uploads/id_cards/" . htmlspecialchars($c['claimer_id_card']) . "' target='_blank'>View ID</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No claims yet.</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
