<?php
// CS 174 San Jose State University
// Project Created By: Thomas Wilson, Paul Diaz, and Sandy Yi
// December 17, 2017

  $title = 'Boy In The Browser';
  require('php/session.php');
  require_once('php/header.php');
  include('php/utility.php');

  if(isset($_SESSION['login_user'])) {
    $username = $_SESSION['login_user'];
    $admin = $_SESSION['admin'];
  }

  if(isset($_FILES['file1'])){
    inspectMalware($db);
  }

  if(isset($_FILES['file2']) and isset($_POST['malware']) and
      isset($_SESSION['admin']) and $_SESSION['admin'] == 1) {
        uploadInfected($db);
  }

  if(isset($_FILES['file3']) and isset($_POST['putative_malware']) and
      isset($_SESSION['login_user'])) {
        uploadPutative($db);
  }
?>

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.</p>
    <div class="welcomeUser">
      <?php
        if(isset($_SESSION['login_user'])) {
            if ($_SESSION['admin'] == 1){
              echo "Welcome, <strong>".$_SESSION['login_user']."</stong>";
            }else{
              echo "Welcome, ".$_SESSION['login_user'];
            }
          }
        ?>
      </div>

    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'putative')" id="defaultOpen">Inspect a Putative File</button>
        <?php
          if (isset($_SESSION['active']) && $_SESSION['active'] == true && $_SESSION['admin'] == 1) {
echo <<<_END
<button class="tablinks" onclick="openTab(event, 'infected')">Upload an Infected File</button>
_END;
          }
          if (isset($_SESSION['active']) && $_SESSION['active'] == true && $_SESSION['admin'] == 0) {
echo <<<_END
<button class="tablinks" onclick="openTab(event, 'putative_infected')">Upload an Infected File</button>
_END;
          }
        ?>
    </div>

    <!-- First tab: to inspect a putative file-->
    <div id="putative" class="tabcontent">
      <form method="POST" enctype="multipart/form-data" class="uploader">
        <label for="file-upload1">
          <img id="file-image" src="#" alt="Preview" class="hidden">
          <div id="start">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <div>Select a putative malware file</div>
            <input id="file-upload1" type="file" name="file1">
          </div>
          <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
        </label>
      </form>
    </div>

    <!-- Second tab: to upload a malware in the database-->
    <div id="infected" class="tabcontent">
      <form id="file-upload-form"  method="POST" enctype="multipart/form-data" class="uploader">
        <input id="file-upload2" type="file" name="file2" >
        <label for="file-upload2">
          <img id="file-image" src="#" alt="Preview" class="hidden">
          <div id="start">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <div>Select a surely infected malware file</div>
          </div>
          <div>Name of Malware:</div><input type="text" name="malware" class="malwareName"><br>
          <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
        </label>
      </form>
    </div>

    <!-- Third tab: to upload a putative malware in the database-->
    <div id="putative_infected" class="tabcontent">
      <form id="file-upload-form"  method="POST" enctype="multipart/form-data" class="uploader">
        <input id="file-upload3" type="file" name="file3" >
        <label for="file-upload3">
          <img id="file-image" src="#" alt="Preview" class="hidden">
          <div id="start">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <div>Select a putatively infected malware file</div>
          </div>
          <div>Name of Malware:</div><input type="text" name="putative_malware" class="malwareName"><br>
          <button id="file-upload-btn" type="submit" class="btn btn-primary">Submit</span>
        </label>
      </form>
    </div>

  </body>

<?php require('php/footer.php'); ?>
