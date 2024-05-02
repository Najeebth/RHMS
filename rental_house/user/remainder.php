<?php

include "conn.php";
$user_id = $_SESSION['identity'];


$sql = "SELECT * FROM reminders WHERE tenant_id = $user_id AND is_paid = FALSE ";
$result = $con->query($sql);

// Check if there are any upcoming reminders
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate the number of days left until the event
        $payment_date = strtotime($row['payment_date']);
        $payment_date1 = $row['payment_date'];
        $id = $row['id'];
        $month = date('m', strtotime($payment_date1));
       

  $sql1 = "SELECT * FROM transactions WHERE sender_user_id = $user_id  AND description = 'rent' AND pay_to_date = '$month'";
  $result1 = $con->query($sql1);   
  if ($result1->num_rows > 0) {
    $sql2 = " UPDATE `reminders` SET `is_paid`=TRUE WHERE id = '$id'";
    mysqli_query($con,$sql2);



  }
      

        } 

      }





// ------------------------------------------------------------------------------------------------------------------------------------------------------//








// Fetch upcoming reminders from the database for the current user
$tenant_id = $user_id; // Assuming the current user's tenant ID is 15
$current_date = date('Y-m-d'); // Get the current date
$sql = "SELECT * FROM reminders WHERE tenant_id = $tenant_id AND payment_date >= '$current_date' AND is_paid = FALSE ORDER BY payment_date ASC LIMIT 1";
$result = $con->query($sql);

// Check if there are any upcoming reminders
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate the number of days left until the event
        $payment_date = strtotime($row['payment_date']);
        $desc = $row['title'];
        $amount = round($row['amount']);
        $days_left = ceil(($payment_date - time()) / (60 * 60 * 24));
        

        } 




?>

</head>
<body>
  <!-- Expenses Card Example -->
            <div class="col-xl-3 col-md-6 mb-4" >
              <div class="card shadow h-100 py-2" style="border-color: <?php echo getColor($days_left); ?>;">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-md font-weight-bold  text-uppercase mb-1" style="color: <?php echo getColor($days_left); ?>;"><?php echo $desc .'-'. $amount ?></div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                      $sql = "SELECT * FROM `room_rental_registrations` WHERE `user_id` = '$landlord_id' ";
                      $query = mysqli_query($con,$sql);
                      $num = mysqli_num_rows($query);
                       echo $days_left." &nbsp;Days left";
                       ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-hourglass-start fa-2x text-gray-300"></i> <!-- Example of a countdown starting icon -->

                    </div>
                  </div>
                </div>
              </div>
            </div>


<?php }
// Function to determine color based on days left
function getColor($days_left) {
    if ($days_left <= 5) {
        return '#e74c3c'; // Red color for 5 or fewer days left
    } elseif ($days_left <= 10) {
        return '#f39c12'; // Orange color for 6-10 days left
    } else {
       return '#2ecc71'; // Default color for more than 10 days left
    }
}
?>
</body>
</html>
