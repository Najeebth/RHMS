<?php
session_start();
// Assuming you've included your database connection code
include "conn.php";

// Check if message IDs were sent in the POST request
if (isset($_POST['read'])) {
    $messageIds = $_POST['message_ids'];
    $success = true;

    // Prepare the SQL update query to mark messages as read
    $stmt = $con->prepare("UPDATE messages SET status = 'read' WHERE msg_id = ?");

    foreach ($messageIds as $id) {
        // Ensure the current ID is an integer to prevent SQL injection
        $id = intval($id);

        // Bind the message ID to the prepared statement
        $stmt->bind_param("i", $id);

        // Execute the statement and check the result
        if ($stmt->execute()) {

             header('Location: inbox.php');
        }
    }

    // Close the statement
    $stmt->close();
}

// Check if message IDs were sent in the POST request
if (isset($_POST['delete'])) {
    $messageIds = $_POST['message_ids'];
    $success = true;

    // Prepare the SQL update query to mark messages as read
    $stmt = $con->prepare("DELETE FROM messages WHERE msg_id = ?");

    foreach ($messageIds as $id) {
        // Ensure the current ID is an integer to prevent SQL injection
        $id = intval($id);

        // Bind the message ID to the prepared statement
        $stmt->bind_param("i", $id);

        // Execute the statement and check the result
        if ($stmt->execute()) {

             header('Location: inbox.php');
        }
    }

    // Close the statement
    $stmt->close();
}


// Check if the 'reply' button is clicked
if (isset($_POST['reply'])) {
    // Retrieve the sender ID, receiver ID, and reply message from the form data
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    //$msg_id = $_POST['msg_id'];
    $reply_message = $_POST['reply_message'];
    $uname = $_SESSION['username'];
    $status = "unread";

    // Prepare the SQL statement with parameterized query
    $sql = "INSERT INTO messages (sender_id, receiver_id, message, created_at, sender_username, status) VALUES (?, ?, ?, NOW(), ?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "iisss", $sender_id, $receiver_id, $reply_message, $uname, $status);

    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    // Check if the query was successful
    if ($result) {
        //  // Display an alert message using JavaScript
         echo "<script>alert('Message sent successfully');</script>";
       
        
        // // Redirect the user to a success page after a short delay
         echo "<script> window.location = 'inbox.php'; </script>";
        
       
       }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

}


?>
