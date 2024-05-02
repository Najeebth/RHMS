
<?php
session_start();
include "conn.php";
if(!($_SESSION['username'] == "Admin")){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
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
  <?php include "navbar.php"; ?>
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
        <div class="container-fluid">
          <h1 class="h3 mb-2 text-gray-800" align = "center">Payments</h1>

          <div class="card shadow mb-4">

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Sender Name</th>
                      <th>Reciever Name</th>
                      <th>Amount Paid </th>
                       <th>Amount Type </th>
                      <th>From</th>
                      <th>To</th>
                      <th>Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $sql = "SELECT * FROM transactions";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $desc = $row['description'];
                    if($desc != "return"){
                    do{
                      $t_id = $row['sender_user_id'];
                      $query = "SELECT * FROM tenant WHERE tenant_id = '$t_id'";
                      $result1 = mysqli_query($con, $query);
                      $row1=mysqli_fetch_assoc($result1);
                      do{
                        $fname = $row1['fname'];
                        $lname = $row1['lname'];
                        $uname = $row1['u_name'];
                        $row1 = mysqli_fetch_assoc($result1);
                      }while ($row1);

                      $receiver_accnt_id = $row['receiver_accntid'];
                      $amount = $row['amount'];
                      $desc = $row['description'];
                      $from = $row['pay_from_date'];
                      $to = $row['pay_to_date'];
                      $sql2 = "SELECT  `accountholdername` FROM `paymentaccount` WHERE `accountid` = '$receiver_accnt_id'";
                      $result2 = mysqli_query($con, $sql2);
                      $row2=mysqli_fetch_assoc($result2);
                      $receiver_name =  $row2['accountholdername'];
                      $currentYear = date('Y');

                      // Construct the date string
                      $dateString = $currentYear . '-' . $to . '-01'; // Assuming day is always 01 for simplicity

                      // Convert the date string to a formatted date
                      $formattedDate = date('F Y', strtotime($dateString));

                      $date = $row['payment_date'];
                        echo '<tr>';
                        echo '<td>'.$fname.' '.$lname.'<br/>('.$uname.')</td>';
                        echo '<td>'." $receiver_name".'</td>';
                        echo '<td>'.number_format($amount).'/-</td>';
                        echo '<td>'.$desc.'</td>';
                        echo '<td>'.$from.'</td>';
                        echo '<td>'.$formattedDate.'</td>';
                        echo '<td>'.$date.'</td>';
                        echo "<td align = 'center'><a href='edit_pay.php?id=".$row['id']."' class='btn btn-success btn-circle'><i class='fas fa-edit'></i></a></td>";
                        echo '</tr>';
                      $row = mysqli_fetch_assoc($result);
                    }while ($row);
                  }
                     ?>

                  </tbody>
                </table>

                <hr>
                <br/>
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                  <tbody>
                    <?php
                    $sql = "SELECT SUM(amount) FROM transactions";
                    $query = mysqli_query($con,$sql);
                    $res = mysqli_fetch_assoc($query);

                    do {
                      $total = $res['SUM(amount)'];
                      $res = mysqli_fetch_assoc($query);
                    } while ($res);

                    echo '<tr>';
                    echo '<td><b><b>TOTAL  AMOUNT</b></b></td>';
                    echo "<td><b><b><span style = 'color:green;'> ".number_format($total).'/-</b></b></td>';
                    echo '</tr>';
                     ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

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
