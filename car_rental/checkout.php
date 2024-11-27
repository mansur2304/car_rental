<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $car_id = $_POST['car_id'];

    // Update car status to 'Available'
    $updateCar = $pdo->prepare("UPDATE cars SET status = 'Available' WHERE id = ?");
    $updateCar->execute([$car_id]);

    // Delete the booking entry
    $deleteBooking = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    $deleteBooking->execute([$booking_id]);

    // Redirect back to the dashboard
    header("Location: dashboard.php");
    exit;
}
?>
