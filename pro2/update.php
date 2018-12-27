<?php
function db_connect(){
  $servername = "localhost";
  $username 	= "root";
  $password 	= "machine1";
  $dbname 		= "contacts";
  $conn = mysqli_connect($servername, $username, $password,$dbname);
  return $conn;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

   <title></title>
 </head>
 <body>

</div>
<?php

if (isset($_POST['id'])){
  $id = $_POST['id'];
}
if (isset($_POST['fname'])){
  $fname = $_POST['fname'];
}
if (isset($_POST['lname'])){
  $lname = $_POST['lname'];
}
if (isset($_POST['phone'])){
  $phone = $_POST['phone'];
}

 $conn = db_connect();
  $sql = "UPDATE contact SET first_name='".$fname."', last_name= '".$lname."' WHERE id= '".$id."'";
  $con_results = mysqli_query($conn, $sql);
  if ($con_results) {
    $sql = "UPDATE phone_numbers SET phone_number='".$phone."' WHERE contact_id= '".$id."'";
    $con_results = mysqli_query($conn, $sql);
    if ($con_results) {
      echo "success - phone";
    }else {
      echo "error - phone";
    }
  }else {
    echo "error - contact";
  }

    ?>
 </body>
</html>
