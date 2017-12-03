<?php
require('../include/config.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    echo "Echo " . $username ." ".$password."".$email. "<br>";
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$password$salt2");
    $sql = "INSERT INTO users (username, password, email, privilege) VALUES ('$username', '$token', '$email', '0')";

    if ($db->query($sql) === TRUE) {
      echo "INSERT Success!"."<br>";
      //header("Location: login.php"); die;
    }else{
      echo "INSERT failed: $sql<br>" . $db->error . "<br><br>";
    }
    header("location: ../index.php");
?>
