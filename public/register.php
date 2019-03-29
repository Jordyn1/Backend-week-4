<?php
session_start();
require "../config.php";
    
      try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    };
   
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
                echo "Something went wrong. Please try again later.";
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
                echo "Something went wrong. Please try again later.";
            }
        }
        //close statement
        unset($stmt);
    }
    //close connection
    unset($pdo);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link href="/movietrackerassignment/public/assets/css/styles.css" rel="stylesheet" type="text/css" >
</head>
<body>

    <div class="wrapper">
        <h4>Sign Up</h4>
        
        <div class="labels1"><p>Please fill this form to create an account.</p></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="labels1">
                    <label1>Username</label1>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div> 
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <div class="labels1">  
                    <label1>Password</label1>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
            </div>
            
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <div class="labels1">
                    <label1>Confirm Password</label1>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            
            <div class="form-group">
                <div class="labels1">
                <input type="submit" class="button" value="Submit">
                <input type="reset" class="button" value="Reset">
                </div>
            </div>
            
            <div class="labels1"><p>Already have an account? <a href="login.php">Login here</a>.</p></div>
        </form>
      

    </div> 
   
</body>
</html>
    
<?php include "templates/footer.php"?>