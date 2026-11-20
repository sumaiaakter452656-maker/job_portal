<?php
// Small functions for talking to the bKash Sandbox API
include_once(__DIR__ . '/bkash_config.php');

// Send a POST request to the bKash server (with cURL)
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

// 1. Get a token (needed before every call)
//    Returns the token on success, otherwise $error holds the reason
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

// 2. Create the payment: bKash returns a bkashURL, the user must be sent there
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

// 3. Finalise the payment after the user enters the PIN
function bkash_execute($paymentId) {
  $token = bkash_token($err);
  if ($token == '') return array('error' => $err);
  return bkash_request('/execute', array('paymentID' => $paymentId), bkash_headers($token));
}

// 4. Ask for the payment status (server-side verification)
function bkash_query($paymentId) {
  $token = bkash_token($err);
  if ($token == '') return array('error' => $err);
  return bkash_request('/payment/status', array('paymentID' => $paymentId), bkash_headers($token));
}
