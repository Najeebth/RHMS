<?php
session_start();
include "conn.php";
if(!$_SESSION['username']){
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

                $uname = $_SESSION['username'];

                $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                $result = mysqli_query($con, $query);
                $row=mysqli_fetch_assoc($result);
                do{
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $full = $fname." ".$lname;
                  echo $full;
                  $row = mysqli_fetch_assoc($result);
                }while ($row);

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
          <h1 class="h3 mb-2 text-gray-800" align="center">Payment Information.</h1>
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Payment to</th>
                      <th>Amount </th>
                      <th>Payment Type</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   
                      $id = $_SESSION['identity'];
                      
                    $sql = "SELECT * FROM transactions WHERE sender_user_id = '$id'";
                    $sql3 = "SELECT * FROM contract WHERE tenant_id = '$id' AND status = 'Active'";
                    $result = mysqli_query($con, $sql);
                    $result3 = mysqli_query($con, $sql3);
                    $row = mysqli_fetch_assoc($result);
                    $row3 = mysqli_fetch_assoc($result3);
                    $total = 0;
                    do{
                      do {
                        // $cid = $row3['contract_id'];
                        $reciever_accntid = $row['receiver_accntid'];
                        $query = "SELECT p.accountholdername 
                        FROM transactions t 
                        JOIN paymentaccount p ON t.receiver_accntid = p.accountid 
                        WHERE t.receiver_accntid = '$reciever_accntid'";
                        $result4 = mysqli_query($con, $query);
                        $row4 = mysqli_fetch_assoc($result4);
                        $accountholdername = $row4['accountholdername'];

                        $amount = $row['amount'];
                        $description = $row['description'];
                        $payment_date = $row['payment_date'];
                       
                        echo '<tr>';
                        echo '<td>'. $accountholdername.'</td>';
                        echo '<td>'.number_format($amount).'/-</td>';
                        echo '<td>'.$description .'</td>';
                        echo '<td>'.$payment_date .'</td>';
                        echo '</tr>';
                        $total += $amount;
                        $row3 = mysqli_fetch_assoc($result3);
                      } while ($row3);
                      $row = mysqli_fetch_assoc($result);
                    }while ($row);
                    echo "<tr><td colspan=2 ><b><b><b>TOTAL</b></b></b></td><td colspan=2  style = 'color:green;'><b><b>".number_format($total)."/-</b></b></td></tr>";
                     ?>

                  </tbody>
                </table>
                <hr>
                <br/>
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                  <tbody>
                    <?php
                    $sql1 = "SELECT * FROM contract WHERE tenant_id = '$id'";
                    $result1 = mysqli_query($con, $sql1);
                    $row1 = mysqli_fetch_assoc($result1);
                    do{
                      $total_rent = (int)$row1['total_rent'];
                      $deposit = (int)$row1['deposit'];
                      $row1 = mysqli_fetch_assoc($result1);
                    }while($row1);

                    echo '<tr>';
                    echo '<td><b><b>TOTAL RENT:</b></b></td>';
                    echo "<td style = 'color:green;'><b><b>Tsh. ".number_format($total_rent)."/=</b></b></td>";
                    echo '</tr>';
                    $total = $total -   $deposit ;
                    $diff = $total_rent - $total;

                    echo '<tr>';
                    echo "<td><b><b>ARREARS:</b></b></td>";
                    echo "<td><b><b><span style = 'color:red;'>Tsh. ".number_format($diff)."/=</span></b></b></td>";
                    echo '</tr>';
                     ?>

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
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; RHMS 2019</span>
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
          <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>

</html>
