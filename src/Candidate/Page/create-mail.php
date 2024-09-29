<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_user'])) {
  header("Location: /src/index.php");
  exit();
}

require_once("../../../database/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAREERCITY</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

  <script src="/js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'#description', height: 150 });</script>
 
  
</head>
<body >

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/loading.php';?>
  
    <div class="container-fluid d-flex justify-content-center gap-2" style="padding-top: calc(6rem + 42px);">

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/candidate-sidebar.php';?>
        <div class="container larger bg-light mx-auto">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#candidate" 
                aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars"></i></button>
            
            <h1 class="text-center my-4">COMPOSE 
                <span style="color: #253D80;">NEW MESSAGE</span>
            </h1>
            <form id="addMail" method="post">              
                <div class="box-body">
                    <div class="form-group">
                        <select name="to" class="form-control mb-2" required>
                            <?php 
                                $sql = "SELECT * FROM apply_job_post 
                                INNER JOIN job_post ON job_post.id_jobpost = apply_job_post.id_jobpost
                                INNER JOIN company ON job_post.id_company=company.id_company 
                                WHERE apply_job_post.id_users='$_SESSION[id_user]' AND apply_job_post.status='2'";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="'.$row['id_company'].'">'.$row['companyname'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <input class="form-control" name="subject" placeholder="Subject:" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control input-lg" id="description" name="description" placeholder="Job Description"></textarea>
                    </div>
                </div>              
                <div class="box-footer mt-2">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"
                        style="background-color:green; color:white; border:0px;"><i class="fa fa-envelope"></i> Send</button>

                        <a href="mailbox.php" class="btn btn-default" 
                        style="background-color:#7D0A0A; color:white"><i class="fa fa-times"></i> Discard</a>
                    </div>                
                </div>              
            
            </form>
        </div>
    </div>
        

  </div>
  

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

    $("#addMail").on("submit", function(e) {
        e.preventDefault();

        const descriptionContent = tinymce.get('description').getContent();
        $('#description').val(descriptionContent);

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);
        
        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        $("#loading-screen").removeClass("hidden");
        $.ajax({
            url: '../process/add-mail.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#addMail')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                    
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        $('#addMail')[0].reset(); // Reset all fields
                        tinymce.get('description').setContent(''); // Clear TinyMCE editor
                    }, 3000);
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                    $("#loading-screen").addClass("hidden");
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $("#loading-screen").addClass("hidden");
            }
        });
    })

</script>
</body>
</html>
