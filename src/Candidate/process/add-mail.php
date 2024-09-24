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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$to  = $_POST['to'];

	$subject = mysqli_real_escape_string($conn, $_POST['subject']);
	$message = mysqli_real_escape_string($conn, $_POST['description']);

	$sql = "INSERT INTO mailbox (id_fromuser, fromuser, id_touser, subject, message) 
	VALUES ('$_SESSION[id_user]', 'user', '$to', '$subject', '$message')";

	if($conn->query($sql) == TRUE) {
		jsonResponse(true, "Mail Sent!");		
	} else {
		jsonResponse(false, "Something went wrong.");
	}
	//Close database connection. Not compulsory but good practice.
	$stmt->close();
	$conn->close();
} else {
	jsonResponse(false, "Invalid request method.");
}