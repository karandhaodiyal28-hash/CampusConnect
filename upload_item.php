<?php
include 'includes/db_connect.php';
include 'includes/upload_helper.php';

$error = null;

if (isset($_POST['submit'])) {
    $name = trim($_POST['item_name']);
    $cat  = trim($_POST['category']);
    $loc  = trim($_POST['location']);
    $desc = trim($_POST['description']);

    if ($name === '' || $loc === '') {
        $error = "Item name and location are required.";
    } else {
        // Safe image upload (validates type & size, random filename)
        list($ok, $value) = save_uploaded_image('item_image', 'uploads/items');

        if ($ok) {
            // Prepared statement — prevents SQL injection
            $stmt = $conn->prepare("INSERT INTO items (item_name, category, location, description, item_image, status) VALUES (?, ?, ?, ?, ?, 'Available')");
            $stmt->bind_param("sssss", $name, $cat, $loc, $desc, $value);

            if ($stmt->execute()) {
                echo "<script>alert('Thank you for helping! Item listed successfully.'); window.location='index.php';</script>";
                exit();
            }
            $error = "Something went wrong while saving. Please try again.";
        } else {
            $error = $value;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Report Found Item | CampusConnect</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Report a Found Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <?php if ($error) echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; ?>

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

            <label>Upload Photo (JPG/PNG/WEBP, max 3 MB)</label>
            <input type="file" name="item_image" accept="image/jpeg,image/png,image/webp" required>

            <button type="submit" name="submit" class="btn" style="width:100%;">Submit Item</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
