<?php if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); die( header( 'location: ../index.php' ) ); }

echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
_END;
    if(isset($title)){ echo $title; }
echo <<<_END
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<div class="loginbtn">

  <div class="right">
_END;

if (isset($_SESSION['active']) && $_SESSION['active'] == true) {
echo <<<_END
  <a href="php/logout.php">Logout</a>
_END;
}
else {
echo <<<_END
  <a href="login.php">Login</a>
_END;
}
echo <<<_END
  </div>
  <div class="left">
    <a href="index.php">Home</a>
  </div>
</div>
_END;
?>
