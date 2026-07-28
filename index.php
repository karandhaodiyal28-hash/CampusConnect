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
            <h1>Lost &amp; Found Portal</h1>
            <p>Helping students reconnect with their lost belongings.</p>
        </div>

        <?php
        $search   = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';
        $categories = ['Electronics', 'Documents', 'Clothing', 'Money', 'Others'];
        ?>

        <!-- Search & Filter -->
        <form method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Search by item name or location..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?php echo $c; ?>" <?php if ($category === $c) echo 'selected'; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Search</button>
        </form>

        <div class="grid">
            <?php
            // Only show AVAILABLE items (with optional search/filter) — prepared statement
            $sql    = "SELECT * FROM items WHERE status = 'Available'";
            $params = [];
            $types  = '';

            if ($search !== '') {
                $sql .= " AND (item_name LIKE ? OR location LIKE ?)";
                $like = "%$search%";
                $params[] = $like;
                $params[] = $like;
                $types .= 'ss';
            }
            if ($category !== '' && in_array($category, $categories, true)) {
                $sql .= " AND category = ?";
                $params[] = $category;
                $types .= 's';
            }
            $sql .= " ORDER BY date_found DESC";

            $stmt = $conn->prepare($sql);
            if ($params) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $img = htmlspecialchars($row['item_image']);
                    echo "<div class='card'>";
                    echo "<img src='uploads/items/$img' alt='" . htmlspecialchars($row['item_name']) . "' loading='lazy'>";
                    echo "<div class='card-content'>";
                    echo "<h3>" . htmlspecialchars($row['item_name']) . "</h3>";
                    echo "<p class='status-tag'>" . htmlspecialchars($row['category']) . "</p>";
                    echo "<p><b>Location:</b> " . htmlspecialchars($row['location']) . "</p>";
                    echo "<a href='claim_item.php?id=" . (int)$row['id'] . "' class='btn'>Claim Now</a>";
                    echo "</div></div>";
                }
            } else {
                echo "<p style='text-align:center; width:100%;'>No lost items found currently.</p>";
            }
            ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
