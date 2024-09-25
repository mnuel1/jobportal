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
	$to  = $_POST['to'];

	$subject = escapeInput($conn, $_POST['subject']);
	$message = escapeInput($conn, $_POST['description']);
	$type = 'company';
	$stmt = $conn->prepare("INSERT INTO mailbox (id_fromuser, fromuser, id_touser, subject, message) 
	VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $_SESSION['id_company'], $type, $to, $subject, $message);
	
	if($stmt->execute()) {
		jsonResponse(true, "Email Sent.");
	} else {
		jsonResponse(false, "Something went wrong.");
	}
	
	$stmt->close();
	$conn->close();

} else {
	jsonResponse(false, "Invalid request method.");
}