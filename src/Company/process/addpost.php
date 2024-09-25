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

	// New way using prepared statements. This is safe from SQL INJECTION. Should consider to update to this method when many people are using this method.

	$jobtitle = escapeInput($conn, $_POST['jobtitle']);
	$description = escapeInput($conn, $_POST['description']);
	$minimumsalary = escapeInput($conn, $_POST['minimumsalary']);
	$maximumsalary = escapeInput($conn, $_POST['maximumsalary']);
	$experience = escapeInput($conn, $_POST['experience']);
	$qualification = escapeInput($conn, $_POST['qualification']);

	
	$stmt = $conn->prepare("INSERT INTO job_post(id_company, jobtitle, description, minimumsalary, 
	maximumsalary, experience, qualification) VALUES (?,?, ?, ?, ?, ?, ?)");

	$stmt->bind_param("issssss", $_SESSION['id_company'], $jobtitle, $description, $minimumsalary, $maximumsalary, $experience, $qualification);

	if($stmt->execute()) {
		jsonResponse(true, "New job posts successfully.");
	} else {
		jsonResponse(false, "Something went wrong.");
	}
	//Close database connection. Not compulsory but good practice.
	$stmt->close();
	$conn->close();

} else {
	jsonResponse(false, "Invalid request method.");
}
 