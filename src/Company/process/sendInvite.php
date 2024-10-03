<?php
// Include the PHPMailer classes into the namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if you're using Composer)
require '../../../vendor/autoload.php';
require '../../../database/db.php';

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
    try {
        $mail = new PHPMailer(true);
        $applicantId = $_POST["applicantId"];
        $jobpostId = $_POST["jobpostId"];
        $email = $_POST["email"];
        $jobTitle = $_POST["jobtitle"];
    
        $status = '5';
        $successMessage = "Job applicant was invited to apply in the job post.";
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
                <br><br>
                We are excited to inform you that you have been invited to apply for the position of <strong>" . 
                htmlspecialchars($jobTitle) . "</strong>!
                <br><br>
                We believe you would be a great fit for our team, and we encourage you to submit your application. 
                <br><br>
                We look forward to receiving your application!
                <br><br>
                Best regards,<br>
                The Hiring Team at JOB PORTAL
            </body>
        </html>";

   
        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output        
        $mail->isSMTP();                            // Send using SMTP
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
        $mail->Subject = "Job Invitation: " . $jobTitle;
        $mail->From = "noreplyjobportal@resiboph.site";
        
        $mail->IsHTML(true);
        $mail->AddAddress($email); // To mail id        
        $mail->MsgHTML($body);
        $mail->WordWrap = 50;
        
        $sql = "INSERT INTO apply_job_post (id_jobpost, id_users, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $jobpostId, $applicantId, $status);

        if ($stmt->execute()) {
            if ($mail->send()) {
                $mail->SmtpClose();
                jsonResponse(true, $successMessage);
            } else {
                $mail->SmtpClose();
                jsonResponse(false, "Email failed to send.");
            }
        } else {
            // Database update failed, no email sent
            jsonResponse(false, "Failed to update application status.");
        }
            
    
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        jsonResponse(false, "Failed to update application status.");
    }
}