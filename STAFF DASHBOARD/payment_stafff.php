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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{
      --bg: #f4f7fb;
      --card: rgba(255,255,255,0.8);
      --muted: #6b7280;
      --accent: #2563eb;
      --accent-2: #06b6d4;
      --glass-shadow: 0 8px 30px rgba(20,24,40,0.06);
      --radius: 12px;
      --nav-height: 84px;
      --container-max: 1200px;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg, #eef2ff 0%, var(--bg) 100%);
      color:#0f172a;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      line-height:1.4;
    }

    /* NAVBAR */
    .navbar{
      position:sticky;
      top:0;
      z-index:1000;
      height:var(--nav-height);
      display:flex;
      align-items:center;
      gap:16px;
      padding:12px 20px;
      backdrop-filter: blur(6px);
      background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(250,250,255,0.55));
      box-shadow: var(--glass-shadow);
      border-bottom: 1px solid rgba(15,23,42,0.04);
    }

    .brand{
      display:flex;
      align-items:center;
      gap:12px;
      text-decoration:none;
      color:var(--accent);
      font-weight:700;
      font-size:20px;
    }
    .brand .logo {
      width:44px;
      height:44px;
      border-radius:10px;
      display:inline-grid;
      place-items:center;
      background: linear-gradient(135deg,var(--accent),var(--accent-2));
      color:white;
      font-size:18px;
      box-shadow: 0 6px 18px rgba(37,99,235,0.18);
    }

    /* Search / employee badge */
    .search {
      margin-left:8px;
      display:flex;
      align-items:center;
      gap:10px;
      background:var(--card);
      padding:8px 14px;
      border-radius:999px;
      box-shadow: 0 4px 12px rgba(16,24,40,0.04);
      border: 1px solid rgba(15,23,42,0.03);
    }
    .search input{
      border:0;
      outline:0;
      background:transparent;
      width:260px;
      font-size:14px;
      color:#0f172a;
    }
    .employee-info{
      display:flex;
      flex-direction:column;
      gap:2px;
      font-size:13px;
      color:var(--muted);
    }
    .employee-info .name{
      font-weight:700;
      color:#0f172a;
      font-size:14px;
    }

    /* Main nav */
    .main-nav{
      display:flex;
      gap:8px;
      margin-left:auto;
      align-items:center;
    }
    .nav-item{
      display:flex;
      align-items:center;
      gap:10px;
      padding:10px 14px;
      border-radius:10px;
      color: #0f172a;
      text-decoration:none;
      font-weight:600;
      font-size:15px;
      background:transparent;
      transition: background .15s ease, transform .12s ease;
      border: 1px solid transparent;
    }
    .nav-item i{ font-size:16px; color:var(--muted) }
    .nav-item:hover{
      background: linear-gradient(90deg, rgba(37,99,235,0.06), rgba(6,182,212,0.03));
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(37,99,235,0.06);
    }
    .nav-item.active{
      background: linear-gradient(90deg, rgba(37,99,235,0.12), rgba(6,182,212,0.06));
      border-color: rgba(37,99,235,0.12);
    }

    /* User area */
    .user-area{
      display:flex;
      align-items:center;
      gap:12px;
      margin-left:12px;
    }
    .btn{
      background: linear-gradient(90deg,var(--accent),var(--accent-2));
      color:white;
      border:0;
      padding:8px 12px;
      border-radius:10px;
      cursor:pointer;
      font-weight:600;
      box-shadow: 0 8px 20px rgba(37,99,235,0.12);
      transition: transform .12s ease, opacity .12s ease;
    }
    .btn:active{ transform: translateY(1px) }
    .avatar{
      width:44px;
      height:44px;
      border-radius:10px;
      background: linear-gradient(135deg,#fff 0%, rgba(255,255,255,0.6) 100%);
      display:inline-grid;
      place-items:center;
      color:var(--accent);
      font-weight:700;
      border:1px solid rgba(15,23,42,0.04);
    }

    /* Content and iframe layout */
    .container{
      max-width:var(--container-max);
      margin:18px auto;
      padding:0 20px;
      width:calc(100% - 40px);
    }
    .content{
      display:grid;
      grid-template-columns: 1fr 420px;
      gap:20px;
      align-items:start;
    }
    .iframe-panel{
      background:var(--card);
      border-radius:var(--radius);
      padding:16px;
      box-shadow: var(--glass-shadow);
      border:1px solid rgba(15,23,42,0.03);
      min-height:60vh;
      display:flex;
      flex-direction:column;
      gap:12px;
    }
    .iframe-stack{
      display:flex;
      flex-direction:column;
      gap:12px;
      height:100%;
    }
    iframe{
      width:100%;
      border:0;
      border-radius:8px;
      background:white;
      min-height:260px;
      box-shadow: 0 6px 18px rgba(16,24,40,0.04);
    }

    /* Right column example (dashboard) */
    .side-panel{
      background:var(--card);
      border-radius:var(--radius);
      padding:16px;
      box-shadow: var(--glass-shadow);
      border:1px solid rgba(15,23,42,0.03);
      min-height:60vh;
    }

    /* Responsive */
    @media (max-width:1100px){
      .content{ grid-template-columns: 1fr; }
      .iframe-panel{ order:1 }
      .side-panel{ order:2 }
    }
    @media (max-width:720px){
      .search{ display:none }
      .main-nav{ display:none }
      .navbar{ padding:10px 14px }
      iframe{ min-height:200px }
    }
  </style>
</head>
<body>
  <nav class="navbar" role="navigation" aria-label="Main navigation">
    <a class="brand" href="dashboard.php" aria-label="Dashboard">
<<<<<<< HEAD
      <span class="logo">v</span>
      <span>Veripool</span>
=======
      <span class="logo">rm.v</span>
      <span>Reservation</span>
>>>>>>> 8dc5fd31c5ccec86e7047c9bff49eada89c3bfce
    </a>

    <div class="search" role="search" aria-label="Employee">
      <div class="employee-info" aria-hidden="false">
        <div class="name"><?php echo htmlspecialchars($_SESSION['Employeename'] ?? 'Employee'); ?></div>
        <div class="muted">ID: <?php echo htmlspecialchars($_SESSION['Employeenumber'] ?? '—'); ?></div>
      </div>
    </div>

    <div class="main-nav" role="menubar" aria-label="Primary">
      <a class="nav-item" href="dashboard.php" role="menuitem">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
      </a>
      <a class="nav-item active" href="payment_stafff.php" role="menuitem" aria-current="page">
        <i class="fa-solid fa-users"></i>
        <span>Staff</span>
      </a>
      <a class="nav-item" href="calendar.php" role="menuitem">
        <i class="fa-solid fa-calendar-days"></i>
        <span>Calendar</span>
      </a>
    </div>

    <div class="user-area" aria-hidden="false">
<<<<<<< HEAD
      <button class="btn" type="button" onclick="window.location.href='../Enter_role.php';">Logout</button>
=======
      <button class="btn" type="button" onclick="window.location.href='../Enter_role.php';">Enter Role</button>
>>>>>>> 8dc5fd31c5ccec86e7047c9bff49eada89c3bfce
      <div class="avatar" title="Profile">
        <i class="fa-solid fa-user"></i>
      </div>
    </div>
  </nav>

  <main class="container" role="main">
    <div class="content">
      <section class="iframe-panel" aria-label="Payments">
        <div class="iframe-stack">
          <iframe src="addpayment.php" title="Add payment"></iframe>
          <iframe src="paymentsdashboard.php" title="Payments dashboard"></iframe>
        </div>
      </section>

      <aside class="side-panel" aria-label="Quick actions">
        <h3 style="margin:0 0 12px 0; font-size:16px;">Quick actions</h3>
        <p style="margin:0 0 12px 0; color:var(--muted); font-size:14px;">
          Use these shortcuts to navigate common tasks.
        </p>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <button class="btn" style="padding:10px 12px;" onclick="window.location.href='payment_stafff.php'">
            Manage Staff Payments
          </button>
          <button class="btn" style="padding:10px 12px; background:linear-gradient(90deg,#10b981,#06b6d4);" onclick="window.location.href='addpayment.php'">
            Add New Payment
          </button>
        </div>
      </aside>
    </div>
  </main>
</body>
</html>
