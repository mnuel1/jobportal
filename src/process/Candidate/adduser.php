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
        'firstname'   => escapeInput($conn, $_POST['fname']),
        'lastname'    => escapeInput($conn, $_POST['lname']),
        'email'       => escapeInput($conn, $_POST['email']),
        'contactno'   => escapeInput($conn, $_POST['contactno']),
        'aboutme'     => escapeInput($conn, $_POST['aboutme']),
        'address'     => escapeInput($conn, $_POST['address']),
        'dob'         => escapeInput($conn, $_POST['dob']),
        'baranggay'   => escapeInput($conn, $_POST['baranggay']),
        'age'         => escapeInput($conn, $_POST['age']),
        'skills'      => escapeInput($conn, $_POST['skills']),
        'passingyear' => escapeInput($conn, $_POST['passingyear']),
        'qualification'=> escapeInput($conn, $_POST['qualification']),
        'designation' => escapeInput($conn, $_POST['designation']),
        'stream'      => escapeInput($conn, $_POST['stream']),
        'password'    => escapeInput($conn, $_POST['password']),
    ];

    // Encrypt Password
    $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $sql = "SELECT email FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $userData['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        jsonResponse(false, "Email already exists");
    }

    // Handle File Upload
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
        jsonResponse(false, "No file uploaded");
    }

	$conn->begin_transaction();

	try {
		// Prepare the SQL statement
		$insertSql = "INSERT INTO users 
			(firstname, lastname, email, password, address, baranggay_id, contactno, 
			qualification, stream, passingyear, dob, age, designation, resume, 
			aboutme, skills) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
		$stmt = $conn->prepare($insertSql);
		$stmt->bind_param('sssssissssssssss', 
			$userData['firstname'], $userData['lastname'], $userData['email'], 
			$userData['password'], $userData['address'], $userData['baranggay'], 
			$userData['contactno'], $userData['qualification'], $userData['stream'], 
			$userData['passingyear'], $userData['dob'], $userData['age'], 
			$userData['designation'], $file, $userData['aboutme'], 
			$userData['skills']
		);
	
		// Execute the prepared statement
		if ($stmt->execute()) {
			// Commit the transaction
			
	
			// Prepare and send confirmation email
			// Uncomment and customize the email sending logic as needed
			// $to = $userData['email'];
			// $subject = "Job Portal - Confirm Your Email Address";
			// $message = '
			// <html>
			// <head>
			//     <title>Confirm Your Email</title>
			// </head>
			// <body>
			//     <p>Click Link To Confirm</p>
			//     <a href="yourdomain.com/verify.php?token=' . bin2hex(random_bytes(16)) . '&email=' . $to . '">Verify Email</a>
			// </body>
			// </html>
			// ';
	
			// $headers[] = 'MIME-VERSION: 1.0';
			// $headers[] = 'Content-type: text/html; charset=iso-8859-1';
			// $headers[] = 'To: ' . $to;
			// $headers[] = 'From: hello@yourdomain.com';
	
			// Send the email
			// if (mail($to, $subject, $message, implode("\r\n", $headers))) {
				$conn->commit();
				jsonResponse(true, "Registration successful! Check your email to activate your account.");
			// } else {
			// 	$conn->rollback();
			//     jsonResponse(false, "Registration successful but email sending failed.");
			// }
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
