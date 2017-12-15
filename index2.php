<?php
  require('php/session.php');
  $title = 'Boy In The Browser';
  require('php/header.php');

  if(isset($_FILES['file'])){
    $file = $_FILES['file'];

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

          $filecontents = file_get_contents($_FILES['file']['tmp_name']);
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
?>

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.<br><br><?php echo "User: ".$_SESSION['login_user'];?></p>
    <!-- Upload  -->
    <form id="file-upload-form" method="POST" enctype="multipart/form-data" class="uploader">
      <input id="file-upload" type="file" name="file" >
      <label for="file-upload">
        <img id="file-image" src="#" alt="Preview" class="hidden">
        <div id="start">
          <i class="fa fa-cloud-upload" aria-hidden="true"></i>
          <div>Select a putative file (drag here not working)</div>
        </div>
      </label>
      <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
    </form>
  </body>

<?php
  require('php/footer.php');
?>
