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
<link href="/movietrackerassignment/public/assets/css/styles.css" rel="stylesheet" type="text/css" >  
    
    <head>
        <title> Jordyn's Movie Tracker</title>        
    </head>
    
    <body>
        <div class="wrapper">
     
   