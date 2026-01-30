<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "logindata"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT Employeename, Employeenumber FROM employees";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Table</title>
    <link rel="stylesheet" href="userdashboard.css">
    <style>
table {
    background-color: ;
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        ul, li {
            border: 2px solid #ddd;
            padding: 8px;
            border-radius: 5px;

            
        }
        li {
            background-color: #f2f2f2;
        }
        
    </style>
<body>

<h2>Staff Accounts</h2>
<div class="AAB">
<table>
    <thead>
        <th>
            <tr>Name</tr>
            <tr>Number</tr>
            <tr>Role</tr>
        </th>
    </thead>
    <tbody>
       <?php
        if ($result->num_rows > 0) {
            // kukunin neto ung mga nainput naten sa database ung logindata
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['Employeename']) . "</td>
                        <td>" . htmlspecialchars($row['Employeenumber']) . "</td>
                       
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No employees found</td></tr>";
        }    
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>
