<?php

session_start();

// Include Database Connection
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
        'companyname' => escapeInput($conn, $_POST['companyname']),        
        'email'       => escapeInput($conn, $_POST['email']),
        'contactno'   => escapeInput($conn, $_POST['contactno']),
        'aboutme'     => escapeInput($conn, $_POST['aboutme']),
        'website'     => escapeInput($conn, $_POST['website']),
        'name'        => escapeInput($conn, $_POST['name']),
        'baranggay'   => escapeInput($conn, $_POST['baranggay']),                                   
        'password'    => escapeInput($conn, $_POST['password']),
    ];

	
	$userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

	//sql query to check if email already exists or not
	$sql = "SELECT email FROM company WHERE email=?";
	$stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $userData['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        jsonResponse(false, "Email already exists");
    }

	// Handle File Upload
    $logoFile = $_FILES['image'] ?? null;
    $uploadOk = true;
    $folder_dir = "../../../uploads/logo/";
	
	if (!file_exists($folder_dir)) {
		mkdir($folder_dir, 0777, true);
	}

	if ($logoFile && is_uploaded_file($logoFile['tmp_name'])) {
        $logoFileType = pathinfo($logoFile['name'], PATHINFO_EXTENSION);
        $logoFileType = strtolower($logoFileType);

		// Check if the file is not a jpg or png, or if it exceeds the size limit
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
        jsonResponse(false, "No file uploaded");
    }

	$conn->begin_transaction();

	try {
		
		// Prepare the SQL statement
		$insertSql = "INSERT INTO company (name, companyname, baranggay_id, 
		contactno, website, email, password, aboutme, logo) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
		$stmt = $conn->prepare($insertSql);
		$stmt->bind_param('ssissssss', 
			$userData['name'], $userData['companyname'], $userData['baranggay'], 
			$userData['contactno'], $userData['website'], $userData['email'], 
			$userData['password'], $userData['aboutme'], $file
		);

		if ($stmt->execute()) {
			
			$conn->commit();
			jsonResponse(true, "Registration successful! Check your email to activate your account.");
			
		} else {
			throw new Exception("Error inserting data: " . $stmt->error);
		}

	} catch (Exception $e) {
		// An error occurred; roll back the transaction
		$conn->rollback();
	
		// Handle any cleanup (like deleting the uploaded file if necessary)
		if (file_exists($filename)) {
			unlink($filename); // Remove the uploaded file if it exists
		}
	
		// Return the error response
		jsonResponse(false, "Error: " . $e->getMessage());
	}

	$stmt->close();
	$conn->close();



} else {
    jsonResponse(false, "Invalid request method.");
}
