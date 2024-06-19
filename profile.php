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
            <h1 id="username">John Doe</h1>
            <p id="email">john.doe@example.com</p>
        </div>
        <div class="profile-details">
            <h2>Profile Details</h2>
            <div class="detail">
                <span class="label">Full Name:</span>
                <span class="value" id="fullName">Johnathan Doe</span>
            </div>
            <div class="detail">
                <span class="label">Email:</span>
                <span class="value" id="userEmail">john.doe@example.com</span>
            </div>
            <div class="detail">
                <span class="label">Phone:</span>
                <span class="value" id="phone">+1234567890</span>
            </div>
            <div class="detail">
                <span class="label">Address:</span>
                <span class="value" id="address">123 Main St, Springfield</span>
            </div>
            <div class="detail">
                <span class="label">Member Since:</span>
                <span class="value" id="memberSince">January 2020</span>
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
        memberSince: "January 2020"
    };

    document.getElementById('username').innerText = userProfile.username;
    document.getElementById('email').innerText = userProfile.email;
    document.getElementById('fullName').innerText = userProfile.fullName;
    document.getElementById('userEmail').innerText = userProfile.email;
    document.getElementById('phone').innerText = userProfile.phone;
    document.getElementById('address').innerText = userProfile.address;
    document.getElementById('memberSince').innerText = userProfile.memberSince;
});
</script>


</html>