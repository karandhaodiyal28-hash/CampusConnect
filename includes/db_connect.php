<?php
// Database connection (credentials live in config.php, which is gitignored)
if (!file_exists(__DIR__ . '/config.php')) {
    die("Configuration missing: copy includes/config.sample.php to includes/config.php and set your DB credentials.");
}
require_once __DIR__ . '/config.php';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// Auto-delete logic: remove claimed items older than 6 months
$conn->query("DELETE FROM items WHERE status = 'Claimed' AND date_found < DATE_SUB(NOW(), INTERVAL 6 MONTH)");
