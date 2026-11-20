<?php
// bKash Sandbox API-এর সাথে কথা বলার ছোট ছোট function
include_once(__DIR__ . '/bkash_config.php');

// bKash server-এ একটা POST request পাঠানো (cURL দিয়ে)
function bkash_request($path, $body, $headers) {
  $ch = curl_init(BKASH_BASE_URL . $path);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(array('Content-Type: application/json', 'Accept: application/json'), $headers));
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
  $response = curl_exec($ch);

  if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    return array('error' => 'Could not connect to bKash: ' . $error);
  }
  curl_close($ch);
  $data = json_decode($response, true);
  return is_array($data) ? $data : array('error' => 'Unexpected reply from bKash.');
}

// ১. Token নেওয়া (প্রতিটা কাজের আগে লাগে)
//    সফল হলে token, না হলে $error-এ কারণ লেখা থাকে
function bkash_token(&$error) {
  $res = bkash_request('/token/grant',
    array('app_key' => BKASH_APP_KEY, 'app_secret' => BKASH_APP_SECRET),
    array('username: ' . BKASH_USERNAME, 'password: ' . BKASH_PASSWORD));
  if (isset($res['id_token'])) {
    return $res['id_token'];
  }
  $error = isset($res['error']) ? $res['error'] : 'bKash token failed: ' . (isset($res['statusMessage']) ? $res['statusMessage'] : 'check credentials');
  return '';
}

function bkash_headers($token) {
  return array('Authorization: ' . $token, 'X-App-Key: ' . BKASH_APP_KEY);
}

// ২. Payment তৈরি: bKash একটা bkashURL দেয়, user-কে সেখানে পাঠাতে হয়
function bkash_create($amount, $invoice, $callbackUrl, $payer) {
  $token = bkash_token($err);
  if ($token == '') return array('error' => $err);
  return bkash_request('/create', array(
    'mode' => '0011',
    'payerReference' => $payer,
    'callbackURL' => $callbackUrl,
    'amount' => number_format($amount, 2, '.', ''),
    'currency' => 'BDT',
    'intent' => 'sale',
    'merchantInvoiceNumber' => $invoice,
  ), bkash_headers($token));
}

// ৩. User PIN দেওয়ার পর payment চূড়ান্ত করা
function bkash_execute($paymentId) {
  $token = bkash_token($err);
  if ($token == '') return array('error' => $err);
  return bkash_request('/execute', array('paymentID' => $paymentId), bkash_headers($token));
}

// ৪. Payment-এর অবস্থা জিজ্ঞেস করা (server-side verification)
function bkash_query($paymentId) {
  $token = bkash_token($err);
  if ($token == '') return array('error' => $err);
  return bkash_request('/payment/status', array('paymentID' => $paymentId), bkash_headers($token));
}
