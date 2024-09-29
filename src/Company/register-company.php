<?php
session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) { 
    header("Location: /src/index.php");
    exit();
}

require_once("../../database/db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CAREERCITY</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/terms-modal.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/loading.php';?>      

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px; padding-top: calc(6rem + 24px);">
        <section class="content-header">
            <div class="container">
                <div class="row latest-job latest-job margin-top-50 margin-bottom-20 mb-2">
                    <h1 class="text-center margin-bottom-20" style="padding:24px">
                        CREATE 
                        <span style="color: #7D0A0A;">COMPANY PROFILE</span>
                    </h1>
          
                    <form method="post" id="registerCompanies" 
                    action="../process/Company/addcompany.php" 
                    enctype="multipart/form-data" class="bg-light p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="name">Name</label>
                                    <input id="name" class="form-control input-lg" type="text" name="name" placeholder="Full Name" required>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control input-lg" type="password" name="password" placeholder="Password" required>
                                </div>
                                                                
                                <div class="form-group mb-2">
                                    <label for="email">Email Address</label>
                                    <input id="email" class="form-control input-lg" type="text" name="email" placeholder="Email" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="aboutme">About Me</label>
                                    <textarea id="aboutme" class="form-control input-lg" rows="4" name="aboutme" placeholder="Brief info about your company"></textarea>
                                </div>

                                <div class="form-group mb-2">
                                    <label>Company Logo</label>
                                    <input id="image" type="file" name="image" class="form-control input-lg" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="companyname">Company Name</label>
                                    <input id="companyname" class="form-control input-lg" type="text" name="companyname" placeholder="Company Name" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="cpassword">Confirm Password</label>
                                    <input id="cpassword" class="form-control input-lg" type="password" name="cpassword" placeholder="Confirm Password" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="contactno">Contact Number</label>
                                    <input id="contactno" class="form-control input-lg" type="text" name="contactno" placeholder="Phone Number" minlength="10" maxlength="10" autocomplete="off" onkeypress="return validatePhone(event);" required>
                                </div>
    
                                
                                <div class="form-group mb-2">
                                    <label for="baranggay">Baranggay</label>
                                    <select id="baranggay" class="form-control input-lg" id="baranggay" name="baranggay" required>
                                        <option selected="" value="">Select baranggay</option>
                                        <?php
                                        $sql="SELECT * FROM baranggay";
                                        $result=$conn->query($sql);

                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['baranggay_id']."' data-id='".$row['baranggay_id']."'>".$row['name']."</option>";
                                            }
                                        }
                                        ?>                            
                                    </select>
                                </div> 
                                <div class="form-group mb-2">
                                    <label for="website">Website</label>
                                    <input id="website" class="form-control input-lg" type="text" name="website" placeholder="Website">
                                </div>                                                                                            
                            </div>
                        </div>
                        
                        
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label mb-2" for="terms">I accept terms & conditions. </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="buttons-sm buttons-color">Register</button>
                        </div>                                                                       
                    </form>
          
                </div>
            </div>
        </section>

    

    </div>


</body>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<!-- Core theme JS-->
<script src="/js/scripts.js"></script>
<!-- JQuery JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   

<script type="text/javascript">
    function validatePhone(event) {

        //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
        //event.which will return key for mouse events and other events like ctrl alt etc. 
        var key = window.event ? event.keyCode : event.which;

        if(event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
            // 8 means Backspace
            //46 means Delete
            // 37 means left arrow
            // 39 means right arrow
            return true;
        } else if( key < 48 || key > 57 ) {
            // 48-57 is 0-9 numbers on your keyboard.
            return false;
        } else return true;
    }

    $('#terms').on('change', function(e) {
        const checkboxTerms = $(this); // Get the checkbox as a jQuery object

        // Use .prop() to check the checked state
        if (checkboxTerms.prop('checked')) {
            checkboxTerms.prop('checked', false);
            const modal = document.getElementById('termsModal')
            var myTerms = new bootstrap.Modal(modal);    
            myTerms.show(); // Show toast
        }
    });

    // Accept button inside the modal
    $('#acceptTerms').on('click', function() {
        const checkboxTerms = $('#terms'); // Get the checkbox

        // Set checkbox to checked when terms are accepted
        checkboxTerms.prop('checked', true);

        // Close the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('termsModal'));
        modal.hide();
    });
    $("#registerCompanies").on("submit", function(e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('cpassword').value;
        const image = document.getElementById('image').files[0];

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        let errorMessage = '';

        if (password !== confirmPassword) {
            errorMessage = 'Passwords do not match!';
        } else if (!passwordRegex.test(password)) {
            errorMessage = 'Password must be at least 8 characters long and contain both letters and numbers!';
        }
        
        if (image && !(image.type === 'image/jpeg' || image.type === 'image/png')) {
            errorMessage = 'Only JPEG/PNG files are allowed for logo upload!';
        }
                
        if (image && image.size > 1000000) {
            errorMessage = 'File size exceeds 1mb.';
        }
        
        if (errorMessage) {            
            toastErrorMsg.textContent = errorMessage           
            errorToast.show();
            return;            
        } 
        
        $("#loading-screen").removeClass("hidden");
        $.ajax({
            url: '../process/Company/addcompany.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#registerCompanies')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    
                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        window.location.href = 'login-company.php';
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
</script>
</html>
