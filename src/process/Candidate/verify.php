<?php

session_start();

// Include Database Connection
require_once("../../../database/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $email = $_GET["email"];
    $active = '1';  // Set active to '1' for activation

    $stmt = $conn->prepare("UPDATE users SET active = ? WHERE email = ?");
    $stmt->bind_param("ss", $active, $email);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Redirect to a success verification page
            header("Location: /src/verified.php");
            exit();
        } else {
            // Redirect to an error page if email is not found or not updated
            header("Location: /src/verified-error.php");
            exit();
        }
    } else {
        // Redirect to an error page if the query fails
        header("Location: /src/verified-error.php");
        exit();
    }

} 


?>