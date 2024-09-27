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
    <title>JobSearch</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    

    
    <div class="container-fluid d-flex justify-content-center gap-2" style="padding-top: calc(6rem + 42px);">
        
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/candidate-sidebar.php';?>
        <div class="container larger bg-light mx-auto" style="padding: 24px;">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#candidate" 
                aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars"></i></button>
            
            <h1 class="text-center my-4">EDIT 
            <span style="color: #253D80;">PROFILE</span></h1>
            
            <form method="post" enctype="multipart/form-data" id="updateCandidate">
                <?php
                    //Sql to get logged in user details.
                    $sql = "SELECT * FROM users WHERE id_users='$_SESSION[id_user]'";
                    $result = $conn->query($sql);

                    //If user exists then show his details.
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" onkeypress="return validateName(event);" value="<?php echo $row['firstname']; ?>" required="">
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="aboutme">About Me</label>
                            <textarea class="form-control" rows="4" name="aboutme"><?php echo $row['aboutme']; ?></textarea>
                        </div>                        
                        <div class="form-group mb-2">
                            <label for="qualification">Highest Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Highest Qualification" value="<?php echo $row['qualification']; ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="stream">Stream</label>
                            <input type="text" class="form-control" id="stream" name="stream" placeholder="stream" value="<?php echo $row['stream']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" onkeypress="return validateName(event);" value="<?php echo $row['lastname']; ?>" required="">
                        </div>                        
                        <div class="form-group mb-2">
                            <label for="contactno">Contact Number</label>
                            <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Contact Number" onkeypress="return validatePhone(event);" maxlength="10" minlength="10" value="<?php echo $row['contactno']; ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="4" placeholder="Address"><?php echo $row['address']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control input-lg" id="baranggay" name="baranggay" required>
                            <option value="">Select baranggay</option>
                                <?php
                                    // Assume the current selected baranggay_id is stored in a variable
                                    $currentBaranggayId = $row['baranggay_id']; // This should hold the baranggay_id of the current row

                                    // Query to fetch all baranggays
                                    $sql = "SELECT * FROM baranggay";
                                    $result = $conn->query($sql);

                                    // Check if the query returns rows
                                    if ($result->num_rows > 0) {
                                        while ($baranggay = $result->fetch_assoc()) {
                                            // Check if this is the current selected baranggay
                                            $isSelected = ($baranggay['baranggay_id'] == $currentBaranggayId) ? 'selected' : '';
                                            
                                            // Output each option, and set the 'selected' attribute if it's the current baranggay
                                            echo "<option value='".$baranggay['baranggay_id']."' data-id='".$baranggay['id']."' $isSelected>".$baranggay['name']."</option>";
                                        }
                                    }
                                ?>

                            
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="skills">Skills</label>
                            <textarea class="form-control" rows="4" name="skills" onkeypress="return validateName(event);" ><?php echo $row['skills']; ?></textarea>
                        </div>                        
                        <div class="form-group mb-2">
                            <span>Resume</span>
                            <input type="file" name="resume" id="resume" class="form-control">
                            <label style="color: red; font-size:small"> PDF Only</label>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <button type="submit" class="button-create-lg ">Update Account</button>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>   
            </form>            
        </div>
    </div>


<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


<script type="text/javascript">
                            
    function validatePhone(event) {

        //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
        //event.which will return key for mouse events and other events like ctrl alt etc. 
        var key = window.event ? event.keyCode : event.which;

        if(event.keyCode == 8 || event.keyCode == 127 || event.keyCode == 37 || event.keyCode == 39) {
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


    function validateName(event) {

        //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
        //event.which will return key for mouse events and other events like ctrl alt etc. 
        var key = window.event ? event.keyCode : event.which;

        if(event.keyCode == 8 || event.keyCode == 127 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 32) {
        
            return true;
        } else if( key < 65 || key > 90 && key < 97 || key > 122) {
            // 65-90 97-122 is A-Z a-z alphabets on your keyboard.
            return false;
        } else return true;
    }

    $("#updateCandidate").on("submit", function(e) {
        e.preventDefault();
       
        const resume = document.getElementById('resume').files[0];


        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        
        let errorMessage = '';

        
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
            url: '../process/update-profile.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#updateCandidate')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
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
                console.error('AJAX Error:', error);
            }
        });
                
    });
</script>
</body>
</html>
