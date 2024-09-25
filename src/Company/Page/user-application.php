<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
  }
  
require_once("../../../database/db.php");


$sql = "SELECT * FROM apply_job_post 
    LEFT JOIN job_post ON job_post.id_jobpost = apply_job_post.id_jobpost
    WHERE id_company='$_SESSION[id_company]' AND id_users='$_GET[id]'";

$result = $conn->query($sql);
if($result->num_rows == 0) 
{
  header("Location: /src/index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JobSearch</title>
    
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

</head>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    
    <div class="container-fluid d-flex justify-content-center gap-2" style="padding-top: calc(6rem + 42px);">

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/company-sidebar.php';?>
        <div class="container larger bg-light mx-auto">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#company" 
                aria-controls="offcanvasWithBothOptions">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            <div class="row margin-top-20">
              <div class="col-md-12">
              <?php
               $sql = "SELECT users.*, baranggay.name as baranggay FROM users                
                LEFT JOIN baranggay ON baranggay.baranggay_id = users.baranggay_id
                WHERE id_users='$_GET[id]'";
                $result = $conn->query($sql);

                //If Job Post exists then display details of post
                if($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) 
                  {
                ?>
                <div class="d-flex justify-content-between align-items-center" style="height: 100px;">
                    <h2 class="mb-0"><?php echo $row['firstname']. ' '.$row['lastname']; ?></h2>
                    <a href="job-applications.php" class="buttons-sm buttons-color">
                        <i class="fa fa-arrow-left" style="margin-right: 1rem;"></i> Back
                    </a>
                </div>

                <div class="clearfix"></div>
                <hr>
                <div>
                    <?php
                        echo 'Email: '.$row['email'];                       
                        echo '<br>';
                        echo 'Baranggay: '.$row['baranggay'];
                        echo '<br>';
                    ?>                
                <div style="display:flex; align-items:end; justify-content:end;">                        
                    <a class="mb-2 buttons-sm buttons-color" 
                    href="https://mail.google.com/mail/u/0/?fs=1&to=<?php echo $row['email']; ?>&su=SUBJECT&body=BODY&bcc=&tf=cm">Contact</a>
                </div>
                
                <div style="display:flex; align-items:end; justify-content:end;">
                    <?php if($row['resume'] != ""): ?>
                        <!-- Open resume in new tab -->
                        <a class="mb-2 buttons-sm buttons-color" href="/uploads/resume/<?php echo $row['resume']; ?>" target="_blank">
                            View Resume
                        </a>
                    <?php endif; ?>              
                </div>
                    
                <!-- Bootstrap Modal to Display PDF -->
                <div class="modal fade" id="resumeModal" tabindex="-1" aria-labelledby="resumeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resumeModalLabel">Resume</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="/uploads/resume/<?php echo $row['resume']; ?>" width="100%" height="500px"></iframe>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Include Bootstrap JS (if not already included) -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

                  
                <div class="d-flex gap-2">
                    <a id="underreview" href="#" class="btn btn-success">Mark Under Review</a>
                    <a id="reject" href="#" class="btn btn-danger">Reject Application</a>
                </div>                                           
                <?php
                  }
                }
                ?>
              </div>
            </div>
            
          </div>
        </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const toastSuccessMsg = document.getElementById('toast-success-msg')
    const succToast = document.getElementById('successToast')
    var successToast = new bootstrap.Toast(succToast);

    const toastErrorMsg = document.getElementById('toast-error-msg')
    const errToast = document.getElementById('errorToast')
    var errorToast = new bootstrap.Toast(errToast);   


    $("#underreview").on("click", function(e) {
        e.preventDefault();
    

        $.ajax({
            url: './process/under-review.php?id_apply=<?php echo $_GET['id_apply']; ?>', 
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();

                    $('#addPost')[0].reset(); // Reset all fields
                    tinymce.get('description').setContent(''); // Clear TinyMCE editor
                    
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                console.log(xhr);
                
                
                console.error('AJAX Error:', error);
            }
        });
      
    })

    $("#reject").on("click", function(e) {
        e.preventDefault();
       
        $.ajax({
            url: './process/reject.php?id=<?php echo $_GET['id_apply']; ?>', // Update with your actual PHP script path
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();

                    $('#addPost')[0].reset(); // Reset all fields
                    tinymce.get('description').setContent(''); // Clear TinyMCE editor
                    
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                console.log(xhr);
                
                
                console.error('AJAX Error:', error);
            }
        });
      
    })

</script>
</body>
</html>
