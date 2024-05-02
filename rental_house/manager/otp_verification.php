<?php
session_start();
include "conn.php";
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}
/*function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
}*/
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify'])) {

// Get the entered OTP from the form submission
$entered_otp = $_POST['otp']; 


// Retrieve the account number from the session
$accountNumber = $_SESSION['user_accountNumber'];
// Query to retrieve the hashed OTP from the database based on the provided account number
$sql = "SELECT `otp` FROM `paymentaccount` WHERE `accountnumber` = '$accountNumber'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
$hashed_otp_from_db = $row['otp']; 

if ($hashed_otp_from_db) {
    // Verify the OTP
    if ($entered_otp == $hashed_otp_from_db) {
        // Remove the session variable
        unset($_SESSION['user_accountNumber']);
         echo "<script type='text/javascript'>alert('Veification Successfull');</script>";
       echo "<script>window.location.href='add_payaccount.php';</script>";
        exit();

        // Redirect to a success page or perform further actions
    } else {
       echo "<script type='text/javascript'>alert('Incorrect OTP');</script>";

        // Delete the account from the database
        $sql_delete = "DELETE FROM paymentaccount WHERE accountnumber = ?";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bind_param('s', $accountNumber);
        $stmt_delete->execute();
        $stmt_delete->close();
        // Remove the session variable
        unset($_SESSION['user_accountNumber']);

        // Redirect back to the OTP entry form or display an error message
         echo "<script>window.location.href='add_payaccount.php';</script>";
    }
} else {
    // Account number not found in the database
    echo "Account number not found.";
    // Redirect back to the OTP entry form or display an error message
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

  <title>Rental House Management System</title>
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
    <?php include('navbar.php'); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

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

                $uname = @$_SESSION['username'];
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

        <!-- Begin Page Content -->
       
        <div class="container-fluid" style="align-items: center;">
    <h1 class="h3 mb-2 text-gray-800" align="center">OTP Verification</h1>

    <div class="card shadow mb-4" style="width:50%; transform: translateX(9cm);">
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="otp">Enter OTP:</label>
                    <input type="text" class="form-control" id="otp" name="otp" required>
                </div>
                <button type="submit" name = "verify" class="btn btn-primary">Verify OTP</button>
            </form>
        </div>
    </div>
</div>


      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include('footer.php'); ?>
      <!-- End of Footer -->

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
