<?php
session_start();
include "conn.php";
 if (isset($_POST['dates']) && !empty($_POST['dates'])) {
        // Get the selected dates
        $dates = $_POST['dates'];
        $tenant_id = $_SESSION['identity'];
       $house_id = $_REQUEST['house_id'];

        $stmt = "SELECT `user_id` FROM `room_rental_registrations` WHERE `id`= '$house_id'";
        $result = mysqli_query($con, $stmt);
        $row = mysqli_fetch_assoc($result);
        $landlord_id = $row['user_id'];
        $query="SELECT `inquiry_date` FROM `inquiries` WHERE `tenant_id` = ' $tenant_id '  AND `house_id` = ' $house_id'";
        $result1= mysqli_query($con,$query);
        $row1 = mysqli_fetch_assoc($result1);
          // Check if there are existing dates for this house and landlord
        if (mysqli_num_rows($result1) > 0) {
                
                $existing_date = $row1['inquiry_date'];
               echo "<script>alert('You have already set a date: $existing_date');";
    echo "window.location.href = 'send_inquiry.php';</script>";
    exit; 
} 
         
        else {
                $sql = "INSERT INTO `inquiries`(`house_id`, `tenant_id`, `landlord_id`, `inquiry_date`, `statuss`) VALUES ('$house_id', '$tenant_id', '$landlord_id', '$dates', 2)";

                 // Execute the SQL statement
                if (mysqli_query($con, $sql)) {
                    echo '<script>alert("Date set successfully");</script>';
                } 
            }
        } 
$tenant_id = $_SESSION['identity'];
$sql1="SELECT `house_id`, `landlord_id`, `inquiry_date`, `statuss` FROM `inquiries` WHERE `tenant_id`= $tenant_id";
$result2=mysqli_query($con, $sql1);
// Initialize an empty array to store the extracted information
$inquiriesArray = array();

    while ($row = mysqli_fetch_assoc($result2)) {
        // Add each row (as an associative array) to the $inquiriesArray
        $inquiriesArray[] = $row;
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
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- SB Admin 2 CSS -->
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
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php
                                include "conn.php";
                                $uname = $_SESSION['username'];
                                $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                                $result = mysqli_query($con, $query);
                                $row=mysqli_fetch_assoc($result);
                                $fname = $row['fname'];
                                echo $fname;
                                ?>
                            </span>
                            <img class="img-profile rounded-circle" src="user.png">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Main Content -->
          <!-- Main Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Choose Viewing Dates</h1>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                   
                </div>
                <div class="card-body">
                    <form id="dateForm" method="POST">
                        <div class="form-group">
                            <label for="dates">Select Viewing Dates:</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" id="dates" name="dates" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Viewing Schedule</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Insert rows dynamically based on data -->
           <?php
// Assuming you already have the $inquiriesArray populated with data from the inquiries table
// Reverse the $inquiriesArray
$reversedArray = array_reverse($inquiriesArray);

foreach ($reversedArray as $inquiry) {
    // Fetch landlord name and house ID using respective IDs
    $house_id = $inquiry['house_id'];
    $landlord_id = $inquiry['landlord_id'];

    // Fetch landlord name
    $sql_landlord = "SELECT `u_name` FROM `user` WHERE `user_id` = $landlord_id";
    $result_landlord = mysqli_query($con, $sql_landlord);
    $landlord_row = mysqli_fetch_assoc($result_landlord);
    $landlord_name = $landlord_row['u_name'];

    // Fetch house name from room_rental_registrations
    $sql_house = "SELECT `fullname` FROM `room_rental_registrations` WHERE `id` = $house_id";
    $result_house = mysqli_query($con, $sql_house);
    $house_row = mysqli_fetch_assoc($result_house);
    $house_name = $house_row['fullname'];

    // Display the data in the div
    echo '<tr>';
   echo '<td>' . 'owner name' . ':' . $landlord_name . '<br>' . 'House name' . ':' . $house_name . '</td>';  
    echo '<td>' . $inquiry['inquiry_date'] . '</td>'; // Display inquiry date
    echo '<td>';
    if ($inquiry['statuss'] == 2) {
        echo '<div class="alert alert-warning" role="alert"><b>Pending</b></div>';
    } elseif ($inquiry['statuss'] == 3) {
        echo '<div class="alert alert-danger" role="alert"><b>Rejected</b></div>';
    } elseif ($inquiry['statuss'] == 1) {
        echo '<div class="alert alert-success" role="alert"><b>Approved</b></div>';
    }
    echo '</td>';
    echo '</tr>';
}
?>


                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->

            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Logout Modal -->
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $("#dates").datepicker({
                format: 'yyyy-mm-dd', // Set the date format
                multidate: false, 
                todayHighlight: true, // Highlight today's date
                autoclose: true // Close the datepicker when a date is selected
            });

           
                if (!selectedDates) {
                    alert("Please select at least one date for viewing.");
                    event.preventDefault(); // Prevent form submission
                }
            
        });
    </script>
    <!-- Prevent form resubmission on page reload -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
