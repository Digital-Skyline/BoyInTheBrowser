<?php
  require('session.php');
  $title = 'Boy In The Browser';
  require('layout/header.php');
?>

  <body>
    <h2>Let the Boy in your Browser keep you secure!</h2>
    <p class="lead">Analyze suspicious files to find Malware.</p>

    <!-- Upload  -->
    <form id="file-upload-form" class="uploader">
      <input id="file-upload" type="file" name="fileUpload" accept="image/*" />
      <label for="file-upload">
        <img id="file-image" src="#" alt="Preview" class="hidden">
        <div id="start">
          <i class="fa fa-cloud-upload" aria-hidden="true"></i>
          <div>Select a file or drag here (drag here not working)</div>
          <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
        </div>
      </label>
    </form>
  </body>

<?php
  require('layout/footer.php');
?>
