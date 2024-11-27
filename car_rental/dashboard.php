<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$cars = $pdo->query("SELECT * FROM cars")->fetchAll();
$bookings = $pdo->prepare("SELECT b.*, c.car_name FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = ?");
$bookings->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="header">
        <div class="user-info">
            <h2>Welcome, <?= $_SESSION['fullname'] ?> (<?= $_SESSION['email'] ?>)</h2>
        </div>
        <nav class="nav-links">
            <a href="booking.php" class="button">Book Now</a>
            <a href="logout.php" class="button logout">Logout</a>
        </nav>
    </header>
    
    <h3>Available Cars</h3>
<table border="1">
    <tr>
        <th>Car Number</th>
        <th>Car Name</th>
        <th>Rent Price (INR)</th>
        <th>Status</th>
    </tr>
    <?php foreach ($cars as $car): ?>
    <tr>
        <td><?= $car['car_number'] ?></td>
        <td><?= $car['car_name'] ?></td>
        <td><?= number_format($car['rent_price'], 2) ?></td>
        <td><?= $car['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>


<h3>Your Bookings</h3>
<table border="1">
    <tr>
        <th>Car Name</th>
        <th>Check-in Date</th>
        <th>Action</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
    <tr>
        <td><?= $booking['car_name'] ?></td>
        <td><?= $booking['checkin_date'] ?></td>
        <td>
            <form action="checkout.php" method="post" style="display: inline;">
                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                <input type="hidden" name="car_id" value="<?= $booking['car_id'] ?>">
                <button type="submit" class="button">Checkout</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
