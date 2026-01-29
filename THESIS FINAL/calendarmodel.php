<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Custom Calendar</title>
</head>
<body>
    <div class="calendar-container">
        <header>
            <button id="prevYear"><<</button>
            <button id="prevMonth"><</button>
            <h2 id="monthYear"></h2>
            <button id="nextMonth">></button>
            <button id="nextYear">>></button>
        </header>
        <div class="calendar-grid" id="calendarGrid"></div>
    </div>
<!-- Add this HTML below your calendar container -->
<div id="reservationModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Make a Reservation</h2>
        <form id="reservationForm">
            <label for="roomSelect">Select Room:</label>
            <select id="roomSelect" required></select>
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" required>
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" required>
            <button type="submit">Reserve</button>
        </form>
    </div>
</div>

    <script src="script.js"></script>
</body>
</html>
