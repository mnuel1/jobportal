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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Create a new PHPMailer instance
    try {
        $mail = new PHPMailer(true);    
        $email = $_GET["email"];
        $jobTitle = urldecode($_GET["jobtitle"]);
        $applicationStatus = $_GET["status"];
        if (isset($_GET["interviewDate"]) && $_GET["interviewTime"]) {
            $meetingDateTime = new DateTime($_GET["interviewDate"] . ' ' . $_GET["interviewTime"]);    
            $meetingDate = $meetingDateTime->format('Y-m-d H:i:s'); 
        }
        
        
        $interviewLink = null;

        if ($applicationStatus === "Accepted") {
            $status = '3';
            $successMessage = "Job applicant was notified that their application was accepted.";
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
                    Congratulations! We are thrilled to inform you that your application for the position of <strong>" . $jobTitle . "</strong> has been <span class='status'>accepted</span>!
                    <br><br>
                    We are excited to welcome you to our team. Further details regarding your start date and onboarding process will be sent to you shortly.
                    <br><br>
                    Welcome aboard!
                    <br><br>
                    Best regards,<br>
                    The Hiring Team at JOB PORTAL
                </body>
            </html>";
        } elseif ($applicationStatus === "Rejected") {
            $status = '1';
            $successMessage = "Job applicant was notified that their application was rejected.";
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
        } elseif ($applicationStatus === "Interview") {
            $interviewLink = "http://localhost:3000/src/interview/interview.php?meetingname=Interview%20of%20" . $email . "%20for%20" . $jobTitle . "&meetingdate=" . urlencode($meetingDate);
            $status = '4'; // Default to 'UnderReview'
            $successMessage = "Job applicant was notified of their online interview schedule.";
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
                        a {
                            color: blue;
                            text-decoration: none;
                            font-weight: bold;
                        }
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>                
                    <br><br>
                    Congratulations! We are pleased to inform you that you've been scheduled for an online interview for the position of <strong>". $jobTitle ."</strong>.
                    <br><br>
                    Your interview is currently <span class='status'>Scheduled</span>.
                    <br><br>
                    Please find the details of your interview below:
                    <br><br>
                    <strong>Date:</strong> ". $_GET["interviewDate"] ."<br>
                    <strong>Time:</strong> ". $_GET["interviewTime"] ."<br>
                    <strong>Interview Link:</strong> <a href='". $interviewLink ."'>Join Interview</a>
                    <br><br>
                    Please make sure to be online and ready at least 10 minutes before the scheduled time. If you have any questions or need to reschedule, feel free to contact us.
                    <br><br>
                    We look forward to meeting you!
                    <br><br>
                    Best regards,<br>
                    The Hiring Team at JOB PORTAL
                </body>
            </html>";

        } else { // Under Review
            $status = '2'; // Default to 'UnderReview'
            $successMessage = "Job applicant was notified that their application is under review.";
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
   
        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output        
        $mail->isSMTP();                            // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'jobportal@resiboph.site';                     //SMTP username
        $mail->Password   = '9@omljoYWV';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->CharSet = 'UTF-8';
        $mail->IsMAIL();
        $mail->IsSMTP();
        $mail->FromName = "JOB PORTAL";
        $mail->Subject = "Application Status Update: " . $jobTitle;
        $mail->From = "jobportal@resiboph.site";
        
        $mail->IsHTML(true);
        $mail->AddAddress($email); // To mail id        
        $mail->MsgHTML($body);
        $mail->WordWrap = 50;
        
        $sql = "UPDATE apply_job_post SET status=?, link=?, createdAt = NOW() WHERE id_apply=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $status, $interviewLink, $_GET['id_apply']); // Using prepared statements to prevent SQL injection

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