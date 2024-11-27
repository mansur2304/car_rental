<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user->execute([$user_id]);
$user = $user->fetch();

// Fetch available cars
$cars = $pdo->query("SELECT * FROM cars WHERE status = 'Available'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $driving_license = $_POST['driving_license'];
    $aadhar_number = $_POST['aadhar_number'];
    $checkin_date = $_POST['checkin_date'];

    // Validate that the user's details match their session-stored data
    if ($driving_license !== $user['driving_license'] || $aadhar_number !== $user['aadhar_number']) {
        echo "<p style='color: red;'>Booking failed: Details do not match your account information.</p>";
    } else {
        // Insert booking and update car status
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, car_id, driving_license, aadhar_number, checkin_date) 
                               VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $car_id, $driving_license, $aadhar_number, $checkin_date])) {
            $pdo->prepare("UPDATE cars SET status = 'Booked' WHERE id = ?")->execute([$car_id]);
            header("Location: dashboard.php");
        } else {
            echo "<p style='color: red;'>Booking failed.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Car</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styles for the caution card and form */
        .caution-card {
            background-color: #ffcc00;
            color: #000;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            width: 500px;
            margin: 0 auto;
        }
        form input, form select, form button {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form button {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Book a Car</h2>

        <!-- Caution Warning -->
        <div class="caution-card">
            <h3>Caution: Payment Requirement</h3>
            <p>At the time of check-in, you are required to pay 50% of the total booking amount. Please ensure you are prepared for the payment during check-in.</p>
        </div>

        <!-- Booking Form -->
        <form method="POST">
            <select name="car_id" required>
                <?php foreach ($cars as $car): ?>
                <option value="<?= $car['id'] ?>"><?= $car['car_name'] ?> (<?= $car['car_number'] ?>)</option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" name="driving_license" value="<?= htmlspecialchars($user['driving_license']) ?>" readonly><br>
            <input type="text" name="aadhar_number" value="<?= htmlspecialchars($user['aadhar_number']) ?>" readonly><br>
            <input type="date" name="checkin_date" required><br>
            <button type="submit">Book</button>
        </form>
    </div>
</body>
</html>
