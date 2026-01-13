<?php
    require_once("database/database.php");
    $response = [];//using JSON

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $fname= trim($_POST['fname']);
        $lname= trim($_POST['lname']);
        $email= trim($_POST['email']);
        $number= trim($_POST['number']);
        $gender=$_POST['gender'];
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $hashpw = password_hash($password, PASSWORD_DEFAULT);


        if(empty($fname) || empty($lname) || empty($email)
            || empty($number) || empty($gender) || empty($username)
            || empty($password)){

                $response = [
                    "status"=>"error",
                    "message"=>"Fill all the required inputs."
                ];
          
            }
        else{
             if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response = [
                    "status"=>"error",
                    "message"=>"Invalid email."
                ];
                exit;
                 }
                 else{
                    if(!preg_match("/^[0-9]{10}$/", $number)){
                           $response = [
                            "status"=>"error",
                            "message"=>"Inavlid phone number."
                           ]; 
                            exit; 
                     }
                     else{

                        $check=$conn->prepare("SELECT * FROM users WHERE username=?");
                        $check->bind_param("s",$username);
                        $check->execute();
                        $result = $check->get_result();

                        if($result->num_rows >0){
                            $response = [
                            "status"=>"error",
                            "message"=>"Username already exists."
                           ]; 
                        }
                        else{
                            $checkemail=$conn->prepare("SELECT * FROM users where email=?");
                            $checkemail->bind_param("s",$email);
                            $checkemail->execute();
                            $resultemail = $checkemail->get_result();

                            if($resultemail->num_rows > 0){
                                $response = [
                                "status"=>"error",
                                "message"=>"This email is already used."
                                    ]; 
                            }
                            else{

                                $stmt=$conn->prepare("INSERT INTO users (fname,lname,email,gender,number,username,password)
                                                    VALUES (?,?,?,?,?,?,?)");
                                $stmt->bind_param("sssssss",
                                    $fname,
                                    $lname,
                                    $email,
                                    $gender,
                                    $number,
                                    $username,
                                    $hashpw
                            );
                    
                            if($stmt->execute()){
                                    $response = [
                                     "status"=>"successyyy",
                                     "message"=>"You have registered successfully. Please login to the login page."
                                    ];
                            }
                            else{
                                $response = [
                            "status"=>"error",
                            "message"=>"Failed to insert data. "
                                     ]; 
                            }
                            
                            
                            }
                        }
                     }
                 }
             }
                if (isset($check)) $check->close();
                if (isset($checkemail)) $checkemail->close();
                if (isset($stmt)) $stmt->close();
                $conn->close();
   
             
    }
    
    else{
        die("Error");
               
    }

    header("Content-Type: application/json");

    echo json_encode($response);

?>
