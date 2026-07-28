<?php
include 'includes/db_connect.php';

if(isset($_POST['submit'])){
    $name = $_POST['item_name'];
    $cat = $_POST['category'];
    $loc = $_POST['location'];
    $desc = $_POST['description'];
    
    // Image Upload
    $target_dir = "uploads/items/";
    $image_name = time() . "_" . basename($_FILES["item_image"]["name"]);
    $target_file = $target_dir . $image_name;
    
    if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO items (item_name, category, location, description, item_image, status) 
                VALUES ('$name', '$cat', '$loc', '$desc', '$image_name', 'Available')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thank you for helping! Item listed successfully.'); window.location='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Error uploading image.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Report Found Item</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Report a Found Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Item Name</label>
            <input type="text" name="item_name" placeholder="e.g. Blue Backpack" required>
            
            <label>Category</label>
            <select name="category">
                <option value="Electronics">Electronics</option>
                <option value="Documents">Documents/ID</option>
                <option value="Clothing">Clothing</option>
                <option value="Money">Money/Wallet</option>
                <option value="Others">Others</option>
            </select>
            
            <label>Location Found</label>
            <input type="text" name="location" placeholder="e.g. Canteen Table 4" required>
            
            <label>Description</label>
            <textarea name="description" placeholder="Any specific details..." rows="4"></textarea>
            
            <label>Upload Photo</label>
            <input type="file" name="item_image" required>
            
            <button type="submit" name="submit" class="btn" style="width:100%;">Submit Item</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
