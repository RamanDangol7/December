<?php 
    require_once("../database/database.php");
    session_start();

    if(!isset($_SESSION["id"])){
        header("Location:../login.html");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard">

    <h1>Welcome</h1>
    <button type="button" onclick="window.location.href='logout.php'">Log out</button>
    </div>

    <script>
        
    </script>
</body>
</html>