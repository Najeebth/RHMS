<?php
include "conn.php";
// PHP backend logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted
    if (validateForm()) {
        // Form data is valid, accept username and password
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Perform further actions, such as database operations
        $sql = "INSERT INTO `tenant_login` (`name`, `u_name`, `pword`) VALUES ('$name', '$username', '$password')";

        $result=mysqli_query($con,$sql);

        // Display a success message
        echo "<script type='text/javascript'>alert('Welcome $name');</script>";
                                echo '<style>body{display:none;}</style>';
                                echo '<script>window.location.href = "home.php";</script>';
            } else {
        // Validation failed, display an error message
        echo "Form validation failed.";
    }
}

// Function to validate the form data
function validateForm() {
  include "conn.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    // Perform validation checks
     $sql4 = "SELECT * FROM tenant WHERE u_name = '$username'";
                        $query = mysqli_query($con, $sql4);
                        if(mysqli_num_rows($query) > 0){
                          echo "<script> alert('Username exists!!');</script>"; }

    // Return true if validation passes, false otherwise
    // You can customize the validation logic based on your requirements
    return (strlen($username) >= 4 && strlen($password) >= 8 && $password === $repeatPassword);
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Rental House Management System</title>
  <link rel="icon" href="rent.ico">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script>
    function validateForm() {
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;
      var repeatPassword = document.getElementById('repeatPassword').value;
      var errorMessages = document.getElementById('errorMessages');
      // Reset error messages
      errorMessages.innerHTML = '';
      // Username validation (you can add more conditions)
      if (username.length < 4) {
        errorMessages.innerHTML += 'Username must be at least 4 characters long.<br>';
        return false; // Prevent form submission
      }
      // Password validation
      if (password.length < 8) {
        errorMessages.innerHTML += 'Password must be at least 8 characters long.<br>';
        return false;
      }
      // Check if passwords match
      if (password !== repeatPassword) {
        errorMessages.innerHTML += 'Passwords do not match.<br>';
        return false;
      }
      // If all checks pass, allow form submission
      return true;
    }
  </script>
</head>
<body style="background-image: linear-gradient(#4e73df, white);">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
                <img src="house.jpg" alt="Rental House" width="500" height="530" style="opacity:0.6;">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><b>Rental House Management System</b><br/><br/>Sign in</h1>
                  </div>
                  <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm()">
                     <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password" required>
                    </div>
                    <input class="btn btn-primary btn-user btn-block" type="submit" name="Sign_in" value="Sign in">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="index.php">Home</a>
                  </div>
                  <div id="errorMessages"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
