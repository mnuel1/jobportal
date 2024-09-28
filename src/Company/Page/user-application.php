<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
  }
  
require_once("../../../database/db.php");


$sql = "SELECT * FROM apply_job_post WHERE id_users='$_GET[id]' AND id_jobpost='$_GET[id_jobpost]'";

$result2 = $conn->query($sql);


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
                    <a href="job-applications.php" class="button-create">
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
                <!-- Contact Button -->
                <div class="d-flex justify-content-start justify-content-sm-end mt-4">                        
                    <a class="mb-2 button-upt-lg" 
                    href="https://mail.google.com/mail/u/0/?fs=1&to=<?php echo $row['email']; ?>&su=SUBJECT&body=BODY&bcc=&tf=cm"
                    target="_blank" 
                    rel="noopener noreferrer">
                        Contact
                    </a>
                </div>

                <!-- View Resume Button -->
                <div class="d-flex justify-content-start justify-content-sm-end">                    
                    <?php if($row['resume'] != ""): ?>
                        <a class="mb-2 button-upt-lg" href="/uploads/resume/<?php echo $row['resume']; ?>" target="_blank">
                            View Resume
                        </a>
                    <?php endif; ?>              
                </div>



                <!-- Include Bootstrap JS (if not already included) -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

                  
                <div class="d-flex justify-content-between flex-column flex-lg-row gap-2">
                    <?php
                        $status = $_GET["status"]; // Assume status is obtained from the URL

                        // Check the status and display the appropriate buttons
                        if ($status == 0) {
                            // Status is 0: Show both 'Under Review' and 'Reject' buttons
                            echo '<a id="underreview" href="#" class="button-upt-lg">Mark Under Review</a>';
                            echo '<a id="reject" href="#" class="button-upt-lg-red">Reject Application</a>';
                        } elseif ($status == 1) {
                            // Status is 1: Show none
                            // Do nothing (no buttons will be displayed)
                            echo '<span href="#" class="badge text-bg-danger">Rejected</span>';
                        } elseif ($status == 2) {
                            // Status is 2: Show 'Accept' button instead of 'Under Review'
                            echo '<a id="interview" href="#" class="btn btn-success">Schedule Interview</a>';
                            echo '<a id="reject" href="#" class="btn btn-danger">Reject Application</a>';
                        } elseif ($status == 3) {
                            // Status is 3: Show only the 'Reject' button
                            echo '<a id="reject" href="#" class="btn btn-danger">Reject Application</a>';
                        } elseif ($status == 4) {

                            if($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    $link = $row2["link"] . '&force=true';                                    
                                    echo '
                                    <div>
                                        <a id="start" href="' . $link . '" class="btn btn-success">Start scheduled meeting</a>
                                        <a id="accept" href="#" class="btn btn-success">Accept Application</a>
                                    </div>
                                ';                        
                                    echo '<a id="reject" href="#" class="btn btn-danger">Reject Application</a>';
                                }
                            }
                            
                        }
                    ?>                   
                </div>                                           
                <?php
                  }
                }
                ?>
                <?php                
                if ($status == 2 || $status == 4) {
                    $title = $status === 2 ? "Set the schedule for the interview" : "Set a reschedule for the intervew";
                    echo '
                    <div id="scheduleFields" style="display: none;" class="mt-3 d-flex flex-column col-12 col-lg-4">
                        <span style="color:gray; font-size:small;">'. $title .'</span>
                        <label for="interviewDate">Interview Date:</label>
                        <input type="date" id="interviewDate" class="form-control" required>
                        <br>
                        <label for="interviewTime">Interview Time:</label>
                        <input type="time" id="interviewTime" class="form-control" required>
                        <a id="submitinterview" href="#" class="btn btn-success mt-2">Send to applicant</a>
                    </div>
                    ';
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
            url: '../process/application-status.php?id_apply=<?php echo $_GET['id_apply']; ?>&email=<?php echo $_GET['email']; ?>&jobtitle=<?php echo $_GET['jobtitle']; ?>&status=UnderReview',
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    console.log("response", response);
                    
                    successToast.show();
                                        
                } else {
                    toastErrorMsg.textContent = response.message;
                    console.log("response", response);
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
            url: '../process/application-status.php?id_apply=<?php echo $_GET['id_apply']; ?>&email=<?php echo $_GET['email']; ?>&jobtitle=<?php echo $_GET['jobtitle']; ?>&status=Rejected',
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                                        
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
    $("#interview").on("click", function(e) {        
        e.preventDefault();        
        $("#scheduleFields").slideToggle(); 
    });
    $("#submitinterview").on("click", function(e) {
        e.preventDefault();

        const interviewDate = document.getElementById("interviewDate").value
        const interviewTime = document.getElementById("interviewTime").value
        if (!interviewDate && !interviewTime) {
            toastErrorMsg.textContent = "Set a date and time before submitting.";
            errorToast.show();
        }
        
        $.ajax({
            url: `../process/application-status.php?id_apply=<?php echo $_GET['id_apply']; ?>&email=<?php echo $_GET['email']; ?>&jobtitle=<?php echo $_GET['jobtitle']; ?>&status=Interview&interviewDate=${interviewDate}&interviewTime=${interviewTime}`,
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                                        
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

    $("#accept").on("click", function(e) {
        e.preventDefault();
       
        $.ajax({
            url: '../process/application-status.php?id_apply=<?php echo $_GET['id_apply']; ?>&email=<?php echo $_GET['email']; ?>&jobtitle=<?php echo $_GET['jobtitle']; ?>&status=Accepted',
            type: 'GET',            
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                                        
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
