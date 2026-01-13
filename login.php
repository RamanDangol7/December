<?php
require_once("database/database.php");
session_start();
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        //Checking the username
        $check = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $check->bind_param("s",$username);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows == 1){
            $rows = $result->fetch_assoc();
            $hashpw = $rows["password"];

            if(password_verify($password,$hashpw)){
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $rows["id"];
                
                $response=[
                    "status"=>"success",
                    "message"=>"success"
                ];

                $check->close();
                $conn->close();
            }
            else{
                $response=[
                    "status"=>"error",
                    "message"=>"Invalid password"
                ];
            }  

        }else{
            $response=[
                "status"=>"error",
                "message"=>"Invalid username"
            ];
        }

    }
    else{
        $response=[
            "status"=>"error",
            "message"=>"Enter the valid username or password."
        ];
    }

}
else{
    $response=[
        "status"=>"error",
        "message"=>"Error"
    ];
    
}

echo json_encode($response);

?>