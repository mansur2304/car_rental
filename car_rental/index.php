<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard if user is already logged in
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Service</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Background styling */
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

        /* Blur effect for container */
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Apply blur effect */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        .container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .container p {
            margin-bottom: 20px;
            color: #666;
        }

        .container a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .container a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Car Rental Service</h1>
        <p>Your one-stop destination for hassle-free car rentals.</p>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>
</body>
</html>
