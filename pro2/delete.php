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

$id = '';
$errors = array();
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
  $sql = "DELETE FROM contact WHERE id = '{$id}'";
  $con_results = mysqli_query($conn, $sql);
  if ($con_results){
    echo "deleted";
  }else{
    echo "error";
  }
}else{
  echo "id doesn't exist";
}
?>
