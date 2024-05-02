<?php
session_start();
include "conn.php";


//user_id fetch
  $uname = $_SESSION['username'];
    // Prepare and execute the query to fetch tenant_id
    $stmt = $con->prepare("SELECT tenant_id FROM tenant WHERE u_name = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->bind_result($tenant_id);
    $stmt->fetch();
    $stmt->close();

// Retrieve plot_number from the POST request
$plot_number = $_POST['plot_number'];

// Check if the house is already in the user's cart
$checkQuery = $con->prepare("SELECT COUNT(*) FROM cart WHERE tenant_id = ? AND plot_number = ?");
$checkQuery->bind_param("is", $tenant_id, $plot_number);
$checkQuery->execute();
$checkQuery->bind_result($count);
$checkQuery->fetch();
$checkQuery->close();

// If the count is greater than 0, the house is already in the cart
if ($count == 0) {
    


// Insert house into user's cart
$stmt = $con->prepare("INSERT INTO cart (tenant_id, plot_number) VALUES (?, ?)");
$stmt->bind_param("is", $tenant_id, $plot_number);
header('Content-Type: application/json');
if ($stmt->execute()) {
    // Success
    echo json_encode(array("status" => "success", "message" => "House added to cart successfully"));
} else {
    // Error
    echo json_encode(array("status" => "error", "message" => "Already in cart"));
}
$stmt->close();

}
?>