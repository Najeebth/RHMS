<?php
session_start();
include "conn.php";


//otp verification via email//

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


function email_verify($otp , $email){


$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                       
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'najeebth9505@gmail.com';                    
    $mail->Password   = 'mbfp cjkg kreq aqob';                    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom('najeebth9505@gmail.com', 'RHMS');
    $mail->addAddress($email);     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'OTP Verification';
    $mail->Body = 'Please enter carefully. Your OTP is: ' . $otp;

    $mail->send();
     echo "<script type='text/javascript'>alert('A OTP has been sent to your email. Please check  to complete registration');</script>";
      echo "<script>window.location.href='otp_verification.php';</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

/*if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}*/

// Database insertion after submit button clicks//

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $uname = $_SESSION['username'];
    $sql="SELECT user_id FROM user WHERE u_name = '$uname'";
    $result=mysqli_query($con,$sql);
    $row = mysqli_fetch_row($result)[0];
    $user_id=$row;
    $accountNumber = $_POST['accountNumber'];
    $accountHolderName = $_POST['accountHolderName'];
    $bankName = $_POST['bankName'];
    $email = $_POST['email'];
    $pinOrPassword = $_POST['pinOrPassword'];
    // Generate a random 4-digit number
    $otp = rand(1000, 9999);



// Check if the account number already exists in the database
$sql_check_account = "SELECT * FROM paymentaccount WHERE accountnumber = ?";
$stmt_check_account = $con->prepare($sql_check_account);
$stmt_check_account->bind_param('s', $accountNumber);
$stmt_check_account->execute();
$stmt_check_account->store_result();

if ($stmt_check_account->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Account already exists');</script>";
    echo "<script>window.location.href='add_payaccount.php';</script>";
    $stmt_check_account->close();
    exit();
}

else{


      // Hash the PIN or password
    $pinOrPassword = md5($pinOrPassword);
    $hashedotp = ($otp);
    // Store the account number value in a session variable
    $_SESSION['user_accountNumber'] = $accountNumber;

     // Prepare SQL query
$sql = "INSERT INTO `paymentaccount`(`user_id`, `accountholdername`, `accountnumber`, `bankname`, `createdat`, `password`, `email_address`, `otp`) VALUES ('$user_id','$accountHolderName','$accountNumber','$bankName',CURDATE(),'$pinOrPassword',' $email',' $hashedotp')";


   // Execute SQL query
    if ($con->query($sql) === TRUE) {
        email_verify($otp, $email);
       
    } else {
        // If an error occurs, display a JavaScript alert with the error message
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
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

  <title>RHMS</title>
  <link rel="icon" href="rent.ico">

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">



  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
   <?php include('navbar.php');?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

 <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <ul class="navbar-nav ml-auto">


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php

                include "conn.php";
                $uname = $_SESSION['username'];
               $query = "SELECT * FROM user WHERE u_name = '$uname' ";
                $result = mysqli_query($con, $query);
                $row=mysqli_fetch_assoc($result);
                
                  $fname = $row['u_name'];
                
                  echo $fname;

                  ?></span>
                <img class="img-profile rounded-circle" src="user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>

            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

      <!-- Main Content -->
<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800" align="center">Create Payment Account</h1>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

          <tbody>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <tr>
  <td>Account Number:</td>
  <td><input type='text' class='form-control form-control-user' name='accountNumber' required pattern="\d{10}" title="Please enter exactly 10 digits" maxlength="10"></td>
</tr>

               <tr>
                <td>Account Holder Name:</td>
                <td><input type='text' class='form-control form-control-user' name='accountHolderName' required></td>
              </tr>
              <tr>
  <td>Bank Name:</td>
  <td>
    <select class="form-control form-control-user" name="bankName" required>
      <option value="" disabled selected>Select Bank</option>
      <option value="State Bank of India">State Bank of India</option>
      <option value="HDFC Bank">HDFC Bank</option>
      <option value="ICICI Bank">ICICI Bank</option>
      <option value="Axis Bank">Axis Bank</option>
      <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
      <!-- Add more options for other popular banks -->
    </select>
  </td>
</tr>
<tr>
                <td>Email Address:</td>
                <td><input type='text' class='form-control form-control-user' name='email' required></td>
              </tr>

              <tr>
                <td>PIN or Password:</td>
                <td>
                  <div class="input-group">
                    <input type='password' class='form-control form-control-user' name='pinOrPassword' id='pinOrPassword' required>
                    <div class="input-group-append">
                      <span class="input-group-text" id="pinViewToggle" style="cursor: pointer;">
                        <i class="fa fa-eye" id="pinViewIcon"></i>
                      </span>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td></td>
                <td><input class='btn btn-primary btn-user btn-lg' type='submit' name='submit' value='Create Account'></td>
              </tr>
            </form>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const pinViewIcon = document.getElementById('pinViewIcon');
  const pinOrPasswordInput = document.getElementById('pinOrPassword');

  // Toggle between password and text visibility
  pinViewIcon.addEventListener('click', function() {
    if (pinOrPasswordInput.type === 'password') {
      pinOrPasswordInput.type = 'text';
      pinViewIcon.classList.remove('fa-eye');
      pinViewIcon.classList.add('fa-eye-slash');
    } else {
      pinOrPasswordInput.type = 'password';
      pinViewIcon.classList.remove('fa-eye-slash');
      pinViewIcon.classList.add('fa-eye');
    }
  });
});
</script>

  
     
 
      <!-- End of Main Content -->


      <!-- Footer -->
      <?php include('footer.php'); ?>
      <!-- End of Footer -->
  </div>
         <!-- /.container-fluid -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
