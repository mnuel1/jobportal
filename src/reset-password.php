<?php
session_start();


require_once("../database/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAREERCITY</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/body.css" rel="stylesheet" />

    <style>
        .login-page {
            background-color: #E7E0DC;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #CA2B2D;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .login-box-msg {
            color:white;
            text-align: center;
            font-size: 17px;
            font-weight:500
        }
        .login-logo a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 50px;
            text-align: center;
            display: block;
            margin-bottom: 20px;
        }
        .form-control-feedback {
            position: absolute;
            right: 15px;
            top: 10px;
        }
        .btn-toggle-password {
            cursor: pointer;
            border: none;
            background: none;
        }
       
        
    </style>
</head>
<body class="login-page">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>

    <div class="fixed-bottom" style="z-index: 0; pointer-events: none; ">
        <img src="/assets/bot.png" alt="Footer Background" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div class="login-box" style="z-index: 50;">
        <div class="login-logo">
            <a class="navbar-brand" href="/src/index.php"><img src="/assets/logo.png" width="250" alt=""></a>
        </div>    
        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>
            
            <form method="post" id="resetPassword">
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" 
                    id="password" name="password" placeholder="Password" required>
                    <span class="form-control-feedback" style="cursor: pointer;" 
                    onclick="togglePassword()">                   
                        <i id="password-icon" class="fa fa-eye"></i>
                    
                    </span>                
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" 
                    id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                    <span class="form-control-feedback" style="cursor: pointer;" 
                    onclick="togglePassword()">                   
                        <i id="password-icon" class="fa fa-eye"></i>                    
                    </span>                
                </div>
                <input type="text" hidden value="<?php echo $_GET["acctype"] ?>" 
                name="acctype" id="acctype">
                <input type="text" hidden value="<?php echo $_GET["email"] ?>" 
                name="email" id="email">

                <div class="d-grid gap-2 mb-2">
                    <button class="buttons buttons-color-dark" type="Submit">Continue</button>
                </div>
                
            </form>

        </div>
     
    </div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
  
    $("#resetPassword").on("submit", function(e) {
        
        e.preventDefault();

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);

        const password = document.getElementById("password").value
        const cpassword = document.getElementById("cpassword").value

        if (password !== cpassword) {
            toastErrorMsg.textContent = "Password don't match!"
            errorToast.show()
            return;
        }

        $.ajax({
            url: './process/reset-pass.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#resetPassword')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    // window.location.href = '/src/index.php';
                } else {            
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    })
</script>

</body>
</html>
