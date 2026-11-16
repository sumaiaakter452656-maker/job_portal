<?php
//connection with mysql
$host ="localhost";
$user="root";
$pass = "";
$db ="jobs_portal";
$conn = new mysqli("localhost", "root", "", "jobs_portal");
if(!$conn){
  die("database connection failed : " . mysqli_connect_error());
    
}

?>