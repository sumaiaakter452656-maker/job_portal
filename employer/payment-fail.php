<?php
include('include/check.php');
include('../payment/demo_gateway.php');
$pageTitle = 'Payment Failed';

// Gateway-তে payment বাতিল বা ব্যর্থ হলে, আমাদের transaction-কেও failed করা
$g = gateway_query($conn, isset($_GET['payment_id']) ? $_GET['payment_id'] : '');
if ($g && ($g['status'] == 'failed' || $g['status'] == 'cancelled')) {
  $invoice = $conn->real_escape_string($g['invoice_no']);
  $conn->query("UPDATE payment_transactions SET status = 'failed'
                WHERE transaction_no = '$invoice' AND user_id = $userId AND status = 'pending'");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Failed | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">
  <div class="card" style="max-width:560px;margin:0 auto">
    <div class="card-body" style="text-align:center">
      <div style="font-size:3rem">❌</div>
      <h2>Payment <?php echo $g ? $g['status'] : 'failed'; ?></h2>
      <p class="muted">No package was activated. You can try again any time.</p>
      <a class="btn btn-primary" href="subscription.php">Back to Packages</a>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
