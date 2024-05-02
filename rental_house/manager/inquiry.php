<?php
session_start();
include "conn.php";
$uname =   $_SESSION['username'];
$stmt = $con->prepare("SELECT role, user_id FROM user WHERE u_name = ?");
$stmt->bind_param("s", $uname);
$stmt->execute();
$stmt->bind_result($role, $user_id);
$stmt->fetch();

$_SESSION['id']=$user_id;
$_SESSION['role']=$role;
  $stmt->close();
/* First query   ----------   */
$stmt = "SELECT * FROM `inquiries` WHERE `landlord_id` = '$user_id' AND `statuss` != 3";

$result1 = mysqli_query($con, $stmt);
 // Check if query executed successfully
        if ($result1) {
            $row1 = array();
          while ($row = mysqli_fetch_assoc($result1)) {
          $row1[] = $row;
            }
            } 
/* end-------*/
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

        <section class="wrapper clearfix">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form method="POST" action="">
      <?php
        if(isset($errMsg)){
          echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
        }
      ?>
      <h2>List of Property Details</h2>
        <?php
foreach ($row1 as $inquiry) {
    $inquiryID = $inquiry['inquiry_id'];
    
    // Query to fetch details for the current inquiry ID
    $query = "SELECT i.*, t.*, r.* 
              FROM inquiries i 
              INNER JOIN tenant t ON i.tenant_id = t.tenant_id 
              INNER JOIN room_rental_registrations r ON i.house_id = r.id 
              WHERE i.inquiry_id = '$inquiryID'";
    
    // Execute the query
    $result = mysqli_query($con, $query);
    
    // Check if the query executed successfully
    if ($result) {
        // Fetch the result row
        $value = mysqli_fetch_assoc($result);
         echo '<div class="card card-inverse card-info mb-3" style="padding:1%;">          
                  <div class="card-block">';
              


                  echo'<div class="row">
                      <div class="col-4">
                      <h4 class="text-center">Tenant Details</h4>';
                      echo '<p><b>Tenant Name: </b>' . $value['fname'] . ' ' . $value['lname'] . '</p>';
                      echo '<p><b>Contact Number: </b>'.$value['p_no'].'</p>';
                        echo '<p><b>Alternate Number: </b>'.$value['pno1'].'</p>';
                        echo '<p><b>Email: </b>'.$value['e_address'].'</p>';
                        
                       echo '</div>
                      <div class="col-5">
                      <h4 class="text-center">Room Details</h4>';
                        // echo '<p><b>Country: </b>'.$value['country'].'<b> State: </b>'.$value['state'].'<b> City: </b>'.$value['city'].'</p>';
                        echo '<p><b>Plot Number: </b>'.$value['plot_number'].'</p>';
                         echo '<p><b>Rent: </b>'.$value['rent'].'</p>';
                        if(isset($value['sale'])){
                          echo '<p><b>Sale: </b>'.$value['sale'].'</p>';
                        }                   
                        
                          if(isset($value['apartment_name']))
                            echo '<div class="alert alert-success" role="alert"><p><b>Apartment Name: </b>'.$value['apartment_name'].'</p></div>';

                          if(isset($value['ap_number_of_plats']))
                            echo '<div class="alert alert-success" role="alert"><p><b>Flat Number: </b>'.$value['ap_number_of_plats'].'</p></div>';
                        if(isset($value['own'])){
                          echo '<p><b>Available Area: </b>'.$value['area'].'</p>';
                          echo '<p><b>Floor: </b>'.$value['floor'].'</p>';
                          echo '<p><b>Owner/Rented: </b>'.$value['own'].'</p>';
                          echo '<p><b>Purpose: </b>'.$value['purpose'].'</p>';
                        }
                        echo '<p><b>Available Rooms: </b>'.$value['rooms'].'</p>';
                          echo '<p><b>Address: </b>'.$value['address'].'</p><p><b> Landmark: </b>'.$value['landmark'].'</p>';
                        echo '<p><b> City: </b>'.$value['city'].'</p>';

                      
                    echo '</div>
                      <div class="col-3">
                      <h4>Other Details</h4>';
                      echo '<p><b>Proposed Date: </b>'.$value['inquiry_date'].'</p>';
                        if ($value['statuss'] == 1) {
                            echo '<p><b>Status: </b>Approved</p>';
                            
                        } elseif ($value['statuss'] == 2) {
                            echo '<p><b>Status: </b>Pending</p>';
                        }
                        else{
                          echo '<p><b>Status: </b>Rejected</p>';
                        }
    if ($value['statuss'] == 2) {
    echo '<div style="margin-top: 200px;">'; // Add a margin between the buttons
    echo '<button class="btn btn-success mr-3" name="confirm_button">';
    echo '<a href="inquiry_delete.php?inquiry_id=' . $value['inquiry_id'] . '&stat=approve" style="text-decoration: none; color: white;">Confirm</a>';
    echo '</button>';
    echo '<button name="delete" class="btn btn-danger">';
    echo '<a href="inquiry_delete.php?inquiry_id=' . $value['inquiry_id'] . '&stat=reject" style="text-decoration: none; color: white;">Reject</a>';
    echo '</button>';
    echo '</div>';
}
                    

                     echo '</div> 
                     </div>              
                   </div>
                </div>';
                
          
        
        
       
        
    } 
}

?>
        </form>         
                  
      </div>
    </div>
  </div>  
</section>


  

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
