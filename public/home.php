<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8">
<link href="/Backend-week-4/public/assets/css/styles.css" rel="stylesheet" type="text/css" >  
    
    <head>
        <title> Jordyn's Movie Tracker</title>        
    </head>
    
    <body>
        <div class="wrapper">
     
   
   <header class="home-header">
            <h7><a href="home.php">Movie Tracker</a></h7>
 
    
            <ul>
        
            <li><a href="create.php" class="home-menu">Add a Movie</a></li>
            <li><a href="read.php" class="home-menu">View all</a></li>
            <li><a href="logout.php" class="home-menu">Log Out</a></li>
        
            </ul>
    </header>
            
<footer>
  <p>Created by Jordyn Kerrison</p>
  <p>University of Canberra</p>
</footer>
<!-- the closing body and html tags are red and i am unsure why. -->
</body>
</html>