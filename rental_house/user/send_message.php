<?php
session_start();
include "conn.php";
if(isset($_POST['smsg'])){
        $sender_id=$_SESSION['identity'];
        $sender_username=$_SESSION['username'];

        $selectedName = $_POST['pno'][0]; // Assuming it's a single select
        $sql="SELECT `user_id` FROM `user` WHERE `name` = '$selectedName'";
        $result=mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $reciever_id=$row['user_id'];
       
       mysqli_free_result($result);
        $msg = $_POST['msg']; 
        $status="unread";      
// Prepare the SQL statement with placeholders
$sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `message`,`sender_username`,`status`,`created_at`) 
        VALUES (?, ?, ?, ?, ?, NOW())";

// Check if the SQL statement is prepared successfully
if ($stmt = mysqli_prepare($con, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "iisss", $sender_id, $reciever_id, $msg, $sender_username,  $status);
     if (mysqli_stmt_execute($stmt)) {
       echo "<script>alert('Message send successfully.');</script>";
    } 

    // Close the statement
    mysqli_stmt_close($stmt);

}
}
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

 <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-2 text-gray-800" align = "center">Messages</h1>


           <!-- DataTales Example -->
           <div class="card shadow mb-4">
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                   <tbody>
                     <form action="" method = "POST">
                      <tr>
    <td>
        Select Role:
    </td>
    <td>
        <select id="roleSelect" class="form-control form-control-user">
    <option value="">Select Role...</option>
    <option value="Manager">Landlord</option>
    <option value="Administrator">Admin</option>
</select>

    </td>
</tr>

                    <tr>
    <td>To:</td>
    <td>
<select class='form-control form-control-user' name='pno[]' id='usernameSelect'>
    <!-- Options will be loaded here dynamically -->
</select>

    </td>
</tr>

                     <tr>
                       <td>
                         Message:
                       </td>
                       <td><textarea class='form-control' name="msg" required></textarea></td>
                     </tr>
                     <tr>
                     <td></td>
                     <td><input class='btn btn-success btn-user btn-lg' type='submit' name='smsg' value='Send Message'></td>
                     </form>
                     <tr>
                   </tbody>
                 </table>
               </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#roleSelect').change(function() {
        var selectedRole = $(this).val();
        var options = '';

        // Clear the existing options in the username select element
        $('#usernameSelect').empty();

        // Check the selected role and add options accordingly
        if (selectedRole === 'Manager') {
             options += '<option value="">Select</option>';
            options += '<option value="Rasul">Rasul</option>';
            options += '<option value="Najeeb">Najeeb</option>';
        } else if (selectedRole === 'Administrator') {
            options += '<option value="Rhms">Rhms</option>';
        } 

        // Append options to the username select element
        $('#usernameSelect').html(options);
       
    });
});


</script>




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
