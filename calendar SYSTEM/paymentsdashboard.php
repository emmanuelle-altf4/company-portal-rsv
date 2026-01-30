<?php
include 'db.php';
session_start();

// Ensure only admin can access this page.
if ($_SESSION['role'] != '') {
    die("Access denied!");
}

// Fetch all payment records from the database.
$payments = $conn->query("
    SELECT payments.id, reservations.id AS reservation_id, users.username, 
           payments.amount_paid, payments.payment_method, payments.payment_date
    FROM payments
    JOIN reservations ON payments.reservation_id = reservations.id
    JOIN users ON reservations.user_id = users.id
")->fetchAll();

// Handle payment deletion.
if (isset($_GET['delete'])) {
    $payment_id = $_GET['delete'];
    $conn->prepare("DELETE FROM payments WHERE id = ?")->execute([$payment_id]);
    header('Location: payments_dashboard.php'); // Refresh the page.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    </style>    
</head>
<body class="bg-light">
     <nav class="AA">
        <h2>Dashboard</h2>
        <div class="user-menu">
            <button onclick="window.location.href='../Enter_role.php';">Enter Role</button>

        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Payments Dashboard</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Payment ID</th>
                    <th>Reservation ID</th>
                    <th>User</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= $payment['id'] ?></td>
                        <td><?= $payment['reservation_id'] ?></td>
                        <td><?= $payment['username'] ?></td>
                        <td>₱<?= number_format($payment['amount_paid'], 2) ?></td>
                        <td><?= $payment['payment_method'] ?></td>
                        <td><?= $payment['payment_date'] ?></td>
                        <td>
                            <a href="payments_dashboard.php?delete=<?= $payment['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this payment?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
