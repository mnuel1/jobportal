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
	$sql = "SELECT id_users, firstname, lastname, email, password, active FROM users WHERE email=?";
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
			jsonResponse(false, "Your account is not yet active. Please check your email.");
		} else if($row['active'] == '2') { 				
			// If the account is deactivated, reactivate it
            $reactivate_sql = "UPDATE users SET active = 1 WHERE id_users = ?";
            $reactivate_stmt = $conn->prepare($reactivate_sql);
            $reactivate_stmt->bind_param('i', $row['id_users']);
            
            // Reactivate the account
            if ($reactivate_stmt->execute()) {                                
                $_SESSION['id_user'] = $row['id_users'];                
                $_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
                jsonResponse(true, "Your account has been reactivated and you are now logged in.");
            } else {
                jsonResponse(false, "Unable to reactivate account. Please try again later.");
            }
		}

		$_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
		$_SESSION['id_user'] = $row['id_users'];
		jsonResponse(true, "Login successfully");

	}
	
 	//Close database connection. Not compulsory but good practice.
 	$stmt->close();
	$conn->close();

}