<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
}
  
require_once("../../../database/db.php");


$id = $_GET["id"]; // Fetch the ID from the URL
$stmt = $conn->prepare("SELECT * FROM job_post WHERE id_jobpost = ?");
$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result(); // Fetch the result set

// Check if any row was returned
if ($result->num_rows > 0) {
    $jobPost = $result->fetch_assoc(); // Fetch the associative array of the job post
} else {
    echo "No job post found.";
    exit; // Stop further execution if no post is found
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAREERCITY</title>
    
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

    <script src="/js/tinymce/tinymce.min.js"></script>

<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/loading.php';?>

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

            <h1 class="text-center my-4"> EDIT
            <span style="color: #253D80;">JOB POST</span></h1>
        
            <div class="row">
                <form method="post" id="addPost">
                    <div class="col-md-12 latest-job">
                        <div class="form-group mb-2">
                            <label for="">Job Title</label>
                            <input class="form-control input-lg" type="text" id="jobtitle" name="jobtitle" placeholder="Job Title" value="<?php echo htmlspecialchars($jobPost['jobtitle']); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Description</label>
                            <textarea class="form-control input-lg" id="description" name="description" placeholder="Job Description">
                                <?php echo htmlspecialchars($jobPost['description']); ?>
                            </textarea>
                            
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Minimum Salary</label>
                            <input type="number" class="form-control input-lg" id="minimumsalary" name="minimumsalary" min="1000" max="1000000" placeholder="Minimum Salary" required value="<?php echo htmlspecialchars($jobPost['minimumsalary']); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Maximum Salary</label>
                            <input type="number" class="form-control input-lg" id="maximumsalary" name="maximumsalary" min="1000" max="1000000" placeholder="Maximum Salary" required value="<?php echo htmlspecialchars($jobPost['maximumsalary']); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Experience</label>
                            <input type="number" class="form-control input-lg" id="experience" name="experience" placeholder="Experience (in Years) Required" required value="<?php echo htmlspecialchars($jobPost['experience']); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Qualification</label>
                            <input type="text" class="form-control input-lg" id="qualification" name="qualification" placeholder="Qualification Required" required value="<?php echo htmlspecialchars($jobPost['qualification']); ?>">
                        </div>
                        <input type="hidden" name="id_jobpost" value="<?php echo $_GET['id']; ?>">
                        <div class="form-group">
                            <button type="submit" class="button-upt-sm">Update</button>
                        </div>
                    </div>
                </form>

            </div>
            
        </div>
    </div>
 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>tinymce.init({ selector:'#description', height: 300 });</script>
<script>

    $("#addPost").on("submit", function(e) {
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
            url: '../process/editpost.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#addPost')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();

                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");                                                
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
