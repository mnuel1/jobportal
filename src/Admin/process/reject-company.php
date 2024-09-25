<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: /src/index.php");
	exit();
}


//Including Database Connection From db.php file to avoid rewriting in all files
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/db.php");

// Function to handle JSON responses
function jsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	//Delete Company using id and redirect
	$sql = "UPDATE company SET active='0' WHERE id_company='$_GET[id]'";
	if($conn->query($sql)) {
		jsonResponse(true, "Company rejected successfully");
	} else {
		jsonResponse(false, "Something went wrong!!");
	}
	$stmt->close();
	$conn->close();
}