<?php
  $target_file = "./".basename($_FILES["fileToUpload"]["name"]);
  $validFile = 1; // 1 is valid file, 0 is invalid file
  $fileType = pathinfo($target_file, PATHINFO_EXTENSION); //Get file type extension

  // Check file size to avoid massive log files
  if ($_FILES["fileToUpload"]["size"] > 100000) {
      echo "Sorry, your file is too large.";
      $validFile = 0;
  }

  // Verify file is a .txt
  if($fileType != "txt") {
      echo "Sorry, only .txt files are allowed.";
      $validFile = 0;
  }

  // Verify file is valid and try to upload file
  if ($validFile == 1 && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
      countNumbers($target_file);
  } else { echo "Sorry, your file was not uploaded."; }

  function countNumbers($file) {
    $contents = file_get_contents($file);

    // store all matching numbers in $matches
    if(preg_match_all('/ \d+ /', $contents, $matches)){
       echo "<br>Numbers Found: ";
       echo implode("\n", $matches[0]);
    }
    else{ echo "No matches found"; }
  }
?>
