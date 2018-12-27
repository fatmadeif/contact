<?php
function db_connect(){
  $servername = "localhost";
  $username 	= "root";
  $password 	= "machine1";
  $dbname 		= "contacts";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password,$dbname);
  return $conn;
}

$fname ='';
$lname ='';
$phone ='';

if (isset( $_POST['fname'])) {
  $fname =$_POST['fname'];
}
if (isset( $_POST['lname'])) {
  $lname =$_POST['lname'];
}
if (isset( $_POST['phone'])) {
  $phone =$_POST['phone'];
}
$errors = array();

if(strlen($fname)<3){
  $errors[] = "First Name must be 5 or more charactes";
}

if(strlen($lname)<3){
  $errors[] = "Last Name must be 5 or more charactes";
}

if(strlen($phone)<11 || !is_numeric($phone)){
  $errors[] = "Phone number is not in the correct format. ex: 905415415412";
}

$conn = db_connect();
$sql = "INSERT INTO contact (first_name, last_name) VALUES ('{$fname}', '{$lname}')";
$con_results = mysqli_query($conn, $sql);
if ($con_results) {
  $contactID = mysqli_insert_id($conn);
  $sql = "INSERT INTO phone_numbers"
  ." (phone_title,phone_number, default_num ,contact_id)"
  ." VALUES ("
  ."'HOME'"
  .","
  .$_POST['phone']
  .","
  ."1"
  .","
  .$contactID
  .");";
  $con_results = mysqli_query($conn, $sql);
  if(!$con_results){
    die("SQL error " . mysqli_error($conn));
  }else {
    echo "success - phone";
  }
}else {
  echo "error - contact";
}
 ?>
