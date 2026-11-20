<?php
// =========================================================
// bKash Tokenized Checkout — SANDBOX (পরীক্ষার জন্য, টাকা কাটে না)
// নিচের credential গুলো bKash-এর পাবলিক sandbox credential।
// আসল (Live) payment নিতে হলে bKash থেকে নিজের merchant credential নিয়ে
// এখানে বসাতে হবে আর BKASH_BASE_URL বদলাতে হবে।
//
// Sandbox পরীক্ষার wallet (একটা locked হলে অন্যটা দিন):
//   01929918378, 01770618576, 01877722345, 01619777282, 01619777283, 01770618575
//   সবগুলোর OTP 123456,  PIN 12121
// =========================================================
define('BKASH_BASE_URL',   'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout');
define('BKASH_APP_KEY',    '0vWQuCRGiUX7EPVjQDr0EUAYtc');
define('BKASH_APP_SECRET', 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx');
define('BKASH_USERNAME',   '01770618567');
define('BKASH_PASSWORD',   'D7DaC<*E*eG');
