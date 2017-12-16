<?php
  $title = 'Boy In The Browser';
  require('php/header.php');
  require('php/session.php');
  include('php/utility.php');

  $username = $_SESSION['login_user'];
  $admin = $_SESSION['admin'];

  if(isset($_FILES['file1'])){
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

  if(isset($_FILES['file2']) and isset($_POST['malware'])){

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
              $message = $malware. " alreadt exists in the database";
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

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.<br><br>
      <?php
        if ($_SESSION['admin'] == 1){
          echo "Admin: ".$_SESSION['login_user'];
        }else{
          echo "Welcome, ".$_SESSION['login_user']."!";
        }?></p>
    <!-- Tabs for Admin -->
    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'putative')" id="defaultOpen">Inspect a Putative File</button>
      <button class="tablinks" onclick="openTab(event, 'infected')">Upload an Infected File</button>
    </div>

    <!-- First tab: to inspect a putative file-->
    <div id="putative" class="tabcontent">
      <form method="POST" enctype="multipart/form-data" class="uploader">
        <input id="file-upload1" type="file" name="file1" >
        <label for="file-upload1">
          <img id="file-image" src="#" alt="Preview" class="hidden">
          <div id="start">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <div>Select a putative file (drag here not working)</div>
          </div>
        </label>
        <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
      </form>
    </div>

    <!-- Second tab: to upload a malware in the databse-->
    <div id="infected" class="tabcontent">
      <form id="file-upload-form"  method="POST" enctype="multipart/form-data" class="uploader">
        <input id="file-upload2" type="file" name="file2" >
        <label for="file-upload2">
          <img id="file-image" src="#" alt="Preview" class="hidden">
          <div id="start">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <div>Select an infected file (drag here not working)</div>
          </div>
          <div>Name of Malware:</div><input type="text" name="malware"><br>
        </label>
        <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
      </form>
    </div>

    <!-- <script>
      function openTab(evt, task) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(task).style.display = "block";
          evt.currentTarget.className += " active";
      }
      document.getElementById("defaultOpen").click();
    </script> -->
  </body>

<?php
  require('php/footer.php');
?>
