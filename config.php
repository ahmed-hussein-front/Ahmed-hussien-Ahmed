<?php
$host="localhost";
$Uname="root";
$password="";
$db_name="failed_training_db";
$conn=mysqli_connect($host,$Uname,$password,$db_name);
if(!$conn){
    die("the connection is fialed".mysqli_connect_errno());
}
?>