<?php
    $hn = 'localhost';
    $db = 'files';
    $un = 'admin';
    $pw = '123456789';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);

    if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PWD'])){

      $un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
      $pw_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);
      $query = "SELECT * FROM users WHERE username='$un_temp'";
      $result = $connection->query($query);
      if (!$result){
        die($connection->error);

      }elseif($result->num_rows){
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $salt1 = "qm&h*";
        $salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");

        if($token == $row[3]){
          echo "$row[0] $row[1] : Hi $row[0], you are now logged in as '$row[2]'";
        }else{
          die("Invalid username/password combination");
        }
      }else{
        else die("Invalid username/password combination");
      }
    }else{
      header('WWW-Authenticate: Basic realm="Restricted Section"');
      header('HTTP/1.0 401 Unauthorized');
      die ("Please enter your username and password");
    }


/**if((isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']))){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hn = 'localhost';
    $db = 'files';
    $un = 'admin';
    $pw = '123456789';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);

    if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PWD'])){

    }
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    $result->data_seek(0);
    $myusername = $result->fetch_assoc()['username'];
    $result->data_seek(0);
    $mypassword = $result->fetch_assoc()['password'];

    if($username == $myusername){
      if($password == $mypassword){
        header("Location: Main.php"); die;
      }else{
        echo "Incorrect password. Try again"."<br>";
      }
    }else{
      echo "Username doesn't exists." . "<br>";
    }
    $result->close();
    $conn->close();
}**/


echo <<<_END
  <html>
    <head>
      <meta charset="UTF-8">
      <title>Boy in the Browser</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

      <h2>Let the Boy in your Browser keep you secure!</h2>
      <p class="lead">Analyze suspicious files to find Malware.</p>

      <!-- Login  -->
      <div class="uploader">
        <label>
            <div id="start">
            <i class="fa fa-sign-in " aria-hidden="true"></i>
        		<h1>Welcome</h1>
        		<form action="Login.php" method="POST" class="login-form" enctype="multipart/form-data">
        			<input type="text" placeholder="Username" name="username">
        			<input type="password" placeholder="Password" name="password">
        		</form>
            <span id="file-upload-btn" class="btn btn-primary">Login</span>
          </div>
        </label>
      </div>

      <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    </body>
  </html>
_END;
?>
