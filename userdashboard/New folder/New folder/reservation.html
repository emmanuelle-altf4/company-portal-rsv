<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];
    $room_type = $_POST['room_type'];
    $total_price = $_POST['total_price'];

    $stmt = $conn->prepare("INSERT INTO reservations (user_id, check_in, check_out, guests, room_type, total_price) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $check_in, $check_out, $guests, $room_type, $total_price]);

    echo "Reservation made successfully!";
}
?>

<form method="POST">
    <input type="date" name="check_in" required>
    <input type="date" name="check_out" required>
    <input type="number" name="guests" placeholder="Number of Guests" required>
    <select name="room_type">
        <option value="Deluxe">Deluxe</option>
        <option value="Suite">Suite</option>
    </select>
    <input type="number" name="total_price" placeholder="Total Price" required>
    <button type="submit">Reserve</button>
</form>
