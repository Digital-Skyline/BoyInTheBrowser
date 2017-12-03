<?php
  require('include/config.php');
  include('php/utility.php');
  $title = 'BiB : Regsiter';
  require('php/header.php');

  $isTaken = $isTakenE = $isTakenP = "";
  if ($db->connect_error) die($db->connect_error);

  if(isset($_POST['username'])){
      $username = $_POST['username'];
      $username = mysql_entities_fix_string($db, $_POST['username']);
      $checkdata = $db->query("SELECT username FROM users WHERE username = '$username'");

      if($checkdata->num_rows > 0){
          echo "User Name Already Exist";
      }
      else{ echo "OK"; }
      exit();
  }

  if(isset($_POST['email'])){
      $email=$_POST['email'];
      $email = mysql_entities_fix_string($db, $_POST['email']);
      $checkdata = $db->query("SELECT email FROM users WHERE email='$email'");

      if($checkdata->num_rows > 0){
          echo "Email Already Exist";
      }
      else{ echo "OK"; }
      exit();
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
    		<form action="php/insert.php" method="POST" class="login-form" enctype="multipart/form-data">
    		    <input type="text" id="username" placeholder="Username" name="username" onkeyup="checkname();">
              <span style="font-size: 10px" id="name_status" value="<?php echo $isTaken; ?>"></span><br>
            <input type="email" id="email" email="email" placeholder="Email" name="email" onkeyup="checkemail();" >
              <span style="font-size: 10px" id="email_status" value="<?php echo $isTakenE; ?>"></span><br>
			      <input type="password" id="password" placeholder="Password" name="password" onkeyup="checkpass();">
            <input type="submit" id="submit" name="reg_user" class="submitbutton" value="Register">
    		</form>
    </div>
  </label>
  </div>
</body>

<?php
  require('php/footer.php');
?>
