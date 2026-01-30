<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Reservation Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f5;
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
            modal.style.display = 'flex';  // Show the modal
        }

        function closeModal() {
            modal.style.display = 'none';  // Hide the modal
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
