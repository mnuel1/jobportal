<?php

//To Handle Session Variables on This Page
session_start();

if(empty($_SESSION['id_user'])) {
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


//If user Actually clicked login button 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	//Escape Special Characters in String
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	//Encrypt Password
	$password = password_hash($password, PASSWORD_DEFAULT);

	//sql query to check user login
	$sql = "UPDATE users SET password='$password' WHERE id_users='$_SESSION[id_user]'";
	if($conn->query($sql) === true) {
		jsonResponse(true, "Password updated!");
	} else {
		jsonResponse(false, "Something went wrong.");
	}

 	//Close database connection. Not compulsory but good practice.
	$stmt->close();
	$conn->close();
} else {
	jsonResponse(false, "Invalid request method.");
 }
 