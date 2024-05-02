<?php
session_start();
include "conn.php";
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}
function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
}

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

                      $col = $_POST['column'];
                      if ($col === "password") {
                       $edit = $_POST['edit'];
                       $edit = md5($edit);
                       } else {
                          $edit = $_POST['edit'];
                      }
                      
                      $accountNumber = $_POST['accountNumber'];
                      $query2 = "UPDATE paymentaccount SET $col = '$edit' WHERE accountnumber = '$accountNumber '";
                      mysqli_query($con, $query2);
                      echo "<script> alert('Edited successfully!!');</script>";
                      echo '<style>body{display:none;}</style>';
                      echo '<script>window.location.href = "my_payaccount.php";</script>';
                      exit;
                       }


  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changestatus'])) {
    $accountNumber = $_POST['accountNumber'];
     $user_id = $_SESSION['identity'];
     $status = $_POST['status'];
      if ( $status === "active") {
      $newStatus = "not active";
      $query3 = "UPDATE paymentaccount SET status = '$newStatus' WHERE accountnumber = '$accountNumber '";
     mysqli_query($con, $query3);
    }
    else if ( $status === "not active"){
      // Execute the SQL query to count active payment accounts
      $sql = "SELECT COUNT(*) AS active_count FROM `paymentaccount` WHERE user_id = '$user_id' AND `status` = 'active'";
      $result = mysqli_query($con, $sql);
      // Check if there are any active payment accounts
          if ($result && mysqli_fetch_assoc($result)['active_count'] > 0) {
           echo '<script>alert("Already one active account") </script>';

           }
           else {
           $newStatus = "active";
           $query3 = "UPDATE paymentaccount SET status = '$newStatus' WHERE accountnumber = '$accountNumber '";
           mysqli_query($con, $query3);
           }
    }
}

 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $accountNumber = $_POST['accountNumber'];
    $sql = "DELETE FROM paymentaccount WHERE accountnumber = '$accountNumber'";
    mysqli_query($con, $sql);
   echo '<script>alert("Deleted successfully") </script>';
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
                $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                $result = mysqli_query($con, $query);
                $row=mysqli_fetch_assoc($result);
               
                  $fname = $row['fname'];
                 
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
        <h1 class="h3 mb-2 text-gray-800" align="center">Bank Account Details</h1>
         
                    <?php
                    $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                    $result1 = mysqli_query($con, $query);
                    $row=mysqli_fetch_assoc($result1);
                    do{
                      $id = $row['tenant_id'];
                      $row = mysqli_fetch_assoc($result1);
                    }while ($row);
                    $sql = "SELECT * FROM paymentaccount WHERE user_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $total = 0;
                    if ($row) {
                    do{
                      echo '<div class="container-fluid">';
                    echo '<div class="card shadow mb-4">';
                    echo '<div class="card-body">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">';
                    echo '<tbody>';


                    // Add a delete button at the beginning of the table
                    
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="accountNumber" value="' . htmlspecialchars($row['accountnumber']) . '">';
                    echo '<button type="submit" class="btn btn-danger btn-sm float-right" name="delete">Delete</button>';
                    echo '</form>';
                   

                      echo '<tr>';
                      echo "<td> Account Holder Name:</td>";
                      echo "<td style = 'color:blue;'>".$row['accountholdername']. "</td>";
                      echo '<tr>';

                      

                      echo '<tr>';
                      $accountNumber = $row['accountnumber'];
                      // Mask all but the last four digits with asterisks
                      $maskedAccountNumber = str_pad(substr($accountNumber, -4), strlen($accountNumber), '*', STR_PAD_LEFT);

                      echo "<td>Account Number:</td>";
                      echo "<td style = 'color:blue;'>".$maskedAccountNumber."</td>";
                      echo '<tr>';

                    

                      echo '<tr>';
                      echo "<td>Bank Name:</td>";
                      echo "<td style = 'color:blue;'>".$row['bankname']."</td>";
                      echo '<tr>';

                     

                      echo '<tr>';
                      echo "<td>Email Address:</td>";
                      echo "<td style = 'color:blue;'>".$row['email_address']."</td>";
                      echo '<tr>';

                     echo '<tr>';
                      echo "<td>Status:</td>";

                      // Check if the status is 'active'
                      if ($row['status'] == 'active') {
                          echo "<td style='color:green;'>Active ";
                      } else {
                          echo "<td style='color:red;'>Not Active ";
                      }

                      // Form with hidden inputs for accountNumber and status
                      echo "<form action='' method='post'>";
                      echo "<input type='hidden' name='accountNumber' value='" . htmlspecialchars($row['accountnumber']) . "'>";
                      echo "<input type='hidden' name='status' value='" . htmlspecialchars($row['status']) . "'>";

                      // Submit button with icon
                      echo "<button type='submit' name='changestatus' style='border:none; background:none; cursor:pointer;'>";
                      echo "<i class='fas fa-sync-alt'></i>"; // Font Awesome sync-alt icon
                      echo "</button>";

                      echo "</form>";
                      echo "</td>";

                      echo '</tr>';

                      echo '<tr>';
                      echo "<td></td>";
                      echo "<td></td>";
                      echo '<tr>';

                      echo '<tr>';
                      echo "<td>Choose below the information you would like to edit: </td>";
                      echo '<tr>';
                      echo '<tr>';
                      echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
                      echo '<td>';
                      echo '<select class="custom-select" name="column" style="width:300px;">';
                      echo '<option value="accountholdername">Account holder name</option>';
                      echo '<option value="email_address">Email Address</option>';
                      echo '<option value="bankname">Bank name</option>';
                      echo '<option value="password">pin no</option>';

                      echo '</select>';
                      echo '</td>';
                      echo '<td><input type="text" class="form-control form-control-user" name="edit"></td>';
                      echo '<input type="hidden" name="accountNumber" value="' . htmlspecialchars($accountNumber) . '">';
                      echo '<td><input class="btn btn-primary btn-user btn-lg" type="submit" name="submit" value="Edit"></td>';
                      echo '</form>';
                      echo '</tr>';
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>
                       </div>
                                </div>

                              </div>';


                                            

                $row = mysqli_fetch_assoc($result);
                    }while ($row);

}
                     ?>
           
        <!-- /.container-fluid -->

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
