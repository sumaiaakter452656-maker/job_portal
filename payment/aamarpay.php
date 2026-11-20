<?php
// aamarPay Sandbox API-এর সাথে কথা বলার function (Card, Nagad, Rocket ইত্যাদি)
include_once(__DIR__ . '/aamarpay_config.php');

// ১. Payment তৈরি: aamarPay একটা payment_url দেয়, user-কে সেখানে পাঠাতে হয়
function aamarpay_create($tranId, $amount, $desc, $name, $email, $phone, $returnUrl) {
  $body = array(
    'store_id'      => AAMARPAY_STORE_ID,
    'signature_key' => AAMARPAY_SIGNATURE,
    'tran_id'       => $tranId,
    'amount'        => number_format($amount, 2, '.', ''),
    'currency'      => 'BDT',
    'desc'          => $desc,
    'cus_name'      => $name,
    'cus_email'     => $email,
    'cus_phone'     => $phone,
    'success_url'   => $returnUrl . '&result=success',
    'fail_url'      => $returnUrl . '&result=fail',
    'cancel_url'    => $returnUrl . '&result=cancel',
    'type'          => 'json',
  );
  $ch = curl_init(AAMARPAY_PAY_URL);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
  $response = curl_exec($ch);
  if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    return array('error' => 'Could not connect to aamarPay: ' . $error);
  }
  curl_close($ch);
  $data = json_decode($response, true);
  if (is_array($data) && isset($data['payment_url'])) {
    return $data;
  }
  // ব্যর্থ হলে aamarPay যা বলেছে সেটাই দেখাই
  return array('error' => 'aamarPay: ' . (is_array($data) ? json_encode($data) : strip_tags($response)));
}

// ২. Payment-এর অবস্থা aamarPay-কে জিজ্ঞেস করা (server-side verification)
function aamarpay_search($tranId) {
  $url = AAMARPAY_SEARCH_URL . '?request_id=' . urlencode($tranId)
       . '&store_id=' . urlencode(AAMARPAY_STORE_ID)
       . '&signature_key=' . urlencode(AAMARPAY_SIGNATURE) . '&type=json';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  $response = curl_exec($ch);
  if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    return array('error' => 'Could not connect to aamarPay: ' . $error);
  }
  curl_close($ch);
  $data = json_decode($response, true);
  if (!is_array($data)) {
    return array('error' => 'Unexpected reply from aamarPay.');
  }
  return isset($data[0]) ? $data[0] : $data;   // কখনো list আকারে আসে
}
