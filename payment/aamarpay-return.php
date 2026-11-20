<?php
// =========================================================
// aamarPay payment শেষে এখানে ফেরত পাঠায় (POST দিয়ে)।
// aamarPay যা POST করে সেটা বিশ্বাস করা হয় না।
// শুধু invoice নম্বর নিয়ে aamarPay-এর Search API-তে নিজে যাচাই করা হয়।
// (এখানে login session লাগে না, কারণ বাইরের site থেকে POST এলে
//  browser অনেক সময় login cookie পাঠায় না।)
// =========================================================
include('../dbconfig.php');
include('aamarpay.php');
include('activate.php');

$invoice = isset($_GET['inv']) ? $conn->real_escape_string($_GET['inv']) : '';
$result  = isset($_GET['result']) ? $_GET['result'] : '';

// আমাদের database-এ এই invoice
$trx = $conn->query("SELECT payment_transactions.*, subscriptions.package_id
                     FROM payment_transactions
                     JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                     WHERE payment_transactions.transaction_no = '$invoice'")->fetch_assoc();

if ($trx && $trx['status'] == 'pending') {
  // aamarPay-কে জিজ্ঞেস করা
  $r = aamarpay_search($invoice);
  $package = $conn->query("SELECT * FROM packages WHERE id = {$trx['package_id']}")->fetch_assoc();

  $paid = isset($r['pay_status']) && $r['pay_status'] == 'Successful'
       && isset($r['mer_txnid']) && $r['mer_txnid'] == $invoice;

  if ($paid) {
    $pgTxn = $conn->real_escape_string($r['pg_txnid']);
    $used  = $conn->query("SELECT id FROM payment_transactions WHERE tx_id = '$pgTxn' AND id != {$trx['id']}")->num_rows;

    if ((float)$r['amount'] != (float)$trx['total_amount'] || (float)$trx['total_amount'] != (float)$package['price']
        || (isset($r['currency']) && $r['currency'] != 'BDT')) {
      // টাকার পরিমাণ বা currency মেলেনি
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
    } else if ($used == 0) {
      // সব যাচাই পার: package চালু
      $co = $conn->query("SELECT name FROM companies WHERE user_id = {$trx['user_id']}")->fetch_assoc();
      activate_package($conn, $trx, $package, $r['pg_txnid'], (int)$trx['user_id'], $co ? $co['name'] : 'Employer');
    }
  } else if ($result == 'fail' || $result == 'cancel') {
    // aamarPay-ও Successful বলছে না, আর user বাতিল/ব্যর্থ পেজ থেকে এসেছে
    $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
  }
}

// ফলাফল দেখানোর পেজে (employer login সহ) পাঠানো
header("Location: ../employer/payment-result.php?inv=" . urlencode($invoice));
exit;
