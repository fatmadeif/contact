<?php
include_once('buttons.php');
$array_errors = array();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $username ='';
  $password = '';
  if(isset($_POST['username'])){
    $username = $_POST['username'];
  }
  if(isset($_POST['password'])){
    $password = $_POST['password'];
  }
  if(strlen($username)<3){
    $array_errors[] ="username must be than 5 characters";
  }
  if(!isset($password)){
    $array_errors[] = "set the Password";
  }
  if(count($array_errors)!==0){
    foreach ($array_errors as $value) {
      echo $value;
    }
  }
  if(count($array_errors)==0){
    $servername = "localhost";
    $username1 = "root";
    $password1 = "machine1";
    $dbname = "contacts";
    $conn = new mysqli($servername, $username1, $password1, $dbname);
    if ($conn->connect_error){
      die ("connection failed: ". $conn->connect_error);
    }
    $array_result =array();
    $sql = "SELECT* FROM login where username='".$username."' ";
    $con_results = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($con_results);
    $array_result = $row;
  }
}










 ?>
