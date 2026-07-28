<?php include 'includes/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusConnect | Home</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <div style="text-align:center; margin-bottom:40px;">
            <h1>Lost & Found Portal</h1>
            <p>Helping students reconnect with their lost belongings.</p>
        </div>

        <div class="grid">
            <?php
            // Only show AVAILABLE items
            $sql = "SELECT * FROM items WHERE status = 'Available' ORDER BY date_found DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<img src='uploads/items/".$row['item_image']."' alt='Item'>";
                    echo "<div class='card-content'>";
                    echo "<h3>".$row['item_name']."</h3>";
                    echo "<p class='status-tag'>".$row['category']."</p>";
                    echo "<p><b>Location:</b> ".$row['location']."</p>";
                    echo "<a href='claim_item.php?id=".$row['id']."' class='btn'>Claim Now</a>";
                    echo "</div></div>";
                }
            } else {
                echo "<p style='text-align:center; width:100%;'>No lost items reported currently.</p>";
            }
            ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
