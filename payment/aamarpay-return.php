<?php
// =========================================================
// After payment, aamarPay sends the user back here (with POST).
// We do not trust what aamarPay POSTs.
// We take only the invoice number and verify it ourselves with aamarPay's Search API.
// (No login session is needed here, because when a POST comes from another site
//  the browser often does not send the login cookie.)
// =========================================================
include('../dbconfig.php');
include('aamarpay.php');
include('activate.php');

$invoice = isset($_GET['inv']) ? $conn->real_escape_string($_GET['inv']) : '';
$result  = isset($_GET['result']) ? $_GET['result'] : '';

// This invoice in our database
$trx = $conn->query("SELECT payment_transactions.*, subscriptions.package_id
                     FROM payment_transactions
                     JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                     WHERE payment_transactions.transaction_no = '$invoice'")->fetch_assoc();

if ($trx && $trx['status'] == 'pending') {
  // Ask aamarPay
  $r = aamarpay_search($invoice);
  $package = $conn->query("SELECT * FROM packages WHERE id = {$trx['package_id']}")->fetch_assoc();

  $paid = isset($r['pay_status']) && $r['pay_status'] == 'Successful'
       && isset($r['mer_txnid']) && $r['mer_txnid'] == $invoice;

  if ($paid) {
    $pgTxn = $conn->real_escape_string($r['pg_txnid']);
    $used  = $conn->query("SELECT id FROM payment_transactions WHERE tx_id = '$pgTxn' AND id != {$trx['id']}")->num_rows;

    if ((float)$r['amount'] != (float)$trx['total_amount'] || (float)$trx['total_amount'] != (float)$package['price']
        || (isset($r['currency']) && $r['currency'] != 'BDT')) {
      // The amount or currency did not match
      $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
    } else if ($used == 0) {
      // All checks passed: activate the package
      $co = $conn->query("SELECT name FROM companies WHERE user_id = {$trx['user_id']}")->fetch_assoc();
      activate_package($conn, $trx, $package, $r['pg_txnid'], (int)$trx['user_id'], $co ? $co['name'] : 'Employer');
    }
  } else if ($result == 'fail' || $result == 'cancel') {
    // aamarPay does not say Successful either, and the user came from the cancel/fail page
    $conn->query("UPDATE payment_transactions SET status = 'failed' WHERE id = {$trx['id']}");
  }
}

// Go to the result page (which has the employer login)
header("Location: ../employer/payment-result.php?inv=" . urlencode($invoice));
exit;
