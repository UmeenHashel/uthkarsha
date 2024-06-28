<?php
include 'connect.php';

// Fetch all FAQs
$sql = "SELECT question, answer FROM faqs";
$result = $conn->query($sql);

$faqs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
} else {
    $faqs = "No FAQs available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="css/navbar.css"> <!-- Assuming the navbar.css is in a css folder -->
    <link rel="stylesheet" href="css/faq.css"> <!-- Include the faq.css here -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var acc = document.getElementsByClassName("accordion");
            for (var i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
        });
    </script>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <div class="faq-container">
            <h2>Frequently Asked Questions</h2>
            <?php if (is_array($faqs) && count($faqs) > 0): ?>
                <?php foreach ($faqs as $faq): ?>
                    <button class="accordion"><?php echo htmlspecialchars($faq['question']); ?></button>
                    <div class="panel">
                        <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo htmlspecialchars($faqs); ?></p>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
