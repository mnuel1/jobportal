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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$sql = "UPDATE users SET active='2' 
	WHERE id_users='$_SESSION[id_user]'";

	if($conn->query($sql) == TRUE) {
		jsonResponse(true, "Account Deactivated.");
	} else {
		echo $conn->error;
	}
} else {
	jsonResponse(false, "Invalid request method.");
}
 