<?php
session_start();
include('conn.php');
$uname = $_SESSION['username'];
$sql="SELECT user_id FROM user WHERE u_name = '$uname'";
$result=mysqli_query($con,$sql);
$row = mysqli_fetch_row($result)[0];
$_SESSION['id']=$row;
include('conn.php');
if(isset($_POST['register_individuals'])) {
      $errMsg = '';
      // Get data from FROM
      $fullname = $_POST['fullname'];
      $email = $_POST['email'];
      $mobile = $_POST['mobile'];
      $alternat_mobile = $_POST['alternat_mobile'];
      $plot_number = $_POST['plot_number'];
      $country = $_POST['country'];
      $state = $_POST['state'];
      $city = $_POST['city'];
      $address = $_POST['address'];
      $landmark = $_POST['landmark'];
      $rent = $_POST['rent'];
      $deposit = $_POST['deposit'];
      $description = $_POST['description'];
      //$open_for_sharing = $_POST['open_for_sharing'];
      $user_id = $_SESSION['id'];
      $accommodation = $_POST['accommodation'];
      //$image = $_POST['image']?$_POST['image']:NULL;
      //$other = $_POST['other'];     
      $rooms = $_POST['rooms'];
      $vacant = $_POST['vacant'];
      $sale = $_POST['sale'];


      //upload an images
      $target_file = "";
      if (isset($_FILES["image"]["name"])) {
        $target_file = "../uploads/".basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
          $check = getimagesize($_FILES["image"]["tmp_name"]);      
          if($check !== false) {
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }
      //end of image upload
      //upload an images
      $target_file1 = "";
      if (isset($_FILES["image1"]["name"])) {
        $target_file1 = "../uploads/".basename($_FILES["image1"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
          $check = getimagesize($_FILES["image1"]["tmp_name"]);      
          if($check !== false) {
            move_uploaded_file($_FILES["image1"]["tmp_name"], "../uploads/" . $_FILES["image1"]["name"]);
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }
      //end of image upload

       //upload an images
      $target_file2 = "";
      if (isset($_FILES["image2"]["name"])) {
        $target_file2 = "../uploads/".basename($_FILES["image2"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
          $check = getimagesize($_FILES["image2"]["tmp_name"]);      
          if($check !== false) {
            move_uploaded_file($_FILES["image2"]["tmp_name"], "../uploads/" . $_FILES["image2"]["name"]);
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }
      //end of image upload

// Prepare the SQL statement
$sql = "INSERT INTO room_rental_registrations (fullname, email, mobile, alternat_mobile, plot_number, rooms, country, state, city, address, landmark, rent, sale, deposit, description, image, accommodation, vacant, user_id, image1,image2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";

// Prepare the statement
$stmt = mysqli_prepare($con, $sql);
if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssiss", $fullname, $email, $mobile, $alternat_mobile, $plot_number, $rooms, $country, $state, $city, $address, $landmark, $rent, $sale, $deposit, $description, $target_file, $accommodation, $vacant, $user_id,$target_file1,$target_file2);
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
     
    header('Location: manager_house_reg.php?success=1');
    exit();
}

     else {
        echo "Error: " . mysqli_error($con);
    }
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($con);
}
}

// Check if success flag is set
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<div class='alert alert-success'>Record inserted successfully.</div>";
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
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
<!-- Single room -->

    <div class="tab-pane active" id="home" role="tabpanel"><br>
        <?php include 'individual.php';?>
    </div>

    <!-- End -->

          <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; RHMS <?php echo (date('Y')) ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

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