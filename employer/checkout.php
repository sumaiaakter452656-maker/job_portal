<?php
include('include/check.php');
include('../payment/demo_gateway.php');
include('../payment/bkash.php');
include('../payment/aamarpay.php');
$pageTitle = 'Checkout';

// কোন package কিনছে (দাম সবসময় database থেকে নেওয়া হয়, form থেকে না)
$packageId = isset($_GET['package']) ? (int)$_GET['package'] : 0;
$package = $conn->query("SELECT * FROM packages WHERE id = $packageId AND price > 0")->fetch_assoc();
if (!$package) {
  header("Location: subscription.php");
  exit;
}

// Online payment method (bKash, Nagad, Card)
$methods = $conn->query("SELECT * FROM payment_methods WHERE status = 'active' AND name IN ('bKash', 'Nagad', 'Card')");
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $methodId = (int)$_POST['payment_method_id'];
  $method = $conn->query("SELECT * FROM payment_methods WHERE id = $methodId AND status = 'active' AND name IN ('bKash', 'Nagad', 'Card')")->fetch_assoc();

  if (!$method) {
    $error = 'Please choose a payment method.';
  } else {
    $amount = $package['price'];

    // ১. Pending subscription (টাকা পাওয়ার পরে active হবে)
    $conn->query("INSERT INTO subscriptions (user_id, package_id, posts_left, status)
                  VALUES ($userId, $packageId, 0, 'pending')");
    $subId = $conn->insert_id;

    // ২. Pending transaction, নিজস্ব invoice নম্বর সহ
    $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
    $conn->query("INSERT INTO payment_transactions (transaction_no, user_id, subscription_id, payment_method_id, total_amount, status)
                  VALUES ('$invoice', $userId, $subId, $methodId, $amount, 'pending')");

    if ($method['name'] == 'bKash') {
      // ৩ক. bKash Sandbox: bKash-এর নিজের payment পেজে পাঠানো
      $callback = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/bkash-callback.php';
      $res = bkash_create($amount, $invoice, $callback, $company['name']);
      if (isset($res['bkashURL'])) {
        // bKash থেকে নিজে থেকে ফেরত না এলে, Billing পেজ থেকে যাচাই করার জন্য মনে রাখি
        $_SESSION['bkash_payment_id'] = $res['paymentID'];
        header("Location: " . $res['bkashURL']);
        exit;
      }
      // bKash-এ payment তৈরি না হলে transaction failed
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE transaction_no = '$invoice'");
      $error = 'bKash error: ' . (isset($res['error']) ? $res['error'] : (isset($res['statusMessage']) ? $res['statusMessage'] : 'Unknown error'));
    } else {
      // ৩খ. Nagad / Card: aamarPay Sandbox-এর নিজের payment পেজে পাঠানো
      $me = $conn->query("SELECT name, email, phone FROM users WHERE id = $userId")->fetch_assoc();
      $returnUrl = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\') . '/payment/aamarpay-return.php?inv=' . $invoice;
      $res = aamarpay_create($invoice, $amount, 'JobHub ' . $package['name'] . ' package',
                             $me['name'], $me['email'], $me['phone'] ? $me['phone'] : '01700000000', $returnUrl);
      if (isset($res['payment_url'])) {
        header("Location: " . $res['payment_url']);
        exit;
      }
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE transaction_no = '$invoice'");
      $error = $res['error'];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Checkout</h2><p>Review your order and choose a payment method.</p></div>
    <a href="subscription.php" class="btn btn-light">Back</a>
  </div>

  <?php if ($error != '') { ?><div class="alert alert-danger"><span><?php echo $error; ?></span></div><?php } ?>

  <div class="dash-grid">
    <form class="card" action="" method="post">
      <div class="card-body">
        <h3>Payment method</h3>
        <?php while ($m = $methods->fetch_assoc()) { ?>
          <label class="check" style="padding:14px;border:1px solid var(--border);border-radius:10px;margin-bottom:10px">
            <input type="radio" name="payment_method_id" value="<?php echo $m['id']; ?>" required>
            <strong><?php echo $m['name']; ?></strong>
            <span class="muted small">&nbsp;<?php echo $m['name'] == 'bKash' ? '(official bKash Sandbox page)' : '(aamarPay Sandbox page)'; ?></span>
          </label>
        <?php } ?>
        <div class="alert alert-warning mt-2"><span>Test mode: <b>no real money</b> will be charged.<br>
          bKash Sandbox test wallet: <b>01929918378</b> (or 01770618576, 01877722345, 01619777282), OTP <b>123456</b>, PIN <b>12121</b><br>
          Nagad / Card open the aamarPay Sandbox page — follow the test instructions shown there.</span></div>
        <button class="btn btn-primary btn-block btn-lg" type="submit">Pay ৳<?php echo number_format($package['price']); ?></button>
      </div>
    </form>

    <div class="card">
      <div class="card-header"><h3>Order summary</h3></div>
      <div class="card-body">
        <ul class="overview-list">
          <li><div><small>Package</small><strong><?php echo $package['name']; ?></strong></div></li>
          <li><div><small>Job posts</small><strong><?php echo $package['job_post_limit']; ?></strong></div></li>
          <li><div><small>Validity</small><strong><?php echo $package['duration_days']; ?> days</strong></div></li>
          <li><div><small>Total</small><strong>৳<?php echo number_format($package['price']); ?></strong></div></li>
        </ul>
      </div>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
