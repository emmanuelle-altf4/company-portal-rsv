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


.calendar {
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .calendar-header h2 {
            margin: 0;
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 10px;
            margin-top: 10px;
        }
        .day {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            background-color: #e0e0eb;
        }
        .day:hover {
            background-color: #007bff;
            color: white;
        }
        .prev-next-btn {
            cursor: pointer;
            font-size: 18px;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }




        
    </style>
</head>
<body>
    <nav class="navbar">
       
        <div class="search-container">
            
        Employee name: <?php echo $_SESSION['Employeename']; ?></h2>
        </div>
        <div class="main-nav">
            <div class="nav-item active">
                <a href="dashboard.php">
            <i class="fas fa-home"></i></div>
            <div class="nav-item">
                    <a href="payment_stafff.php">
            <i class="fas fa-users"></i></div>
            <div class="nav-item">
                 <a href="calendar.php">
                <i class="fas fa-th"></i></div>
        </div>
        <div class="user-menu">
            <img src="/placeholder.svg?height=40&width=40" alt="User Avatar" class="user-avatar">
        </div>
    </nav> 
        </div>
    </div>
<div class="calendar">
        <div class="calendar-header">
            <span class="prev-next-btn" id="prev-month">❮</span>
            <h2 id="current-month-year"></h2>
            <span class="prev-next-btn" id="next-month">❯</span>
        </div>
        <div class="days" id="calendar-days"></div>
    </div>

    <!-- Reservation Modal -->
    <div id="reservation-modal" class="modal">
        <div class="modal-content">
            <h3>Make a Reservation</h3>
            <form action="calendar_process.php" method="POST">
    <input type="hidden" name="reservation_date" id="reservation-date">
    
    <label for="staffname">Employee Name:</label>
     <input type="text" name="staffname" required><br>
    <label for="customer_name">Customer Name:</label>
    <input type="text" name="customer_name" required><br>

    <label for="reservation_time">Reservation Time:</label>
    <input type="time" name="reservation_time" required><br>
    
    <button type="submit">Confirm Reservation</button>
</form>

            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        const currentMonthYear = document.getElementById("current-month-year");
        const calendarDays = document.getElementById("calendar-days");
        const modal = document.getElementById("reservation-modal");
        const reservationDateInput = document.getElementById("reservation-date");

        let currentDate = new Date();

        function renderCalendar() {
            const month = currentDate.getMonth();
            const year = currentDate.getFullYear();
            currentMonthYear.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

            calendarDays.innerHTML = "";

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const totalDaysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDayOfMonth; i++) {
                calendarDays.innerHTML += `<div></div>`;
            }

            for (let day = 1; day <= totalDaysInMonth; day++) {
                calendarDays.innerHTML += `<div class="day" onclick="selectDay(${day})">${day}</div>`;
            }
        }

        function selectDay(day) {
            const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            reservationDateInput.value = selectedDate.toISOString().split('T')[0];
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        document.getElementById("prev-month").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById("next-month").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    </script>


</body>
</html>