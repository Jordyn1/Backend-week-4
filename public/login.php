<?php
//initialise the session
session_start();
//check if user is already logged in. yes = redirect to welcome page.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
//include config
require "../config.php";
      try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    };
//define variables
$username = $password = "";
$username_err = $password_err = "";
//processing data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    //check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //validate
    if(empty($username_err) && empty($password_err)){
        //select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            //bind variables
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            //set parameters
            $param_username = trim($_POST["username"]);
            
            //execute
            if($stmt->execute()){
                //check if username exists
                //if yes, verify password
                
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            
                            //password is correct - start a new session//
                            
                            session_start();
                            //store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            
                            //redirect to welcome page
                            header("location: home.php");
                        } else{
                            //display error message if password is invalid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    //error if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/movietrackerassignment/public/assets/css/styles.css" rel="stylesheet" type="text/css">
    
    
</head>
    
<body>
    
    <div class="wrapper">
        <h4>Login</h4>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="labels">
                    <label1>Username</label1>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?> ">
                <div class="labels">
                    <label1>Password</label1>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>    
            </div>
            <div class="form-group">
                <div class="labels">
                <input type="submit" class="button" value="Login">
                </div>
            </div>
            <div class="labels"><p>Don't have an account? <a href="register.php">Register now</a>.</p></div>
        </form>
        </div>
    
</body>
</html>

<?php include "templates/footer.php"?>