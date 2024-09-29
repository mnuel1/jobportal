<?php

//To Handle Session Variables on This Page
session_start();

if(empty($_SESSION['id_company'])) {
  header("Location: /src/index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../../../database/db.php");


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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id_jobpost = escapeInput($conn, $_GET['id_jobpost']);
	
	$stmt = $conn->prepare("DELETE FROM `job_post` WHERE id_jobpost = ? and id_company = ?");

    // Bind the parameters
    $stmt->bind_param("ss", $id_jobpost, $_SESSION['id_company']);
  
    // Execute the query
    if ($stmt->execute()) {

        jsonResponse(true, "Post deleted successfully.");


    } else {        
        jsonResponse(false, "Something went wrong.");
    }
	//Close database connection. Not compulsory but good practice.
	$stmt->close();
	$conn->close();

} else {
	jsonResponse(false, "Invalid request method.");
}
 