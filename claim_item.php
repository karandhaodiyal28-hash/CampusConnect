<?php
include 'includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$item_id = $_GET['id'];

if(isset($_POST['claim'])){
    $name = $_POST['name'];
    $sid = $_POST['student_id'];
    $mobile = $_POST['mobile'];
    
    // ID Card Upload
    $target_dir = "uploads/id_cards/";
    $id_name = time() . "_ID_" . basename($_FILES["id_card"]["name"]);
    $target_file = $target_dir . $id_name;
    
    if (move_uploaded_file($_FILES["id_card"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO claims (item_id, claimer_name, student_id, mobile, claimer_id_card) 
                VALUES ('$item_id', '$name', '$sid', '$mobile', '$id_name')";
        
        if ($conn->query($sql) === TRUE) {
            // Update Item Status
            $conn->query("UPDATE items SET status='Claimed' WHERE id=$item_id");
            echo "<script>alert('Claim Successful! Please visit the Lost & Found office.'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Error uploading ID Card.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Claim Item</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Claim Verification</h2>
        <form method="POST" enctype="multipart/form-data">
            <p>Please provide your details to claim this item.</p>
            
            <label>Your Name</label>
            <input type="text" name="name" required>
            
            <label>Student ID (Compulsory)</label>
            <input type="text" name="student_id" required>
            
            <label>Mobile Number (Compulsory)</label>
            <input type="text" name="mobile" required>
            
            <label>Upload Your College ID Card</label>
            <input type="file" name="id_card" required>
            
            <button type="submit" name="claim" class="btn" style="width:100%;">Submit Claim</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
