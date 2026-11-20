<?php
// =========================================================
// aamarPay — SANDBOX (for testing, no money is charged)
// The credentials below are the public sandbox credentials from aamarPay's documentation.
// To take real payments, get your own store_id and signature_key from aamarPay,
// put them here and replace both URLs with the live URLs.
// =========================================================
define('AAMARPAY_PAY_URL',    'https://sandbox.aamarpay.com/jsonpost.php');
define('AAMARPAY_SEARCH_URL', 'https://sandbox.aamarpay.com/api/v1/trxcheck/request.php');
define('AAMARPAY_STORE_ID',   'aamarpaytest');
define('AAMARPAY_SIGNATURE',  'dbb74894e82415a2f7ff0ec3a97e4183');
