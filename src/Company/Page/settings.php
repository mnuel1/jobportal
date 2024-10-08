<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if(empty($_SESSION['id_company'])) {
  header("Location: ./src/index.php");
  exit();
}

?>
<!DOCTYPE html>
<html>
<head>
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
</head>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/confirmModal.php';?>
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

            <h1 class="text-center my-4"> ACCOUNT
            <span style="color: #253D80;">SETTINGS</span></h1>
            <p style="font-size: small; color:gray"><i>In this section you can change your name and account password</i></p>
          
          
            
            <div class="row">
                <div class="col-md-6">
                    <form id="updateName" method="post">
                        <div class="form-group mb-2">
                            <label>Your Name (Full Name)</label>
                            <input class="form-control input-lg" name="name" type="text" required>
                        </div>
                        <div class="form-group mb-2">
                            <button type="submit" class="button-change">Change Name</button>
                        </div>
                    </form>
                    <form id="changePassword" action="change-password.php" method="post">
                        <div class="form-group mb-2">
                            <input id="password" class="form-control input-lg" type="password" name="password" autocomplete="off" placeholder="Password" required>
                        </div>
                        <div class="form-group mb-2">
                            <input id="cpassword" class="form-control input-lg" type="password" autocomplete="off" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group mb-2">
                            <button type="submit" class="button-change-dark">Change Password</button>
                        </div>
                    
                    </form>
                    
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center flex-grow-1" style="margin-top: 20rem;">
                    <form id="deactivateAccount" method="post">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="deact" required>
                            <label class="form-check-label mb-2" for="deact"> <b>I want to 
                                <span style="color: #B80000;">deactivate</span> my account.</b> </label>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <button type="submit" class="deact-account">Deactivate My Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
              
              


<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const toastSuccessMsg = document.getElementById('toast-success-msg')
    const succToast = document.getElementById('successToast')
    var successToast = new bootstrap.Toast(succToast);

    const toastErrorMsg = document.getElementById('toast-error-msg')
    const errToast = document.getElementById('errorToast')
    var errorToast = new bootstrap.Toast(errToast);   

    $('#deact').on('change', function(e) {
        const checkboxdeact = $(this); // Get the checkbox as a jQuery object

        // Use .prop() to check the checked state
        if (checkboxdeact.prop('checked')) {
            checkboxdeact.prop('checked', false);
            const modal = document.getElementById('confirmModal')
            const msg = document.getElementById('confirm-msg')
            msg.textContent = `Are you sure you want to deactivate your account? If you are not sure don't 
            worry you can contact the admin to reactivate your account.`
            
            var mydeact = new bootstrap.Modal(modal);    
            mydeact.show(); // Show toast
        }
    });

    $('#confirmThis').on('click', function() {
        const checkboxdeact = $('#deact'); // Get the checkbox

        // Set checkbox to checked when deact are accepted
        checkboxdeact.prop('checked', true);

        // Close the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal.hide();
    });

    $("#changePassword").on("submit", function(e) {
        e.preventDefault();

        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if($('#password').val() != $('#cpassword').val() ) {
            toastErrorMsg.textContent = "Password don't match!"
            errToast.show()
            return            
        } else if(!passwordRegex.test($('#password').val())){
            toastErrorMsg.textContent = 'Password must be at least 8 characters long and contain both letters and numbers!';
            errToast.show()
            return 
        }
        $("#loading-screen").removeClass("hidden");
        $.ajax({
            url: '../process/change-password.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#changePassword')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    
                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        $('#changePassword')[0].reset();
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

     });

    $("#updateName").on("submit", function(e) {
        e.preventDefault();
        $("#loading-screen").removeClass("hidden");      
        $.ajax({
            url: '../process/update-name.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#updateName')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    
                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        $('#updateName')[0].reset(); 
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

    $("#deactivateAccount").on("submit", function(e) {
        e.preventDefault();
        $("#loading-screen").removeClass("hidden");          
        $.ajax({
            url: '../process/deactivate-account.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#deactivateAccount')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();

                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        window.location.href = '/src/logout.php';
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
