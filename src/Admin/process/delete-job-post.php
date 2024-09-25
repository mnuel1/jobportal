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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$sql = "DELETE FROM job_post WHERE id_jobpost='$_GET[id]'";
	// if($conn->query($sql)) {
	// 	// $sql1 = "DELETE FROM apply_job_post WHERE id_jobpost='$_GET[id]'";
	// 	// if($conn->query($sql1)) {
	// 	// }
	// 	// header("Location: active-jobs.php");
	// 	// exit();
	// } else {
	// 	echo "Error";
	// }
	if($conn->query($sql)) {
		jsonResponse(true, "Deleted successfully");
	} else {
		jsonResponse(false, "Something went wrong!!");
	}
	$stmt->close();
	$conn->close();
}
