<?php
 session_start();
 $_SESSION = array();
 mysqli_close($db);
 setcookie(session_name(), '', time()-2592000, '/');
 if(session_destroy()) {
    header("Location: ../index.php");
 }
?>
