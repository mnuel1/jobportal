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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Prepare and escape input data
    $userData = [
        'firstname'   => escapeInput($conn, $_POST['fname']),
        'lastname'    => escapeInput($conn, $_POST['lname']),
        'email'       => escapeInput($conn, $_POST['email']),
        'contactno'   => escapeInput($conn, $_POST['contactno']),
        'aboutme'     => escapeInput($conn, $_POST['aboutme']),
        'address'     => escapeInput($conn, $_POST['address']),        
        'baranggay_id'   => escapeInput($conn, $_POST['baranggay']),        
        'skills'      => escapeInput($conn, $_POST['skills']),        
        'qualification'=> escapeInput($conn, $_POST['qualification']),        
        'stream'      => escapeInput($conn, $_POST['stream']),
        
    ];
	
	$resumeFile = $_FILES['resume'] ?? null;
    $uploadOk = true;
    $folder_dir = "../../../uploads/resume/";

	if (!file_exists($folder_dir)) {
		mkdir($folder_dir, 0777, true);
	}

	if ($resumeFile && is_uploaded_file($resumeFile['tmp_name'])) {
        $resumeFileType = pathinfo($resumeFile['name'], PATHINFO_EXTENSION);
        if ($resumeFileType !== "pdf" || $resumeFile['size'] > 1000000) {
            jsonResponse(false, "Invalid file format or size. Only PDF files under 1mb are allowed.");
        }

        $file = uniqid() . "." . $resumeFileType;
        $filename = $folder_dir . $file;

        if (!move_uploaded_file($resumeFile["tmp_name"], $filename)) {
            jsonResponse(false, "File upload failed. Please try again.");
        }
    } else {
        $uploadOk = false;
    }

	$sql = "UPDATE users SET ";

	// Build the SQL query dynamically from the $userData array
	$updates = [];
	foreach ($userData as $key => $value) {
		$updates[] = "$key = '$value'";
	}

	// If resume upload is successful, include it in the update query
	if ($uploadOk == true) {
		$updates[] = "resume = '$file'";
	}

	// Join the updates with commas
	$sql .= implode(', ', $updates);

	// Add the WHERE clause for user ID
	$sql .= " WHERE id_users = '$_SESSION[id_user]'";

	// Execute the query
	if ($conn->query($sql) === TRUE) {
		// Update session name
		$_SESSION['name'] = $userData['firstname'] . ' ' . $userData['lastname'];
		jsonResponse(true, "Edit account success.");
	} else {
		// Display error message if query fails
		jsonResponse(false, "Something went wrong.");
	}

	//Close database connection. Not compulsory but good practice.
	$stmt->close();
	$conn->close();

} else {
    jsonResponse(false, "Invalid request method.");
}
