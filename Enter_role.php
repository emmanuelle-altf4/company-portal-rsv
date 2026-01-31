<?php
session_start();

// Handle role selection
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST['role'] ?? '';

    if ($role === 'admin') {
        header("Location: ADMIN/adminlogin.php");
        exit();
    } elseif ($role === 'staff') {
        header("Location: LoginAndregistrationform.php");
        exit();
    } elseif ($role === 'New Staff') {
        header("Location: registrationform.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Choose Role • Company Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{
      --bg: #f4f7fb;
      --card: #ffffff;
      --muted: #6b7280;
      --accent: #2563eb;
      --accent-2: #06b6d4;
      --radius: 12px;
      --shadow: 0 12px 30px rgba(16,24,40,0.06);
      --max-width: 420px;
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
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
    }

    .card{
      width:100%;
      max-width:var(--max-width);
      background:var(--card);
      border-radius:var(--radius);
      padding:20px;
      box-shadow:var(--shadow);
      border:1px solid rgba(15,23,42,0.04);
    }

    .header{
      display:flex;
      align-items:center;
      gap:12px;
      margin-bottom:14px;
    }
    .logo{
      width:48px;
      height:48px;
      border-radius:10px;
      display:grid;
      place-items:center;
      color:#fff;
      background:linear-gradient(135deg,var(--accent),var(--accent-2));
      font-weight:800;
      font-size:18px;
      box-shadow:0 8px 20px rgba(37,99,235,0.12);
    }
    h1{
      margin:0;
      font-size:18px;
      letter-spacing: -0.2px;
    }
    p.lead{
      margin:8px 0 18px 0;
      color:var(--muted);
      font-size:13px;
    }

    form{ display:flex; flex-direction:column; gap:12px; }

    label{
      font-size:13px;
      color:var(--muted);
      font-weight:600;
    }

    .select-wrap{
      position:relative;
    }
    select{
      appearance:none;
      -webkit-appearance:none;
      width:100%;
      padding:12px 44px 12px 14px;
      border-radius:10px;
      border:1px solid rgba(15,23,42,0.06);
      background:linear-gradient(180deg,#fff,#fbfdff);
      font-size:14px;
      color:#0f172a;
      cursor:pointer;
      transition:box-shadow .12s ease, transform .08s ease;
    }
    select:focus{ box-shadow:0 8px 20px rgba(37,99,235,0.06); outline:none; transform:translateY(-1px); }

    .select-wrap .chev{
      position:absolute;
      right:12px;
      top:50%;
      transform:translateY(-50%);
      color:var(--muted);
      pointer-events:none;
      font-size:16px;
    }

    .actions{
      display:flex;
      gap:10px;
      align-items:center;
      margin-top:6px;
    }

    .btn{
      flex:1;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      padding:12px 14px;
      border-radius:10px;
      border:0;
      cursor:pointer;
      font-weight:700;
      color:#fff;
      background:linear-gradient(90deg,var(--accent),var(--accent-2));
      box-shadow:0 10px 30px rgba(37,99,235,0.12);
      transition:transform .08s ease, opacity .08s ease;
    }
    .btn:active{ transform:translateY(1px) }
    .btn.secondary{
      background:transparent;
      color:var(--accent);
      border:1px solid rgba(37,99,235,0.12);
      box-shadow:none;
      font-weight:700;
    }

    .note{
      font-size:13px;
      color:var(--muted);
      text-align:center;
      margin-top:8px;
    }

    @media (max-width:420px){
      .card{ padding:16px; }
      .logo{ width:40px; height:40px; font-size:16px; }
    }
  </style>
</head>
<body>
  <main class="card" role="main" aria-labelledby="role-heading">
    <div class="header">
      <div class="logo" aria-hidden="true">v</div>
      <div>
        <h1 id="role-heading">Select your role</h1>
        <p class="lead">Choose how you want to sign in. This helps route you to the correct area.</p>
      </div>
    </div>

    <form action="" method="POST" novalidate>
      <div>
        <label for="role">Role</label>
        <div class="select-wrap">
          <select name="role" id="role" required aria-required="true">
            <option value="">Please select a role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="New Staff">New Staff</option>
          </select>
          <span class="chev"><i class="fa-solid fa-chevron-down"></i></span>
        </div>
      </div>

      <div class="actions">
        <button type="submit" class="btn" aria-label="Enter selected role">
          <i class="fa-solid fa-right-to-bracket"></i>
          Enter
        </button>
        <button type="button" class="btn secondary" onclick="location.href='dashboard.php'" aria-label="Back to dashboard">
          <i class="fa-solid fa-arrow-left"></i>
          Back
        </button>
      </div>

      <p class="note">If you are a new staff member, choose <strong>New Staff</strong> to register.</p>
    </form>
  </main>
</body>
</html>
