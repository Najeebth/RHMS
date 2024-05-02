<?php
// Include your database connection file
include('conn.php');



// Check if the 'id' parameter is present in the URL
if(isset($_GET['plot_number'])) {
    
      $plot_number = $_REQUEST['plot_number'];
    
    
    // Construct the DELETE query
    $sql = "DELETE FROM cart WHERE `cart`.`plot_number` = '$plot_number'";


    $result=mysqli_query($con,$sql);
    if($result){
       
        header('location:cart.php');
        
    }
}
?>
