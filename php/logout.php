<?php if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); die( header( 'location: ../index.php' ) ); }

 session_start();
 $_SESSION = array();
 setcookie(session_name(), '', time()-2592000, '/');
 if(session_destroy()) {
    header("Location: ../index.php");
 }
?>
