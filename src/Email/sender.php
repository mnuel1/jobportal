<?php
// Include the PHPMailer classes into the namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader (if you're using Composer)
require 'vendor/autoload.php';

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
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    $name = "John Doe";              // Applicant's name
    $email = "";
    $jobTitle = "Software Engineer"; // Job title they applied for
    $applicationStatus = "Accepted"; // Status could be 'Accepted', 'Rejected', or 'Under Review'
    $resetLink = "https://example.com/reset-password?token=abcd1234";

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
            Hello, ". $name .",
            <br><br>
            It seems like you requested to reset your password. If this was you, please click the link below to reset your password:
            <br><br>
            <a class='link' href='". $resetLink ."'>Reset your password</a>
            <br><br>
            If you did not make this request, you can safely ignore this email. Your password will remain unchanged.
            <br><br>
            For security reasons, this link will expire in 24 hours.
            <br><br>
            Best regards,<br>
            The Support Team at RESIBO PH
        </body>
    </html>";
    try {
        // Server settings
        $mail->isSMTP();                            // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';     // Set the SMTP server to send through (e.g., smtp.gmail.com for Gmail)
        $mail->SMTPAuth   = true;                   // Enable SMTP authentication
        $mail->Username   = 'jobportal@ph.resibo.ph';// SMTP username
        $mail->Password   = '8B4aspKb>';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS for SSL
        $mail->Port       = 465;                    // TCP port to connect to (use 465 for SSL)

        $mail->CharSet = 'UTF-8';
        $mail->IsMAIL();
        $mail->IsSMTP();
        $mail->FromName = "JOB PORTAL";
        $mail->Subject = "Password Reset Request";
        $mail->From = "jobportal@ph.resibo.ph";
        
        $mail->IsHTML(true);
        $mail->AddAddress($email); // To mail id
        
        
        $mail->MsgHTML($body);
        $mail->WordWrap = 50;
        $mail->Send();
        $mail->SmtpClose();
            
        // Send the email
        if ($mail->send()) {
            jsonResponse(true, "Email sent!");		
        } else {
            jsonResponse(false, "Something went wrong.");
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}