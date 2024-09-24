<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/db.php");

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

	
    $userData = [
        'username' => escapeInput($conn, $_POST['email']),        
        'password' => escapeInput($conn, $_POST['password']),       
    ];
	//Encrypt Password
	// $password = base64_encode(strrev(md5($password)));

	//sql query to check user login
	$sql = "SELECT * FROM admin WHERE username=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $userData['username']);
	$stmt->execute();
    $result = $stmt->get_result();

	if ($result->num_rows < 0) {
        jsonResponse(false, "Wrong email and password!");
    }
		
	//output data
	while($row = $result->fetch_assoc()) {
		
		if (!password_verify($userData['password'], $row['password'])) {
			jsonResponse(false, "Wrong password!");
		}

		//Set some session variables for easy reference
		$_SESSION['id_admin'] = $row['admin_id'];
		jsonResponse(true, "Login successfully");
	}
 	

	$stmt->close();
	$conn->close();
}