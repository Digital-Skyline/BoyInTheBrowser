<?php

echo <<<_END
  <html>
    <head>
      <meta charset="UTF-8">
      <title>Boy in the Browser</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
      <div class="loginbtn"><a href="Login.php">Login</a></div>
      <div class="loginbtn"><a href="Register.php">Register</a></div>

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

      <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    </body>
  </html>
_END;
?>
