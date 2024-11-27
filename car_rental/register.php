<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $driving_license = $_POST['driving_license'];
    $aadhar_number = $_POST['aadhar_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, driving_license, aadhar_number, username, password)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$fullname, $email, $phone, $driving_license, $aadhar_number, $username, $password])) {
        header("Location: login.php");
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('AIeR8eZ-wallpapers-of-cars.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    
    <form method="POST">
    <h2>Register</h2>
        <input type="text" name="fullname" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone" placeholder="Phone" required><br>
        <input type="text" name="driving_license" placeholder="Driving License" required><br>
        <input type="text" name="aadhar_number" placeholder="Aadhar Number" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <button type="submit">Register</button>
    </form>
</body>
</html>
