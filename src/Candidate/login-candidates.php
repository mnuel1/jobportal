<?php
session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) { 
  header("Location: index.php");
  exit();
}
require_once("../../database/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JobSearch</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
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
        .buttons {
            color: white;
            background-color: #B22222;                       
            border-radius: 6px;
            font-size: 20px;
            font-weight:bold;
        }

        .buttons:hover {
            background-color: #A11111; 
            color: white;           
        }
        .links {
            margin-top:2px; font-size:14px; color:white;
            text-decoration: none;
        }
        .links:hover {
            color:white;        
            text-decoration:underline;
        }
    </style>
</head>
<body class="login-page">

<div class="login-box">
    <div class="login-logo">
        <a href="../../index.php">JobSearch</a>
    </div>    
    <div class="login-box-body">
        <p class="login-box-msg">Candidates Login</p>
        
        <form method="post" action="">
            <div class="mb-3 position-relative">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <span class="form-control-feedback">
                    <i class="fa fa-envelope"></i>
                </span>
            </div>
            <div class="mb-3 position-relative">
                <input type="password" class="form-control" 
                id="password" name="password" placeholder="Password" required>
                <span class="form-control-feedback" style="cursor: pointer;" 
                onclick="togglePassword()">                   
                    <i id="password-icon" class="fa fa-eye"></i>
                   
                </span>                
            </div>
            <div class="d-grid gap-2">
                <button class="btn buttons" type="button">Sign in</button>            
            </div>
            <div class="mb-3 d-flex items-align-center justify-content-between">
               
                    <a href="./register-candidates.php" class="links">No account yet? Click here</a>
                    <a href="#" class="links">I forgot my password</a>
               
                
            </div>
        </form>

    </div>
    <div class="fixed-bottom" style="z-index: 0; pointer-events: none; ">
        <img src="../../assets/bot.png" alt="Footer Background" style="width: 100%; height: 100%; object-fit: cover;">
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
</script>

</body>
</html>
