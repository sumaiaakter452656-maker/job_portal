<?php
// Clear the session and go back to the login page
session_start();
session_destroy();
header("Location: login.php");
exit;
