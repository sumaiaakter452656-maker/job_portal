<?php
// =========================================================
// DEMO PAYMENT GATEWAY (fake bKash / Nagad / Card)
// A real gateway has its own server and database.
// Here we use the demo_gateway table instead.
// No money is charged here.
// =========================================================

// Create the table if it does not exist
function gateway_setup($conn) {
  $conn->query("CREATE TABLE IF NOT EXISTS demo_gateway (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    payment_id VARCHAR(30) NOT NULL UNIQUE,
    invoice_no VARCHAR(30) NOT NULL,
    method VARCHAR(20) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    account VARCHAR(30) DEFAULT NULL,
    tx_id VARCHAR(30) DEFAULT NULL,
    status ENUM('initiated','completed','failed','cancelled') NOT NULL DEFAULT 'initiated',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
  )");
}

// 1. The merchant (our site) tells the gateway: "take this amount for this invoice"
//    The gateway returns a payment_id.
function gateway_create($conn, $invoice, $amount, $method) {
  gateway_setup($conn);
  $paymentId = 'PAY' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 12));
  $invoice = $conn->real_escape_string($invoice);
  $method  = $conn->real_escape_string($method);
  $amount  = (float)$amount;
  $conn->query("INSERT INTO demo_gateway (payment_id, invoice_no, method, amount)
                VALUES ('$paymentId', '$invoice', '$method', $amount)");
  return $paymentId;
}

// 2. Ask the gateway whether the payment was made (server-side verification)
//    Instead of trusting what is in the URL, the gateway's own record is checked.
function gateway_query($conn, $paymentId) {
  gateway_setup($conn);
  $paymentId = $conn->real_escape_string($paymentId);
  return $conn->query("SELECT * FROM demo_gateway WHERE payment_id = '$paymentId'")->fetch_assoc();
}
