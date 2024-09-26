<?php
// Include the PHPMailer classes into the namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader (if you're using Composer)
require '../../vendor/autoload.php';

// Function to handle JSON responses
function jsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);    
    $email = $_POST["email"];
    $acctype = $_POST["acctype"];
    $resetLink = "http://localhost:3000/src/reset-password.php?email=" . $email . "&acctype=" . $acctype;

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
            It seems like you requested to reset your password. If this was you, please click the link below to reset your password:
            <br><br>
            <a class='link' href='". $resetLink ."'>Reset your password</a>
            <br><br>
            If you did not make this request, you can safely ignore this email. Your password will remain unchanged.
            <br><br>
            Best regards,<br>
            The Support Team at RESIBO PH
        </body>
    </html>";
   
    try {
       
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
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
        $mail->Subject = "Password Reset Request";
        $mail->From = "jobportal@resiboph.site";
        
        $mail->IsHTML(true);
        $mail->AddAddress($email); // To mail id                
        $mail->MsgHTML($body);
        $mail->WordWrap = 50;
       
            
        // Send the email
        if ($mail->send()) {            
            $mail->SmtpClose();
            jsonResponse(true, "Email sent!");		
        } else {
            $mail->SmtpClose();
            jsonResponse(false, "Something went wrong.");
        }
    } catch (Exception $e) {
        
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        jsonResponse(false, "Something went wrong.");
    }
}