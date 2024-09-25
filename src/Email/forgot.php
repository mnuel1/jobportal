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
    $interviewLink = "https://example.com/interview/schedule"; // Interview link for accepted candidates

    if ($applicationStatus === "Accepted") {
        $body = "
        <html>
            <head>
                <style type='text/css'> 
                    body {
                        font-family: Calibri, sans-serif;
                        font-size: 16px;
                        color: #000;
                    }
                    .status {
                        font-weight: bold;
                        color: green;
                    }
                </style>
            </head>
            <body>
                Hello, ". $name .",
                <br><br>
                Congratulations! We are pleased to inform you that your application for the position of <strong>". $jobTitle ."</strong> has been <span class='status'>Accepted</span>.
                <br><br>
                As the next step, we would like to invite you for an interview. Please use the following link to schedule your interview at your convenience:
                <br>
                <a href='". $interviewLink ."'>Schedule Interview</a>
                <br><br>
                We look forward to meeting with you.
                <br><br>
                Best regards,<br>
                The Hiring Team at JOB PORTAL
            </body>
        </html>";
    } elseif ($applicationStatus === "Rejected") {
        $body = "
        <html>
            <head>
                <style type='text/css'> 
                    body {
                        font-family: Calibri, sans-serif;
                        font-size: 16px;
                        color: #000;
                    }
                    .status {
                        font-weight: bold;
                        color: red;
                    }
                </style>
            </head>
            <body>
                Hello, ". $name .",
                <br><br>
                Thank you for applying for the position of <strong>". $jobTitle ."</strong>.
                <br><br>
                We regret to inform you that your application has been <span class='status'>Rejected</span> after careful review.
                <br><br>
                We appreciate your interest in joining our company and encourage you to apply for other positions that match your skills in the future.
                <br><br>
                Best of luck in your job search!
                <br><br>
                Sincerely,<br>
                The Hiring Team at JOB PORTAL
            </body>
        </html>";
    } else { // Under Review
        $body = "
        <html>
            <head>
                <style type='text/css'> 
                    body {
                        font-family: Calibri, sans-serif;
                        font-size: 16px;
                        color: #000;
                    }
                    .status {
                        font-weight: bold;
                        color: orange;
                    }
                </style>
            </head>
            <body>
                Hello, ". $name .",
                <br><br>
                We wanted to update you regarding your application for the position of <strong>". $jobTitle ."</strong>.
                <br><br>
                Your application is currently <span class='status'>Under Review</span>.
                <br><br>
                Our team is carefully evaluating your qualifications, and we will get back to you soon with the next steps.
                <br><br>
                Thank you for your patience!
                <br><br>
                Best regards,<br>
                The Hiring Team at JOB PORTAL
            </body>
        </html>";
    }
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
        $mail->Subject = "Application Status Update: " . $jobTitle;
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