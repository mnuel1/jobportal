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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/mystyle.css" rel="stylesheet" />
    <link href="../../css/body.css" rel="stylesheet" />
    
</head>
<body>


    <nav class="navbar navbar-expand-lg text-uppercase fixed-top" style="background-color: #CA2B2D;" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php">JobSearch</a>
            <button class="navbar-toggler text-uppercase font-weight-bold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #CA2B2D; color: white;">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded" href="../job/jobs.php">Jobs</a></li>
                    <li class="nav-item mx-0 mx-lg-1" style="margin-left: 20px; margin-right: 20px;">
                        <hr class="d-lg-none" style="border-top: 2px solid white; width: 100%; margin: 10px 0;">
                    </li>
                    <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="../../login.php">Login</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="../../sign-up.php">Sign-up</a></li>
                    <?php } else {
                        if(isset($_SESSION['id_user'])) { ?>  
                            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="user/index.php">Dashboard</a></li>
                        <?php } else if(isset($_SESSION['id_company'])) { ?>
                            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="company/index.php">Dashboard</a></li>
                        <?php } ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="logout.php">Log-out</a></li>                       
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="toast-container top-0 start-50 translate-middle-x ">
        <div id="myToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                Hello, world! This is a toast message.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>  
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bootstrap Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure commodi fugiat consequatur, ad neque sint a perspiciatis odio cupiditate amet, unde laborum distinctio sed doloribus expedita! Assumenda error unde itaque!

                </div>                
            </div>
        </div>
    </div>
   
    <div class="content-wrapper" style="margin-left: 0px; padding-top: calc(6rem + 42px);">
        <section class="content-header">
            <div class="container">
                <div class="row latest-job latest-job margin-top-50 margin-bottom-20 mb-2">
                    <h1 class="text-center margin-bottom-20" style="padding:24px">
                        CREATE YOUR 
                        <span style="color: #7D0A0A;">PROFILE</span>
                    </h1>
                    <form method="post" id="registerCandidates" action="adduser.php" enctype="multipart/form-data" class="bg-light p-4">
                        <!-- <div class="row">
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
                                    <label for="email">Email</label>
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
                                <div class="form-group mb-2">
                                    <label for="baranggay">Baranggay</label>
                                    <input class="form-control" type="text" id="baranggay" name="baranggay" placeholder="Baranggay">
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
                        </div> -->
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I accept terms & conditions. 
                                <span id="termscondition"  style="cursor: pointer;">Read it here.</span></label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">Register</button>
                        </div>
                    </form>

                
                </div>
            </div>
        </section>

        

    </div>



<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
   

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

    $('#termscondition').on('click', function() {
        const modal = document.getElementById('myModal')
        var myTerms = new bootstrap.Modal(modal);    
        myTerms.show(); // Show toast
    })

   
    $("#registerCandidates").on("submit", function(e) {
        e.preventDefault();

        // const password = document.getElementById('password').value;
        // const confirmPassword = document.getElementById('cpassword').value;
        // const resume = document.getElementById('resume').files[0];
        
        const error = document.getElementById('myToast')
        var myToast = new bootstrap.Toast(error);    
        myToast.show(); // Show toast

        
        // let errorMessage = '';

        // // Check if passwords match
        // if (password !== confirmPassword) {
        //     errorMessage = 'Passwords do not match!';
        // }

        // // Check if resume is a PDF file
        // if (resume && resume.type !== 'application/pdf') {
        //     errorMessage = 'Only PDF files are allowed for resume upload!';
        // }

        // // If there is an error, show the Bootstrap Toast
        // if (errorMessage) {
        //     document.getElementById('message').textContent = errorMessage;
        //     error.show(); // Show toast
        // } else {
        //     // No error, proceed with form submission
        //     $(this).unbind('submit').submit();
        // }
        
    });
</script>
</body>
</html>
