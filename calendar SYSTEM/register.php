<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $Fullname = $_POST['Fullname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, Fullname, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $Fullname, $password]);

    echo "Registration successful! <a href='login.php'>Login here</a>";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="Fullname" name="Fullname" placeholder="Fullname" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
