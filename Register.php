<?php
$title = 'BiB : Regsiter';
require('php/header.php');

  $isTaken = "";
  $isTakenE = "";
  if(isset($_POST['username'])){
      $username=$_POST['username'];
      $hn = 'localhost';
      $db = 'files';
      $un = 'admin';
      $pw = '123456789';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) die($conn->connect_error);

      $username = mysql_real_escape_string($_POST['username']);
      $checkdata = $conn->query("SELECT username FROM users WHERE username='$username'");
      if($checkdata->num_rows > 0){
          echo "User Name Already Exist";
      }else{
          echo "OK";
      }
      exit();
  }

  if(isset($_POST['email'])){
      $email=$_POST['email'];
      $hn = 'localhost';
      $db = 'files';
      $un = 'admin';
      $pw = '123456789';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) die($conn->connect_error);

      $email = mysql_real_escape_string($_POST['email']);
      $checkdata = $conn->query("SELECT email FROM users WHERE email='$email'");

      if($checkdata->num_rows > 0){
          echo "Email Already Exist";
      }else{
          echo "OK";
      }
    exit();
  }

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
?>

<body>
  <h2>Let the Boy in your Browser keep you secure!</h2>
  <p class="lead">Analyze suspicious files to find Malware.</p>

  <!-- Register  -->
  <div class="uploader">
  <label>
    <div id="start">
        <i class="fa fa-sign-in " aria-hidden="true"></i>
    		<h2>Register</h2>
    		<form action="" method="POST" class="login-form" enctype="multipart/form-data">
    		    <input type="text" id="username" placeholder="Username" name="username" onkeyup="checkname();">
            <span style="font-size: 10px" id="name_status" value="<?php echo $isTaken; ?>"></span><br>
            <input type="email" id="email" email="email" placeholder="Email" name="email" onkeyup="checkemail();" >
            <span style="font-size: 10px" id="email_status" value="<?php echo $isTakenE; ?>"></span><br>
			      <input type="password" id="password" placeholder="Password" name="password">
            <input type="submit" id="submitButton" name="submit" class="submitbutton" value="Register">
    		</form>
    </div>
  </label>
  </div>
</body>

<?php
  require('php/footer.php');
?>
