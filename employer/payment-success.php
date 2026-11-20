<?php
include('include/check.php');
include('../payment/demo_gateway.php');
include('../payment/activate.php');
$pageTitle = 'Payment Result';

// =========================================================
// শুধু এই পেজে চলে আসলেই payment সফল ধরা হবে না।
// নিচের সব যাচাই পার হলে তবেই subscription চালু হবে।
// =========================================================
$paymentId = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$ok = false;
$message = '';

// যাচাই ১: gateway-কে জিজ্ঞেস করা, এই payment আসলেই আছে কিনা
$g = gateway_query($conn, $paymentId);

if (!$g) {
  $message = 'Payment not found at the gateway.';
} else if ($g['status'] != 'completed') {
  // যাচাই ২: gateway বলছে Completed কিনা
  $message = 'The gateway says this payment is "' . $g['status'] . '", not completed.';
} else {
  // যাচাই ৩: invoice টা আমাদের database-এ আছে আর এই employer-এর কিনা
  $invoice = $conn->real_escape_string($g['invoice_no']);
  $trx = $conn->query("SELECT payment_transactions.*, subscriptions.package_id
                       FROM payment_transactions
                       JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                       WHERE payment_transactions.transaction_no = '$invoice'
                         AND payment_transactions.user_id = $userId")->fetch_assoc();

  if (!$trx) {
    $message = 'This invoice does not belong to your account.';
  } else if ($trx['status'] == 'completed') {
    // যাচাই ৪: আগেই চালু করা হয়েছে (page refresh করলে দুবার চালু হবে না)
    $ok = true;
    $message = 'This payment was already verified.';
  } else {
    $package = $conn->query("SELECT * FROM packages WHERE id = {$trx['package_id']}")->fetch_assoc();
    $txId = $conn->real_escape_string($g['tx_id']);
    $used = $conn->query("SELECT id FROM payment_transactions WHERE tx_id = '$txId' AND id != {$trx['id']}")->num_rows;

    if ((float)$g['amount'] != (float)$trx['total_amount'] || (float)$trx['total_amount'] != (float)$package['price']) {
      // যাচাই ৫: টাকার পরিমাণ package-এর দামের সাথে মিলছে কিনা
      $message = 'Amount mismatch. Paid ৳' . $g['amount'] . ' but the package costs ৳' . $package['price'] . '.';
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
    } else if ($used > 0) {
      // যাচাই ৬: একই transaction ID আগে ব্যবহার হয়েছে কিনা
      $message = 'This transaction ID was already used.';
    } else {
      // ===== সব যাচাই পার: payment completed + subscription active =====
      activate_package($conn, $trx, $package, $g['tx_id'], $userId, $company['name']);

      $ok = true;
      $message = 'Payment verified. Your ' . $package['name'] . ' package is now active.';
    }
  }
}

// চালু package আবার আনা (উপরের menu-তে ঠিক সংখ্যা দেখানোর জন্য)
$sub = $conn->query("SELECT subscriptions.*, packages.name AS package_name FROM subscriptions
                     JOIN packages ON packages.id = subscriptions.package_id
                     WHERE subscriptions.user_id = $userId AND subscriptions.status = 'active'
                     ORDER BY subscriptions.id DESC LIMIT 1")->fetch_assoc();
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
      <div style="font-size:3rem"><?php echo $ok ? '✅' : '⚠️'; ?></div>
      <h2><?php echo $ok ? 'Payment successful' : 'Payment not verified'; ?></h2>
      <p class="muted"><?php echo $message; ?></p>
      <?php if ($ok && $g) { ?>
        <ul class="overview-list" style="text-align:left">
          <li><div><small>Invoice</small><strong><?php echo $g['invoice_no']; ?></strong></div></li>
          <li><div><small>Transaction ID</small><strong><?php echo $g['tx_id']; ?></strong></div></li>
          <li><div><small>Paid with</small><strong><?php echo $g['method'] . ' (' . $g['account'] . ')'; ?></strong></div></li>
          <li><div><small>Amount</small><strong>৳<?php echo number_format($g['amount'], 2); ?></strong></div></li>
          <?php if ($sub) { ?><li><div><small>Package</small><strong><?php echo $sub['package_name']; ?> · <?php echo $sub['posts_left']; ?> posts · till <?php echo date('d M Y', strtotime($sub['end_date'])); ?></strong></div></li><?php } ?>
        </ul>
      <?php } ?>
      <div class="flex gap-2 mt-2" style="justify-content:center">
        <a class="btn btn-light" href="subscription.php">Billing</a>
        <?php if ($ok) { ?><a class="btn btn-primary" href="post-job.php">Post a Job</a><?php } ?>
      </div>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
