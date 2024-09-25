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
	//Escape Special Characters in String
	$name = escapeInput($conn, $_POST['name']);

	//sql query to check user login
	$stmt = $conn->prepare("UPDATE company SET name= ? 
	WHERE id_company=?");
	$stmt->bind_param("ss", $name, $_SESSION['id_company']);

	if($stmt->execute()) {
		jsonResponse(true, "Name updated.");
	} else {
		jsonResponse(false, "Something went wrong.");
	}
	
	$stmt->close();
	$conn->close();

} else {
	jsonResponse(false, "Invalid request method.");
}