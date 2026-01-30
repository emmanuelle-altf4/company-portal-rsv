<?php
include 'db.php';
session_start();

// Ensure only admin can access this page.
if ($_SESSION['role'] != 'admin') {
    die("Access denied!");
}

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $amount_paid = $_POST['amount_paid'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("
        INSERT INTO payments (reservation_id, amount_paid, payment_method) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$reservation_id, $amount_paid, $payment_method]);

    echo "Payment added successfully!";
}

$reservations = $conn->query("SELECT id FROM reservations")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

 <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
                .AA {
            background-color: #343a40;
            padding: 0 16px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }
        .AA h2 {
            font-size: 24px;
        }
        .BB {
            background-color: #2c2f33;
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            color: #fff;
        }
        .BB a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            padding: 15px 20px;
            display: block;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }
        .BB a:hover {
            background-color: #41464b;
        }
        .BB .active {
            background-color: #1d2124;
        }
        .CC {
            margin-left: 240px;
            padding: 20px;
        }
        .CC h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .icon-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .icon {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 180px;
            text-align: center;
            transition: box-shadow 0.3s ease;
        }
        .icon i {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .icon:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .user-menu {
            display: flex;
            align-items: center;
            color: white;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 12px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .CC {
                margin-left: 0;
            }
            .BB {
                position: relative;
                width: 100%;
                height: auto;
                padding: 0;
            }
            .icon-container {
                flex-direction: column;
                align-items: center;
            }
        }

        .DD {
            text-align: center;
            width: 100%;
        }

        .DD table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        .DD th, .DD td {
            border: 1px solid #ddd; 
            padding: 8px;
        }
        
    </style> 

</head>




<body class="bg-light">
<nav class="AA">
        <h2>Dashboard</h2>
        <div class="user-menu">
            <button onclick="window.location.href='../Enter_role.php';">Enter Role</button>
        </div>
    </nav>

 <div class="BB">
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="enter_role.php"><i class="fas fa-users"></i> User Control</a>
        <a href="Calendar.php" class="active"><i class="fas fa-calendar-alt"></i> Calendar/Reservations</a>
        <a href="addpayment.php"><i class="fas fa-credit-card"></i> Payments</a>
        <a href="userdashboard/user_logs.php"><i class="fas fa-history"></i> User Logs</a>
        <a href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
    </div>
    
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Payment</h2>
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="reservation_id" class="form-label">Reservation ID</label>
                <select name="reservation_id" id="reservation_id" class="form-select">
    <option value="">Select Reservation</option>
    <?php foreach ($reservations as $res): ?>
        <option value="<?= htmlspecialchars($res['id']) ?>">
            Reservation <?= htmlspecialchars($res['id']) ?>
        </option>
    <?php endforeach; ?>
</select>
            </div>
            <div class="mb-3">
                <label for="amount_paid" class="form-label">Amount Paid</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid" 
                       class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" 
                       class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Payment</button>
        </form>
    </div>
</body>
</html>
