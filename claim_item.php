<?php
include 'includes/db_connect.php';
include 'includes/upload_helper.php';

// Validate item id (must be a number)
$item_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($item_id <= 0) {
    header("Location: index.php");
    exit();
}

// Make sure the item exists and is still available
$stmt = $conn->prepare("SELECT id, item_name, category, location FROM items WHERE id = ? AND status = 'Available'");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    echo "<script>alert('Sorry, this item is no longer available.'); window.location='index.php';</script>";
    exit();
}

$error = null;

if (isset($_POST['claim'])) {
    $name   = trim($_POST['name']);
    $sid    = trim($_POST['student_id']);
    $mobile = trim($_POST['mobile']);

    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $error = "Please enter a valid 10-digit mobile number.";
    } else {
        // Safe ID card upload
        list($ok, $value) = save_uploaded_image('id_card', 'uploads/id_cards', 'ID_');

        if ($ok) {
            // Prepared statement — prevents SQL injection
            $ins = $conn->prepare("INSERT INTO claims (item_id, claimer_name, student_id, mobile, claimer_id_card) VALUES (?, ?, ?, ?, ?)");
            $ins->bind_param("issss", $item_id, $name, $sid, $mobile, $value);

            if ($ins->execute()) {
                // Update item status
                $up = $conn->prepare("UPDATE items SET status = 'Claimed' WHERE id = ?");
                $up->bind_param("i", $item_id);
                $up->execute();

                echo "<script>alert('Claim Successful! Please visit the Lost & Found office.'); window.location='index.php';</script>";
                exit();
            }
            $error = "Something went wrong while saving your claim. Please try again.";
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
    <title>Claim Item | CampusConnect</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h2 style="text-align:center;">Claim Verification</h2>
        <form method="POST" enctype="multipart/form-data">
            <p>You are claiming: <b><?php echo htmlspecialchars($item['item_name']); ?></b>
               (<?php echo htmlspecialchars($item['category']); ?> — found at <?php echo htmlspecialchars($item['location']); ?>)</p>

            <?php if ($error) echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; ?>

            <label>Your Name</label>
            <input type="text" name="name" required>

            <label>Student ID (Compulsory)</label>
            <input type="text" name="student_id" required>

            <label>Mobile Number (Compulsory)</label>
            <input type="tel" name="mobile" pattern="[0-9]{10}" placeholder="10-digit mobile number" required>

            <label>Upload Your College ID Card (JPG/PNG/WEBP, max 3 MB)</label>
            <input type="file" name="id_card" accept="image/jpeg,image/png,image/webp" required>

            <button type="submit" name="claim" class="btn" style="width:100%;">Submit Claim</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
