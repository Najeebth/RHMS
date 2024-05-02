<?php
include 'conn.php';
if (isset($_GET['stat']) && $_GET['stat'] === 'reject') {
        $inquiryID = $_GET['inquiry_id'];
        
       
        $deleteQuery = "UPDATE `inquiries` SET `statuss` = 3 WHERE `inquiry_id` = '$inquiryID'";
       
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Deletion successful, show alert and redirect
            echo '<script>alert("Kindly inform the reason to tenant .");</script>';
            echo '<script>window.location.href = "inquiry.php";</script>';
            exit; // Stop further execution
        } else {
            // Error occurred during deletion, display error message
            echo "Error: " . mysqli_error($con);
        }
    
}
if (isset($_GET['stat']) && $_GET['stat'] === 'approve') {
        $inquiryID = $_GET['inquiry_id'];
        
       
        $deleteQuery = "UPDATE `inquiries` SET `statuss` = 1 WHERE `inquiry_id` = '$inquiryID'";
       
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Deletion successful, show alert and redirect
            echo '<script>alert("Date Approved.");</script>';
            echo '<script>window.location.href = "inquiry.php";</script>';
            exit; // Stop further execution
        } else {
            // Error occurred during deletion, display error message
            echo "Error: " . mysqli_error($con);
        }
    
}



?>