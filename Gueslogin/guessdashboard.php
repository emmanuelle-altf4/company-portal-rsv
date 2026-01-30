<?php
session_start();
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
      --card: rgba(255,255,255,0.75);
      --muted: #6b7280;
      --accent: #2563eb;
      --accent-2: #06b6d4;
      --glass-shadow: 0 6px 18px rgba(20,24,40,0.08);
      --radius: 12px;
      --nav-height: 84px;
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
      padding-bottom:20px;
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

    /* Search */
    .search {
      margin-left:8px;
      display:flex;
      align-items:center;
      gap:8px;
      background:var(--card);
      padding:8px 12px;
      border-radius:999px;
      box-shadow: 0 4px 12px rgba(16,24,40,0.04);
      border: 1px solid rgba(15,23,42,0.03);
      transition: box-shadow .18s ease, transform .12s ease;
    }
    .search:focus-within{ box-shadow: 0 8px 24px rgba(16,24,40,0.06); transform: translateY(-1px); }
    .search input{
      border:0;
      outline:0;
      background:transparent;
      width:260px;
      font-size:14px;
      color: #0f172a;
    }
    .search .fa-magnifying-glass{ color:var(--muted); font-size:14px }

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
    .user-badge{
      display:flex;
      flex-direction:column;
      align-items:flex-end;
      gap:2px;
      font-size:13px;
      color:var(--muted);
    }
    .user-badge .name{
      font-weight:700;
      color:#0f172a;
      font-size:14px;
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

    /* Content and iframe */
    .content{
      display:flex;
      gap:20px;
      padding:22px;
      max-width:1200px;
      margin:18px auto;
      width:calc(100% - 48px);
    }
    .iframe-container{
      flex:1;
      background:var(--card);
      border-radius:var(--radius);
      padding:18px;
      box-shadow: var(--glass-shadow);
      border:1px solid rgba(15,23,42,0.03);
      min-height:60vh;
      display:flex;
      flex-direction:column;
      gap:12px;
    }
    iframe{
      width:100%;
      height:100%;
      border:0;
      border-radius:8px;
      background:white;
      min-height:420px;
    }

    /* Responsive */
    @media (max-width:900px){
      .search input{ width:160px }
      .main-nav .nav-item span{ display:none }
      .content{ padding:16px; width:calc(100% - 32px) }
    }
    @media (max-width:720px){
      .search{ display:none }
      .main-nav{ display:none }
      .navbar{ padding:10px 14px }
      .content{ flex-direction:column; gap:12px }
      iframe{ min-height:320px }
    }

    :root { 
		--glass-shadow: 0 8px 24px rgba(0,0,0,0.12); } 
	/* Portrait image base */ 
	
.row-container
{
	display:flex;
	flex-wrap:wrap;
	gap:18px;
	justify-content:center;
	align-items:flex-start;}
.row-container .item
{
	border-radius:12px;
	box-shadow:var(--glass-shadow);
	object-fit:cover;
	cursor:pointer;
	aspect-ratio:3/4;
	width:90%;
	max-width:300px;
	height:auto;
	transition:transform .18s ease, box-shadow .18s ease;
}

  </style>
</head>
<body>
  <nav class="navbar" role="navigation" aria-label="Main navigation">
    <a class="brand" href="dashboard.php" aria-label="Dashboard">
      <span class="logo">v</span>
      <span>Veripool</span>
      <!-- name to kooky -->
         <div class="cxname" aria-hidden="false">
         <span class="name"><?php echo htmlspecialchars($_SESSION['cxname'] ?? 'cxname'); ?></span>
      
    </div>
    </a>
<!-- search bar just incase HAHHAHHAHA -->
    <!-- <div class="search" role="search" aria-label="Search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" placeholder="Search people, docs, tools" aria-label="Search input" />
    </div> -->

    <div class="main-nav" role="menubar" aria-label="Primary">
      <a class="nav-item active" href="guessdashboard.php" role="menuitem" aria-current="page">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
      </a>
      <!-- <a class="nav-item" href="guesaboutus.php" role="menuitem">
        <i class="fa-solid fa-users"></i>
        <span>about us</span>
      </a> -->
      <a class="nav-item" href="Guesreservation.php" role="menuitem">
        <i class="fa-solid fa-calendar-days"></i>
        <span>Reserver Now!</span>
      </a>
    </div>

    <!-- <div class="user-area" aria-hidden="false">
      <div class="user-badge" title="Employee">
      </div> -->
    </div>
  </nav>
<!-- for ano to ung ifram burahin monalang if dili mo gusto -->
  <!-- <main class="content" role="main">
    <section class="iframe-container" aria-label="Main content">
      <iframe src="BUNDLE.html" title="Embedded content"></iframe> -->

	<!-- row -->
	<div class="row-container">
  <img src="poolpic.jpg" alt="pool" class="item" onclick="window.location='Gueslogin/gueslogin.php'">
  <img src="cottage.jpg" alt="cottage" class="item" onclick="window.location='cottageinfo.php'">
  <img src="room.jpg" alt="room" class="item" onclick="window.location='roominfo.php'">
</div>


    </section>
  </main>
</body>
</html>
