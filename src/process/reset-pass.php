<?php

session_start();

// Include Database Connection
require_once("../../database/db.php");

// Function to handle JSON responses
function jsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}

// Function to escape input data
function escapeInput($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["acctype"] == "user") {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $_POST["password"], $_POST["email"]);
    } else {
        $stmt = $conn->prepare("UPDATE company SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $_POST["password"], $_POST["email"]);
    }    	
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            jsonResponse(true, "Password reset success!");
        } else {
            jsonResponse(false, "Email does not exist.");
        }
    } else {
        jsonResponse(false, "Reset password failed!");
    }

} else {
    jsonResponse(false, "Invalid request method.");
}


?>