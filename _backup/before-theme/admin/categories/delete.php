<?php
include('../../dbconfig.php');

// Database Connection

$id = $_GET['id'];

$conn->query("DELETE FROM categories WHERE id = '$id'");

if($conn->affected_rows){
    header("Location: index.php");
}

?>