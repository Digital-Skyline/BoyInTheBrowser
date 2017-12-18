<?php
  require_once('include/config.php');
  include('php/utility.php');
  $title = 'BiB : Regsiter';
  require_once('php/header.php');

  $isTaken = $isTakenE = $isTakenP = "";
  $username = $email = $password = "";
  $checkData = "";

  if(isset($_POST['username'])){
      $username = mysql_entities_fix_string($db, $_POST['username']);
      $checkdata = $db->query("SELECT username FROM users WHERE username = '$username'");
      if($checkdata->num_rows > 0){
          echo "User Name Already Exist";
      }
      else{ echo "OK"; }
  }
  if(isset($_POST['email'])){
      $email = mysql_entities_fix_string($db, $_POST['email']);
      $checkdata = $db->query("SELECT email FROM users WHERE email='$email'");
      if($checkdata->num_rows > 0){
          echo "Email Already Exist";
      }
      else{ echo "OK"; }
    }
    if (isset($_POST['password'])) {
      $password = mysql_entities_fix_string($db, $_POST['password']);
    }
    $fail = validate_Username($username);
    $fail .= validate_Email($email);
    $fail .= validate_Password($password);
    if ($fail == "") { exit; }

echo <<<_END
<body>
  <h2>Let the Boy in your Browser keep you secure!</h2>
  <p class="lead">Analyze suspicious files to find Malware.</p>

  <!-- Register  -->
  <div class="uploader">
  <label>
    <div id="start">
        <i class="fa fa-sign-in " aria-hidden="true"></i>
        <h2>Register</h2>
        <form action="php/insert.php" method="POST" class="login-form" onsubmit="return validate(this)">
            <input type="text" id="username" placeholder="Username" name="username">
              <span style="font-size: 10px" id="name_status" value="$isTaken;"></span><br>
            <input type="email" id="email" email="email" placeholder="Email" name="email">
              <span style="font-size: 10px" id="email_status" value="$isTakenE;"></span><br>
            <input type="password" id="password" placeholder="Password" name="password">
            <input type="submit" id="submit" name="submit" class="submitbutton" value="Register">
        </form>
    </div>
  </label>
  </div>
</body>
_END;
require('php/footer.php');
?>
