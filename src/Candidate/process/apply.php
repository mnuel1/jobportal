<?php


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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$id_jobpost = escapeInput($conn, $_GET["id_jobpost"]);
	$id_user = $_SESSION["id_user"];
	
	$checkStmt = $conn->prepare("SELECT id_apply FROM apply_job_post WHERE id_jobpost = ? AND id_users = ?");
	$checkStmt->bind_param("ss", $id_jobpost, $id_user);
	$checkStmt->execute();
	$checkStmt->store_result();
	
	if ($checkStmt->num_rows > 0) {

		$createdAt = date("Y-m-d H:i:s");
		$updateStmt = $conn->prepare("UPDATE apply_job_post SET status = '0', createdAt = ? WHERE id_jobpost = ? AND id_users = ?");
		$updateStmt->bind_param("sss", $createdAt, $id_jobpost, $id_user);
	
		if ($updateStmt->execute()) {
			jsonResponse(true, "Job application status updated successfully!");
		} else {
			jsonResponse(false, "Failed to update job application status.");
		}
	
		$updateStmt->close();
	} else {

		$insertStmt = $conn->prepare("INSERT INTO apply_job_post (id_jobpost, id_users, status) VALUES (?, ?, '1')");
		$insertStmt->bind_param("ss", $id_jobpost, $id_user);
	
		if ($insertStmt->execute()) {
			jsonResponse(true, "Job application sent successfully!");
		} else {
			jsonResponse(false, "Failed to submit job application.");
		}
	
		$insertStmt->close();
	}
	
	// Close connections
	$checkStmt->close();
	$conn->close();
} else {
	jsonResponse(false, "Invalid request method.");
}