<?php
include 'connect.php';

$sql = "SELECT content FROM privacy_policy";
$result = $conn->query($sql);

$policy = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $policy .= $row['content'] . "\n\n";
    }
} else {
    $policy = "No privacy policy available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
    <link rel="stylesheet" href="css/navbar.css"> 
    <link rel="stylesheet" href="css/privacy_policy.css"> 
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="policy-container">
        <div class="policy-card">
            <h1>Privacy Policy</h1>
            <p><?php echo nl2br(htmlspecialchars($policy)); ?></p>
        </div>
    </div>
</body>
</html>
