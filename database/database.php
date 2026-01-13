<?php
$servername="localhost";
$username="root";
$password= "";
$database = "december";

$conn = new mysqli($servername,$username,$password,$database);

if($conn->connect_error){
    die("Failed to connect the database".$conn->connect_error);
}

?>