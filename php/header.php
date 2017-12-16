<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<div class="loginbtn">

<div class="right">
<?php
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

?>
</div>

<div class="left">
  <a href="index.php">Home</a>
</div>

</div>
