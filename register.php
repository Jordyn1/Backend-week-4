<?php
require "../config.php";


//define variables
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//If form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
//validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        //prepare select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
         //bind variables as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
         
         //set parameters
            $param_username = trim($_POST["username"]);
            
         //execute prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later."
            }
        }
        //close statement
        unset($stmt);
    }
//validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
//validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    //check errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        //insert statement
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        
        if ($stmt = $pdo->prepare($sql)){
            //bind variables
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            //set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //creates a password hash
            
            //execute prepared statement
            if($stmt->execute()){
                //redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later."
            }
        }
        //close statement
        unset($stmt);
    }
    //close connection
    unset($pdo);
}
?>
<?php include "templates/footer.php"?>






