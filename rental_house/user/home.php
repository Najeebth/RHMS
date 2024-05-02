<?php
session_start();
include "conn.php";
$tenant_id = $_SESSION['identity'];



// Lease Informations  Query //
$sql="SELECT `contract_id`,  `house_id`,   `rent_per_term`, `start_day`, `end_day`,   `landlord_id`, `deposit` , `date_contract_sign` , `status` ,`tenant_id`FROM `contract` WHERE `tenant_id` = '$tenant_id'";
$result=mysqli_query($con,$sql);
$contracts=mysqli_fetch_assoc($result);


      // <!-- house name and landlord name -->
if($contracts){
$landlord_id = $contracts['landlord_id'];
      $house_id = $contracts['house_id'];
      $sql = "SELECT  `name` FROM `user` WHERE `user_id` = $landlord_id";
      $sql1 = "SELECT  `fullname` FROM `room_rental_registrations` WHERE `id` = $house_id";
      $query = mysqli_query($con,$sql);
      $query1 = mysqli_query($con,$sql1);
      $landlord=mysqli_fetch_assoc($query);
      $house=mysqli_fetch_assoc($query1); }
   // <!-- End of house name and landlord name -->

// end of Lease Informations  Query//

// if(!$_SESSION['username']){
//   echo '<script>window.location.href = "login.php";</script>';
//   exit();
// }

// Deal submit button process//
// Check if the form is submitted
if (isset($_POST["contract"])) {
    // Define variables and initialize with empty values
    $fname1 = $lname1 = $occu1 = $nature1 = $cpno1 = $cpno4 = $city1 = $region1 = $email1 = $p_address1 = "";

    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // Fetch values//
    $contract_id = $contracts['contract_id'];

    // Validate and sanitize form fields
    $fname1 = sanitize_input($_POST["fname1"]);
    $lname1 = sanitize_input($_POST["lname1"]);
    $occu1 = sanitize_input($_POST["occu1"]);
    $nature1 = sanitize_input($_POST["nature1"]);
    $cpno1 = sanitize_input($_POST["cpno1"]);
    $cpno4 = sanitize_input($_POST["cpno4"]);
    $city1 = sanitize_input($_POST["city1"]);
    $region1 = sanitize_input($_POST["region1"]);
    $email1 = sanitize_input($_POST["email1"]);
    $p_address1 = sanitize_input($_POST["p_address1"]);

   

    // Validate email address
    if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        $errors["email1"] = "Invalid email format";
        echo "<script type='text/javascript'>alert('Invalid email format');</script>";
    }

   
    else{
    // If no errors, process the form data
    
      // Tenant contacts//
     $sql2 = "INSERT INTO `tenant_contacts`( `tenant_id`, `fname1`, `lname1`, `occupation1`, `nature1`, `pno1`, `pno2`, `e_address1`, `p_address1`, `city1`, `region1`) VALUES ('$tenant_id',' $fname1',' $lname1','$occu1','$nature1',' $cpno1','$cpno4',' $email1','  $p_address1','$city1','$region1')";
       mysqli_query($con, $sql2);

       // Tenant contract//
       $date_contract_sign = date('Y-m-d');
       $sql3 = "UPDATE `contract` SET `date_contract_sign`=' $date_contract_sign ' WHERE `tenant_id`= '$tenant_id'";
       mysqli_query($con, $sql3);

        // Tenant Document//
  
        $uploadDir = '../uploads/'; // Target directory
        $fileName = basename($_FILES['signatureImage']['name']); // Get the basename of the uploaded file
        $targetSignPath = $uploadDir . $fileName; // Path name
        move_uploaded_file($_FILES['signatureImage']['tmp_name'], $targetSignPath);
    
       $sql4 = "UPDATE `document` SET `tsign_path`='$targetSignPath' WHERE `tenant_id`= '$tenant_id'";
       mysqli_query($con, $sql4);

       echo "<script type='text/javascript'>alert('Welcome, please make the deposit !');</script>";
       echo '<script>window.location.href = "../login.php";</script>';  
   
}
}

$transaction =  "SELECT COUNT(*) AS count FROM transactions WHERE  sender_user_id = '$tenant_id' AND description = 'deposit'";
$transaction_result = mysqli_query($con, $transaction);
    
    // Check if the query executed successfully
    if ($transaction_result) {
        $row0 = mysqli_fetch_assoc($transaction_result);

        // Retrieve the count of transactions
        $tran_count = $row0['count'];
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
    <?php  
      if (!$contracts OR $tran_count == 0 ) {  ?>
        <div style="text-align: center; color: red;">
    <p>No active contract or Deposit not paid</p>
    <button style="padding: 10px 20px; margin-top: 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" onclick="location.href='house_list.php'">Find Home</button>
    <button style="padding: 10px 20px; margin-top: 20px; background-color: blue; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" onclick="location.href='add_payaccount.php'">Make Payment</button>
</div>

    <?php  }
      elseif (!$contracts['date_contract_sign'] AND $contracts['tenant_id'] === $tenant_id) {    ?>
             <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800" align="center">Contract</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body"> 
          <p><span style = "color:#4e73df;"><b><b>LEASE INFORMATION</b></b></span></p>
          <div class="row">
            <div class="col-md-6">
                <span class="label">Owner Name:</span>
                <span><?php echo $landlord['name'];?></span>
            </div>
            <div class="col-md-6">
                <span class="label">House Name:</span>
                <span><?php echo $house['fullname'];?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mt-2">
                <span class="label">Deposit:</span>
                <span><b><?php echo $contracts['deposit'];?></b></span>
            </div>
            <div class="col-md-6 mt-2">
                <span class="label">Rent per month:</span>
                <span><b><?php echo $contracts['rent_per_term'];?></b></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mt-2">
                <span class="label">Lease start date:</span>
                <span><?php echo $contracts['start_day'];?></span>
            </div>
            <div class="col-md-6 mt-2">
                <span class="label">Lease end date:</span>
                <span><?php echo $contracts['end_day'];?></span>
            </div>
          </div>
           <!-------------------------->
                <hr>
                <p>Please read the contract <span style = "color:red;">CAREFULLY</span> and check "I agree" if you agree with the TERMS AND CONDITIONS stated.</p><br/>
                <div class="form-group">
                  <iframe src="../uploads/rental-agreement.pdf" width="1000px" height="400px" style="border: none;"></iframe>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="checkbox" name="contract" value = "Occupied" required>I agree&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                  </div>
                </div>
                <hr>
                <p><span style = "color:#4e73df;"><b><b>CONTACTS' INFORMATION</b></b></span></p>
                 <form method="POST" action="">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="fname1" value="<?php echo @$cfname1; ?>" placeholder="First Name" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="lname1" value="<?php echo @$clname1; ?>"placeholder="Last Name" required>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="occu1" value="<?php echo @$c_occu1; ?>"placeholder="Occupation" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="nature1" value="<?php echo @$nature1; ?>" placeholder="Nature of the Relationship" required>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="cpno1" value="<?php echo @$cpno1; ?>" placeholder="Phone Number 1 e.g; 255717******" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="cpno4" value="<?php echo @$cpno4; ?>" placeholder="Phone Number 2 e.g; 255717******">
                  </div>
                </div>        
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="city1" value="<?php echo @$city1; ?>" placeholder="City" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="region1" value="<?php echo @$region1; ?>" placeholder="Region" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="email" class="form-control form-control-user" name="email1" value="<?php echo @$cemail1; ?>" placeholder="Email Address">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="p_address1" value="<?php echo @$p_address1; ?>" placeholder="Postal Address" required>
                  </div>
                   <div class="col-md-6 mt-4">
    <div class="form-group" style="width :50%">
        <label for="tenantSignature">Tenant's Signature</label>
 <input type="file" name="signatureImage" id="signatureImage" accept="image/*" required>

</div>
    </div>
  </div>
      

    <!-- Submit Button -->
    <button type="submit" name="contract" class="btn btn-primary" style="margin-top: 20px; margin-left: 15.5cm; padding: 14px;">Deal</button>
</form>
        
    </div>
</div>


    <?php  } 

    else {  ?>
              <div class="container-fluid">
          <h1 class="h3 mb-2 text-gray-800" align="center">Welcome!!</h1>
          <p class="mb-0"><span style="color:red;">You Occupy <b><b>House: <?php
          $uname = $_SESSION['username'];
          $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
          $result1 = mysqli_query($con, $query);
          $row=mysqli_fetch_assoc($result1);
          do{
            $id = $row['tenant_id'];
            $row = mysqli_fetch_assoc($result1);
          }while ($row);
          $sql = "SELECT * FROM contract WHERE tenant_id = '$id'";
          $result = mysqli_query($con, $sql);
          $row = mysqli_fetch_assoc($result);
          do{
            $h_id = $row['house_id'];
            $end_day = $row['end_day'];
            $sql1 = "SELECT * FROM room_rental_registrations WHERE id = '$h_id'";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            do{
              $name = $row1['fullname'];

              $row1 = mysqli_fetch_assoc($result1);
            }while ($row1);
            $row = mysqli_fetch_assoc($result);
          }while ($row);
          echo $name;
          
          ?></b></b></span></p>

            <p class="mb-2"><span style="color:red;">Contract ends :<b><b> <?php
         
          echo $end_day;
          
          ?></b></b></span></p>

          <?php include('remainder.php');  ?>

          <p class="mb-4">The information below shows the amount to be paid with respect with  the terms stated and their respective due dates.</p>

          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Amount to be Paid/Paid</th>
                      <th>Type</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                    $result1 = mysqli_query($con, $query);
                    $row=mysqli_fetch_assoc($result1);
                    do{
                      $id = $row['tenant_id'];
                      $row = mysqli_fetch_assoc($result1);
                    }while ($row);

                    $sql = "SELECT * FROM contract WHERE tenant_id = '$id' AND status = 'active'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $total = 0;
                    do{
                      $date_contract_sign = $row['date_contract_sign'];
                      $deposit = $row['deposit'];
                     
                           echo '<tr>';
                           echo '<td>' . $date_contract_sign . '</td>';
                            echo '<td>' . $deposit . '/-</td>';
                            echo '<td>' . 'Deposit' . '</td>';
                            echo '<td style="color: green;">' . 'paid' . '</td>';
                           echo '</tr>';
                   
                      $hid = $row['house_id'];
                      $dur = $row['duration_month'];
                      $term = $row['rent_per_term'];
                      //$div = $dur/$term;
                      $startday = $row['start_day'];
                      $endday = $row['end_day'];
                     $total_rent = $row['total_rent'];

                      // Calculate the next payment date for the start of the next month
                      $next_payment_date = date("Y-m-d", strtotime($startday . " + 1 month"));
                      $sender_user_id = $_SESSION['identity'];

 // Loop until the next payment date is less than or equal to the end day
while (strtotime($next_payment_date) <= strtotime($endday)) {
    // Prepare the SQL query to check if the payment date exists and meets certain criteria
    // Convert $next_payment_date to 'Month YYYY' format
    $formatted_next_payment_month = date("n", strtotime($next_payment_date));
    $query1 = "SELECT COUNT(*) AS count FROM transactions WHERE pay_to_date = '$formatted_next_payment_month' AND sender_user_id = '$sender_user_id'
    AND description = 'rent'";
    $result1 = mysqli_query($con, $query1);
    
    // Check if the query executed successfully
    if ($result1) {
        $row1 = mysqli_fetch_assoc($result1);

        // Retrieve the count of transactions
        $transaction_count = $row1['count'];

        // Check if there are any transactions for the current payment date
        if ($transaction_count > 0) {
            $paymentStatus = "Paid";
            $statusColor = "color: green;";
        } else {
            $paymentStatus = "Not Paid";
            $statusColor = "color: red;";
        }

        // Output the table row for the current payment date
        echo '<tr>';
        echo '<td>' . $next_payment_date. '</td>';
        echo '<td>' . number_format($term) . '/-</td>';
        echo '<td>' . 'Rent' . '</td>';
        // Change the color based on payment status
        echo '<td style="' . $statusColor . '">' . $paymentStatus . '</td>';
        echo '</tr>';
    } else {
        // Handle query execution errors
        echo "Error: " . mysqli_error($con);
    }

    // Calculate the next payment date for the next installment
    $next_payment_date = date("Y-m-d", strtotime($next_payment_date . " + 1 month"));
}



                      echo '<tr><td colspan="2"><b><b><b>TOTAL RENT:</b></b></b></td><td colspan="2">'.number_format($total_rent).'</td></tr>';

                      $row = mysqli_fetch_assoc($result);
                    }while ($row);


                     ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
            <p class="mb-4">For more information or help please kindly contact us through:<br/><br/><b>Phone Number: 756 777 777.<br/>Email Address: rhms123@gmail.com</b></p>

        </div>
        </div> 

      </div>

   <?php } ?>
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
