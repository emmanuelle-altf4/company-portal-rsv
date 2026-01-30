<?php
// get_rooms.php
$pdo = new PDO('mysql:host=localhost;dbname=resort', 'username', 'password');
$stmt = $pdo->query("SELECT id, room_type, price FROM rooms WHERE available > 0");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rooms);
?>
