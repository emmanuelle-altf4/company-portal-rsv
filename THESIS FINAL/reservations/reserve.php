<?php
// reserve.php
$pdo = new PDO('mysql:host=localhost;dbname=resort', 'username', '');
$data = json_decode(file_get_contents("php://index.php"));

$roomId = $data->roomId;
$startDate = $data->startDate;
$endDate = $data->endDate;
$userId = 1; // For demonstration; replace with actual user ID

// Check room availability here (optional)

// Insert reservation
$stmt = $pdo->prepare("INSERT INTO reservations (user_id, room_id, start_date, end_date) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$userId, $roomId, $startDate, $endDate])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not reserve the room.']);
}
?>
