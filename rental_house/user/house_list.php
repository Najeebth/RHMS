<?php
session_start();
include "conn.php";



/*if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}*/





// Fetch data from room_rental_registrations table
try {
    $sql = "SELECT * FROM `room_rental_registrations`";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
} catch (Exception $e) {
    $errMsg = $e->getMessage();
    echo $errMsg;
}




 ?>
<script>var data = <?php echo json_encode($data); ?>;</script>
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="zcustom.css" rel="stylesheet">

 <!-- Include your JavaScript file -->
    <script src="sort.js"></script>

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
 <section class="wrapper clearfix">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php
        if (isset($errMsg)) {
          echo '<div style="color:#FF0000;text-align:center;font-size:17px;">' . $errMsg . '</div>';
        }
        ?>
        <!-- Example of dropdown button -->
        <div class="sort-container">
          <button class="dropbtn">Sort By</button>
          <div class="dropdown-content">
             <a onclick="sortByDefault()">Default</a>
            <a onclick="sortByRentIncreasing()">Rent (Low to High)</a>
            <a onclick="sortByRentDecreasing()">Rent (High to Low)</a>
            <a onclick="sortByLastUpdated()">Last Updated</a>
            <a onclick="sortByLastCreated()">Last Created</a>
          </div>
           <!-- Span to display selected option -->

          <span id="selected-option" class="selected-option"></span>
        </div>
        <!-- end  -->
        <h2>List of Property Details</h2>
        <div id="property-details-container"></div> <!-- Container to display property details -->
      </div>
    </div>
  </div>
</section>

<script>

// Function to display property details using JavaScript
function displayPropertyDetails(data) {
  // Get reference to container where property details will be displayed
  var container = document.getElementById('property-details-container');

  // Clear existing contents of the container
  container.innerHTML = '';

  // Loop through property data and create HTML elements for each property
  data.forEach(value => {
    // Create card element for property
    var card = document.createElement('div');
    card.className = 'card card-inverse card-info mb-3';
    card.style.padding = '1%';

    // Construct HTML content for property card
    card.innerHTML = `
      <div class="card-block">
        <div class="row">
          <div class="col-4">
            <h4 class="text-center">Owner Details</h4>
            <p><b>Owner Name: </b>${value.fullname}</p>
            <p><b>Contact Number: </b>${value.mobile}</p>
            <p><b>Alternate Number: </b>${value.alternate_mobile}</p>
            <p><b>Email: </b>${value.email}</p>
          </div>
          <div class="col-5">
            <h4 class="text-center">Room Details</h4>
            <p><b>Plot Number: </b>${value.plot_number}</p>
            <p><b>Rent: </b>${value.rent}</p>
            <p><b>Sale: </b>${value.sale}</p>
            <p><b>Available Rooms: </b>${value.rooms}</p>
            <p><b>Address: </b>${value.address}</p>
            <p style="width: 200px; height: 200px;"><b>Landmark: </b>${value.landmark}</p>
            <p><b>City: </b>${value.city}</p>                       
          </div>
          <div class="col-3">
            <h4>Other Details</h4>
            <p><b>Accommodation: </b>${value.accommodation}</p>
            <p><b>Description: </b>${value.description}</p>
            <p><b>Images</b> (click to view more)</p>
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="thumbnail" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">
                    <img src="${value.image}" width="200" alt="House Thumbnail" onclick="showModal(['${value.image}', '${value.image1}', '${value.image2}'])">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 alert alert-${value.vacant == 0 ? 'danger' : 'success'}" role="alert">
          <p><b>${value.vacant == 0 ? 'Occupied' : 'Vacant'}</b></p>
        </div>
        <button class="add-to-cart-btn btn btn-info" style="position: absolute; right: 10px; bottom: 10px; text-decoration: none;" data-plot-number="${value.plot_number}">Add to cart</button>
      </div>
    `;

    // Append card to container
    container.appendChild(card);
  });

  // Create the modal dynamically
  var modal = document.createElement('div');
  modal.className = 'modal fade';
  modal.id = 'exampleModal';
  modal.tabIndex = '-1';
  modal.role = 'dialog';
  modal.setAttribute('aria-labelledby', 'exampleModalLabel');
  modal.setAttribute('aria-hidden', 'true');

  // Construct the HTML content for the modal
  var modalHTML = `
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-body" id="modalBody">
        </div>
      </div>
    </div>
  `;

  // Set the modal HTML
  modal.innerHTML = modalHTML;

  // Append modal to the document body
  document.body.appendChild(modal);
}

// Function to handle the click event on the thumbnail image
function showModal(imageUrls) {
  // Get reference to the modal body
  var modalBody = document.getElementById('modalBody');

  // Clear existing contents of the modal body
  modalBody.innerHTML = '';

  // Create the carousel HTML
  var carouselHTML = `
    <div id="carouselExample" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
  `;

  // Loop through image URLs to create carousel items
  imageUrls.forEach((imageUrl, index) => {
    carouselHTML += `
      <div class="carousel-item ${index === 0 ? 'active' : ''}">
        <img src="${imageUrl}" class="d-block w-100" alt="Image ${index}">
      </div>
    `;
  });

  // Close the carousel HTML
  carouselHTML += `
      </div>
      <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  `;

  // Append the carousel HTML to the modal body
  modalBody.innerHTML = carouselHTML;

  // Show the modal
  $('#exampleModal').modal('show');
}



// Call displayPropertyDetails function with the data array
displayPropertyDetails(data);



</script>
 

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
