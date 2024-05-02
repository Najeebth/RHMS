<?php
// Include your database connection file
include('conn.php');

// Initialize success message variable
$successMessage = '';

// Check if the 'id' parameter is present in the URL
if(isset($_GET['id'])) {
    
      $id = $_REQUEST['id'];
    
    
    // Construct the DELETE query
    $sql = "DELETE FROM room_rental_registrations WHERE `room_rental_registrations`.`id` = $id";

    $result=mysqli_query($con,$sql);
    if($result){
       
        header('location:house_list.php');
        
    }
}
?>
