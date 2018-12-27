<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container">
      <div class="jumbotron">
    <h1 class="display-4">welcome</h1>
    <hr class="my-4">

    <div class="login-form">
    <div class="main-div">
      <div class="panel">

      </div>
    </div></div>

    <?php
    $login_array_errors = array();
    if($_SERVER['REQUEST_METHOD']==='POST'){

      $username = '';
      $password = '';

      if (isset($_POST['username'])) {
        $username = $_POST['username'];
      }
      if (isset($_POST['password'])) {
        $password = $_POST['password'];
      }
      if (!isset($password)){
        $login_array_errors[] = "set the password";
      }
      if(strlen($username)<3){
        $login_array_errors[] = "username must be more than 5 characters";
		echo strlen($username);
      }
      if(count($login_array_errors) !== 0)
          {
            echo '<div class="alert alert-dark" role="alert">';
            foreach ($login_array_errors as $value) {
              echo $value. "</br>";
            }
              echo '</div>';
            }
      if(count($login_array_errors) == 0){
        $servername = "localhost";
        $username1 = "root";
        $password1 = "";
        $dbname = "userdb";

        $conn = new mysqli($servername, $username1, $password1,$dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $array_result = array();
        $test = array($username => $password);
        $json = json_encode($test);

        $sql = "SELECT * FROM uesrs where username ='".$username."' " ;
        $con_results = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($con_results);
        $array_result = $row;

        if (mysqli_num_rows($con_results) > 0){
          if ($row['password'] === $password){
            ?>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">Password</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">Email</th>
                </tr>
</div>
                <?php
          $array_result = $row;
          //print_r($result);

          //print_r(json_encode($result));
           echo "<tbody>";
           echo "<tr>";
           echo "<td>".$array_result['id']."</td>";
           echo "<td>".$array_result['username']."</td>";
           echo "<td>".$array_result['password']."</td>";
           echo "<td>".$array_result['full_name']."</td>";
           echo "<td>".$array_result['email']."</td>";
           echo "</tr>";
           echo "</tbody>";
           echo "</table>";
         }else if ($row ['username'] === $username && $row ['password'] !== $password ){
           $error_message = array("error_code"=> "102","error_message" => "User are not correct");
           //header('Content-Type: application/json');
           //header("HTTP/1.0 404 Not Found");
           //print_r(json_encode($error_message));
           echo '<div class="alert alert-dark" role="alert">
           error_code"=> "102","error_message" => "User  are not correct!'."</div>";
             $login_array_errors[] = json_encode($error_message);
         }
       }else {
         $error_message = array("error_code" =>"101" ,"error_message"=> "User not found");
         //print_r(json_encode($error_message));
         //header('Content-Type: application/json');
         //header("HTTP/1.0 404 Not Found");
         echo '<div class="alert alert-dark" role="alert">
         error_code" =>"101" ,"error_message"=> "User not found!'."</div>";
         $login_array_errors[] = json_encode($error_message);
       }
     }
   }
           ?>

</body>
</html>
