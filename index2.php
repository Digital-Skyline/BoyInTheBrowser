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
  
          $query = "SELECT * FROM files";
          $result = $db->query($query);
        
          if($result->num_rows > 0) {
            $row = $result->fetch_all(MYSQLI_NUM);
            $isMalware = false;

            foreach($row as $malware){
              $bytes20Malware = substr($malware[1], 0, 20);
              //echo $bytes20Malware ."<br>";
              //echo $bytes20file ."<br>";
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
      </label>
      <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
    </form>
  </body>

<?php
  require('php/footer.php');
?>
