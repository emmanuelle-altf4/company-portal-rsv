<?php
session_start();
if (!isset($_SESSION['Employeenumber'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <3</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
        .navbar {
            background-color: grey;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0 16px;
            height: 90px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;

        }
        .logo {
            color: #1877f2;
            font-size: 40px;
            margin-right: 10px;
        }
        .search-container {
            background-color: #f0f2f5;
            border-radius: 50px;
            padding: 5px 10px;
            margin-right: 100px;
        }
        .search-container input {
            border: none;
            background-color: transparent;
            font-size: 15px;
            outline: none;
            width: 240px;
        }
        .main-nav {
            display: flex;
            flex-grow: 1;
            justify-content: center;
        }
        .nav-item {
            color: black;
            font-size: 24px;
            padding: 10px 40px;
            border-radius: 8px;
            cursor: pointer;
        }
        .nav-item:hover, .nav-item.active {
            background-color: #f0f2f5;
        }
        .user-menu {
            display: flex;
            align-items: center;
        }
        .menu-icon {
            background-color: white;
            color: black;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            cursor: pointer;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 8px;
            cursor: pointer;
        }
        .content {
            display: flex;
            height: calc(100vh - 56px);
        }
        .iframe-container {
            flex: 1;
            padding: 20px;
        }
        iframe {
            width: 100%;
            height: 78%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .search-container, .main-nav {
                display: none;
            }
            .navbar {
                justify-content: space-between;
            }
            .content {
                flex-direction: column;
            }
            .iframe-container {
                height: 50vh;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
       
        <div class="search-container">
            
        Employee name: <?php echo $_SESSION['Employeename']; ?></h2>
        </div>
        <div class="main-nav">
            <div class="nav-item ">
                <a href="dashboard.php">
            <i class="fas fa-home"></i></div>
            <div class="nav-item ">
                < <a href="payment_stafff.php">
            <i class="fas fa-users"></i></div>
            <div class="nav-item active">
                  <a href="Kalendar.php">
                <i class="fas fa-th"></i></div>
        </div>
        <div class="user-menu">
            <img src="/placeholder.svg?height=40&width=40" alt="User Avatar" class="user-avatar">
        </div>
    </nav>
        
    <div class="content"> 
        <div class="iframe-container">
            <iframe src="BUNDLE.html" title="Left iframe"></iframe>
        </div>
        
        </div>
    </div>
</body>
</html>