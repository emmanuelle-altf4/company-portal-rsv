const calendarGrid = document.getElementById("calendarGrid");
const monthYear = document.getElementById("monthYear");
let currentDate = new Date();

function renderCalendar() {
    calendarGrid.innerHTML = "";
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // Set the month and year display
    monthYear.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

    // Get the first day of the month
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Add empty days before the first day
    for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        calendarGrid.appendChild(emptyDiv);
    }

    // Add the days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement("div");
        dayDiv.textContent = day;
        dayDiv.className = "day";
        dayDiv.onclick = () => alert(`You clicked on ${day} ${currentDate.toLocaleString('default', { month: 'long' })} ${year}`);
        calendarGrid.appendChild(dayDiv);
    }
}

// Change month
document.getElementById("prevMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
};

document.getElementById("nextMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
};

// Change year
document.getElementById("prevYear").onclick = () => {
    currentDate.setFullYear(currentDate.getFullYear() - 1);
    renderCalendar();
};

document.getElementById("nextYear").onclick = () => {
    currentDate.setFullYear(currentDate.getFullYear() + 1);
    renderCalendar();
};
const reservationModal = document.getElementById("reservationModal");
const closeModal = document.getElementById("closeModal");
const roomSelect = document.getElementById("roomSelect");
const reservationForm = document.getElementById("reservationForm");

// Open reservation modal on day click
const openReservationModal = (day) => {
    reservationModal.style.display = "block";
    document.getElementById("startDate").value = currentDate.toISOString().split('T')[0];
    document.getElementById("endDate").value = currentDate.toISOString().split('T')[0];
};

// Close the modal
closeModal.onclick = () => {
    reservationModal.style.display = "none";
};

// Close the modal when clicking outside of it
window.onclick = (event) => {
    if (event.target === reservationModal) {
        reservationModal.style.display = "none";
    }
};

// Load room options
const loadRooms = async () => {
    const response = await fetch('get_rooms.php');
    const rooms = await response.json();
    rooms.forEach(room => {
        const option = document.createElement("option");
        option.value = room.id;
        option.textContent = `${room.room_type} - $${room.price}`;
        roomSelect.appendChild(option);
    });
};

// Submit reservation
reservationForm.onsubmit = async (e) => {
    e.preventDefault();
    const roomId = roomSelect.value;
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;

    const response = await fetch('reserve.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ roomId, startDate, endDate })
    });

    const result = await response.json();
    if (result.success) {
        alert('Reservation successful!');
        reservationModal.style.display = "none";
    } else {
        alert('Reservation failed: ' + result.message);
    }
};

// Fetch rooms on load
loadRooms();

// Initial render
renderCalendar();
