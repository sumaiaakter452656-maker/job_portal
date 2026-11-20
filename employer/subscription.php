<?php
include('include/check.php');
$pageTitle = 'Packages & Billing';

// All packages (except Free, which is given automatically on the first job post)
$packages = $conn->query("SELECT * FROM packages WHERE price > 0 ORDER BY price");

// All my payments
$payments = $conn->query("SELECT payment_transactions.*, packages.name AS package_name, payment_methods.name AS method_name
                          FROM payment_transactions
                          JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                          JOIN packages ON packages.id = subscriptions.package_id
                          JOIN payment_methods ON payment_methods.id = payment_transactions.payment_method_id
                          WHERE payment_transactions.user_id = $userId
                          ORDER BY payment_transactions.id DESC");

$payColor = array('pending' => 'badge-warning', 'completed' => 'badge-success', 'failed' => 'badge-danger');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Packages & Billing | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions"><div><h2>Packages &amp; Billing</h2><p>Your current package and payment history.</p></div></div>

  <?php if (isset($_SESSION['bkash_payment_id'])) { ?>
    <!-- If bKash does not redirect back automatically, the payment can be verified here -->
    <div class="alert alert-info mb-3"><span>Paid with bKash but did not come back here automatically?
      <a class="btn btn-sm btn-primary" href="bkash-callback.php?paymentID=<?php echo urlencode($_SESSION['bkash_payment_id']); ?>&status=success">Check my bKash payment</a></span></div>
  <?php } ?>

  <!-- Active package -->
  <div class="card mb-3">
    <div class="card-body">
      <?php if ($sub) { ?>
        <h3 class="mb-0">Current package: <?php echo $sub['package_name']; ?></h3>
        <p class="muted mb-0"><?php echo $sub['posts_left']; ?> job posts left · valid till <?php echo date('d M Y', strtotime($sub['end_date'])); ?></p>
      <?php } else { ?>
        <h3 class="mb-0">No active package</h3>
        <p class="muted mb-0">Buy a package below to post jobs.</p>
      <?php } ?>
    </div>
  </div>

  <!-- Packages to buy -->
  <div class="grid grid-3 mb-3">
    <?php while ($p = $packages->fetch_assoc()) { ?>
      <div class="card"><div class="card-body">
        <h3><?php echo $p['name']; ?></h3>
        <h2 style="margin:4px 0">৳<?php echo number_format($p['price']); ?></h2>
        <p class="muted small"><?php echo $p['job_post_limit']; ?> job posts · <?php echo $p['duration_days']; ?> days</p>
        <a class="btn btn-primary btn-block" href="checkout.php?package=<?php echo $p['id']; ?>">Buy now</a>
      </div></div>
    <?php } ?>
  </div>

  <!-- Payment history -->
  <div class="card">
    <div class="card-header"><h3>Payment history</h3></div>
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Invoice</th><th>Package</th><th>Method</th><th>Amount</th><th>Transaction ID</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php if ($payments->num_rows == 0) { ?><tr><td colspan="7" class="muted">No payments yet.</td></tr><?php } ?>
        <?php while ($pay = $payments->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $pay['transaction_no']; ?></td>
            <td><?php echo $pay['package_name']; ?></td>
            <td><?php echo $pay['method_name']; ?></td>
            <td>৳<?php echo number_format($pay['total_amount']); ?></td>
            <td><?php echo $pay['tx_id'] ? $pay['tx_id'] : '-'; ?></td>
            <td><span class="badge <?php echo $payColor[$pay['status']]; ?>"><?php echo ucfirst($pay['status']); ?></span></td>
            <td>
              <?php if ($pay['status'] == 'pending' && $pay['method_name'] != 'bKash') { ?>
                <!-- If aamarPay does not redirect back automatically: ask aamarPay again -->
                <a class="btn btn-sm btn-light" href="../payment/aamarpay-return.php?inv=<?php echo urlencode($pay['transaction_no']); ?>">Check</a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
