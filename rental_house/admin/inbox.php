<?php
session_start();
include "conn.php";
// Receiver ID
$uname=$_SESSION['username'];
$sql1="SELECT `user_id` FROM `user` WHERE `u_name`='$uname'";
$result=mysqli_query($con,$sql1);
$row = mysqli_fetch_assoc($result);
$receiver_id=$row['user_id'];
//end of receiver id

$sql = "SELECT * FROM messages WHERE receiver_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $receiver_id);
$stmt->execute();
$result = $stmt->get_result();
$data = array(); // Initialize an empty array to store the fetched rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Push each fetched row into the array
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
  <link href="../user/zcustom.css" rel="stylesheet">
  <style>
  

  </style>

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
               echo $uname;

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
<form action="update_inbox.php" method="post">
    <div class="inbox">
        <div class="toolbar">
            <button type="button" id="checkAllBtn" class="btn btn-primary" style="margin-left: 10px;">Check All</button>
            <button id="deleteBtn" name="delete" class="btn btn-danger float-right" style="margin-right: 13px;">Delete</button>
            <button type="submit" id="readBtn" name="read" class="btn btn-warning float-right" style="margin-right: 5px;">Read</button>

            <h1 class="h3 mb-2 text-gray-800" align="center">Inbox</h1>
        </div>

        <?php foreach (array_reverse($data) as $message): ?>
            <div class="message">
                <input type="checkbox" name="message_ids[]" value="<?php echo $message['msg_id']; ?>" id="message<?php echo $message['msg_id']; ?>">
                <label for="message<?php echo $message['msg_id']; ?>">
                    <div class="message-header">
                        <span class="sender"><?php echo $message['sender_username']; ?></span>
                        <span class="date"><?php echo date('d F', strtotime($message['created_at'])); ?></span>
                    </div>
                    <div class="message-content <?php echo $message['status'] == 'unread' ? 'bold' : ''; ?>">
                        <p><?php echo $message['message']; ?></p>
                          <!-- reply button -->
                        <div class="col-md-12 text-right">
                            <input type="hidden" name="sender_id" value="<?php echo $message['receiver_id']; ?>">
                            <input type="hidden" name="receiver_id" value="<?php echo $message['sender_id']; ?>">
                            <textarea name="reply_message" class="replyInput" rows="1" cols="30" placeholder="Type your reply here..."></textarea>
                            <button type="submit" id="replyBtn" name="reply" class="btn btn-primary btn-sm"  style="margin-top: -23px;">Reply</button>
                        </div>
                        <!-- End of reply -->
                    
                    </div>
                </label>

            </div>
        <?php endforeach; ?>
    </div>
</form>

 
     




     
 
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
<script>
// Get the check all button and all message checkboxes
var checkAllBtn = document.getElementById('checkAllBtn');
var messageCheckboxes = document.querySelectorAll('.message input[type="checkbox"]');

// Add event listener to check all button
checkAllBtn.addEventListener('click', function() {
    // Loop through all message checkboxes
    messageCheckboxes.forEach(function(checkbox) {
        // Toggle the checked state of each checkbox
        checkbox.checked = !checkbox.checked;
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
