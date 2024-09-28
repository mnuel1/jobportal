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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE apply_job_post SET status='1', createdAt = NOW() WHERE id_apply='$_GET[id_apply]'";
    if($conn->query($sql) === TRUE) {
        jsonResponse(true, "Job applicant rejected.");
	} else {
		jsonResponse(false, "Something went wrong.");
	}
}

?>