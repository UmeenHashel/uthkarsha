<?php
include '../connect.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Fetch admin and users
$admin_sql = "SELECT * FROM admin";
$admin_result = $conn->query($admin_sql);

$user_sql = "SELECT * FROM users";
$user_result = $conn->query($user_sql);

// Add admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
    $conn->query($sql);
}

// Add user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO users (username, email, password, first_name, last_name, phone, address) VALUES ('$username', '$email', '$password', '$first_name', '$last_name', '$phone', '$address')";
    $conn->query($sql);
}

// Delete admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_admin'])) {
    $admin_id = $_POST['admin_id'];
    $sql = "DELETE FROM admin WHERE admin_id='$admin_id'";
    $conn->query($sql);
}

// Delete user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE user_id='$user_id'";
    $conn->query($sql);
}

// Update admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_admin'])) {
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE admin SET username='$username', password='$password' WHERE admin_id='$admin_id'";
    $conn->query($sql);
}

// Update user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE users SET username='$username', email='$email', password='$password', first_name='$first_name', last_name='$last_name', phone='$phone', address='$address' WHERE user_id='$user_id'";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/user_management.css">
</head>
<body>
    <header>
        <?php include 'admin_navbar.php'; ?>
    </header>
    <main>
        <section id="admin-management" class="dashboard-section">
            <h2>Admin Management</h2>
            <form action="user_management.php" method="POST" class="user-form">
                <input type="hidden" name="admin_id" id="admin_id">
                <input type="text" name="username" id="admin_username" placeholder="Username" required>
                <input type="password" name="password" id="admin_password" placeholder="Password" required>
                <button type="submit" name="add_admin">Add Admin</button>
                <button type="submit" name="update_admin">Update Admin</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = $admin_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $admin['admin_id']; ?></td>
                        <td><?php echo $admin['username']; ?></td>
                        <td>
                            <button onclick="editAdmin(<?php echo $admin['admin_id']; ?>, '<?php echo $admin['username']; ?>')">Edit</button>
                            <form action="user_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                                <button type="submit" name="delete_admin">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section id="user-management" class="dashboard-section">
            <h2>User Management</h2>
            <form action="user_management.php" method="POST" class="user-form">
                <input type="hidden" name="user_id" id="user_id">
                <input type="text" name="username" id="user_username" placeholder="Username" required>
                <input type="email" name="email" id="user_email" placeholder="Email" required>
                <input type="password" name="password" id="user_password" placeholder="Password" required>
                <input type="text" name="first_name" id="user_first_name" placeholder="First Name" required>
                <input type="text" name="last_name" id="user_last_name" placeholder="Last Name" required>
                <input type="text" name="phone" id="user_phone" placeholder="Phone" required>
                <textarea name="address" id="user_address" placeholder="Address" required></textarea>
                <button type="submit" name="add_user">Add User</button>
                <button type="submit" name="update_user">Update User</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $user_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['first_name']; ?></td>
                        <td><?php echo $user['last_name']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $user['address']; ?></td>
                        <td>
                            <button onclick="editUser(<?php echo $user['user_id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['first_name']; ?>', '<?php echo $user['last_name']; ?>', '<?php echo $user['phone']; ?>', '<?php echo $user['address']; ?>')">Edit</button>
                            <form action="user_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="delete_user">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function editAdmin(id, username) {
            document.getElementById('admin_id').value = id;
            document.getElementById('admin_username').value = username;
        }

        function editUser(id, username, email, firstName, lastName, phone, address) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_username').value = username;
            document.getElementById('user_email').value = email;
            document.getElementById('user_first_name').value = firstName;
            document.getElementById('user_last_name').value = lastName;
            document.getElementById('user_phone').value = phone;
            document.getElementById('user_address').value = address;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
