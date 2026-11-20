<?php
// =========================================================
// DEMO PAYMENT GATEWAY (নকল bKash / Nagad / Card)
// আসল gateway-এর নিজের server আর database থাকে।
// এখানে সেটার বদলে demo_gateway টেবিল ব্যবহার করছি।
// এখানে কোনো টাকা কাটে না।
// =========================================================

// টেবিল না থাকলে বানিয়ে নেওয়া
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

// ১. Merchant (আমাদের site) gateway-কে বলে: "এই invoice-এর জন্য এত টাকা নাও"
//    Gateway একটা payment_id ফেরত দেয়।
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

// ২. Payment হয়েছে কিনা gateway-কে জিজ্ঞেস করা (Server-side verification)
//    URL-এ কী লেখা আছে তা বিশ্বাস না করে, gateway-এর নিজের রেকর্ড দেখা হয়।
function gateway_query($conn, $paymentId) {
  gateway_setup($conn);
  $paymentId = $conn->real_escape_string($paymentId);
  return $conn->query("SELECT * FROM demo_gateway WHERE payment_id = '$paymentId'")->fetch_assoc();
}
