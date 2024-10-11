<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
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
<div>

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

            <h1 class="text-center my-4"> MY
            <span style="color: #253D80;">COMPANY</span></h1>
            <p style="font-size: small; color:gray"><i>In this section you can change your company details</i></p>
            
            <form id="updateCompany" method="post" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM company WHERE id_company='$_SESSION[id_company]'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                <div class="row">
                    <div class="col-md-6 col-12"> 
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control input-lg" name="companyname" value="<?php echo $row['companyname']; ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control input-lg" name="website" value="<?php echo $row['website']; ?>" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control input-lg" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>About Me</label>
                            <textarea class="form-control input-lg" rows="4" name="aboutme"><?php echo $row['aboutme']; ?></textarea>
                        </div>
                        <div class="form-group" style="margin: 12px 0px;">
                            <button type="submit" class="button-upt">Update Company Profile</button>
                        </div>
                    </div>

                    <div class="col-md-6 col-12"> 
                        <div class="form-group">
                            <label for="contactno">Contact Number</label>
                            <input type="text" class="form-control input-lg" id="contactno" name="contactno" placeholder="Contact Number" onkeypress="return validatePhone(event);" minlength="10" maxlength="10" value="<?php echo $row['contactno']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control input-lg" id="city" name="city" onkeypress="return validateName(event);" value="Taguig City" placeholder="City" readonly>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control input-lg" id="state" onkeypress="return validateName(event);" name="state" placeholder="State" value="Metro Manila" readonly>
                        </div>
                        <div class="form-group">
                            <label for="baranggay">Baranggay</label>
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
                        <div class="form-group" style="display:flex; flex-direction:column">
                            <label>Change Company Logo</label>
                            <input type="file" id="image" 
                            name="image" style="margin:12px 0px;">
                            <?php if($row['logo'] != "") { ?>
                                <img src="/uploads/logo/<?php echo $row['logo']; ?>" 
                                class="img-responsive" style="max-height: 200px; max-width: 200px;">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>  
            </form>

          
            
          </div>
        </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

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

    $("#updateCompany").on("submit", function(e) {
        e.preventDefault();
    
        const image = document.getElementById('image').files[0];

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        
        let errorMessage = '';
               
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
            url: '../process/update-company.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#updateCompany')[0]), // Assuming you have a form with this ID
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
