<?php
include('include/check.php');
include('../payment/bkash.php');
include('../payment/activate.php');
$pageTitle = 'Payment Result';

// =========================================================
// bKash payment শেষ হলে bKash এই পেজে পাঠায়:
//   bkash-callback.php?paymentID=...&status=success / failure / cancel
// শুধু status=success দেখে বিশ্বাস করা হয় না।
// bKash server-এ execute আর query করে নিজে যাচাই করা হয়।
// =========================================================
$paymentId = isset($_GET['paymentID']) ? $_GET['paymentID'] : '';
$status    = isset($_GET['status']) ? $_GET['status'] : '';
$ok = false;
$message = '';
$result = array();

if ($paymentId == '') {
  $message = 'No payment information received from bKash.';
} else if ($status != 'success') {
  // বাতিল বা ব্যর্থ: bKash থেকে invoice জেনে আমাদের transaction failed করা
  $q = bkash_query($paymentId);
  if (isset($q['merchantInvoiceNumber'])) {
    $trx = find_invoice($conn, $q['merchantInvoiceNumber'], $userId);
    if ($trx && $trx['status'] == 'pending') {
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
    }
  }
  $message = 'bKash payment was ' . htmlspecialchars($status) . '. No package was activated.';
} else {
  // ১. Execute: bKash-কে payment চূড়ান্ত করতে বলা
  $result = bkash_execute($paymentId);

  // ২. Execute সফল না হলে (যেমন আগেই execute হয়েছে) bKash-কে জিজ্ঞেস করা
  if (!isset($result['transactionStatus'])) {
    $result = bkash_query($paymentId);
  }

  if (isset($result['error'])) {
    $message = $result['error'];
  } else if (!isset($result['transactionStatus']) || $result['transactionStatus'] != 'Completed') {
    // যাচাই ১: bKash বলছে Completed কিনা
    $message = 'bKash says the payment is not completed' . (isset($result['statusMessage']) ? ': ' . $result['statusMessage'] : '.');
  } else {
    // যাচাই ২: invoice আমাদের database-এ আর এই employer-এর কিনা
    $trx = find_invoice($conn, $result['merchantInvoiceNumber'], $userId);

    if (!$trx) {
      $message = 'This invoice does not belong to your account.';
    } else if ($trx['status'] == 'completed') {
      // যাচাই ৩: আগেই চালু হয়ে গেছে (refresh করলে দুবার হবে না)
      $ok = true;
      $message = 'This payment was already verified.';
    } else {
      $package = $conn->query("SELECT * FROM packages WHERE id = {$trx['package_id']}")->fetch_assoc();
      $trxId = $conn->real_escape_string($result['trxID']);
      $used = $conn->query("SELECT id FROM payment_transactions WHERE tx_id = '$trxId' AND id != {$trx['id']}")->num_rows;

      if ((float)$result['amount'] != (float)$trx['total_amount'] || (float)$trx['total_amount'] != (float)$package['price']) {
        // যাচাই ৪: টাকার পরিমাণ
        $message = 'Amount mismatch. Paid ৳' . $result['amount'] . ' but the package costs ৳' . $package['price'] . '.';
        $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
      } else if ($used > 0) {
        // যাচাই ৫: একই bKash trxID আগে ব্যবহার হয়েছে কিনা
        $message = 'This bKash transaction ID was already used.';
      } else {
        activate_package($conn, $trx, $package, $result['trxID'], $userId, $company['name']);
        $ok = true;
        $message = 'Payment verified with bKash. Your ' . $package['name'] . ' package is now active.';
      }
    }
  }
}

// এই payment-এর কাজ শেষ, তাই মনে রাখা paymentID মুছে ফেলি
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
