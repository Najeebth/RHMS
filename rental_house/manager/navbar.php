<?php
// Receiver ID
$uname=$_SESSION['username'];
$sql1="SELECT `user_id` FROM `user` WHERE `u_name`='$uname'";
$result=mysqli_query($con,$sql1);
$row = mysqli_fetch_assoc($result);
$id=$row['user_id'];
//end of receiver id
// Execute query to count unread messages
$countQuery = "SELECT COUNT(*) AS unreadCount FROM `messages` WHERE `status` = 'unread' AND `receiver_id` = '$id'";
$countResult = mysqli_query($con, $countQuery);

// Check if the query executed successfully
if ($countResult) {
    // Fetch the count
    $unreadCount = mysqli_fetch_assoc($countResult)['unreadCount'];
} else {
    // Handle query error
    $unreadCount = 0; // Set unread count to 0 if there's an error
}
//Inquiries
$countQuery1 = "SELECT COUNT(*) AS pendingCount FROM `inquiries` WHERE `statuss` = 2 AND `landlord_id` = '$id'";
$countResult1 = mysqli_query($con, $countQuery1);

// Check if the query executed successfully
if ($countResult1) {
    // Fetch the count
    $pendingCount = mysqli_fetch_assoc($countResult1)['pendingCount'];
} else {
    // Handle query error
    $pendingCount = 0; // Set unread count to 0 if there's an error
}
?>



<!-- Sidebar -->
<br>
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="manager_home.php" >

        <div class="sidebar-brand-text mx-3">Rental House Management System</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">

      <!-- Nav Item  -->
      <li class="nav-item">
        <a class="nav-link" href="manager_home.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Tenant</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->


              <!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
 <i class="fas fa-fw fa-dollar-sign"></i>

    <span>Payment</span>
  </a>
  <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="list.php">List of payments</a>
      <a class="collapse-item" href="my_payaccount.php">My account</a>
      <a class="collapse-item" href="add_payaccount.php">Add account</a>
      
    </div>
  </div>
</li>



      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-home fa-cog"></i>
          <span>House</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Details:</h6>
            <a class="collapse-item" href="house_list.php">House Information</a>
            <a class="collapse-item" href="manager_house_reg.php">Add a House</a>
            
            
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
          <!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
    <i class="fas fa-fw fa-comments"></i>
       <!-- Notification Badge -->
  
<?php if ($unreadCount > 0): ?>
    <span class="badge badge-danger badge-counter"><?php echo $unreadCount; ?></span>
<?php endif; ?>

    <span>Message</span>

  </a>
  <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="inbox.php">Inbox</a>
      <a class="collapse-item" href="send_message.php">Send Message</a>
    </div>
  </div>
</li>

<hr class="sidebar-divider">

          <!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
 <i class="fas fa-file-contract"></i>
    <span>Contract</span>
  </a>
  <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="new_contract.php">New Contract</a>
      <a class="collapse-item" href="contract_detail.php">Contract Details</a>
      
    </div>
  </div>
</li>
<hr class="sidebar-divider">


      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="inquiry.php">
       <i class="fas fa-envelope"></i>
             <!-- Notification Badge -->
  
<?php if ($pendingCount > 0): ?>
    <span class="badge badge-danger badge-counter"><?php echo $pendingCount; ?></span>
<?php endif; ?>

          <span>Inquries</span>
        </a>
<hr class="sidebar-divider">


      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="mform_out.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Tenant-Out form</span>
        </a>

      </li>
      <hr class="sidebar-divider">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="m_change.php">
          <i class="fas fa-fw fa-exchange-alt"></i>
          <span>Change Password</span>
        </a>
        <hr class="sidebar-divider">

      </li>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>


    </ul>
    <!-- End of Sidebar -->