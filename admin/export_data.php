<?php
session_start();
// Security Check — only logged-in admins can download data
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db_connect.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=Campus_Data_Backup.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Item ID', 'Item Name', 'Category', 'Status', 'Date Found', 'Claimer Name', 'Claimer Mobile', 'Claimer Student ID'));

$sql = "SELECT items.id, items.item_name, items.category, items.status, items.date_found, 
        claims.claimer_name, claims.mobile, claims.student_id 
        FROM items LEFT JOIN claims ON items.id = claims.item_id";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit();
