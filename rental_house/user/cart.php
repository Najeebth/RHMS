<?php
session_start();
include "conn.php";

// Assuming you've already retrieved the session identity ($id)
$id = $_SESSION['identity'];

// Step 1: Retrieve plot numbers from the cart table based on the session identity
$stmt = $con->prepare("SELECT plot_number FROM cart WHERE tenant_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($plot_number);
// Fetch plot numbers and store them in an array
while ($stmt->fetch()) {
    $plotNumbers[] = $plot_number;
}

$stmt->close(); // Close the statement

$data = array();

// Loop through plot numbers and execute the second query
if(!empty($plotNumbers)){
foreach ($plotNumbers as $plotNumber) {
    // Fetch and store house details
    $stmt2 = $con->prepare("SELECT * FROM room_rental_registrations WHERE plot_number = ?");
    if (!$stmt2) {
        die("Error in SQL query: " . $con->error);
    }
    $stmt2->bind_param("s", $plotNumber);
    if (!$stmt2->execute()) {
        die("Error executing SQL query: " . $stmt2->error);
    }
    $result = $stmt2->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt2->close(); // Close the statement
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
                $uname = $_SESSION['username'];
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
      <!-- Main Content -->
       <section class="wrapper clearfix">
  <div class="container">
    <div class="row">
      <div class="col-12">
         <h2>List of Property Details</h2>
      <?php
        if(!$data){
          echo '<div style="color:#FF0000; text-align:center; font-size:20px; margin-bottom: 200px; margin-top: 50px;">Cart is empty</div>';

        }
      ?>
     
        <?php 
          foreach ($data as $value) {           
            echo '<div class="card card-inverse card-info mb-3" style="padding:1%;">          
                  <div class="card-block">';
                  echo '<a class="btn btn-danger float-right" style=" margin-left: 5px;" href="individual_delete.php?plot_number='.$value['plot_number'].'" onclick="return confirm(\'Are you sure you want to delete this item?\');">';echo 'Delete</a>';
                


                  echo'<div class="row">
                      <div class="col-4">
                      <h4 class="text-center">Owner Details</h4>';
                        echo '<p><b>Owner Name: </b>'.$value['fullname'].'</p>';
                        echo '<p><b>Contact Number: </b>'.$value['mobile'].'</p>';
                        echo '<p><b>Alternate Number: </b>'.$value['alternat_mobile'].'</p>';
                        echo '<p><b>Email: </b>'.$value['email'].'</p>';
                        
                      
                        if ($value['image'] !== '../uploads/') {
                          # code...
                          echo '<img src="'.$value['image'].'" width="200" alt="no inage">';
                        }


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
                      echo '<p><b>Accommodation: </b>'.$value['accommodation'].'</p>';
                      echo '<p><b>Description: </b>'.$value['description'].'</p>';
                        if($value['vacant'] == 0){ 
                          echo '<div class="alert alert-danger" role="alert"><p><b>Occupied</b></p></div>';
                        }else{
                          echo '<div class="alert alert-success" role="alert"><p><b>Vacant</b></p></div>';
                          $house_id = $value['id']; // House ID from $value['id']
                          
                          // Generating the URL with parameters
                          $button_url = 'send_inquiry.php?house_id=' . $house_id;
                          echo '<a href="' . $button_url . '" class="btn btn-primary float-right" style="margin-top: 30px;">I Am Interested</a>';
                        
                        } 
                      echo '</div>
                    </div>              
                   </div>
                </div>';
                
          }
        ?>        
      </div>
    </div>
  </div>  
</section>


      
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
  <!-- End of logout model -->
  
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
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
