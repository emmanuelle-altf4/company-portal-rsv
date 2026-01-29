<?php
include 'db.php';

$reservations = $conn->query("SELECT * FROM reservations")->fetchAll();

echo "<h2>Reservation Calendar</h2>";
echo "<ul>";
foreach ($reservations as $res) {
    echo "<li>Reservation ID: {$res['id']} | Check-in: {$res['check_in']} | Check-out: {$res['check_out']}</li>";
}
echo "</ul>";
?>
