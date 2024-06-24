<?php
include 'connect.php';

// Fetch all terms and conditions
$sql = "SELECT content FROM terms_conditions";
$result = $conn->query($sql);

$terms = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $terms .= $row['content'] . "\n\n";
    }
} else {
    $terms = "No terms and conditions available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="css/navbar.css"> 
    <link rel="stylesheet" href="css/terms_conditions.css">  
    <style>
        .terms-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .terms-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="terms-container">
        <h1>Terms and Conditions</h1>
        <div class="terms-card">
            <p><?php echo nl2br(htmlspecialchars($terms)); ?></p>
        </div>
    </div>
</body>
</html>
