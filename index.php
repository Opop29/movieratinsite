<?php 

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}

require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
?>