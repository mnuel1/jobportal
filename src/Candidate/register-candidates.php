<?php 

session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) { 
  header("Location: index.php");
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
    <title>JobSearch</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
    
</head>
<body>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/terms-modal.php';?>
      
    <div class="content-wrapper" style="margin-left: 0px; padding-top: calc(6rem + 24px);">
        <section class="content-header">
            <div class="container">
                <div class="row latest-job latest-job margin-top-50 margin-bottom-20 mb-2">
                    <h1 class="text-center margin-bottom-20" style="padding:24px">
                        CREATE YOUR 
                        <span style="color: #7D0A0A;">PROFILE</span>
                    </h1>
                    <form method="post" id="registerCandidates" action="../process/Candidate/adduser.php" 
                    enctype="multipart/form-data" class="bg-light p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="fname">First Name</label>
                                    <input class="form-control" type="text" id="fname" name="fname" placeholder="First Name *" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" id="password" name="password" placeholder="Password *" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="email">Email Address</label>
                                    <input class="form-control" type="email" id="email" name="email" placeholder="Email *" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="aboutme">About Me</label>
                                    <textarea class="form-control" rows="4" id="aboutme" name="aboutme" placeholder="Brief intro about yourself *" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="dob">Date Of Birth</label>
                                    <input class="form-control" type="date" id="dob" min="1960-01-01" max="1999-01-31" name="dob">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="age">Age</label>
                                    <input class="form-control" type="text" id="age" name="age" placeholder="Age" readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="passingyear">Passing Year</label>
                                    <input class="form-control" type="date" id="passingyear" name="passingyear">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="qualification">Qualification</label>
                                    <input class="form-control" type="text" id="qualification" name="qualification" placeholder="Highest Qualification">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="stream">Stream</label>
                                    <input class="form-control" type="text" id="stream" name="stream" placeholder="Stream">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="lname">Last Name</label>
                                    <input class="form-control" type="text" id="lname" name="lname" placeholder="Last Name *" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="cpassword">Confirm Password</label>
                                    <input class="form-control" type="password" id="cpassword" name="cpassword" placeholder="Confirm Password *" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="contactno">Contact Number</label>
                                    <input class="form-control" type="text" id="contactno" name="contactno" minlength="10" maxlength="10" onkeypress="return validatePhone(event);" placeholder="Phone Number">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" rows="4" id="address" name="address" placeholder="Address"></textarea>
                                </div>
                                <div class="form-group">
                                    <select class="form-control input-lg" id="baranggay" name="baranggay" required>
                                        <option selected="" value="">Select baranggay</option>
                                        <?php
                                        $sql="SELECT * FROM baranggay";
                                        $result=$conn->query($sql);

                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['baranggay_id']."' data-id='".$row['id']."'>".$row['name']."</option>";
                                            }
                                        }
                                        ?>
                                    
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="skills">Skills</label>
                                    <textarea class="form-control" rows="4" id="skills" name="skills" placeholder="Enter Skills"></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="designation">Designation</label>
                                    <input class="form-control" type="text" id="designation" name="designation" placeholder="Designation">
                                </div>
                                <div class="form-group mb-2">
                                    <span>Resume</span>
                                    <input type="file" name="resume" id="resume" class="form-control" required>
                                    <label style="color: red; font-size:small"> PDF Only</label>
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

    $('#dob').on('change', function() {
        var today = new Date();
        var birthDate = new Date($(this).val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();

        if(m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
        }

        $('#age').val(age);
    });

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
           
    $("#registerCandidates").on("submit", function(e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('cpassword').value;
        const resume = document.getElementById('resume').files[0];


        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        
        let errorMessage = '';

        if (password !== confirmPassword) {
            errorMessage = 'Passwords do not match!';
        }
        
        if (resume && resume.type !== 'application/pdf') {
            errorMessage = 'Only PDF files are allowed for resume upload!';
        }
                
        if (resume && resume.size > 1000000) {
            errorMessage = 'File size exceeds 1mb.';
        }
        
        if (errorMessage) {            
            toastErrorMsg.textContent = errorMessage           
            errorToast.show();
            return;            
        } 
        

        $.ajax({
            url: '../process/Candidate/adduser.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#registerCandidates')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    window.location.href = 'login-candidates.php';
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
                
    });
</script>
</html>
