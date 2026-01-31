<?php
// guespayment.php
// Combined: dashboard view + POST handler for adding payments
ini_set('display_errors', 0);
error_reporting(0);

session_start();

// Database config
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'resortpayment_db';

// Connect
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    // If DB is unavailable, show a friendly message in the UI later
    $db_error = 'Database connection failed: ' . $mysqli->connect_error;
} else {
    $db_error = null;
}

// POST handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and trim inputs
    $customer_name  = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $customer_email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
    $amount         = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $method         = isset($_POST['method']) ? trim($_POST['method']) : '';
    $invoice        = isset($_POST['invoice']) ? trim($_POST['invoice']) : null;
    $payment_date   = isset($_POST['payment_date']) ? trim($_POST['payment_date']) : date('Y-m-d H:i:s');

    // Basic validation
    $errors = [];
    if ($customer_name === '') $errors[] = 'Customer name is required.';
    if ($customer_email === '' || !filter_var($customer_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($amount === '' || !is_numeric($amount) || (float)$amount <= 0) $errors[] = 'Valid amount is required.';
    if ($method === '') $errors[] = 'Payment method is required.';

    if (!empty($errors)) {
        $_SESSION['payment_errors'] = $errors;
        // Redirect back to avoid form resubmission
        header('Location: guespayment.php');
        exit;
    }

    // Auto-generate invoice if empty
    if (empty($invoice)) {
        $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
    }

    // If DB connection failed earlier, set error and redirect
    if ($db_error) {
        $_SESSION['payment_errors'] = ['Database connection failed.'];
        header('Location: guespayment.php');
        exit;
    }

    // Prepare insert
    $sql = "INSERT INTO payments (customer_name, customer_email, amount, payment_method, invoice_number, payment_date, status)
            VALUES (?, ?, ?, ?, ?, ?, 'completed')";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        $_SESSION['payment_errors'] = ['Database error (prepare).'];
        header('Location: guespayment.php');
        exit;
    }

    // Bind parameters: s = string, d = double
    $amt = number_format((float)$amount, 2, '.', '');
    $stmt->bind_param('ssdsss', $customer_name, $customer_email, $amt, $method, $invoice, $payment_date);

    if ($stmt->execute()) {
        $_SESSION['payment_success'] = "Payment saved (Invoice: $invoice).";
        $stmt->close();
        $mysqli->close();
        header('Location: guespayment.php');
        exit;
    } else {
        $_SESSION['payment_errors'] = ['Database error: ' . $stmt->error];
        $stmt->close();
        $mysqli->close();
        header('Location: guespayment.php');
        exit;
    }
}

// Fetch recent payments for display (read-only)
$payments = [];
if (!$db_error) {
    $res = $mysqli->query("SELECT id, invoice_number, customer_name, payment_method, amount, payment_date, status FROM payments ORDER BY id DESC LIMIT 50");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $payments[] = $row;
        }
        $res->free();
    }
    $mysqli->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Payments Dashboard · Reservation</title>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
  :root{
    --bg:#071827;
    --card:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
    --muted:#94a3b8;
    --accent:#2563eb;
    --accent-2:#06b6d4;
    --success:#10b981;
    --danger:#ef4444;
    --glass: rgba(255,255,255,0.04);
    --radius:12px;
    --shadow: 0 8px 30px rgba(2,6,23,0.6);
    font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
    color-scheme: dark;
  }

  html,body { height:100%; }
  body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(180deg,#071029 0%, #071827 100%);
    color: #e6eef8;
    -webkit-font-smoothing:antialiased;
    display: flex;
    flex-direction: column;
  }

  /* Top navigation */
  .navbar {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 12px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    background: rgba(2,6,23,0.35);
    backdrop-filter: blur(6px);
  }
  .brand { display:flex; align-items:center; gap:10px; text-decoration:none; color:inherit; }
  .logo {
    display:inline-flex; align-items:center; justify-content:center;
    width:44px; height:44px; border-radius:10px;
    background: linear-gradient(90deg,var(--accent),var(--accent-2));
    font-weight:700; color:#fff; box-shadow: 0 8px 20px rgba(37,99,235,0.12);
  }
  .brand .title { font-weight:700; color:#f1f7ff; letter-spacing:-0.2px; }

  .search { margin-left: 12px; flex:1; display:flex; align-items:center; }
  .employee-info { display:flex; flex-direction:column; gap:2px; }
  .employee-info .name { font-weight:600; color:#fff; }
  .employee-info .muted { color:var(--muted); font-size:0.9rem; }

  .main-nav { display:flex; gap:8px; align-items:center; margin-left:12px; }
  .nav-item {
    display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
    color:var(--muted); text-decoration:none; transition: background 120ms ease, transform 120ms ease;
  }
  .nav-item:hover { background: rgba(255,255,255,0.02); color:#fff; transform: translateY(-1px); }
  .nav-item.active { background: linear-gradient(90deg,var(--accent),var(--accent-2)); color:#fff; box-shadow: 0 8px 20px rgba(37,99,235,0.12); }

  .user-area { display:flex; align-items:center; gap:12px; margin-left:auto; }
  .avatar { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; background: rgba(255,255,255,0.03); color:var(--muted); }

  /* Page layout */
  .page {
    width:100%;
    max-width:1200px;
    margin: 20px auto;
    padding: 0 20px 40px;
    box-sizing:border-box;
  }
  .grid {
    display:grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items:start;
  }

  /* Overview cards */
  .cards { display:flex; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
  .card {
    background: var(--card); border-radius:12px; padding:14px; box-shadow:var(--shadow);
    border:1px solid rgba(255,255,255,0.03); min-width:180px; flex:1;
  }
  .card h4 { margin:0 0 8px 0; font-size:0.95rem; color:var(--muted); }
  .card .value { font-size:1.4rem; font-weight:700; color:#fff; }

  /* Payments table */
  .panel {
    background: var(--card); border-radius: var(--radius); padding: 14px; box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.03);
  }
  table {
    width:100%; border-collapse:collapse; font-size:0.95rem;
  }
  thead th {
    text-align:left; padding:10px 8px; color:var(--muted); font-weight:600; font-size:0.85rem;
    border-bottom:1px solid rgba(255,255,255,0.03);
  }
  tbody td {
    padding:10px 8px; border-bottom:1px dashed rgba(255,255,255,0.03); color:#e6eef8;
  }
  .status {
    display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border-radius:999px; font-weight:600; font-size:0.85rem;
  }
  .status.completed { background: rgba(16,185,129,0.12); color:var(--success); }
  .status.pending { background: rgba(255,193,7,0.08); color:#f59e0b; }
  .status.failed { background: rgba(239,68,68,0.08); color:var(--danger); }

  /* Side panel */
  .side {
    display:flex; flex-direction:column; gap:12px;
  }
  .side .panel { padding:16px; }
  .quick-actions { display:flex; flex-direction:column; gap:8px; }
  .muted { color:var(--muted); }

  /* Modal */
  .modal { display:none; position:fixed; inset:0; background: rgba(2,6,23,0.6); backdrop-filter: blur(6px); z-index:1200; align-items:center; justify-content:center; padding:20px; }
  .modal.open { display:flex; }
  .modal-content { width:100%; max-width:520px; background:var(--card); border-radius:12px; padding:20px; border:1px solid rgba(255,255,255,0.04); box-shadow:var(--shadow); }
  .form-row { display:flex; flex-direction:column; gap:8px; margin-bottom:12px; }
  input, select, textarea {
    background: var(--glass); border:1px solid rgba(255,255,255,0.04); color:#e6eef8; padding:10px 12px; border-radius:10px; outline:none;
  }
  input:focus, select:focus, textarea:focus { border-color:var(--accent); box-shadow:0 6px 18px rgba(37,99,235,0.12); transform: translateY(-1px); }

  .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 12px; border-radius:10px; border:none; cursor:pointer; background: linear-gradient(90deg,var(--accent),var(--accent-2)); color:#fff; font-weight:600; }
  .btn.ghost { background:transparent; border:1px solid rgba(255,255,255,0.06); color:var(--muted); }

  .notice {
    max-width:1200px; margin:12px auto; padding:12px 16px; border-radius:10px; font-weight:600;
  }
  .notice.success { background: rgba(16,185,129,0.08); color: #10b981; border:1px solid rgba(16,185,129,0.12); }
  .notice.error { background: rgba(239,68,68,0.06); color: #ef4444; border:1px solid rgba(239,68,68,0.10); }

  @media (max-width: 980px) {
    .grid { grid-template-columns: 1fr; }
    .main-nav { display:none; }
  }
  </style>
</head>
<body>
  <nav class="navbar" role="navigation" aria-label="Main navigation">
    <a class="brand" href="guespayment.php" aria-label="Dashboard">
      <span class="logo">rm.v</span>
      <span class="title">Reservation</span>
    </a>

    <div class="search" role="search" aria-label="Employee">
      <div class="employee-info" aria-hidden="false">
        <div class="name"><?php echo htmlspecialchars($_SESSION['cxname'] ?? 'cxname'); ?></div>
        <!-- idk -->
      </div>
    </div>

    <div class="main-nav" role="menubar" aria-label="Primary">
      <a class="nav-item" href="guessdashboard.php" role="menuitem"><i class="fa-solid fa-house"></i><span>Home</span></a>
      <a class="nav-item active" href="guespayment.php" role="menuitem" aria-current="page"><i class="fa-solid fa-users"></i><span>Reservations</span></a>
      <a class="nav-item" href="calendar.php" role="menuitem"><i class="fa-solid fa-calendar-days"></i><span>Calendar</span></a>
    </div>

    <div class="user-area" aria-hidden="false">
      <button class="btn ghost" type="button" onclick="window.location.href='../Resortwebsite.php';">LogOut</button>
      <div class="avatar" title="Profile" role="img" aria-label="Profile"><i class="fa-solid fa-user"></i></div>
    </div>
  </nav>

  <?php
  // ISHOWDB TAENAung ano to connection
  if (!empty($db_error)) {
      echo '<div class="notice error" role="alert">' . htmlspecialchars($db_error) . '</div>';
  }

  // kung gumagana ung status
  if (!empty($_SESSION['payment_success'])) {
      echo '<div class="notice success" role="status">' . htmlspecialchars($_SESSION['payment_success']) . '</div>';
      unset($_SESSION['payment_success']);
  }
  if (!empty($_SESSION['payment_errors'])) {
      echo '<div class="notice error" role="alert"><ul>';
      foreach ($_SESSION['payment_errors'] as $err) {
          echo '<li>' . htmlspecialchars($err) . '</li>';
      }
      echo '</ul></div>';
      unset($_SESSION['payment_errors']);
  }
  ?>

  <main class="page" role="main">
    <div class="cards" aria-hidden="false">
      <div class="card">
        <h4>Total Collected (sample)</h4>
        <div class="value">₱ 0.00</div>
        <div class="muted" style="margin-top:8px;">Completed payments only</div>
      </div>

      <div class="card">
        <h4>Pending Payments</h4>
        <div class="value">0</div>
        <div class="muted" style="margin-top:8px;">Awaiting confirmation</div>
      </div>

      <div class="card">
        <h4>Recent Invoice</h4>
        <div class="value">—</div>
        <div class="muted" style="margin-top:8px;">Latest invoice number</div>
      </div>
    </div>

    <div class="grid">
      <section class="panel" aria-label="Payments table">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
          <h3 style="margin:0;">Payments</h3>
          <div style="display:flex;gap:8px;">
            <button class="btn ghost" onclick="location.reload()"><i class="fa-solid fa-filter"></i> Refresh</button>
            <button class="btn" onclick="openAddPaymentModal()"><i class="fa-solid fa-plus"></i> Add Payment</button>
          </div>
        </div>

        <div style="overflow:auto;">
          <table role="table" aria-label="Payments list">
            <thead>
              <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($payments)): ?>
                <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:18px;">No payments yet</td></tr>
              <?php else: ?>
                <?php foreach ($payments as $p): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($p['invoice_number']); ?></td>
                    <td><?php echo htmlspecialchars($p['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($p['payment_method']); ?></td>
                    <td><?php echo 'PHP ' . number_format((float)$p['amount'],2); ?></td>
                    <td><?php echo htmlspecialchars($p['payment_date']); ?></td>
                    <td>
                      <span class="status <?php echo htmlspecialchars($p['status']); ?>">
                        <?php echo ucfirst(htmlspecialchars($p['status'])); ?>
                      </span>
                    </td>
                    <td style="text-align:right;">
                      <button class="btn ghost" onclick="viewPayment(<?php echo (int)$p['id']; ?>)"><i class="fa-solid fa-eye"></i></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>

      <aside class="side" aria-label="Quick actions and filters">
        <div class="panel">
          <h4 style="margin:0 0 8px 0;">Quick actions</h4>
          <p class="muted" style="margin:0 0 12px 0;">Shortcuts for common tasks</p>
          <div class="quick-actions">
            <button class="btn" onclick="openAddPaymentModal()">Add New Payment</button>
            <!-- add this if want copy for staff -->
            <!-- <button class="btn ghost" onclick="location.href='payment_stafff.php'">Manage Staff Payments</button> -->
          </div>
        </div>
<!-- pilter -->
        <div class="panel">
          <h4 style="margin:0 0 8px 0;">Filters</h4>
          <label class="muted" style="font-size:0.9rem;">Status</label>
          <select id="filter-status" style="margin-top:8px;padding:8px;border-radius:8px;background:var(--glass);border:1px solid rgba(255,255,255,0.04);color:#e6eef8;">
            <option value="">All</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
          </select>
        </div>
      </aside>
    </div>
  </main>

  <!-- Add Payment Modal -->
  <div id="add-payment-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="add-payment-title">
    <div class="modal-content" role="document">
      <h3 id="add-payment-title">Add Payment</h3>
      <form id="add-payment-form" action="guespayment.php" method="POST" novalidate>
        <div class="form-row">
          <label for="customer_name">Full Name</label>
          <input id="customer_name" name="customer_name" type="text" required />
        </div>

        <div class="form-row">
          <label for="customer_email"> Email</label>
          <input id="customer_email" name="customer_email" type="email" required />
        </div>

        <div class="form-row">
          <label for="amount">Amount</label>
          <input id="amount" name="amount" type="number" step="0.01" min="0" required />
        </div>

        <div class="form-row">
          <label for="method">Payment Method</label>
          <select id="method" name="method" required>
            <option value="Cash">Cash</option>
            <option value="Card">Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="GCash">GCash</option>
          </select>
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px;">
          <button type="button" class="btn ghost" onclick="closeAddPaymentModal()">Cancel</button>
          <button type="submit" class="btn">Save Payment</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  // Modal helpers
  function openAddPaymentModal() {
    const modal = document.getElementById('add-payment-modal');
    if (!modal) return;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden','false');
    setTimeout(()=>document.getElementById('customer_name').focus(),120);
  }
  function closeAddPaymentModal() {
    const modal = document.getElementById('add-payment-modal');
    if (!modal) return;
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden','true');
    const form = document.getElementById('add-payment-form');
    if (form) form.reset();
  }

  // Close modal on outside click or Escape
  const addModal = document.getElementById('add-payment-modal');
  if (addModal) {
    addModal.addEventListener('click', (e) => { if (e.target === addModal) closeAddPaymentModal(); });
  }
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAddPaymentModal(); });

  // Placeholder view action
  function viewPayment(id) {
    alert('Open payment details for ID ' + id + '. Replace with real view logic.');
  }

  // Simple client-side filter by status
  const filterEl = document.getElementById('filter-status');
  if (filterEl) {
    filterEl.addEventListener('change', function() {
      const val = this.value;
      document.querySelectorAll('tbody tr').forEach(tr => {
        if (!val) { tr.style.display = ''; return; }
        const statusEl = tr.querySelector('.status');
        if (!statusEl) { tr.style.display = ''; return; }
        tr.style.display = statusEl.classList.contains(val) ? '' : 'none';
      });
    });
  }
  </script>
</body>
</html>
