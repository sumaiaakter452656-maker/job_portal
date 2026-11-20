<?php
include('include/check.php');
include('../payment/aamarpay.php');
$pageTitle = 'Payment Result';

// Show this employer's invoice status from the database
$invoice = isset($_GET['inv']) ? $conn->real_escape_string($_GET['inv']) : '';
$trx = $conn->query("SELECT payment_transactions.*, packages.name AS package_name, payment_methods.name AS method_name
                     FROM payment_transactions
                     JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                     JOIN packages ON packages.id = subscriptions.package_id
                     JOIN payment_methods ON payment_methods.id = payment_transactions.payment_method_id
                     WHERE payment_transactions.transaction_no = '$invoice' AND payment_transactions.user_id = $userId")->fetch_assoc();

$ok = $trx && $trx['status'] == 'completed';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Result | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">
  <div class="card" style="max-width:560px;margin:0 auto">
    <div class="card-body" style="text-align:center">
      <?php if (!$trx) { ?>
        <div style="font-size:3rem">⚠️</div>
        <h2>Payment not found</h2>
        <p class="muted">This invoice does not belong to your account.</p>
      <?php } else if ($ok) { ?>
        <div style="font-size:3rem">✅</div>
        <h2>Payment successful</h2>
        <p class="muted">Payment verified with aamarPay. Your <?php echo $trx['package_name']; ?> package is now active.</p>
        <ul class="overview-list" style="text-align:left">
          <li><div><small>Invoice</small><strong><?php echo $trx['transaction_no']; ?></strong></div></li>
          <li><div><small>aamarPay Transaction ID</small><strong><?php echo $trx['tx_id']; ?></strong></div></li>
          <li><div><small>Amount</small><strong>৳<?php echo number_format($trx['total_amount'], 2); ?></strong></div></li>
          <?php if ($sub) { ?><li><div><small>Package</small><strong><?php echo $sub['package_name']; ?> · <?php echo $sub['posts_left']; ?> posts · till <?php echo date('d M Y', strtotime($sub['end_date'])); ?></strong></div></li><?php } ?>
        </ul>
      <?php } else if ($trx['status'] == 'failed') { ?>
        <div style="font-size:3rem">❌</div>
        <h2>Payment failed or cancelled</h2>
        <p class="muted">No package was activated. You can try again any time.</p>
      <?php } else { ?>
        <div style="font-size:3rem">⏳</div>
        <h2>Payment not completed yet</h2>
        <p class="muted">aamarPay has not confirmed this payment. If you already paid, check again.</p>
        <a class="btn btn-primary" href="../payment/aamarpay-return.php?inv=<?php echo urlencode($trx['transaction_no']); ?>">Check again</a>
      <?php } ?>
      <div class="flex gap-2 mt-2" style="justify-content:center">
        <a class="btn btn-light" href="subscription.php">Billing</a>
        <?php if ($ok) { ?><a class="btn btn-primary" href="post-job.php">Post a Job</a><?php } ?>
      </div>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
