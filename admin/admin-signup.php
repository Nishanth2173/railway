<?php
session_start();

include('assets/inc/config.php');

if (isset($_POST['register'])) {
  // Capture form data
  $admin_id= $_POST['admin_id'];
  $admin_fname = $_POST['admin_fname'];
  $admin_lname = $_POST['admin_lname'];
  $admin_email = $_POST['admin_email'];
  $admin_uname = $_POST['admin_uname'];
  $admin_pass = $_POST['admin_pass'];
  $admin_dpic = $_FILES['admin_dpic'];

  $hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT); 

  $sql = "INSERT INTO users (admin_fname, admin_lname, admin_email, admin_uname, admin_pass) VALUES (?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($sql);

  $stmt->bind_param('sssss',$admin_id, $admin_fname, $admin_lname, $admin_email, $admin_uname, $hashed_password);

  if ($stmt->execute()) {
    echo "Registration Successful!";

    if (isset($_FILES['dpic']) && $_FILES['dpic']['error'] === 0) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["dpic"]["name"]);
      $uploadOk = true;

      // Check if image file is a real image
      $check = getimagesize($_FILES["dpic"]["tmp_name"]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
      } else {
        echo "File is not an image.";
        $uploadOk = false;
      }

      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = false;
      }

      // Check file size
      if ($_FILES["dpic"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = false;
      }

      // Allow certain file formats
      $allowed_extensions = array("jpg", "jpeg", "png", "gif");
      $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
      if (!in_array($file_extension, $allowed_extensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = false;
      }

      // Move the file if no errors
      if ($uploadOk) {
        if (move_uploaded_file($_FILES["dpic"]["tmp_name"], $target_file)) {
          echo "The file " . basename( $_FILES["dpic"]["name"]) . " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
    }
  } else {
    echo "Failed to register user! Error: " . $mysqli->error;
  }

  // Close the statement
  $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <title>Online Railway Reservation System</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="card card-border-color card-border-color-success">
              <div class="card-header"><img class="logo-img" src="assets/img/logo-xx.png" alt="logo" width="{conf.logoWidth}" height="27"><span class="splash-description">Admin Registration Form</span></div>
              <div class="card-body">
            
              <?php if(isset($success)) {?>
							<!--This code for injecting an alert-->
									<script>
												setTimeout(function () 
												{ 
													swal("Success!","<?php echo $success;?>!","success");
												},
													100);
									</script>
					
							<?php } ?>
							<?php if(isset($err)) {?>
							<!--This code for injecting an alert-->
									<script>
												setTimeout(function () 
												{ 
													swal("Failed!","<?php echo $err;?>!","Failed");
												},
													100);
									</script>
					
							<?php } ?>

                            <form method ="POST">
                  <div class="login-form">

                    <div class="form-group">
                      <input class="form-control" name="admin_id" type="text" placeholder="Enter Your Id" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="admin_fname" type="text" placeholder="Enter Your First Name" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="admin_lname" type="text" placeholder="Enter Your Last Name" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="admin_email" type="text" placeholder="Enter Your Email" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="admin_uname" type="text" placeholder="Enter Your Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="admin_pwd" type="password" placeholder="Password">
                    </div>
                    <div class="form-group row login-submit">
                      <div class="col-6"><a class="btn btn-outline-success btn-xl" href="pass-login.php">Login</a></div>
                      <div class="col-6"><input type = "submit" name ="pass_register" class="btn btn-outline-danger btn-xl" value ="Register"></div>
                    </div>

                  </div>
                </form>
                <!--End Login-->
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script src="assets/js/swal.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      });
      
    </script>
  </body>

</html>