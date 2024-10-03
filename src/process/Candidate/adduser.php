<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once("../../../database/db.php");
require '../../../vendor/autoload.php';
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
			
			$verifyLink = "http://localhost:3000/src/process/Candidate/verify.php?email=" . $userData["email"];
			$body = "
			<html>
				<head>
					<style type='text/css'> 
						body {
							font-family: Calibri, sans-serif;
							font-size: 16px;
							color: #000;
						}
						.link {
							font-weight: bold;
							color: #007bff;
						}
					</style>
				</head>
				<body>            
					<br><br>
					Welcome to JOB PORTAL! To complete your account creation and verify your email, please click the link below:
					<br><br>
					<a class='link' href='". $verifyLink ."'>Verify your account</a>
					<br><br>
					If you did not sign up for this account, please ignore this email.
					<br><br>
					Best regards,<br>
					The Support Team at JOB PORTAL
				</body>
			</html>";
					
			try {   
				$mail = new PHPMailer(true);    				
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'noreplyjobportal@resiboph.site';                     //SMTP username
				$mail->Password   = '9@omljoYWV';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;                                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				
				$mail->CharSet = 'UTF-8';
				$mail->IsMAIL();
				$mail->IsSMTP();
				$mail->FromName = "JOB PORTAL";
				$mail->Subject = "Verify Account";
				$mail->From = "noreplyjobportal@resiboph.site";
				
				$mail->IsHTML(true);
				$mail->AddAddress($userData['email']); // To mail id                
				$mail->MsgHTML($body);
				$mail->WordWrap = 50;
			
					
				// Send the email
				if ($mail->send()) {
					$conn->commit();
					$mail->SmtpClose();
					jsonResponse(true, "Registration successful! Check your email to activate your account.");		
				} else {
					$conn->rollback();
					$mail->SmtpClose();
					jsonResponse(false, "Something went wrong.");
				}
			} catch (Exception $e) {
				
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				jsonResponse(false, "Something went wrong.");
			}		
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
