<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'boyinthebrowser');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   $max_pw = 32;
   $min_pw = 6;
   $max_un = 32;
   $min_un = 6;
   $max_email = 64;
?>
