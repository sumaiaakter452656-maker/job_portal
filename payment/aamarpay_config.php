<?php
// =========================================================
// aamarPay — SANDBOX (পরীক্ষার জন্য, টাকা কাটে না)
// নিচের credential গুলো aamarPay-এর ডকুমেন্টেশনে দেওয়া পাবলিক sandbox credential।
// আসল payment নিতে হলে aamarPay থেকে নিজের store_id আর signature_key নিয়ে
// এখানে বসাতে হবে আর URL দুটো live URL দিয়ে বদলাতে হবে।
// =========================================================
define('AAMARPAY_PAY_URL',    'https://sandbox.aamarpay.com/jsonpost.php');
define('AAMARPAY_SEARCH_URL', 'https://sandbox.aamarpay.com/api/v1/trxcheck/request.php');
define('AAMARPAY_STORE_ID',   'aamarpaytest');
define('AAMARPAY_SIGNATURE',  'dbb74894e82415a2f7ff0ec3a97e4183');
