<?php if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); die( header( 'location: ../index.php' ) ); }

 include('include/config.php');
 session_start();

 if(!isset($_SESSION['login_user'])){
   $_SESSION['active'] = false;
 }
 else {
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db, "SELECT username FROM users WHERE username = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
   $login_session = $row['username'];
 }

?>
