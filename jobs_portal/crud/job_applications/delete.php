<?php

include_once("../../config/dbconfig.php");

$id = $_GET['id'];

try {
    $conn->query("DELETE FROM job_applications WHERE id = '$id'");
} catch (Exception $e) {
    echo "<script>alert('This record cannot be deleted because it is used in another table.'); window.location='index.php';</script>";
    exit;
}

if($conn->affected_rows){
    header("Location: index.php");
}

?>
