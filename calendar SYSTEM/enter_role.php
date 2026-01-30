<?php
include 'db.php';

session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    die("Access denied!");
}

// Fetch all users from the database
$users = $conn->query("SELECT id, Fullname, role FROM users")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$role, $user_id]);

    echo "User role updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
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
<body>
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

    <div class="CC">
        <form method="POST">
            <input type="number" name="user_id" placeholder="User ID" required>
            <select name="role">
                <option value="guest">Guest</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Update Role</button>
        </form>
    </div>

    <div class="DD"> 
        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Admin Name</th>
                <th>Role</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['Fullname']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
