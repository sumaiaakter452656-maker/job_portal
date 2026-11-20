<?php
// =========================================================
// নকল payment পেজ (Demo bKash / Nagad / Card)
// এটা আসল কোনো কোম্পানির পেজ না। কোনো টাকা কাটে না।
// Demo তথ্য:  OTP = 123456, PIN = 12345
//             Card সফল = 4242 4242 4242 4242, Card বাতিল = 4000 0000 0000 0002
// =========================================================
include('../dbconfig.php');
include('demo_gateway.php');

$paymentId = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$pay = gateway_query($conn, $paymentId);
$error = '';

if (!$pay) {
  die('Invalid payment.');
}
$pid = $conn->real_escape_string($pay['payment_id']);
$isCard = $pay['method'] == 'Card';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $pay['status'] == 'initiated') {

  // ===== Cancel =====
  if (isset($_POST['cancel'])) {
    $conn->query("UPDATE demo_gateway SET status = 'cancelled' WHERE payment_id = '$pid'");
    header("Location: ../employer/payment-fail.php?payment_id=" . $pay['payment_id']);
    exit;
  }

  // ===== Pay =====
  if ($isCard) {
    $card = str_replace(' ', '', $_POST['card_number']);
    if (!preg_match('/^[0-9]{16}$/', $card) || !preg_match('/^[0-9]{3}$/', $_POST['cvv']) || $_POST['expiry'] == '') {
      $error = 'Please enter a valid 16 digit card number, expiry and 3 digit CVV.';
    } else if ($card == '4000000000000002') {
      // Demo: এই card বাতিল হয়
      $conn->query("UPDATE demo_gateway SET status = 'failed', account = '**** " . substr($card, -4) . "' WHERE payment_id = '$pid'");
      header("Location: ../employer/payment-fail.php?payment_id=" . $pay['payment_id']);
      exit;
    } else {
      $account = '**** ' . substr($card, -4);
    }
  } else {
    $wallet = trim($_POST['wallet']);
    if (!preg_match('/^01[0-9]{9}$/', $wallet)) {
      $error = 'Please enter a valid 11 digit mobile number (01XXXXXXXXX).';
    } else if ($_POST['otp'] != '123456') {
      $error = 'Wrong OTP. (Demo OTP is 123456)';
    } else if ($_POST['pin'] != '12345') {
      $error = 'Wrong PIN. (Demo PIN is 12345)';
    } else {
      $account = substr($wallet, 0, 3) . '*****' . substr($wallet, -3);
    }
  }

  if ($error == '') {
    // সফল: gateway নিজের রেকর্ডে Completed লিখে, transaction ID দেয়
    $prefix = array('bKash' => 'BK', 'Nagad' => 'NG', 'Card' => 'CD');
    $txId = $prefix[$pay['method']] . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    $conn->query("UPDATE demo_gateway SET status = 'completed', tx_id = '$txId', account = '$account' WHERE payment_id = '$pid'");

    // Merchant-এর success পেজে ফেরত (সেখানে server আবার যাচাই করবে)
    header("Location: ../employer/payment-success.php?payment_id=" . $pay['payment_id']);
    exit;
  }
}

$colors = array('bKash' => '#be185d', 'Nagad' => '#c2410c', 'Card' => '#1d4ed8');
$color = $colors[$pay['method']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Demo <?php echo $pay['method']; ?> Payment</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body style="background:#f1f5f9;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px">

<div class="card" style="width:100%;max-width:440px;overflow:hidden">
  <div style="background:<?php echo $color; ?>;color:#fff;padding:22px 24px">
    <div style="font-size:.8rem;letter-spacing:.08em;opacity:.85">DEMO PAYMENT GATEWAY</div>
    <div style="font-size:1.5rem;font-weight:800"><?php echo $pay['method']; ?> (Demo)</div>
  </div>
  <div class="card-body">
    <div class="alert alert-warning"><span>Practice page only. <b>No real money</b> is charged.</span></div>

    <ul class="overview-list">
      <li><div><small>Merchant</small><strong>JobHub</strong></div></li>
      <li><div><small>Invoice</small><strong><?php echo $pay['invoice_no']; ?></strong></div></li>
      <li><div><small>Amount</small><strong>৳<?php echo number_format($pay['amount'], 2); ?></strong></div></li>
    </ul>

    <?php if ($pay['status'] != 'initiated') { ?>
      <div class="alert alert-info mt-2"><span>This payment is already <b><?php echo $pay['status']; ?></b>.</span></div>
      <a class="btn btn-light btn-block" href="../employer/subscription.php">Back to JobHub</a>
    <?php } else { ?>

      <?php if ($error != '') { ?><div class="alert alert-danger mt-2"><span><?php echo $error; ?></span></div><?php } ?>

      <form action="" method="post" class="mt-2">
        <?php if ($isCard) { ?>
          <div class="form-group"><label class="form-label">Card number</label><input class="form-control" name="card_number" placeholder="4242 4242 4242 4242" maxlength="19"></div>
          <div class="form-row">
            <div class="form-group"><label class="form-label">Expiry</label><input class="form-control" name="expiry" placeholder="12/29"></div>
            <div class="form-group"><label class="form-label">CVV</label><input class="form-control" name="cvv" placeholder="123" maxlength="3"></div>
          </div>
          <p class="small muted">Demo: 4242 4242 4242 4242 = success, 4000 0000 0000 0002 = declined</p>
        <?php } else { ?>
          <div class="form-group"><label class="form-label"><?php echo $pay['method']; ?> account number</label><input class="form-control" name="wallet" placeholder="01XXXXXXXXX" maxlength="11"></div>
          <div class="form-row">
            <div class="form-group"><label class="form-label">OTP</label><input class="form-control" name="otp" placeholder="123456" maxlength="6"></div>
            <div class="form-group"><label class="form-label">PIN</label><input class="form-control" type="password" name="pin" placeholder="•••••" maxlength="5"></div>
          </div>
          <p class="small muted">Demo: any 01XXXXXXXXX number, OTP 123456, PIN 12345</p>
        <?php } ?>
        <button class="btn btn-block btn-lg" style="background:<?php echo $color; ?>;color:#fff" type="submit" name="pay">Confirm Payment</button>
        <button class="btn btn-light btn-block mt-1" type="submit" name="cancel" formnovalidate>Cancel</button>
      </form>
    <?php } ?>
  </div>
</div>

</body>
</html>
