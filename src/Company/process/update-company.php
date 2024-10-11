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
	// Prepare and escape input data
	$userData = [
		'companyname'  => escapeInput($conn, $_POST['companyname']),
		'website'      => escapeInput($conn, $_POST['website']),
		'baranggay_id' => escapeInput($conn, $_POST['baranggay']),
		'contactno'    => escapeInput($conn, $_POST['contactno']),
		'aboutme'      => escapeInput($conn, $_POST['aboutme']),
						
	];
	
	$logoFile = $_FILES['image'] ?? null;
    $uploadOk = true;
    $folder_dir = "../../../uploads/logo/";

	if (!file_exists($folder_dir)) {
		mkdir($folder_dir, 0777, true);
	}

	if ($logoFile && is_uploaded_file($logoFile['tmp_name'])) {
        $logoFileType = pathinfo($logoFile['name'], PATHINFO_EXTENSION);
        if (($logoFileType !== "jpg" && $logoFileType !== "png" && $logoFileType !== "PNG" && $logoFileType !== "JPG"
			&& $logoFileType !== "JPEG" && $logoFileType !== "jpeg") 
		|| $logoFile['size'] > 1000000) {
            jsonResponse(false, "Invalid file format or size. Only jpg/png files under 1mb are allowed.");
        }

        $file = uniqid() . "." . $logoFileType;
        $filename = $folder_dir . $file;

        if (!move_uploaded_file($logoFile["tmp_name"], $filename)) {
            jsonResponse(false, "File upload failed. Please try again.");
        }
    } else {        
		$uploadOk = false;
		jsonResponse(false, "No file uploaded");
    }

	$sql = "UPDATE company SET ";

	// Build the SQL query dynamically from the $userData array
	$updates = [];
	foreach ($userData as $key => $value) {
		$updates[] = "$key = '$value'";
	}

	if ($uploadOk == true) {
		$updates[] = "logo = '$file'";
	}

	// Join the updates with commas
	$sql .= implode(', ', $updates);

	// Add the WHERE clause for user ID
	$sql .= " WHERE id_company='$_SESSION[id_company]'";

	// Execute the query
	if ($conn->query($sql) === TRUE) {
		// Update session name
		$_SESSION['name'] = $userData['companyname'];
		jsonResponse(true, "Edit company success.");
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
 