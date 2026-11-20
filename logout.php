<?php
// Session মুছে দিয়ে login পেজে ফেরত
session_start();
session_destroy();
header("Location: login.php");
exit;
