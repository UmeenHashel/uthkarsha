<?php
include '../connect.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Add FAQ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_faq'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";
    $conn->query($sql);
}

// Delete FAQ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_faq'])) {
    $faq_id = $_POST['faq_id'];
    $sql = "DELETE FROM faqs WHERE faq_id='$faq_id'";
    $conn->query($sql);
}

// Update FAQ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_faq'])) {
    $faq_id = $_POST['faq_id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "UPDATE faqs SET question='$question', answer='$answer' WHERE faq_id='$faq_id'";
    $conn->query($sql);
}

// Fetch FAQs
$faqs = $conn->query("SELECT * FROM faqs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Management - Admin</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/faq_management.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <h1>FAQ Management</h1>

    <form action="faq_management.php" method="POST" class="faq-form">
        <input type="hidden" name="faq_id" id="faq_id">
        <textarea name="question" id="question" placeholder="Question" required></textarea>
        <textarea name="answer" id="answer" placeholder="Answer" required></textarea>
        <button type="submit" name="add_faq">Add FAQ</button>
        <button type="submit" name="update_faq">Update FAQ</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($faq = $faqs->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $faq['faq_id']; ?></td>
                <td><?php echo $faq['question']; ?></td>
                <td><?php echo $faq['answer']; ?></td>
                <td>
                    <button type="button" onclick="editFAQ(<?php echo $faq['faq_id']; ?>, '<?php echo addslashes($faq['question']); ?>', '<?php echo addslashes($faq['answer']); ?>')">Edit</button>
                    <form action="faq_management.php" method="POST" style="display:inline;">
                        <input type="hidden" name="faq_id" value="<?php echo $faq['faq_id']; ?>">
                        <button type="submit" name="delete_faq">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

