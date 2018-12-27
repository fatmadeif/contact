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

$contact = array();
$phone = array();
$errors = array();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
case 'GET':
$first_name= '';
$last_name='';

if (isset($_GET['first_name'])) {
  $first_name = mb_strtoupper($_GET['first_name']);
}
if (isset($_GET['last_name'])) {
  $last_name = mb_strtoupper($_GET['last_name']);
}
if(strlen($first_name)<3){
  $errors[] = "First Name must be 5 or more charactes";
}


if(strlen($last_name)<3){
  $errors[] = "Last Name must be 5 or more charactes";
}
$conn = db_connect();
$sql ="SELECT * FROM contact WHERE first_name LIKE '%{$first_name}%' AND last_name LIKE '%{$last_name}%'";
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
// handle get contacts here. i,e. call a function that retrieve and return contacts
break;

case 'POST':
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
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
break;
case 'DELETE':

if (isset( $_GET['id'])) {
  $id =$_GET['id'];
}
if(strlen($id)<3 || !is_numeric($id)){
  $errors[] = "id number is not in the correct format. ex: 90";
}
$conn = db_connect();
$sql = "SELECT * FROM contact WHERE id= '{$id}'";
$con_results = mysqli_query($conn, $sql);
if(mysqli_num_rows($con_results)>0){
  $sql = "DELETE FROM contact WHERE id= '{$id}'";
  $con_results = mysqli_query($conn, $sql);
  if ($con_results){
    echo "deleted";
  }else{
    echo "error";
  }
}else{
    echo "id doesn't exist";
}
 break;
case 'PUT':
$data = file_get_contents('php://input');
$data = json_decode($data, TRUE);
$conn = db_connect();
$sql = "UPDATE contact SET first_name='".$data['firstname']."', last_name= '".$data['lastname']."' WHERE id= '".$data['id']."'";
$con_results = mysqli_query($conn, $sql);
if ($con_results){
  $sql="UPDATE phone_numbers SET phone_number='".$data['phone']."' WHERE contact_id= '".$data['id']."'";
  $con_results = mysqli_query($conn, $sql);
  if ($con_results){
    echo "success - phone";
  }else {
    echo "error - phone";
  }
} else {
  echo "error - contact";
}
// handle updating contacts here. i,e. call a function that update and return a contact

break;
}




 ?>
