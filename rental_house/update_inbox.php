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





?>
