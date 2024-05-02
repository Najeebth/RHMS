<?php
session_start();
include "conn.php";
// if(!($_SESSION['username'] == "Admin")){
//   echo '<script>window.location.href = "login.php";</script>';
//   exit();
// }
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

   <!-- Custom fonts for this template -->
   <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="../css/sb-admin-2.min.css" rel="stylesheet">

   <!-- Custom styles for this page -->
   <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

 </head>

 <body id="page-top">

   <!-- Page Wrapper -->
   <div id="wrapper">

     <!-- Sidebar -->
    <?php include "navbar.php"; ?>
         <!-- End of Topbar -->

         <!-- Begin Page Content -->
         <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-2 text-gray-800" align = "center">Contracts</h1>
           <p style="color:red;"><b><b>Please choose a contract to change from the table showing contract information.</b></b></p>


           <!-- DataTales Example -->
           <div class="card shadow mb-4">
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                   <tbody>
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                       <tr>
                         <td>
                           Contract ID:
                         </td>
                         <td><input type='text' class='form-control form-control-user' name='id' value = "<?php echo  @$_GET['id']; ?>" readonly></td>
                       </tr>

                    <!--  <tr>
                       <td>
                         Please click the price of the house you want to rent:
                       </td>
                       <td>
                         <input type="radio" name="price" value = "50000" required>Tsh. 50,000&nbsp
                         <input type="radio" name="price" value = "60000">Tsh. 60,000&nbsp
                         <input type="radio" name="price" value = "70000">Tsh. 70,000&nbsp
                         <input type="radio" name="price" value = "80000">Tsh. 80,000
                       </td>
                     </tr> -->
                    <!--  <tr>
                       <td>
                       </td>
                       <td>
                         <select class="custom-select" name="house" id = "values" style="width:200px;">

                         </select>
                       </td>
                     </tr> -->
                     <tr>
                       <td>
                         Contract Duration:
                       </td>
                       <td>
                         <select class="custom-select" name="duration" style="width:300px;">
                           <option  value = "0">0 months</option>
                           <option  value = "1">1 months</option>
                           <option  value = "3">3 months</option>
                           <option value = "6">6 months</option>
                           <option value = "12">12 months</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Payment Terms:
                       </td>
                       <td>
                        <input type='text' class='form-control form-control-user' name='term' id="term">
                       </td>
                     </tr>
                     <tr>
                     <td></td>
                     <td><input class='btn btn-success btn-user btn-lg' type='submit' name='submit' value='Edit'></td>
                     </form>
                     <tr>
                   </tbody>
                   <?php
                   if(isset($_POST["submit"])){
                     $id = $_POST['id'];
                    $query = "SELECT * FROM contract WHERE contract_id = '$id' ";
                     $result = mysqli_query($con, $query);
                     $row = mysqli_fetch_assoc($result);
                     do{
                       $hid = $row['house_id'];
                       $end_day = $row['end_day'];
                       $rent_per_term = $row['rent_per_term'];
                       $duration_month = $row['duration_month'];
                       $total_rent = $row['total_rent'];
                        $tenant_id = $row['tenant_id'];
                       $row = mysqli_fetch_assoc($result);
                     }while ($row);

                     $dur =  (int)$_POST['duration'];
                     $duration_month = $duration_month+$dur;
// Create DateTime object from the date string
$date = new DateTime($end_day);

// Add the duration to the date
$date->add(new DateInterval('P' . $dur . 'M'));
$newDateStr = $date->format('Y-m-d');


 $term = $_POST['term'];

    // If the value is empty, set it to 0
    if (empty($term)) {
        $term = $rent_per_term;
    }
       $total =   $term*$dur ;
       $total_rent = $total_rent + $total ;       

$sql ="UPDATE `contract` SET `duration_month`='$duration_month',`total_rent`='$total_rent',`rent_per_term`='$term',`end_day`='$newDateStr' WHERE contract_id = '$id' ";
$result = mysqli_query($con,$sql);

if($result){
  // Convert end_day and newDateStr to DateTime objects
$end_day = new DateTime($end_day);
$newDate = new DateTime($newDateStr);

// Initialize an array to store the dates
$dates = array();

// Loop through each month and calculate the dates
while ($end_day < $newDate) {
    // Add 1 month to the end_day
    $end_day->add(new DateInterval('P1M'));

    // Add the date to the dates array
    $dates[] = $end_day->format('Y-m-d'); // Format as yyyy-mm-dd
}
foreach ($dates as $date) {
    // Insert $date into your database
    $query = "INSERT INTO `reminders`( `tenant_id`, `title`, `payment_date`, `amount`, `is_paid`) VALUES (' $tenant_id ','Rent','$date',' $term',0)";
    mysqli_query($con , $query);
    echo "<script>alert('Contract extended')</script>";
}
}
                     // $house = (int)$_POST["house"];
                     // $dur =  (int)$_POST['duration'];
                     // $dur1 =  $dur - 1;
                     // $rent = (int)$_POST['term'];
                     // $price = (int)$_POST['price'];
                     // $stat = "Active";
                     // $total_rent = $dur * $price;
                     // $rent_term = $total_rent / $term;
                     // $date_sign = date("Y-m-d H:i:s");
                     // $contract = 'Occupied';
                     // if(date('d')<27){
                     //   $end = date('Y-m-t', strtotime('+'.$dur1.' month'));
                     // }else{
                     //   $end = date('Y-m-t', strtotime('+'.$dur1.' month'));
                     // }
                     // if((date('d')<27)){
                     //   $start = date('Y-m-01');
                     // }else{
                     //   $start = date('Y-m-01', strtotime('+1 month'));
                     // }

}
                     // $query = "SELECT * FROM contract WHERE tenant_id = '$id' ";
                     // $result = mysqli_query($con, $query);
                     // $row = mysqli_fetch_assoc($result);
                     // do{
                     //   $hid = $row['house_id'];

                     //   $row = mysqli_fetch_assoc($result);
                     // }while ($row);

                     // if($id != ""){
                     //   if ($dur == 3) {
                     //     if (!($term == 1)) {
                     //       echo "<script> alert('3 months cannot have more than 1 term.');</script>";
                     //     }else {
                     //       $sql = "UPDATE contract SET house_id = '$house', duration_month = '$dur', total_rent = '$total_rent', terms = '$term', rent_per_term = '$rent_term', start_day = '$start', end_day ='$end', date_contract_sign = '$date_sign' WHERE tenant_id = '$id' AND status = '$stat'";
                     //       if(mysqli_query($con, $sql)){
                     //         $sql1 = "UPDATE house SET status= 'Empty' WHERE house_id = '$hid'";
                     //         mysqli_query($con, $sql1);
                     //         $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                     //         mysqli_query($con, $sql3);
                     //         mysqli_close($con);
                     //         echo "<script type='text/javascript'>alert('Updated Successfully!!!');</script>";
                     //         echo '<style>body{display:none;}</style>';
                     //         echo '<script>window.location.href = "contract_detail.php";</script>';
                     //         exit;
                     //     }
                     //   }
                     //   }elseif($dur == 6){
                     //       if ($term == 4) {
                     //         echo "<script type='text/javascript'>alert('6 months cannot have more than 2 term.');</script>";
                     //       }else {
                     //         $sql = "UPDATE contract SET house_id = '$house', duration_month = '$dur', total_rent = '$total_rent', terms = '$term', rent_per_term = '$rent_term', start_day = '$start', end_day ='$end', date_contract_sign = '$date_sign' WHERE tenant_id = '$id' AND status = '$stat'";
                     //         if(mysqli_query($con, $sql)){
                     //           $sql1 = "UPDATE house SET status= 'Empty' WHERE house_id = '$hid'";
                     //           mysqli_query($con, $sql1);
                     //           $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                     //           mysqli_query($con, $sql3);
                     //           mysqli_close($con);
                     //           echo "<script type='text/javascript'>alert('Updated Successfully!!!');</script>";
                     //           echo '<style>body{display:none;}</style>';
                     //           echo '<script>window.location.href = "contract_detail.php";</script>';
                     //           exit;
                     //       }
                     //     }
                     //   }elseif ($dur == 12) {
                     //     $sql = "UPDATE contract SET house_id = '$house', duration_month = '$dur', total_rent = '$total_rent', terms = '$term', rent_per_term = '$rent_term', start_day = '$start', end_day ='$end', date_contract_sign = '$date_sign' WHERE tenant_id = '$id' AND status = '$stat'";
                     //     if(mysqli_query($con, $sql)){
                     //       $sql1 = "UPDATE house SET status= 'Empty' WHERE house_id = '$hid'";
                     //       mysqli_query($con, $sql1);
                     //       $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                     //       mysqli_query($con, $sql3);
                     //       mysqli_close($con);
                     //       echo "<script type='text/javascript'>alert('Updated Successfully!!!');</script>";
                     //       echo '<style>body{display:none;}</style>';
                     //       echo '<script>window.location.href = "contract_detail.php";</script>';
                     //       exit;
                     //     }
                     //   }
                     // }else {
                     //   echo "<script type='text/javascript'>alert('Please choose a contract to change from the table showing contract information.');</script>";
                     //   echo '<style>body{display:none;}</style>';
                     //   echo '<script>window.location.href = "contract_detail.php";</script>';
                     //   exit;

                     // }





                 
                    ?>
                 </table>
               </div>
             </div>
           </div>

         </div>
         <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->

       <!-- Footer -->
       <footer class="sticky-footer bg-white">
         <div class="container my-auto">
           <div class="copyright text-center my-auto">
             <span>Copyright &copy; RHMS 2024</span>
           </div>
         </div>
       </footer>
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
           <a class="btn btn-success" href="logout.php">Logout</a>
         </div>
       </div>
     </div>
   </div>


   <script type="text/javascript">
       $(document).ready(function(){
           $("input[name='price']").click(function(){
               var radioValue = $("input[name='price']:checked").val();
               if(radioValue == 50000){
                 var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                   mysqli_select_db($con,'rental_house');
                   $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '50000' AND status = 'Empty'";
                   $res = mysqli_query($con, $sql);
                   $row = mysqli_fetch_assoc($res);


                   if (mysqli_num_rows($res) > 0) {

                     do{

                       echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                       $row = mysqli_fetch_assoc($res);
                     }while ($row);

                   }else {

                     echo "<option selected disabled>No rooms available</option>";

                   }


   ?>";
                 document.getElementById("values").innerHTML = out;

               }else if (radioValue == 60000) {
                   var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                     mysqli_select_db($con,'rental_house');
                     $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '60000' AND status = 'Empty'";
                     $res = mysqli_query($con, $sql);
                     $row = mysqli_fetch_assoc($res);
                     if (mysqli_num_rows($res) > 0) {

                       do{

                         echo "<option value ='".$row["house_id"]."' selected>".$row["house_name"]."</option>";
                         $row = mysqli_fetch_assoc($res);
                       }while ($row);

                     }else {

                       echo "<option selected disabled>No rooms available</option>";

                     }

                     ?>";
                   document.getElementById("values").innerHTML = out;
               }else if (radioValue == 70000) {
                   var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                     mysqli_select_db($con,'rental_house');
                     $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '70000' AND status = 'Empty'";
                     $res = mysqli_query($con, $sql);
                     $row = mysqli_fetch_assoc($res);

                     if (mysqli_num_rows($res) > 0) {

                       do{

                         echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                         $row = mysqli_fetch_assoc($res);
                       }while ($row);

                     }else {

                       echo "<option selected disabled>No rooms available</option>";

                     }

     ?>";
                   document.getElementById("values").innerHTML = out;
               }else {
                   var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                     mysqli_select_db($con,'rental_house');
                     $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '80000' AND status = 'Empty'";
                     $res = mysqli_query($con, $sql);
                     $row = mysqli_fetch_assoc($res);

                     if (mysqli_num_rows($res) > 0) {

                       do{

                         echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                         $row = mysqli_fetch_assoc($res);
                       }while ($row);

                     }else {

                       echo "<option selected disabled>No rooms available</option>";

                     }

     ?>";
                   document.getElementById("values").innerHTML = out;
               }
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
   <script src="../js/jquery.min.js"></script>

   <!-- Page level plugins -->
   <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

   <!-- Page level custom scripts -->
   <script src="../js/demo/datatables-demo.js"></script>

 </body>

 </html>
