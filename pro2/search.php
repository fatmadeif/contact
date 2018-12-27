<?php
function db_connect(){
  $servername = "localhost";
  $username 	= "root";
  $password 	= "";
  $dbname 		= "contacts";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password,$dbname);
  return $conn;
}
$first_name = "";
$last_name = "";
if(isset($_GET['first_name'])){
  $first_name = mb_strtoupper($_GET['first_name']);
}
if(isset($_GET['last_name'])){
  $last_name = mb_strtoupper($_GET['last_name']);
}
if(strlen($first_name) <3){
  $errors[] = "First Name must be 5 or more charactes";
}
if(strlen($last_name) <3){
  $errors[] = "last Name must be 5 or more charactes";
}
$conn = db_connect();
$sql = "SELECT*FROM contact WHERE first_name LIKE '%{$first_name}%'AND last_name LIKE '%{$last_name}%'";
$con_results = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($con_results);
$contact = $row;
if(!$con_results){
  die("SQL error - contact" . mysqli_error($conn));
}
else{
  $sql ="SELECT phone_number FROM phone_numbers WHERE contact_id =  {$contact['id']}";
  $con_results = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($con_results);
  $phone [] = $row;
  if (!$con_results) {
    die("SQL error - phone" . mysqli_error($conn));
  } else {
    echo "success";
  }
}
print_r($contact);
print_r($phone);





 ?>
