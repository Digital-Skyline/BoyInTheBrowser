<?php
  require('include/config.php');
  include('php/utility.php');
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST") {

     $un_temp = mysql_entities_fix_string($db, $_POST['username']);
     $pw_temp = mysql_entities_fix_string($db, $_POST['password']);
     $query = "SELECT * FROM users WHERE username='$un_temp'";
     $result = $db->query($query);
     //$active = $row['active'];

     // Do we need to kill connection here if result is false?
     if($result->num_rows == 1) {
        $result->close();
        $_SESSION['login_user'] = $un_temp;
        $_SESSION['active'] = true;

        header("location: index.php");
     }else {
        $error = "Username or Password is invalid";
        echo $error;
     }
  }

  // if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PWD'])){
  //   elseif($result->num_rows){
  //     $row = $result->fetch_array(MYSQLI_NUM);
  //     //$result->close();
  //     $salt1 = "qm&h*";
  //     $salt2 = "pg!@";
  //     $token = hash('ripemd128', "$salt1$pw_temp$salt2");
  //
  //     if($token == $row[3]){
  //       echo "$row[0] $row[1] : Hi $row[0], you are now logged in as '$row[2]'";
  //     }
  //     else{
  //       die("Invalid username/password combination");
  //     }
  //   }
  // }



$title = 'BiB : Login';
require('php/header.php');
?>

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.</p>

    <!-- Login  -->
    <div class="uploader">
      <label>
          <div id="start">
          <i class="fa fa-sign-in " aria-hidden="true"></i>
      		<h2>Welcome</h2>
      		<form action="Login.php" method="POST" class="login-form" enctype="multipart/form-data">
      			<input type="text" placeholder="Username" name="username">
      			<input type="password" placeholder="Password" name="password">
            <input type = "submit" value = " Submit " class="btn btn-primary"/>
      		</form>
          <a href="register.php"><span class="btn btn-primary">Register</span></a>
        </div>
      </label>
    </div>
  </body>

<?php
  require('php/footer.php');
?>
