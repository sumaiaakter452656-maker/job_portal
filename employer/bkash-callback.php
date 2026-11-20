<?php
include('include/check.php');
include('../payment/bkash.php');
include('../payment/activate.php');
$pageTitle = 'Payment Result';

// =========================================================
// When the bKash payment ends, bKash sends the user to this page:
//   bkash-callback.php?paymentID=...&status=success / failure / cancel
// We do not trust status=success alone.
// We verify it ourselves by calling execute and query on the bKash server.
// =========================================================
$paymentId = isset($_GET['paymentID']) ? $_GET['paymentID'] : '';
$status    = isset($_GET['status']) ? $_GET['status'] : '';
$ok = false;
$message = '';
$result = array();

if ($paymentId == '') {
  $message = 'No payment information received from bKash.';
} else if ($status != 'success') {
  // Cancelled or failed: get the invoice from bKash and mark our transaction failed
  $q = bkash_query($paymentId);
  if (isset($q['merchantInvoiceNumber'])) {
    $trx = find_invoice($conn, $q['merchantInvoiceNumber'], $userId);
    if ($trx && $trx['status'] == 'pending') {
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
    }
  }
  $message = 'bKash payment was ' . htmlspecialchars($status) . '. No package was activated.';
} else {
  // 1. Execute: ask bKash to finalise the payment
  $result = bkash_execute($paymentId);

  // 2. If execute did not succeed (e.g. already executed), ask bKash for the status
  if (!isset($result['transactionStatus'])) {
    $result = bkash_query($paymentId);
  }

  if (isset($result['error'])) {
    $message = $result['error'];
  } else if (!isset($result['transactionStatus']) || $result['transactionStatus'] != 'Completed') {
    // Check 1: does bKash say Completed?
    $message = 'bKash says the payment is not completed' . (isset($result['statusMessage']) ? ': ' . $result['statusMessage'] : '.');
  } else {
    // Check 2: is the invoice in our database and does it belong to this employer?
    $trx = find_invoice($conn, $result['merchantInvoiceNumber'], $userId);

    if (!$trx) {
      $message = 'This invoice does not belong to your account.';
    } else if ($trx['status'] == 'completed') {
      // Check 3: already activated? (a refresh will not activate it twice)
      $ok = true;
      $message = 'This payment was already verified.';
    } else {
      $package = $conn->query("SELECT * FROM packages WHERE id = {$trx['package_id']}")->fetch_assoc();
      $trxId = $conn->real_escape_string($result['trxID']);
      $used = $conn->query("SELECT id FROM payment_transactions WHERE tx_id = '$trxId' AND id != {$trx['id']}")->num_rows;

      if ((float)$result['amount'] != (float)$trx['total_amount'] || (float)$trx['total_amount'] != (float)$package['price']) {
        // Check 4: the amount
        $message = 'Amount mismatch. Paid ৳' . $result['amount'] . ' but the package costs ৳' . $package['price'] . '.';
        $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
      } else if ($used > 0) {
        // Check 5: has the same bKash trxID been used before?
        $message = 'This bKash transaction ID was already used.';
      } else {
        activate_package($conn, $trx, $package, $result['trxID'], $userId, $company['name']);
        $ok = true;
        $message = 'Payment verified with bKash. Your ' . $package['name'] . ' package is now active.';
      }
    }
  }
}

// This payment is done, so remove the remembered paymentID
if ($ok || $status != 'success') {
  unset($_SESSION['bkash_payment_id']);
}

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
      <h2><?php echo $ok ? 'Payment successful' : 'Payment not completed'; ?></h2>
      <p class="muted"><?php echo $message; ?></p>
      <?php if ($ok && isset($result['trxID'])) { ?>
        <ul class="overview-list" style="text-align:left">
          <li><div><small>Invoice</small><strong><?php echo $result['merchantInvoiceNumber']; ?></strong></div></li>
          <li><div><small>bKash Transaction ID</small><strong><?php echo $result['trxID']; ?></strong></div></li>
          <li><div><small>Paid from</small><strong><?php echo isset($result['customerMsisdn']) ? $result['customerMsisdn'] : 'bKash'; ?></strong></div></li>
          <li><div><small>Amount</small><strong>৳<?php echo number_format($result['amount'], 2); ?></strong></div></li>
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
