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
            <p>Helping students <span id="typed-text" class="typed-text"></span><span class="typed-cursor">|</span></p>
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

    <script>
    // Typewriter effect: types a phrase, backspaces it, then types the next one
    (function () {
        const phrases = [
            "reconnect with lost belongings.",
            "find what they lost.",
            "recover items quickly & safely."
        ];
        const el = document.getElementById('typed-text');
        if (!el) return;
        let phraseIndex = 0, charIndex = 0, deleting = false;
        function tick() {
            const current = phrases[phraseIndex];
            charIndex += deleting ? -1 : 1;
            el.textContent = current.substring(0, charIndex);
            let delay = deleting ? 45 : 90;
            if (!deleting && charIndex === current.length) {
                delay = 1600;          // pause on the full phrase
                deleting = true;
            } else if (deleting && charIndex === 0) {
                deleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                delay = 400;
            }
            setTimeout(tick, delay);
        }
        tick();
    })();
    </script>
</body>
</html>
