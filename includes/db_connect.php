<?php
// Details taken directly from your screenshot
$servername = "sql101.infinityfree.com";             // MySQL Host Name
$username = "YOUR_DB_USERNAME";                      // MySQL User Name
$password = "YOUR_DB_PASSWORD";             // ⚠️ REPLACE THIS with your real password
$dbname = "YOUR_DB_NAME";                            // MySQL Database Name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Auto-delete logic
$cleanup = "DELETE FROM items WHERE status = 'Claimed' AND date_found < DATE_SUB(NOW(), INTERVAL 6 MONTH)";
$conn->query($cleanup);
?>
