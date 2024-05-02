
<?php
session_start();
include "conn.php";
$user_id = $_SESSION['identity'];
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}


// Data retrieve from paymentaccount table //

$sql = " SELECT * FROM paymentaccount WHERE user_id = '$user_id' AND status = 'active'";
 $result = mysqli_query($con, $sql);
  $row=mysqli_fetch_assoc($result);
  do{
    $accountnumber = $row['accountnumber'];
    $sender_accntid = $row['accountid'];
     $password = $row['password'];
    $row = mysqli_fetch_assoc($result);
  }while ($row);
  $maskedAccountNumber = str_pad(substr($accountnumber, -4), strlen($accountnumber), '*', STR_PAD_LEFT);
//----------------------------//


//Form submission//
  
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve the values from the form

    $account_number = $_POST['pno']; // Your Account Number
    $receiver_id = $_POST['pno1']; // Receiver ID
    $sql1 = " SELECT * FROM paymentaccount WHERE user_id = '$receiver_id' AND status = 'active'";
    $result1 = mysqli_query($con, $sql1);
    $row1=mysqli_fetch_assoc($result1);
    do{
    $receiver_id = $row1['accountid'];
    $row1 = mysqli_fetch_assoc($result1);
    }while ($row1);

    $amount_type = $_POST['desc']; // Amount Type (rent or deposit)
    $amount = $_POST['amount']; // Amount
    $payment_from = $_POST['from']; // Payment From
    $payment_to = $_POST['to']; // Payment To
    $entered_password = $_POST['password']; // Pin no
    $entered_password = md5($entered_password );

    if ($password === $entered_password) {

  $query = "INSERT INTO `transactions`( `sender_accntid`, `receiver_accntid`, `amount`, `description`, `pay_from_date`, `pay_to_date`, `payment_date` ,`sender_user_id`) VALUES ('$sender_accntid','$receiver_id','$amount','$amount_type ','$payment_from',' $payment_to',CURRENT_TIMESTAMP,'$user_id')";
  mysqli_query($con,$query);


  //Contract active operation//
        if($amount_type==='deposit'){
          $query2 = "UPDATE `contract` SET `status`='active' WHERE `tenant_id`='$user_id'";
          mysqli_query($con,$query2);

          //Remainder table insertion//
          $rem= "SELECT `start_day`, `end_day`, `rent_per_term` FROM `contract` WHERE `tenant_id` = '$user_id' AND `status` = 'active'";
$rem1 = mysqli_query($con ,$rem);
$rem2 = mysqli_fetch_assoc($rem1);
$start_day = $rem2['start_day'];
$end_day = $rem2['end_day'];
$rent_per_term = $rem2['rent_per_term'];

$start_day = new DateTime($rem2['start_day']);
$end_day = new DateTime($rem2['end_day']);


$paymentDates = array();
$currentDate = clone $start_day; // Clone the start day to avoid modifying the original date object
$oneMonthInterval = new DateInterval('P1M'); // Represents a one-month interval.

// Start from one month after the start day and loop until the end day
$currentDate->add($oneMonthInterval); // Move to the next month after the start day
while ($currentDate <= $end_day) {
    $paymentDates[] = $currentDate->format('Y-m-d');
    $currentDate->add($oneMonthInterval); // Move to the next month
}

foreach ($paymentDates as $payment_date) {
    // Prepare the SQL statement
    $sql = "INSERT INTO `reminders`(`tenant_id`, `title`, `payment_date`, `amount`, `is_paid`) 
            VALUES ('$user_id', 'Rent', '$payment_date', '$rent_per_term', FALSE)";

    // Execute the SQL statement
    // Assuming $conn is your database connection
    if ($con->query($sql) === TRUE) {
        // echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $con->error;
    }
}
}

   echo "<script> alert('Transaction successfull!!');</script>";
}
else{
   echo "<script> alert('Incorrect pin no!!');</script>";

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
                 $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                 $result = mysqli_query($con, $query);
                 $row=mysqli_fetch_assoc($result);
                  $fname = $row['fname'];
                   
                   $id = $row['tenant_id'];
                   
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
         <div class="container-fluid">
           <h1 class="h3 mb-2 text-gray-800" align="center"> Payment</h1>

           <div class="card shadow mb-4">
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                   <tbody>
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                     <tr>
                       <td>
                         Your Account Number:
                       </td>
                      <td><input type='text' class='form-control form-control-user' name='pno' value="<?php echo  $maskedAccountNumber; ?>" readonly></td>
                     </tr>
                     <tr>
                       <td>
                         Receipient:
                       </td>
                       <td>
                         <select class='form-control form-control-user' name='pno1'>
                      <?php
                      $sql1 = "SELECT * FROM `user` WHERE `role` = 'manager'";
                      $result1 = mysqli_query($con, $sql1);
                      while($row1 = mysqli_fetch_assoc($result1)) {
                          $reciever_name = $row1['name'];
                          $reciever_id = $row1['user_id'];
                          echo "<option value='$reciever_id'>$reciever_name (Manager)</option>";
                      }
                      ?>
                      </select>

                       </td>
                     </tr>
                     <tr>
                       <td>
                         Amount type:
                       </td>
                       <td><select class='form-control form-control-user' name='desc'>
                        <option value='rent'>Rent</option>
                        <option value='deposit'>Deposit</option>
                    </select>
                    </td>
                     </tr>
                     <tr>
                       <td>
                         Amount:
                       </td>
                       <td><input type='text' class='form-control form-control-user' name='amount'></td>
                     </tr>
                     <tr>
                       <td>
                         Payment From:
                       </td>
                       <td>
                         <select class="custom-select" name="from" id="terms" style="width:300px;">
                         <option value = "january2024">January <?php echo date('Y'); ?></option>
                         <option value = "february2024">February <?php echo date('Y'); ?></option>
                         <option value = "March <?php echo date('Y'); ?>">March <?php echo date('Y'); ?></option>
                         <option value = "April <?php echo date('Y'); ?>">April <?php echo date('Y'); ?></option>
                         <option value = "May <?php echo date('Y'); ?>">May <?php echo date('Y'); ?></option>
                         <option value = "June <?php echo date('Y'); ?>">June <?php echo date('Y'); ?></option>
                         <option value = "July <?php echo date('Y'); ?>">July <?php echo date('Y'); ?></option>
                         <option value = "August <?php echo date('Y'); ?>">August <?php echo date('Y'); ?></option>
                         <option value = "September <?php echo date('Y'); ?>">September <?php echo date('Y'); ?></option>
                         <option value = "October <?php echo date('Y'); ?>">October <?php echo date('Y'); ?></option>
                         <option value = "November <?php echo date('Y'); ?>">November <?php echo date('Y'); ?></option>
                         <option value = "December <?php echo date('Y'); ?>">December <?php echo date('Y'); ?></option>
                        <!--  <option value = "January <?php echo date('Y')+1; ?>">January <?php echo date('Y')+1; ?></option>
                         <option value = "February <?php echo date('Y')+1; ?>">February <?php echo date('Y')+1; ?></option>
                         <option value = "March <?php echo date('Y')+1; ?>">March <?php echo date('Y')+1; ?></option>
                         <option value = "April <?php echo date('Y')+1; ?>">April <?php echo date('Y')+1; ?></option>
                         <option value = "May <?php echo date('Y')+1; ?>">May <?php echo date('Y')+1; ?></option>
                         <option value = "June <?php echo date('Y')+1; ?>">June <?php echo date('Y')+1; ?></option>
                         <option value = "July <?php echo date('Y')+1; ?>">July <?php echo date('Y')+1; ?></option>
                         <option value = "August <?php echo date('Y')+1; ?>">August <?php echo date('Y')+1; ?></option>
                         <option value = "September <?php echo date('Y')+1; ?>">September <?php echo date('Y')+1; ?></option>
                         <option value = "October <?php echo date('Y')+1; ?>">October <?php echo date('Y')+1; ?></option>
                         <option value = "November <?php echo date('Y')+1; ?>">November <?php echo date('Y')+1; ?></option>
                         <option value = "December <?php echo date('Y')+1; ?>">December <?php echo date('Y')+1; ?></option> -->
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         To:
                       </td>
                       <td>
                         <select class="custom-select" name="to" id="terms" style="width:300px;">
                         <option value = "1">January <?php echo date('Y'); ?></option>
                         <option value = "2">February <?php echo date('Y'); ?></option>
                         <option value = "3">March <?php echo date('Y'); ?></option>
                         <option value = "4">April <?php echo date('Y'); ?></option>
                         <option value = "5">May <?php echo date('Y'); ?></option>
                         <option value = "6">June <?php echo date('Y'); ?></option>
                         <option value = "7">July <?php echo date('Y'); ?></option>
                         <option value = "8">August <?php echo date('Y'); ?></option>
                         <option value = "9">September <?php echo date('Y'); ?></option>
                         <option value = "10">October <?php echo date('Y'); ?></option>
                         <option value = "11">November <?php echo date('Y'); ?></option>
                         <option value = "12">December <?php echo date('Y'); ?></option>
                        <!--  <option value = "January <?php echo date('Y')+1; ?>">January <?php echo date('Y')+1; ?></option>
                         <option value = "February <?php echo date('Y')+1; ?>">February <?php echo date('Y')+1; ?></option>
                         <option value = "March <?php echo date('Y')+1; ?>">March <?php echo date('Y')+1; ?></option>
                         <option value = "April <?php echo date('Y')+1; ?>">April <?php echo date('Y')+1; ?></option>
                         <option value = "May <?php echo date('Y')+1; ?>">May <?php echo date('Y')+1; ?></option>
                         <option value = "June <?php echo date('Y')+1; ?>">June <?php echo date('Y')+1; ?></option>
                         <option value = "July <?php echo date('Y')+1; ?>">July <?php echo date('Y')+1; ?></option>
                         <option value = "August <?php echo date('Y')+1; ?>">August <?php echo date('Y')+1; ?></option>
                         <option value = "September <?php echo date('Y')+1; ?>">September <?php echo date('Y')+1; ?></option>
                         <option value = "October <?php echo date('Y')+1; ?>">October <?php echo date('Y')+1; ?></option>
                         <option value = "November <?php echo date('Y')+1; ?>">November <?php echo date('Y')+1; ?></option>
                         <option value = "December <?php echo date('Y')+1; ?>">December <?php echo date('Y')+1; ?></option> -->
                         </select>
                       </td>
                     </tr>
                     <td>
                         Pin no:
                       </td>
                       <td><input type="password" class="form-control form-control-user" name="password" required></td>
                     </tr>
                     

                     <tr>
                     <td></td>
                     <td><input class='btn btn-primary btn-user btn-lg' type='submit' name='submit' value='Pay'></td>
                     </form>
                     <tr>
                    </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
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
