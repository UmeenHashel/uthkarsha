<?php
include 'connect.php';

function hashPasswords($conn, $table) {
    // Fetch all usernames and plain text passwords
    $stmt = $conn->prepare("SELECT username, password FROM $table");
    $stmt->execute();
    $stmt->bind_result($username, $password);
    $stmt->store_result();

    // Prepare an update statement
    $update_stmt = $conn->prepare("UPDATE $table SET password = ? WHERE username = ?");

    while ($stmt->fetch()) {
        // Hash the plain text password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password with the hashed password
        $update_stmt->bind_param("ss", $hashed_password, $username);
        $update_stmt->execute();
    }

    $stmt->close();
    $update_stmt->close();
}

// Hash passwords for both admin and users tables
hashPasswords($conn, 'admin');
hashPasswords($conn, 'users');

$conn->close();

echo "Passwords have been hashed and updated successfully.";
?>
