<?php
session_start();
include "conn.php";
$uname =   $_SESSION['username'];
if ( isset($_GET['id'])) {
      $id = $_REQUEST['id'];
    } 

    if ( isset($_GET['act'])) {
      $active = $_REQUEST['act'];


     if ($active == 'indi') { 
        // Get user ID from session
       
        try {

        // Prepare SQL query
        $sql = "SELECT * FROM `room_rental_registrations` WHERE `id` = $id";

        // Execute SQL query
        $result = mysqli_query($con, $sql);

        // Check if query executed successfully
        if ($result) {
            // Fetch and print data
            $data = mysqli_fetch_assoc($result);
            
            
          

        
            } 
    }
 catch (Exception $e) {
    $errMsg = $e->getMessage();
    echo $errMsg;
}
}
}
if(isset($_POST['register_individuals'])) {
    $errMsg = '';
    // Get data from FORM
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $alternat_mobile = $_POST['alternat_mobile'];
    $plot_number = $_POST['plot_number'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $rent = $_POST['rent'];
    $deposit = $_POST['deposit'];
    $description = $_POST['description'];
    //$open_for_sharing = $_POST['open_for_sharing'];
    $user_id = $_SESSION['id'];
    $accommodation = $_POST['accommodation'];
    //$image = $_POST['image'];
    //$other = $_POST['other'];
    $vacant = $_POST['vacant'];
    $rooms = $_POST['rooms'];
    $id = $_POST['id'];
    $sale = $_POST['sale'];
      
     

    // Prepare SQL statement
    $sql = "UPDATE room_rental_registrations SET fullname = ?, email = ?, mobile = ?, alternat_mobile = ?, plot_number = ?, rooms = ?, country = ?, state = ?, city = ?, address = ?,  rent = ?, sale = ?, deposit = ?, description = ?, accommodation = ?,  vacant = ?, user_id = ? WHERE id = ?";
    
    // Prepare and bind parameters
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssss", $fullname, $email, $mobile, $alternat_mobile, $plot_number, $rooms, $country, $state, $city, $address,  $rent, $sale, $deposit, $description, $accommodation,  $vacant, $user_id,$id);

    // Execute the statement
    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Close statement
       
        header('Location: house_list.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}


    // print_r($data1); 
    // echo "<br><br><br>";
    // print_r($data2);
    // echo "<br><br><br>"; 
    // print_r($data);  

/*$user = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE u_name = '$user'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
do {
  $role = $row['role'];
  $row = mysqli_fetch_assoc($res);
} while ($row);
if(!$user && $role == 'Manager'){
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

  <title>Rental House Management System</title>
  <link rel="icon" href="rent.ico">

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- navbar -->
    <?php include('navbar.php'); ?>
    <!-- End of navbar -->

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
          
        <!-- Begin Page Content -->
   
        <?php include('individual_edit.php'); ?>
        <!-- End of Page Content -->
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
          <a class="btn btn-dark" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>
