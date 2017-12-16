<?php if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); die( header( 'location: ../index.php' ) ); }

////// String fix functions \\\\\\
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


////// Upload Functions \\\\\\
function inspectMalware($db) {
  $file = $_FILES['file1'];

  //File properties
  $file_name = $file['name'];
  $file_tmp = $file['tmp_name'];
  $file_size = $file['size'];
  $file_error = $file['error'];

  //Work out the file extension
  $file_ext = explode('.', $file_name);
  $file_ext = strtolower(end($file_ext));

  //Assure that only txt files are allowed
  //Instruction did not specify if the program can only take text file
  //So, in this program, we assume that it can only take text files.
  $allowed = array('txt');
  if(in_array($file_ext, $allowed)){
    if($file_error === 0) {
      //1 byte can store a character; must check the first 20 bytes
      if($file_size >= 20){
        $file_name_new = uniqid('', true) . '.' . $file_ext;

        $filecontents = file_get_contents($_FILES['file1']['tmp_name']);
        $words = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);

        $bytes20file = "";
        if(strlen($filecontents) >= 20){
          $bytes20file = substr($filecontents, 0, 20);
        }else{
          $bytes20file = $filecontents;
        }

        $query = "SELECT * FROM malware";
        $result = $db->query($query);

        if($result->num_rows > 0) {
          $row = $result->fetch_all(MYSQLI_NUM);
          $isMalware = false;

          foreach($row as $malware){
            $bytes20Malware = substr($malware[1], 0, 20);
            if($bytes20file == $bytes20Malware){
              $isMalware = true;
              break;
            }else{
              $isMalware = false;
            }
          }

          if($isMalware){
            $message = "Malware: YES". "\\n"."Name    : " .$malware[0];
            echo "<script type=\"text/javascript\">".
                    "alert('$message');".
                 "</script>";
            //echo "Malware: YES — name: " .$malware[0] ;
          }else{
            //Save putative infected file in the database
            $malware = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

            //Check if putative file already exists
            $query = "SELECT * FROM putative_malware WHERE name='$malware' AND signature='$bytes20file'";
            $result = $db->query($query);

            //If it doesn't exists, then we store it in the database
            if(!$result->num_rows > 0){
              $query = "INSERT INTO putative_malware VALUES('$malware', '$bytes20file')";
              $result = $db->query($query);
            }

            echo "<script type=\"text/javascript\">".
                    "alert('File entered is NOT infected');".
                 "</script>";
          }
        }
      }
    }
  }

}

function uploadPutative($db) {
  $file = $_FILES['file3'];
  $malware = $_POST['putative_malware'];

  //File properties
  $file_name = $file['name'];
  $file_tmp = $file['tmp_name'];
  $file_size = $file['size'];
  $file_error = $file['error'];

  //Work out the file extension
  $file_ext = explode('.', $file_name);
  $file_ext = strtolower(end($file_ext));

  //Assure that only txt files are allowed

  $allowed = array('txt');
  if(in_array($file_ext, $allowed)){
    if($file_error === 0) {
      //1 byte can store a character; must check the first 20 bytes
      if($file_size >= 20){
        $file_name_new = uniqid('', true) . '.' . $file_ext;
        //echo "Enter file size";
        $filecontents = file_get_contents($_FILES['file3']['tmp_name']);
        $words = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);

        $bytes20file = "";
        if(strlen($filecontents) >= 20){
          $bytes20file = substr($filecontents, 0, 20);
        }else{
          $bytes20file = $filecontents;
        }

        //Sanitize malware variable
        $malware = mysql_entities_fix_string($db, trim($malware));
        //Sanitize contents of the file
        $bytes20file = mysql_entities_fix_string($db, trim($bytes20file));

        //Must check if contents are string a-Z and digits 0-9 as per project's instruction
        if(preg_match('/[^A-Za-z0-9]/', $bytes20file)){
          //Do we have to check if malware already exists in the database?
          $queryCheckIfMalwareExists = "SELECT * FROM putative_malware WHERE name='$malware'";
          $resultMalwareCheck = $db->query($queryCheckIfMalwareExists);

          if($resultMalwareCheck->num_rows > 0){//This mean that malware already exists
            $message = $malware. " alreadt exists in the database";
              echo "<script type=\"text/javascript\">".
                  "alert('$message');".
                  "</script>";
          }else{

            $query = "INSERT INTO putative_malware VALUES('$malware', '$bytes20file')";
            $result = $db->query($query);
            if($result){
              $message = $malware. " is uploaded in the database";
              echo "<script type=\"text/javascript\">".
                  "alert('$message');".
                  "</script>";
            }
          }

        }else{
          $message = "Contents in the file must be string or digits only";
          echo "<script type=\"text/javascript\">".
                "alert('$message');".
                "</script>";
        }
      }
    }
  }
}

function uploadInfected($db) {
  $file = $_FILES['file2'];
  $malware = $_POST['malware'];

  //File properties
  $file_name = $file['name'];
  $file_tmp = $file['tmp_name'];
  $file_size = $file['size'];
  $file_error = $file['error'];

  //Work out the file extension
  $file_ext = explode('.', $file_name);
  $file_ext = strtolower(end($file_ext));

  //Assure that only txt files are allowed

  $allowed = array('txt');
  if(in_array($file_ext, $allowed)){
    if($file_error === 0) {
      //1 byte can store a character; must check the first 20 bytes
      if($file_size >= 20){
        $file_name_new = uniqid('', true) . '.' . $file_ext;
        //echo "Enter file size";
        $filecontents = file_get_contents($_FILES['file2']['tmp_name']);
        $words = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);

        $bytes20file = "";
        if(strlen($filecontents) >= 20){
          $bytes20file = substr($filecontents, 0, 20);
        }else{
          $bytes20file = $filecontents;
        }

        //Sanitize malware variable
        $malware = mysql_entities_fix_string($db, trim($malware));
        //Sanitize contents of the file
        $bytes20file = mysql_entities_fix_string($db, trim($bytes20file));

        //Must check if contents are string a-Z and digits 0-9 as per project's instruction
        if(preg_match('/[^A-Za-z0-9]/', $bytes20file)){
          //Do we have to check if malware already exists in the database?
          $queryCheckIfMalwareExists = "SELECT * FROM malware WHERE name='$malware'";
          $resultMalwareCheck = $db->query($queryCheckIfMalwareExists);

          if($resultMalwareCheck->num_rows > 0){//This mean that malware already exists
            $message = $malware. " already exists in the database";
              echo "<script type=\"text/javascript\">".
                  "alert('$message');".
                  "</script>";
          }else{

            $query = "INSERT INTO malware VALUES('$malware', '$bytes20file')";
            $result = $db->query($query);
            if($result){
              $message = $malware. " is uploaded in the database";
              echo "<script type=\"text/javascript\">".
                  "alert('$message');".
                  "</script>";
            }
          }

        }else{
          $message = "Contents in the file must be string or digits only";
          echo "<script type=\"text/javascript\">".
                "alert('$message');".
                "</script>";
        }
      }
    }
  }
}
?>
