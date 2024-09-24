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
        'email'    => escapeInput($conn, $_POST['email']),
        'password' => escapeInput($conn, $_POST['password']),        
    ];

	//sql query to check user login
	$sql = "SELECT id_company, companyname, email, password, active FROM company WHERE email=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $userData['email']);
	$stmt->execute();
    $result = $stmt->get_result();
	
	if ($result->num_rows < 0) {
        jsonResponse(false, "Wrong email and password!");
    }
	
	while ($row = $result->fetch_assoc()) {
		if (!password_verify($userData['password'], $row['password'])) {
			jsonResponse(false, "Wrong password!");
		}

		if($row['active'] == '0') {
			jsonResponse(false, "Your account is rejected. Please contact the admin for more information.");
		} else if($row['active'] == '2') { 				
			jsonResponse(false, "Your account is not yet approve by admin.");
		} else if($row['active'] == '3') { 				
			jsonResponse(false, "Your account is deactivated. Contact admin to reactivate. your account");
		}

		$_SESSION['name'] = $row['companyname'];
		$_SESSION['id_company'] = $row['id_company'];
		jsonResponse(true, "Login successfully");

	}
	
 	//Close database connection. Not compulsory but good practice.
 	$stmt->close();
	$conn->close();

}