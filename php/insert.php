<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); die( header( 'location: ../index.php' ) ); }

require_once('../include/config.php');

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
echo "Echo " . $username ." ".$password."".$email. "<br>";
$salt1 = "qm&h*";
$salt2 = "pg!@";
$token = hash('ripemd128', "$salt1$password$salt2");
$sql = "INSERT INTO users (username, password, email, privilege) VALUES ('$username', '$token', '$email', '0')";

if ($db->query($sql) === TRUE) {
  echo "User account has been registered!"."<br>";
  header("location: ../index.php"); die;
}else{
  echo "INSERT failed: $sql<br>" . $db->error . "<br><br>";
}
?>
