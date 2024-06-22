<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <div class="container">

        <div class="profile-header">
            <img src="img/avatar.jpg" alt="User Avatar" class="avatar">
            <h1 id="username"><?php echo $user['username']; ?></h1>
            <p id="email"><?php echo $user['email']; ?></p>
        </div>


        <div class="profile-details">
            <h2>Profile Details</h2>
            <div class="detail">
                <span class="label">First Name:</span>
                <span class="value" id="first_name"><?php echo $user['first_name']; ?></span>
            </div>
            <div class="detail">
                <span class="label">Last Name:</span>
                <span class="value" id="Last_name"><?php echo $user['Last_name']; ?></span>
            </div>
            <div class="detail">
                <span class="label">Email:</span>
                <span class="value" id="email"><?php echo $user['email']; ?></span>
                <div class="detail">
                    <span class="label">Phone:</span>
                    <span class="value" id="phone"><?php echo $user['phone']; ?></span>
                </div></span>
            </div>

            <div class="detail">
                <span class="label">Address:</span>
                <span class="value" id="address"><?php echo $user['address']; ?></span>
            </div>
        </div>
    </div>
</body>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userProfile = {
        username: "John Doe",
        email: "john.doe@example.com",
        fullName: "Johnathan Doe",
        phone: "+1234567890",
        address: "123 Main St, Springfield",

    };

    document.getElementById('username').innerText = userProfile.username;
    document.getElementById('email').innerText = userProfile.email;
    document.getElementById('fullName').innerText = userProfile.fullName;
    document.getElementById('userEmail').innerText = userProfile.email;
    document.getElementById('phone').innerText = userProfile.phone;
    document.getElementById('address').innerText = userProfile.address;

});
</script>


</html>