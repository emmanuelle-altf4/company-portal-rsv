<?php
session_start();
if (!isset($_SESSION['Employeenumber'])) {
    header('Location: login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Calendar • Company Portal hehehheheh</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{
      --bg: #f4f7fb;
      --card: rgba(255,255,255,0.85);
      --muted: #6b7280;
      --accent: #2563eb;
      --accent-2: #06b6d4;
      --radius: 12px;
      --shadow: 0 10px 30px rgba(16,24,40,0.06);
      --nav-h: 84px;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#eef2ff 0%,var(--bg) 100%);
      color:#0f172a;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      line-height:1.45;
    }

    /* NAV */
    .navbar{
      position:sticky;
      top:0;
      z-index:1000;
      height:var(--nav-h);
      display:flex;
      align-items:center;
      gap:16px;
      padding:12px 20px;
      background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(250,250,255,0.55));
      box-shadow: var(--shadow);
      border-bottom:1px solid rgba(15,23,42,0.04);
    }
    .brand{ display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--accent); font-weight:700; }
    .logo{
      width:44px; height:44px; border-radius:10px; display:grid; place-items:center;
      background:linear-gradient(135deg,var(--accent),var(--accent-2)); color:#fff; font-weight:700;
    }

    .employee{
      display:flex; flex-direction:column; gap:2px; margin-left:8px; font-size:13px; color:var(--muted);
    }
    .employee .name{ font-weight:700; color:#0f172a; font-size:14px; }

    .main-nav{ margin-left:auto; display:flex; gap:8px; align-items:center; }
    .nav-item{
      display:flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px;
      text-decoration:none; color:#0f172a; font-weight:600; font-size:15px; border:1px solid transparent;
      transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
    }
    .nav-item i{ color:var(--muted); font-size:16px; }
    .nav-item:hover{ transform:translateY(-2px); box-shadow:0 8px 20px rgba(37,99,235,0.06); }
    .nav-item.active{ background:linear-gradient(90deg, rgba(37,99,235,0.12), rgba(6,182,212,0.06)); border-color:rgba(37,99,235,0.12); }

    .btn{
      background:linear-gradient(90deg,var(--accent),var(--accent-2)); color:#fff; border:0; padding:8px 12px; border-radius:10px;
      cursor:pointer; font-weight:700; box-shadow:0 8px 20px rgba(37,99,235,0.12);
    }

 
    .container{ max-width:1200px; margin:20px auto; padding:0 20px; width:calc(100% - 40px); }
    .calendar-wrap{ display:grid; grid-template-columns: 1fr 320px; gap:20px; align-items:start; }
    .calendar-card{
      background:var(--card); border-radius:var(--radius); padding:18px; box-shadow:var(--shadow); border:1px solid rgba(15,23,42,0.03);
    }

    
    .calendar-header{ display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px; }
    .month-title{ font-size:18px; font-weight:700; }
    .nav-controls{ display:flex; gap:8px; align-items:center; color:var(--muted); }
    .nav-controls button{ background:transparent; border:0; font-size:20px; cursor:pointer; padding:8px; border-radius:8px; color:var(--muted); }
    .nav-controls button:hover{ background:rgba(15,23,42,0.03); color:var(--accent); }

    .weekdays{ display:grid; grid-template-columns: repeat(7,1fr); gap:8px; margin-bottom:8px; color:var(--muted); font-size:13px; text-align:center; }
    .days{ display:grid; grid-template-columns: repeat(7,1fr); gap:8px; }
    .day{
      min-height:64px; background:#f7f9fc; border-radius:8px; padding:8px; display:flex; flex-direction:column; justify-content:flex-start; align-items:flex-start;
      cursor:pointer; transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
      border:1px solid rgba(15,23,42,0.02);
    }
    .day.empty{ background:transparent; cursor:default; box-shadow:none; border:0; }
    .day:hover{ transform:translateY(-4px); box-shadow:0 10px 30px rgba(16,24,40,0.06); }
    .day .num{ font-weight:700; color:#0f172a; font-size:14px; margin-bottom:6px; }
    .day.reserved{ background:linear-gradient(90deg,#fff0f0,#fff6f6); border-color:rgba(255,99,71,0.08); }
    .day.reserved .num{ color:#b91c1c; }

    
    .side-panel{ display:flex; flex-direction:column; gap:12px; }
    .side-panel h3{ margin:0; font-size:16px; }
    .shortcut{ display:flex; gap:10px; align-items:center; padding:10px; border-radius:10px; background:linear-gradient(180deg,#fff,#fbfdff); border:1px solid rgba(15,23,42,0.03); }

    
    .modal{ display:none; position:fixed; inset:0; background:rgba(2,6,23,0.5); align-items:center; justify-content:center; padding:20px; z-index:2000; }
    .modal.open{ display:flex; }
    .modal-content{ width:100%; max-width:420px; background:#fff; border-radius:12px; padding:18px; box-shadow:0 20px 60px rgba(2,6,23,0.3); }
    .modal-content h3{ margin:0 0 12px 0; }
    .form-row{ display:flex; flex-direction:column; gap:6px; margin-bottom:10px; }
    .form-row input, .form-row select{ padding:10px; border-radius:8px; border:1px solid rgba(15,23,42,0.06); font-size:14px; }
    .modal-actions{ display:flex; gap:8px; justify-content:flex-end; margin-top:8px; }

    /* mini screen to  */
    @media (max-width:980px){
      .calendar-wrap{ grid-template-columns: 1fr; }
    }
    @media (max-width:640px){
      .day{ min-height:56px; }
      .employee{ display:none; }
      .nav-item span{ display:none; }
    }
  </style>
</head>
<body>
  <nav class="navbar" role="navigation" aria-label="Main">
    <a class="brand" href="dashboard.php" aria-label="Dashboard">
      <span class="logo">v</span>
      <span>Veripool</span>
    </a>

    <div class="employee" aria-hidden="false">
      <span class="name"><?php echo htmlspecialchars($_SESSION['Employeename'] ?? 'Employee'); ?></span>
      <span class="muted">ID: <?php echo htmlspecialchars($_SESSION['Employeenumber'] ?? '—'); ?></span>
    </div>

    <div class="main-nav" role="menubar" aria-label="Primary">
      <a class="nav-item" href="dashboard.php" role="menuitem"><i class="fa-solid fa-house"></i><span>Home</span></a>
      <a class="nav-item" href="payment_stafff.php" role="menuitem"><i class="fa-solid fa-users"></i><span>Confirmation</span></a>
      <a class="nav-item active" href="calendar.php" role="menuitem" aria-current="page"><i class="fa-solid fa-calendar-days"></i><span>Calendar</span></a>
    </div>

    <div style="margin-left:12px; display:flex; gap:10px; align-items:center;">
      <button class="btn" onclick="location.href='../Enter_role.php'">Logout</button>
        <!-- <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#fff,#f7fbff);display:grid;place-items:center;border:1px solid rgba(15,23,42,0.04);">
          <i class="fa-solid fa-user" style="color:var(--accent)"></i> -->
      </div>
    </div>
  </nav>

  <main class="container" role="main">
    <div class="calendar-wrap">
      <section class="calendar-card" aria-labelledby="calendar-heading">
        <div class="calendar-header">
          <div>
            <div id="calendar-heading" class="month-title" aria-live="polite"></div>
            <div style="color:var(--muted); font-size:13px; margin-top:4px;">Click a date to reserve</div>
          </div>

          <div class="nav-controls" role="toolbar" aria-label="Month navigation">
            <button id="prev-month" aria-label="Previous month">❮</button>
            <button id="next-month" aria-label="Next month">❯</button>
          </div>
        </div>

        <div class="weekdays" aria-hidden="true">
          <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
        </div>

        <div id="calendar-days" class="days" role="grid" aria-label="Calendar days"></div>
      </section>

      <aside class="side-panel">
        <div class="calendar-card">
          <h3>Quick actions</h3>
          <p style="color:var(--muted); margin:8px 0 12px 0;">Shortcuts for common tasks.</p>
          <div class="shortcut">
            <i class="fa-solid fa-plus" style="color:var(--accent)"></i>
            <div>
              <div style="font-weight:700">Add Reservation</div>
              <div style="color:var(--muted); font-size:13px">Click any date on the calendar</div>
            </div>
          </div>

          <div style="display:flex; gap:8px; margin-top:12px;">
            <!-- <button class="btn" onclick="location.href='payment_stafff.php'">Manage Staff</button> -->
            <button class="btn" style="background:linear-gradient(90deg,#10b981,#06b6d4)" onclick="location.href='addpayment.php'">Add Payment</button>
          </div>
        </div>

        <div class="calendar-card" aria-hidden="false">
          <!-- <h3>Legend</h3>
          <div style="display:flex; gap:8px; margin-top:8px;">
            <div style="width:14px;height:14px;border-radius:4px;background:#f7f9fc;border:1px solid rgba(15,23,42,0.02)"></div>
            <div style="font-size:13px;color:var(--muted)">Available</div>
          </div>
          <div style="display:flex; gap:8px; margin-top:8px;">
            <div style="width:14px;height:14px;border-radius:4px;background:linear-gradient(90deg,#fff0f0,#fff6f6);border:1px solid rgba(255,99,71,0.08)"></div>
            <div style="font-size:13px;color:var(--muted)">Reserved</div>
          </div> -->
        </div>
      </aside>
    </div>
  </main>

  <!-- Modal -->
  <div id="reservation-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="modal-title">
    <div class="modal-content">
      <h3 id="modal-title">Make a Reservation</h3>
      <form id="reservation-form" action="calendar_process.php" method="POST">
        <input type="hidden" name="reservation_date" id="reservation-date" />
        <div class="form-row">
          <label for="staffname">Employee Name</label>
          <input id="staffname" name="staffname" type="text" required />
        </div>
        <div class="form-row">
          <label for="customer_name">Customer Name</label>
          <input id="customer_name" name="customer_name" type="text" required />
        </div>
        <div class="form-row">
          <label for="reservation_time">Reservation Time</label>
          <input id="reservation_time" name="reservation_time" type="time" required />
        </div>
        <div class="form-row">
          <label for="room_type">Room Type</label>
          <select id="room_type" name="room_type" required>
            <option value="Deluxe">Deluxe</option>
            <option value="Suite">Suite</option>
          </select>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn" id="cancel-btn">Cancel</button>
          <button type="submit" class="btn">Confirm</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const monthTitle = document.getElementById('calendar-heading');
    const daysContainer = document.getElementById('calendar-days');
    const modal = document.getElementById('reservation-modal');
    const reservationDateInput = document.getElementById('reservation-date');
    const reservationForm = document.getElementById('reservation-form');
    const cancelBtn = document.getElementById('cancel-btn');

    let currentDate = new Date();
    let reservedDates = []; // store ng date as a sting  ung yyyy mm at DD

    function renderCalendar() {
      const month = currentDate.getMonth();
      const year = currentDate.getFullYear();
      monthTitle.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
      daysContainer.innerHTML = '';

      const firstDayIndex = new Date(year, month, 1).getDay();
      const totalDays = new Date(year, month + 1, 0).getDate();

      
      for (let i = 0; i < firstDayIndex; i++) {
        const empty = document.createElement('div');
        empty.className = 'day empty';
        daysContainer.appendChild(empty);
      }

      for (let d = 1; d <= totalDays; d++) {
        const dateStr = `${year}-${String(month + 1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const isReserved = reservedDates.includes(dateStr);

        const cell = document.createElement('div');
        cell.className = 'day' + (isReserved ? ' reserved' : '');
        cell.setAttribute('role','button');
        cell.setAttribute('tabindex','0');
        cell.dataset.date = dateStr;

        const num = document.createElement('div');
        num.className = 'num';
        num.textContent = d;
        cell.appendChild(num);

        
        const note = document.createElement('div');
        note.style.fontSize = '12px';
        note.style.color = isReserved ? '#b91c1c' : 'var(--muted)';
        note.textContent = isReserved ? 'Reserved' : '';
        cell.appendChild(note);

        cell.addEventListener('click', () => openModal(dateStr));
        cell.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') openModal(dateStr); });

        daysContainer.appendChild(cell);
      }
    }

    function openModal(dateStr) {
      reservationDateInput.value = dateStr;
      modal.classList.add('open');
      modal.setAttribute('aria-hidden','false');
      // para sa first input  accessibility ata nakalimutan kona 
      document.getElementById('staffname').focus();
    }

    function closeModal() {
      modal.classList.remove('open');
      modal.setAttribute('aria-hidden','true');
      reservationForm.reset();
    }

    reservationForm.addEventListener('submit', (e) => {
      
      // prevent default only if you want to handle via AJAX. Here we update UI then allow submit.
      const date = reservationDateInput.value;
      if (!reservedDates.includes(date)) {
        reservedDates.push(date);
      }
      
      // closemodal para sa ux
      closeModal();
    });

    cancelBtn.addEventListener('click', closeModal);
    document.getElementById('prev-month').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });
    document.getElementById('next-month').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });

    // close modal on outside click or Escape
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

    renderCalendar();
  </script>
</body>
</html>
