<?php
session_start();
include "conn.php";


if (isset($_POST['contract'])) {
   
    $sender_username = $_SESSION['username'];
    $sql1 = "SELECT `user_id` FROM `user` WHERE `u_name`='$sender_username'";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $landlordId = $row1['user_id'];

    // Store form data in variables
    $tenantId = isset($_POST['tenantId']) ? $_POST['tenantId'] : '';
    $propertyId = isset($_POST['propertyId']) ? $_POST['propertyId'] : '';
    $leaseStart = isset($_POST['leaseStart']) ? $_POST['leaseStart'] : '';
    $leaseEnd = isset($_POST['leaseEnd']) ? $_POST['leaseEnd'] : '';
    $MonthlyRent = isset($_POST['monthlyRent']) ? $_POST['monthlyRent'] : '';
    $deposit = isset($_POST['deposit']) ? $_POST['deposit'] : '';
    $status = "Inactive";

    // Create DateTime objects from the start and end dates
    $start = new DateTime($leaseStart);
    $end = new DateTime($leaseEnd);

    // Calculate the difference between the dates
    $interval = $start->diff($end);

    // Get the total number of months
    $totalMonths = $interval->m + ($interval->y * 12);

   // Ensure $totalMonths and $MonthlyRent are integers
$totalMonths = intval($totalMonths);
$MonthlyRent = intval($MonthlyRent);

// Calculate total rent
$total_rent = $totalMonths * $MonthlyRent;


    // Contract document
    if (isset($_FILES['contractDocument']) && $_FILES['contractDocument']['error'] == 0) {
        $uploadDir = '../uploads/'; // Target directory
        $fileName = basename($_FILES['contractDocument']['name']); // Get the basename of the uploaded file
        $targetFilePath = $uploadDir . $fileName; // Path name
        move_uploaded_file($_FILES['contractDocument']['tmp_name'], $targetFilePath);
    }

    // Manager signature
    if (isset($_FILES['signatureImage']) && $_FILES['signatureImage']['error'] == 0) {
        $uploadDir = '../uploads/'; // Target directory
        $fileName = basename($_FILES['signatureImage']['name']); // Get the basename of the uploaded file
        $targetSignPath = $uploadDir . $fileName; // Path name
        move_uploaded_file($_FILES['signatureImage']['tmp_name'], $targetSignPath);
    }

    $sql = "INSERT INTO `contract`(`tenant_id`, `house_id`, `duration_month`, `start_day`, `end_day`, `status`, `landlord_id` , `total_rent`, `deposit` , `rent_per_term`) VALUES ('$tenantId','$propertyId','$totalMonths','$leaseStart','$leaseEnd','$status','$landlordId','$total_rent','$deposit','$MonthlyRent')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Get the contract ID of the inserted record
        $contractId = mysqli_insert_id($con);
        $stmt = "INSERT INTO `document`( `contract_id`, `landlord_id`, `tenant_id`, `document_path`, `msign_path`) VALUES ('$contractId','$landlordId','$tenantId','$targetFilePath','$targetSignPath')";
        $info = mysqli_query($con, $stmt);
        if ($info) {
            $success = "Contract sent successfully to Tenant Id: $tenantId";
            echo "<script>alert('$success');</script>";
        } else {
            $error = "Error: " . mysqli_error($con);
            echo "<script>alert('$error');</script>";
        }
    } else {
        $error = "Error: " . mysqli_error($con);
        echo "<script>alert('$error');</script>";
    }
} 




// Fetch tenants
$tenantsResult = mysqli_query($con, "SELECT tenant_id, CONCAT(fname, ' ', lname) AS tenantName FROM tenant ORDER BY lname");

// Fetch properties
$propertiesResult = mysqli_query($con, "SELECT id, fullname FROM room_rental_registrations ORDER BY id");
/*if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}*/
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
  <!-- Include Signature Pad CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/signature_pad/dist/signature-pad.css">


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
                echo "<b><b>".$uname."</b></b>";

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
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800" align="center">Contract</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body"> 
           <form method="POST" enctype="multipart/form-data">
    <div class="row">
        <!-- Tenant Dropdown -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="tenantId">Tenant</label>
                <select name="tenantId" id="tenantId" class="form-control">
                  <option>---Select---</option>
                    <?php while ($row = mysqli_fetch_assoc($tenantsResult)): ?>
                        <option value="<?php echo htmlspecialchars($row['tenant_id']); ?>">
                            <?php echo htmlspecialchars($row['tenantName']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Property Dropdown -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="propertyId">Property</label>
                <select name="propertyId" id="propertyId" class="form-control">
                   <option>---Select---</option>
                    <?php while ($row = mysqli_fetch_assoc($propertiesResult)): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lease Start Date -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="leaseStart">Lease Start Date</label>
                <input type="date" name="leaseStart" id="leaseStart" class="form-control" required>
            </div>
        </div>

        <!-- Lease End Date -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="leaseEnd">Lease End Date</label>
                <input type="date" name="leaseEnd" id="leaseEnd" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Rent -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="monthlyRent">Monthly Rent</label>
                <input type="number" name="monthlyRent" id="monthlyRent" class="form-control" required>
            </div>
        </div>

        <!-- Deposit -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="deposit">Deposit</label>
                <input type="text" name="deposit" id="deposit" class="form-control" required>
            </div>
        </div>
    </div>

<div class="row">
    <!-- File Upload for Contract Document -->
    <div class="col-md-6">
    <div class="form-group">
        <label for="contractDocument">Contract Document</label>
        <input type="file" name="contractDocument" id="contractDocument" class="form-control-file">
    </div>
  </div>

    <!-- Manager Signature -->
    <div class="col-md-6">
    <div class="form-group" style="width :50%">
        <label for="managerSignature">Manager's Signature</label>
 <input type="file" name="signatureImage" id="signatureImage" accept="image/*" required>

</div>
    </div>
  </div>

    <!-- Submit Button -->
   <center> <button type="submit" name="contract" class="btn btn-primary" style="margin-top: 20px;">Create</button></center>
</form>
          
        </div>
    </div>
</div>

   
  

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
