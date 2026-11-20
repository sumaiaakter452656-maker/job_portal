<?php
// Function that activates the package after the payment is verified
// (Used by both the demo gateway and the bKash sandbox)
function activate_package($conn, $trx, $package, $txId, $userId, $companyName) {
  $txId = $conn->real_escape_string($txId);

  // payment completed
  $conn->query("UPDATE payment_transactions SET status = 'completed', tx_id = '$txId' WHERE id = {$trx['id']}");

  // If an older package is still active, its remaining posts and days are added to the new package
  $old = $conn->query("SELECT * FROM subscriptions WHERE user_id = $userId AND status = 'active'
                       AND end_date >= CURDATE() AND id != {$trx['subscription_id']}
                       ORDER BY end_date DESC LIMIT 1")->fetch_assoc();
  $extraPosts = $old ? (int)$old['posts_left'] : 0;
  $startFrom  = $old ? $old['end_date'] : date('Y-m-d');   // the new period starts from the day the old one ends

  // Close the old package (its posts moved to the new one)
  $conn->query("UPDATE subscriptions SET status = 'expired' WHERE user_id = $userId AND status = 'active'
                AND id != {$trx['subscription_id']}");

  // Activate the new package: new posts + old remaining posts, end = old end date + new days
  $posts = $package['job_post_limit'] + $extraPosts;
  $end   = date('Y-m-d', strtotime($startFrom . ' +' . $package['duration_days'] . ' days'));
  $conn->query("UPDATE subscriptions SET status = 'active', start_date = CURDATE(), end_date = '$end',
                posts_left = $posts WHERE id = {$trx['subscription_id']}");

  // Notification: employer and admin
  $msg = $conn->real_escape_string('Payment ' . $trx['transaction_no'] . ' completed. ' . $package['name'] . ' package is active'
                                   . ($extraPosts > 0 ? ' (' . $extraPosts . ' unused posts carried over)' : '') . '.');
  $conn->query("INSERT INTO notifications (user_id, message) VALUES ($userId, '$msg')");
  $admins = $conn->query("SELECT id FROM users WHERE role = 'admin'");
  $amsg = $conn->real_escape_string($companyName . ' paid ৳' . $trx['total_amount'] . ' for ' . $package['name'] . ' (' . $trx['transaction_no'] . ')');
  while ($ad = $admins->fetch_assoc()) {
    $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$ad['id']}, '$amsg')");
  }
}

// Find the invoice in our database (only for this user)
function find_invoice($conn, $invoice, $userId) {
  $invoice = $conn->real_escape_string($invoice);
  return $conn->query("SELECT payment_transactions.*, subscriptions.package_id
                       FROM payment_transactions
                       JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                       WHERE payment_transactions.transaction_no = '$invoice'
                         AND payment_transactions.user_id = $userId")->fetch_assoc();
}
