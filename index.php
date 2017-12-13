<?php
  $title = 'Boy In The Browser';
  require('php/header.php');
  require('php/session.php');
  include('php/utility.php'); 

  $username = $_SESSION['login_user'];
  $admin = $_SESSION['admin'];

  if(isset($_FILES['file']) and isset($_POST['malware'])){
    $file = $_FILES['file'];
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

          $filecontents = file_get_contents($_FILES['file']['tmp_name']);
          $words = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);

          $bytes100file = "";
          if(strlen($filecontents) >= 20){
            $bytes100file = substr($filecontents, 0, 100);
          }else{
            $bytes100file = $filecontents;
          }

          //Sanitize malware variable
          $malware = mysql_entities_fix_string($db, trim($malware));
          //Sanitize contents of the file
          $bytes100file = mysql_entities_fix_string($db, trim($bytes100file));

          //Must check if contents are string a-Z and digits
          if(preg_match('/[^A-Za-z0-9]/', $bytes100file)){

            $query = "INSERT INTO files VALUES('$malware', '$bytes100file')";
            $result = $db->query($query);

            //Do we have to check if malware already exists in the database?
            if($result){
              echo $malware. " is uploaded in the database";
            }
          }else{
            echo "Contents in the file must be string or digits only";
          }
        }
      }
    }
  }
?>

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.</p>
    <!-- Upload  -->
    <form id="file-upload-form" method="POST" enctype="multipart/form-data" class="uploader">
      <input id="file-upload" type="file" name="file" >
      <label for="file-upload">
        <img id="file-image" src="#" alt="Preview" class="hidden">
        <div id="start">
          <i class="fa fa-cloud-upload" aria-hidden="true"></i>
          <div>Select a file (drag here not working)</div>
        </div>
        <div>Name of Malware:</div><input type="text" name="malware"><br>
      </label>
      <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
    </form>
  </body>

<?php
  require('php/footer.php');
?>
