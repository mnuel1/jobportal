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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$sql = "'";
	$deactcode = "3";
	$stmt = $conn->prepare("UPDATE company SET active=? WHERE id_company=?");
	$stmt->bind_param("ss", $deactcode, $_SESSION['id_company']);

	if($stmt->execute()) {
		jsonResponse(true, "Account deactivated.");
	} else {
		jsonResponse(false, "Something went wrong.");
	}
	$stmt->close();
	$conn->close();

} else {
	jsonResponse(false, "Invalid request method.");
}