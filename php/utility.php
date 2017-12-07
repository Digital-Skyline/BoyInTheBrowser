<?php

function mysql_entities_fix_string($conn, $string){
  return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string){
  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
}

function validate_Username($field) {
  if ($field == "") { return "No username was entered.<br>"; }
  else if (strlen($field) < 6) {
      return "Username must be at least 6 characters.<br>"; }
  else if (preg_match("/[^a-zA-Z0-9_-]/", $field)) {
      return "Only letters, numbers, -, and _ are allowed in usernames.<br>"; }
  return "";
}

function validate_Email($field) {
  if ($field == "") { return "No email was entered.<br>"; }
  else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field)) {
      return "The email address is invalid.<br>"; }
  return "";
}

function validate_Password($field) {
  if ($field == "") { return "No password was entered.<br>"; }
  else if (strlen($field) < 6) {
    return "Password must be at least 6 characters.<br>"; }
  else if (!preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field)) {
    return "Password requires one of each of A-Z, a-z, and 0-9.<br>"; }
  return "";
}

function fix_string($string) {
  if (get_magic_quotes_gpc()) {
      $string = stripslashes($string);
  }
  return htmlentities($string);
}
?>
