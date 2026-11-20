<?php
include('include/check.php');
include('../dbconfig.php');

// Status দিয়ে filter
$status = isset($_GET['status']) ? $_GET['status'] : '';
$where = '';
if ($status == 'pending' || $status == 'completed' || $status == 'failed') {
  $where = "WHERE payment_transactions.status = '$status'";
}

$payments = $conn->query("SELECT payment_transactions.*, users.name AS user_name, companies.name AS company_name,
                                 packages.name AS package_name, payment_methods.name AS method_name,
                                 subscriptions.status AS sub_status, subscriptions.end_date
                          FROM payment_transactions
                          JOIN users ON users.id = payment_transactions.user_id
                          LEFT JOIN companies ON companies.user_id = users.id
                          JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                          JOIN packages ON packages.id = subscriptions.package_id
                          JOIN payment_methods ON payment_methods.id = payment_transactions.payment_method_id
                          $where
                          ORDER BY payment_transactions.id DESC");

$totalIncome = $conn->query("SELECT SUM(total_amount) AS s FROM payment_transactions WHERE status = 'completed'")->fetch_assoc()['s'];
$payColor = array('pending' => 'badge-warning', 'completed' => 'badge-success', 'failed' => 'badge-danger');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payments | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions">
    <div><h2>Payments</h2><p>All package payments (demo gateway).</p></div>
    <span class="badge badge-success">Total income: ৳<?php echo number_format((float)$totalIncome); ?></span>
  </div>

  <div class="tabs mb-2">
    <a class="tab-btn <?php if ($status == '') echo 'active'; ?>" href="payments.php">All</a>
    <a class="tab-btn <?php if ($status == 'completed') echo 'active'; ?>" href="payments.php?status=completed">Completed</a>
    <a class="tab-btn <?php if ($status == 'pending') echo 'active'; ?>" href="payments.php?status=pending">Pending</a>
    <a class="tab-btn <?php if ($status == 'failed') echo 'active'; ?>" href="payments.php?status=failed">Failed</a>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Invoice</th><th>Employer</th><th>Package</th><th>Method</th><th>Amount</th><th>Transaction ID</th><th>Payment</th><th>Package status</th></tr></thead>
        <tbody>
        <?php if ($payments->num_rows == 0) { ?><tr><td colspan="8" class="muted">No payments found.</td></tr><?php } ?>
        <?php while ($p = $payments->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $p['transaction_no']; ?></td>
            <td><strong><?php echo $p['company_name'] ? $p['company_name'] : $p['user_name']; ?></strong></td>
            <td><?php echo $p['package_name']; ?></td>
            <td><?php echo $p['method_name']; ?></td>
            <td>৳<?php echo number_format($p['total_amount']); ?></td>
            <td><?php echo $p['tx_id'] ? $p['tx_id'] : '-'; ?></td>
            <td><span class="badge <?php echo $payColor[$p['status']]; ?>"><?php echo ucfirst($p['status']); ?></span></td>
            <td><?php echo ucfirst($p['sub_status']); ?><?php if ($p['end_date']) echo '<br><small class="muted">till ' . date('d M Y', strtotime($p['end_date'])) . '</small>'; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
