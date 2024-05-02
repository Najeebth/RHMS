<?php

include "conn.php";

// Assuming you've already retrieved the session identity ($id)
$id = $_SESSION['identity'];
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

?>
 
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">

        <div class="sidebar-brand-text mx-3">Rental House Management System</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="home.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
     <hr class="sidebar-divider">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
    <i class="fas fa-home fa-cog"></i>
    <span>House</span>
  </a>
  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="house_list.php">Find Home</a>
      <a class="collapse-item" href="cart.php">Cart</a>
    </div>
  </div>
</li>
<hr class="sidebar-divider">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
    <i class="fas fa-user fa-cog"></i>
    <span>Profile</span>
  </a>
  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="u_personal.php">Personal Information</a>
      <a class="collapse-item" href="u_contact.php">Contact Information</a>
      <a class="collapse-item" href="upay.php">Payment Information</a>
      <a class="collapse-item" href="u_contract.php">Contract</a>
    </div>
  </div>
</li>
<hr class="sidebar-divider">
  
   
    <!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
  <i class="fas fa-fw fa-comments"></i>

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
 <i class="fas fa-fw fa-dollar-sign"></i>

    <span>Pay here</span>
  </a>
  <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Details:</h6>
      <a class="collapse-item" href="pay.php">Make payment</a>
      <a class="collapse-item" href="my_payaccount.php">My account</a>
      <a class="collapse-item" href="add_payaccount.php">Add account</a>
      
    </div>
  </div>
</li>

    <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="inquiry.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Inquries</span>
        </a>

      </li>


      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="form_in.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Tenant-In form</span>
        </a>

      </li>
     
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="u_change.php">
          <i class="fas fa-fw fa-exchange-alt"></i>
          <span>Change Password</span>
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- <li class="nav-item">
        <a class="nav-link" href="cart.php">
          <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Cart</span></a>
      </li>  -->

      <!-- Nav Item - Tables -->

      <!-- Divider -->
     <!-- <hr class="sidebar-divider d-none d-md-block">-->

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>