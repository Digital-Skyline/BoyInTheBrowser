<?php
require_once "Register.php";

if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['email']) && !empty($_POST['email'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    echo "Echo " . $username ." ".$password."".$email. "<br>";
    $hn = 'localhost';
    $db = 'files';
    $un = 'admin';
    $pw = '123456789';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);

    $salt1 = "qm&h*";
    $salt2 = "pg!@";

    $token = hash('ripemd128', "$salt1$password$salt2");

    $query = "INSERT INTO users(username,password,email) VALUES".
         "('$username', '$token', '$email')";

    $result = $conn->query($query);
    if (!$result){
      echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
    }else{
      echo "INSERT Success!"."<br>";
      header("Location: Main.php"); die;
    }
}
echo <<<_END
  <html>
    <head>
      <meta charset="UTF-8">
      <title>Boy in the Browser</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
      <div class="loginbtn"><a href="Login.php">Login</a></div>
      <div class="loginbtn"><a href="index.php">Home</a></div>

      <h2>Let the Boy in your Browser keep you secure!</h2>
      <p class="lead">Analyze suspicious files to find Malware.</p>

      <!-- Login  -->
      <div class="uploader">
        <label>
            <div id="start">
            <i class="fa fa-sign-in " aria-hidden="true"></i>
        		<h1>Register</h1>
        		<form action="" method="POST" class="login-form" enctype="multipart/form-data">
        			<input type="text" id="username" placeholder="Username" name="username">
        			<input type="password" id="password" placeholder="Password" name="password">
              <input type="email" email="email" placeholder="Email" name="email">
              <input type="submit" id="submitButton" name="submit" class="submitbutton" value="Register">
        		</form>

          </div>
        </label>
      </div>

      <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    </body>
  </html>
_END;
?>
