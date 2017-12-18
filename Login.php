<?php
  require_once('include/config.php');
  include('php/utility.php');
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST") {
     $un_temp = mysql_entities_fix_string($db, $_POST['username']);
     $pw_temp = mysql_entities_fix_string($db, $_POST['password']);
     $query = "SELECT * FROM users WHERE username='$un_temp'";
     $result = $db->query($query);

     if($result->num_rows == 1) {
         $row = $result->fetch_array(MYSQLI_NUM);
         $salt1 = "qm&h*";
         $salt2 = "pg!@";
         $token = hash('ripemd128', "$salt1$pw_temp$salt2");
         if($token != $row[1]){
           die("Invalid username/password combination");
         }

        $result->close();
        $_SESSION['login_user'] = $un_temp;
        $_SESSION['active'] = true;
        $_SESSION['admin'] = $row[3];

        header("location: index.php");

     }else {
        echo "Username or Password is invalid";
     }
  }

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
          <form action="login.php" method="POST" class="login-form" enctype="multipart/form-data">
            <input type="text" placeholder="Username" name="username">
            <input type="password" placeholder="Password" name="password">
            <input type = "submit" value = " Submit " class="btn btn-primary"/>
          </form>
          <a href="register.php"><span class="btn btn-primary">Register</span></a>
        </div>
      </label>
    </div>
  </body>

<?php require('php/footer.php'); ?>
