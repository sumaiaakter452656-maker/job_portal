<?php

include_once("../../config/dbconfig.php");

$id = $_GET['id'];

$conn->query("DELETE FROM jobs WHERE id = '$id'");

if($conn->affected_rows){
    header("Location: index.php");
}

?>